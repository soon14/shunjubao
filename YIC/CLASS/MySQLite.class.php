<?php
class MySQLite {
	/**
     * 当前的数据库连接对象
     *
     * @var mysqli
     */
    private $link;

    /**
     * 当前连接的数据库名
     * @var string
     */
    private $dbname;

        /**
     * #private
     * 统计查询次数
     *
     * @var Int
     */
    static public $queries = 0;

    /**
     * 通过$this->query 所执行的总时间
     * 只有 debug::sql打开才会统计
     *
     * @var Int
     */
    private static $intQueriesTotalTime = 0;

    /**
     * 保存所有已建立的到服务器的连接。
     *
     * @var Array 结构如下：
     * array(
     *     '连接唯一标志' => mysqli   //连接唯一标志由 $this->getUniqueFlagOfLink() 获取；mysqli 是到主服务器1的连接。
     *     , ...
     * )
     */
    static private $links;

    /**
     * 调试等级
     * 0 不处理（交予外部程序处理）
     * 1 显示错误并中断程序
     * 2 直接中断程序
     *
     * @var Int
     */
    public $debug_level = 1;

    /**
     * 最近一次执行的语句
     *
     * @var string
     */
    private $last_sql;

    /**
     * 最后一次执行 query 后获取的 mysqli_result 对象
     *
     * @var mysqli_result
     */
    private $result;

	/**
     * from Data Source Name (dsn)
     * for example: mysqli://root:851031@localhost:3306/testDb
     *
     * @var Array ( 'prefix' => '', 'host' => '', 'port' => '', 'user' => '', 'pass' => '' )
     */
    private $arrDsn;

    /**
     * 保存当前主服务器连接的信息
     *是对 self::$masterDBInfos 数据结构某一项的引用
     * @var array
     * 结构如下
     * array(// 当前集群下的主服务器
     *     'host' => //主机名
     *     , 'port'  => //端口
     *     , 'user' => //用户名
     *     , 'pass' => //密码
     *     , 'transactionIds' => //用于存储事务id。Array ('taId1' => true, 'taId2' => false, ...);
     *                                                        //键代表事务标志，同时也是用于保存点的标志。值表示是否为顶层事务（只能有一个顶层事务）
     *     , 'isRunOnMaster' => Boolean   //$this->query 方法里可检验该值，判断当前查询正连接于主服务器上
     *     , 'isUseMaster' => Boolean //指示后续查询是否要使用到主库的连接
     *     , 'arrStatusOfUseMaster' => Array(); //当嵌套修改 isUseMaster 的值时，需要有一个结构保存之前的状态，以便恢复
     * )
     */
    private $masterDBInfo;

    /**
     * 保存所有用于主服务器连接的信息
     *
     * @var Array  结构如下：
     * array(
     *     '集群1标志' => array( //
     *         '主服务器标志' => array(//该标志通过 $this->getUniqueFlagOfLink() 获取:实质是通过 host, port, user, pass 来区别，所以同一集群如果使用不同的用户连接，会有不同的标志
     *             'host' => //主机名
     *             , 'port'  => //端口
     *             , 'user' => //用户名
     *             , 'pass' => //密码
     *             , 'transactionIds' => //用于存储事务id。Array ('taId1' => true, 'taId2' => false, ...);
     *                                                        //键代表事务标志，同时也是用于保存点的标志。值表示是否为顶层事务（只能有一个顶层事务）
     *             , 'isRunOnMaster' => Boolean   //$this->query 方法里可检验该值，判断$this->link是否正链接到主服务器上
     *             , 'isUseMaster' => Boolean //指示后续查询是否要使用到主库的连接
     *             , 'arrStatusOfUseMaster' => Array();
     *         )
     *         , ...
     *     )
     *     , ...
     * )
     */
    static private $masterDBInfos = array();


    /**
     * 集群信息，即用于候选的从服务器集
     * array(
     *     'clusterLevel' => (2 表示正常集群、3 表示低效集群)
     *     , 'Ignore_Check_Master_Patterns' => array()
     *
     *     , '集群1标志' => array( // 该标志通过 $this->getMasterHost() 获取：集群只需要通过主服务器host即可区分
     *                        array(
     *                                  'host' =>
     *                                  , 'port'  =>
     *                                  , 'user' =>
     *                                  , 'pass' =>
     *                        )
     *                        , ...
     *                  )
     *     , ...
     * )
     * @var Array
     */
    static private $slaveDBInfos;

    /**
     * 保存已从集群信息中获取的用于连接从服务器的信息
     * @author Gxg <gaoxiaogang@gmail.com>
     *
     * @var Array  结构如下：
     * array(// 当前集群下的从库信息
     *         'host' => //主机名
     *         , 'port'  => //端口
     *         , 'user' => //用户名
     *         , 'pass' => //密码
     * )
     */
    private $slaveDBInfo;

    /**
     * 返回当前集群中从服务器的信息
     *
     * @return false | Array 格式：
     * array(
     *       'host' => //主机名
     *       , 'user' => //用户名
     *       , 'pass' => //密码
     * )
     */
    private function getCurrentSlaveInfo() {
    	$arrInvalidSlaveInfos = $this->getCurrentInvalidSlaveInfos();
        if (isset($this->slaveDBInfo)) {
            # 检验是否有效
            if (!$arrInvalidSlaveInfos || !in_array($this->slaveDBInfo['host'], $arrInvalidSlaveInfos)) {
                return $this->slaveDBInfo;
            }
        }

        $strUniqueFlagOfCluster = $this->getUniqueFlagOfCurrentCluster();
        if (!isset(self::$slaveDBInfos[$strUniqueFlagOfCluster])) {
        	# 不能使用 $this->slaveDBInfo = null，否则引用的 self::$slaveDBInfos 相应的值也会变成 null
            return false;
        }

        # 把 self::$slaveDBInfos 中已经无效的从库踢掉
        if ($arrInvalidSlaveInfos) {
            foreach (self::$slaveDBInfos[$strUniqueFlagOfCluster] as $key => $arrSlaveInfo) {
                $strSlaveHost = $arrSlaveInfo['host'];
                if (in_array($strSlaveHost, $arrInvalidSlaveInfos)) {
                    unset(self::$slaveDBInfos[$strUniqueFlagOfCluster][$key]);
                }
            }
        }

        if (count(self::$slaveDBInfos[$strUniqueFlagOfCluster]) == 0) {
        	return false;
        }

        $intRandPos = array_rand(self::$slaveDBInfos[$strUniqueFlagOfCluster]);
	    $this->slaveDBInfo = & self::$slaveDBInfos[$strUniqueFlagOfCluster][$intRandPos];
	    if (!isset($this->slaveDBInfo['user']) || !isset($this->slaveDBInfo['pass'])) {//从服务器没有提供连接帐户，则使用主服务器的帐户
	        $this->slaveDBInfo['user'] = $this->masterDBInfo['user'];
	        $this->slaveDBInfo['pass'] = $this->masterDBInfo['pass'];
	    }
	    if (!isset($this->slaveDBInfo['port'])) {
	        $this->slaveDBInfo['port'] = $this->masterDBInfo['port'];
	    }

	    return $this->slaveDBInfo;
    }

    /**
     * 集群中无效的从服务器信息
     * 寻找从服务器时，会忽略该结构中列出的主机
     * array(
     *     '集群1标志' => array('从服务器host', '从服务器host', ...)
     *     , ...
     * )
     *
     * @var Array
     */
    static private $invalidSlaveInfos;

    /**
     * 增加无效的从服务器信息
     *
     * @param String $strHost
     * @return true
     */
    private function addInvalidSlaveInfo($strHost) {
        $strUniqueFlagOfCluster = $this->getUniqueFlagOfCurrentCluster();
        if (!isset(self::$invalidSlaveInfos[$strUniqueFlagOfCluster])
            || !in_array($strHost, self::$invalidSlaveInfos[$strUniqueFlagOfCluster])
        ) {
            self::$invalidSlaveInfos[$strUniqueFlagOfCluster][] = $strHost;
        }
        return true;
    }

    /**
     * 获取当前集群的唯一标志（即主服务器host）
     *
     * @return String
     */
    private function getUniqueFlagOfCurrentCluster() {
        return "{$this->masterDBInfo['host']}_{$this->masterDBInfo['port']}_{$this->masterDBInfo['user']}";
    }

    /**
     * 获取当前集群下无效的从服务器信息
     *
     * @return false | Array
     */
    private function getCurrentInvalidSlaveInfos() {
        $strUniqueFlagOfCluster = $this->getUniqueFlagOfCurrentCluster();
        if (!isset(self::$invalidSlaveInfos[$strUniqueFlagOfCluster])) {
            return false;
        }

        return self::$invalidSlaveInfos[$strUniqueFlagOfCluster];
    }

    /**
     * 设置客户端连接字符集
     *
     * @param String $strCharset
     * @return Boolean true:成功;false:失败.
     */
    private function setCharacter($strCharset = 'latin1') {
        return $boolResult = mysqli_set_charset($this->link, $strCharset);
    }

    /**
     * 取得客户端连接字符集
     *
     * @return String
     */
    public function getCharacter() {
        return $strResult = mysqli_character_set_name($this->link);
    }

    /**
     * 获取当前连接的唯一标志
     *
     * @return String
     */
    private function getUniqueFlagOfLink() {
        return "{$this->arrDsn['host']}_{$this->arrDsn['port']}_{$this->arrDsn['user']}_{$this->arrDsn['pass']}";
    }

    /**
     * 构造函数
     *
     * @param String $dsn For Example: mysqli://root:851031@localhost/testDb
     */
    public function __construct($dsn) {
        $arrUrlInfo = parse_url($dsn);
        if (!is_array($arrUrlInfo) || !isset($arrUrlInfo['host']) || !isset($arrUrlInfo['user'])
           || !isset($arrUrlInfo['pass']) || !isset($arrUrlInfo['path']))
        {
        	$this->_halt("构造参数不正确：{$dsn}");
        	return false;
            //解析出错时的处理
        }
        $this->arrDsn['host'] = $arrUrlInfo['host'];
        $this->arrDsn['user'] = $arrUrlInfo['user'];
        $this->arrDsn['pass'] = $arrUrlInfo['pass'];

        $dbname = substr($arrUrlInfo['path'], 1);
        if (empty($dbname)) {
        	return $this->_halt('请先设置数据库名', '21');
        }
        $this->dbname = $dbname;

        isset($arrUrlInfo['scheme']) && $this->arrDsn['prefix'] = $arrUrlInfo['scheme'];
        if (!isset($arrUrlInfo['port'])) {
        	$this->arrDsn['port'] = 3306;
        } else {
        	$this->arrDsn['port'] = $arrUrlInfo['port'];
        }

        $strUniqueFlagOfCluster = $this->arrDsn['host'];
        $strUniqueFlagOfMaster = $this->getUniqueFlagOfLink();
        if (!isset(self::$masterDBInfos[$strUniqueFlagOfCluster][$strUniqueFlagOfMaster])) {
            self::$masterDBInfos[$strUniqueFlagOfCluster][$strUniqueFlagOfMaster] = array(
                'host' => $this->arrDsn['host']
                , 'port' => $this->arrDsn['port']
                , 'user' => $this->arrDsn['user']
                , 'pass' => $this->arrDsn['pass']
                , 'transactionIds' => null
                , 'isRunOnMaster' => false
                , 'isUseMaster' => false
                , 'arrStatusOfUseMaster' => null
            );
        }
        $this->masterDBInfo = & self::$masterDBInfos[$strUniqueFlagOfCluster][$strUniqueFlagOfMaster];

        if (!isset(self::$slaveDBInfos)) {
            $this->initSlaveDBInfos();
        }
    }

/**
     * 初始化 self::$slaveDBInfos 数据结构
     *
     * $_SERVER['DataBase_Cluster_Map'] 的结构：
     * array(
     *     array(
     *         'master' => (string),//对应主库的host值
     *         'mixed'  => array(//正常从库
     *             'mysqld-6.yoka.com',
     *             '192.168.0.150',
     *             ... ,
     *         ),
     *         'delay_mixed'    => array(//慢速从库，比如用于提供给爬虫、或提供给翻页的比较后面的页面，无需保证特别好的服务
     *             'mysqld-12.yoka.com',
     *             array(
     *                 'host'   => (string),//必须
     *                 'user'   => (string),//必须
     *                 'pass'   => (string),//必须
     *                 'port'   => (int),//非必须
     *             ),
     *             ... ,
     *         ),
     *     )
     * );
     *
     */
    private function initSlaveDBInfos() {
    	if (!isset($_SERVER['DataBase_Cluster_Map']) || !is_array($_SERVER['DataBase_Cluster_Map'])) {
    		return false;
    	}
    	$db_cluster_maps = $_SERVER['DataBase_Cluster_Map'];
    	if (isset($_SERVER['Cluster_User_Level']) && $_SERVER['Cluster_User_Level'] == 3) {
    		$cluster_level = 3;
    		$strType = 'delay_mixed';
    	} else {
    		$cluster_level = 2;
    		$strType = 'mixed';
    	}
    	foreach ($db_cluster_maps as $arrClusterInfo) {
    		if (!isset($arrClusterInfo['master']) || !isset($arrClusterInfo[$strType]) || !is_array($arrClusterInfo[$strType]) || (count($arrClusterInfo[$strType]) == 0)) {
    			# TODO 记录日志
    			continue;
    		}

    		foreach($arrClusterInfo[$strType] as $mixConnectInfo) {
                if (is_string($mixConnectInfo)) {//类似 mysqld-6.verycd.com 的值
                    self::$slaveDBInfos[$arrClusterInfo['master']][] = array(
                        'host'      => $mixConnectInfo
                        , 'port'    => null
                        , 'user'    => null
                        , 'pass'    => null
                    );
                } elseif (is_array($mixConnectInfo)) {//如果$_SERVER['DataBase_Cluster_Map'] 提供客启端的密码，请使用以下格式 !
                    if (isset($mixConnectInfo['host']) && isset($mixConnectInfo['user']) && isset($mixConnectInfo['pass'])) {
                    	$tmpPort = isset($mixConnectInfo['port']) ? $mixConnectInfo['port'] : 3306;
                        self::$slaveDBInfos[$arrClusterInfo['master']][] = array(
                            'host'      => $mixConnectInfo['host']
                            , 'port'    => $tmpPort
                            , 'user'    => $mixConnectInfo['user']
                            , 'pass'    => $mixConnectInfo['pass']
                        );
                    } else {
//                                $this->_halt('该集群：' . $arrClusterInfo['master'] . '在$_SERVER[\'DataBase_Cluster_Map\']里提供的连接信息格式错误');
                        # TODO 记下错误日志
                        continue;
                    }
                } else {
                    # TODO 记下错误日志
//                            $this->_halt('该集群：' . $arrClusterInfo['master'] . '在$_SERVER[\'DataBase_Cluster_Map\']里提供的连接信息格式错误');
                    continue;
                }
            }//end foreach
    	}//end foreach
    }

    /**
     * 获取当前主连接唯一标志
     *
     * @return String
     */
    private function getUniqueFlagOfCurrentMaster() {
        return "{$this->masterDBInfo['host']}_{$this->masterDBInfo['port']}_{$this->masterDBInfo['user']}_{$this->masterDBInfo['pass']}";
    }

    /**
     * 获取当前集群状态下到主服务器的连接
     *
     * @return mysqli | false   已有连接，返回该连接（即mysqli对象）；false：没有连接
     */
    private function getCurrentMasterLink() {
        $strUniqueFlagOfCurrentMaster = $this->getUniqueFlagOfCurrentMaster();
        if (isset(self::$links[$strUniqueFlagOfCurrentMaster])) {
            if ($this->isLink(self::$links[$strUniqueFlagOfCurrentMaster])) {
                return self::$links[$strUniqueFlagOfCurrentMaster];
            } else {
            	# 曾建立过连接，但中途该连接失效了，应该对此做出处理的。
            	if (!empty($this->masterDBInfo['transactionIds'])) {
            		return $this->_halt("到主库的连接已失效，且该主库上存在事务，必须中断！");
            	}
            }
        }

        return false;
    }

    /**
     * 当前连接是否连到主库
     */
    private function isRunOnMaster() {
        return (boolean) $this->masterDBInfo['isRunOnMaster'];
    }

    /**
     * 获取所有事务信息
     * 只有当前集群中主服务器的连接是可用的，才有事务可言
     *
     * @return false | Array()   false：没有到主服务器的连接或者还没开启事务；
     */
    private function getTransactions() {
        if ($this->getCurrentMasterLink()) {
            if (!empty($this->masterDBInfo['transactionIds'])) {
                return $this->masterDBInfo['transactionIds'];
            }
        }

        return false;
    }

    /**
     * 当前查询是否正运行在主服务器上并且开启了事务
     * 该方法在 $this->query 方法里调用才是最有价值的。
     *
     * @return Boolean     true：是；false：否
     */
    private function isRunOnTransaction() {
        if ($this->isRunOnMaster() && $this->getTransactions()) {
            return true;
        }

        return false;
    }

    private function isLink($link) {
        if (!($link instanceof mysqli)) return false;
        $sinfo = @mysqli_get_host_info($link);
        return !empty($sinfo);
    }

    private function isReadSql($sql) {
        static $r_ops = array('select','show','desc');
        $sql = strtolower(trim($sql));
        foreach ($r_ops as $op) {
           if (strpos($sql,$op)===0) return true;
        }
        return false;
    }

    /**
     * 连接数据库。这里创建的是真实链接，不会重用已有的链接
     *
     * @return false | mysqli false：连接失败
     */
     private function connect() {
        // 连接数据库服务器
        $objMysqli = mysqli_init();

        $connect_rs = mysqli_real_connect($objMysqli, $this->arrDsn['host'], $this->arrDsn['user'], $this->arrDsn['pass']
                            , null, $this->arrDsn['port'], null
                            , MYSQLI_CLIENT_COMPRESS);
        if (!$connect_rs) {
            return false;
        }

        # 设置字符集的代码

        $this->link = $objMysqli;
        $this->setCharacter();
        return $this->link;
    }

    /**
     * 标志当前连接$this->link连接到主库
     *
     * @return Boolean
     */
    private function beginRunOnMaster() {
        $this->masterDBInfo['isRunOnMaster'] = true;
        return true;
    }

    /**
     * 标志当前连接$this->link离开主库
     *
     * @return Boolean
     */
    private function endRunOnMaster() {
        $this->masterDBInfo['isRunOnMaster'] = false;
        return true;
    }

    /**
     * 该方法只应该由 $this->xconnect()调用
     *
     * @return Boolean  false：连接失败
     */
    private function connectMaster() {
        # These codes increase by Gxg <gaoxiaogang@gmail.com>
        # 保证到当前集群的主服务器的连接唯一
        $this->arrDsn['host'] = $this->masterDBInfo['host'];
        $this->arrDsn['port'] = $this->masterDBInfo['port'];
        $this->arrDsn['user'] = $this->masterDBInfo['user'];
        $this->arrDsn['pass'] = $this->masterDBInfo['pass'];

        $objCurrentMasterLink = $this->getCurrentMasterLink();
        if ($objCurrentMasterLink) {
            $this->link = $objCurrentMasterLink;
        } else {
            if (false === $this->connect()) {
                return false;
            }
            $strUniqueFlagOfLink = $this->getUniqueFlagOfLink();
            self::$links[$strUniqueFlagOfLink] = $this->link;
        }

        $this->beginRunOnMaster();

        return true;
    }

    /**
     * 该方法只应该由 $this->xconnect()调用
     *
     * @return Boolean  false：连接失败
     *
     */
    private function connectSlave() {
    	$arrCurrentSlaveInfo = $this->getCurrentSlaveInfo();
        if ($arrCurrentSlaveInfo) {
            $this->arrDsn['host'] = $arrCurrentSlaveInfo['host'];
            $this->arrDsn['port'] = $arrCurrentSlaveInfo['port'];
            $this->arrDsn['user'] = $arrCurrentSlaveInfo['user'];
            $this->arrDsn['pass'] = $arrCurrentSlaveInfo['pass'];

            $strUniqueFlagOfLink = $this->getUniqueFlagOfLink();
            if (isset(self::$links[$strUniqueFlagOfLink]) && $this->isLink(self::$links[$strUniqueFlagOfLink])) {
                $this->link = self::$links[$strUniqueFlagOfLink];
            } else {
                if(false === $this->connect()) {
                    return false;
                }
                self::$links[$strUniqueFlagOfLink] = $this->link;
            }
            return true;
        } else {//还是连主服务器
            return $this->connectMaster();
        }
    }

    /**
     * 判断查询是否要使用主服务器
     *
     * @return Boolean  true：使用主；false：使用从
     */
    private function isUseMaster() {
    	return (boolean) $this->masterDBInfo['isUseMaster'];
    }

    /**
     * 保存当前状态，并置为$status
     *
     * @param Boolean $status
     * @return String
     */
    private function changeStatusOfUseMaster($status) {
    	($status === true) || $status = false;

        # 保存当前状态
        $strMasterStatusId = $this->getUniqueMasterStatusId();
        $this->masterDBInfo['arrStatusOfUseMaster'][$strMasterStatusId] = $this->masterDBInfo['isUseMaster'];
        $this->masterDBInfo['isUseMaster'] = $status;
        return $strMasterStatusId;
    }

    /**
     * 开始使用主库
     *
     * @return String 返回一串标志，供$this->restore 方法使用，用于恢复上一个状态
     */
    public function beginUseMaster() {
        return $this->changeStatusOfUseMaster(true);
    }

    /**
     * 恢复采用 $strMasterStatusId 为句柄保存的上次的状态
     *
     * @param String $strMasterStatusId
     * @return Boolean
     *
     */
    public function restore($strMasterStatusId) {
        # 恢复指定状态
        if (isset($this->masterDBInfo['arrStatusOfUseMaster'][$strMasterStatusId])) {
            $this->masterDBInfo['isUseMaster'] = $this->masterDBInfo['arrStatusOfUseMaster'][$strMasterStatusId];
            unset($this->masterDBInfo['arrStatusOfUseMaster'][$strMasterStatusId]);
            return true;
        }

        return false;
    }

    /**
     * 开始使用从库
     * 尽量不要使用该接口，除非你明白自己真的需要
     *
     */
    public function beginUseSlave() {
        return $this->changeStatusOfUseMaster(false);
    }

    /**
     * 处理连接
     *
     * @param String $sql
     */
    protected function xconnect($sql) {
    	$isUseSlave = $this->isReadSql($sql) && !$this->isUseMaster() ? true : false;

        $intConnectErrorNum = 0;//连接出错次数
        while(true) {
            if ($isUseSlave) {
                $isConnect = $this->connectSlave();
            } else {
                $isConnect = $this->connectMaster();
            }

            if (!$isConnect) {//连接失败
                ++$intConnectErrorNum;
                $strMasterHost = $this->masterDBInfo['host'];
                if(4 >= $intConnectErrorNum   //允许四次重试
                   && $this->arrDsn['host'] != $strMasterHost //错误不是发生在主服务器上
                ) {
                    $this->addInvalidSlaveInfo($this->arrDsn['host']);
//                    $this->addErrorLog(self::PARAM_NO_IMPORTANCE_ERROR_DIR, $intConnectErrorNum);
                    continue;
                }

                return $this->_halt('服务器连接失败', '01');
            }

            # 成功就退出循环
            break;
        }
     }

    /**
     * 执行一条SQL
     *
     * @param String $sql
     * @return resource result
     */
    public function query($sql) {
        if (Debug::$open && preg_match('#^\s*select\s#i', $sql)) {
            $explain_query = true;
        } else {
            $explain_query = false;
        }

        if ($explain_query) {
        	# 便于查看不使用缓存时的情况
//            $sql = preg_replace('#select #i', 'select sql_no_cache ', $sql);
        }

        $this->last_sql = $sql; // 临时加上
        $intQueryErrorNum = 0;//查询出错次数
        $intSelectErrorNum = 0;//选择数据库出错次数
        while (true) {
            $this->xconnect($sql);

            $isSelect = mysqli_select_db($this->link, $this->dbname);
            # 处理选择数据库错误
            if (!$isSelect) {
                ++$intSelectErrorNum;
                static $arrSelectErrnos = array(
                    2006    //MySQL服务器不可用
                );
                if (4 >= $intSelectErrorNum   //允许四次重试
                   && (! $this->isRunOnMaster()) //当前 query 不处于主服务器
                   && in_array($this->errno(), $arrSelectErrnos) //指定的错误号
                ) {
                    $this->addInvalidSlaveInfo($this->dsn['host']);//将这台服务器标记为无效
//                    $this->addErrorLog(self::PARAM_NO_IMPORTANCE_ERROR_DIR, $intSelectErrorNum);
                    continue;
                }

                return $this->_halt('进入数据库失败', '02');
            }

            if (!$this->isReadSql($sql)) {
//                # 如果是写入语句，记录开始时间
//                $objProcessTimeOfWriteSqlTime = new ProcessTime();
//                $objProcessTimeOfWriteSqlTime->start();

                # 如果运行于事务中，记录该语句
                if ($this->isRunOnTransaction()) {
                    $this->masterDBInfo['arrTransactionSqls'][] = $sql;
                }
            }

            $query = mysqli_query($this->link, $sql);

//            # 记录慢写入语句
//            if (!$this->isReadSql($sql)) {
//                if (($runTimeOfWriteSql = $objProcessTimeOfWriteSqlTime->getFinalTime()) > 1) {
//                    $this->addSlowWriteSqlLog($runTimeOfWriteSql);
//                }
//            }
            # 处理查询错误
            if (!$query) {
                ++$intQueryErrorNum;

                static $arrConnectErrnos = array(
                    1053      //在操作过程中服务器关闭。
                    , 2013    //查询过程中丢失了与MySQL服务器的连接。
                    , 2006    //MySQL服务器不可用, MySQL server has gone away
                    , 1030    //从存储引擎中获得错误
                    , 126     //表损坏
                );

                if(4 >= $intQueryErrorNum   //允许四次重试
                   && (! $this->isRunOnMaster()) //当前 query 不处于主服务器
                   && in_array($this->errno(), $arrConnectErrnos) //指定的错误号
                ) {
                    $this->addInvalidSlaveInfo($this->arrDsn['host']);//由于连接失效导致的查询出错，将这台服务器标记为无效
//                    $this->addErrorLog(self::PARAM_NO_IMPORTANCE_ERROR_DIR, $intQueryErrorNum);
                    continue;
                }

                return $this->_halt('查询数据库失败', '21');
            }
            break;
        }

        # 走到这里，说明成功的执行了写入sql
        if ($this->canSetCookieForMasterDBHasWrite($sql)) {// 如果写入语句成功，就写一个保存时间为$tmp_expiration秒的cookie
        	$tmp_expiration = 2*60;
			TMCookie::set(getCookieKeyForMasterDBHasWrite(), '1', $tmp_expiration);// 设置$tmp_expiration秒的cookie
        }

        self::$queries++;
        if ($explain_query) {
            $begin_microtime = Debug::getTime();

            self::$intQueriesTotalTime += $begin_microtime;

//            $explainSql = 'explain ' . $sql;
//            $equery = mysqli_query($this->link, $explainSql);
//            $explain = $this->fetch($equery);
//            $this->freeResult($equery);
//            Debug::db($this->getLinkDesc(), $this->dbname, $explainSql, Debug::getTime() - $begin_microtime, $explain);
        }

        $this->isRunOnMaster() && $this->endRunOnMaster();

        return $query;
    }

    /**
     *
     * 判断指定的sql执行后，能否设置后续查询转到主库的cookie
     * @param string $sql
     * @return boolean
     */
    private function canSetCookieForMasterDBHasWrite($sql) {
    	if (Request::isCLI()) {
    		return false;
    	}
		if ($this->isReadSql($sql)) {
			return false;
		}

		# xhprof_logs表是用来记录慢查询的，没必要因为这个表写入了一次就把后续的请求都转到主库。
		if (preg_match('#(xhprof_logs)#', strtolower($sql))) {
			return false;
		}

		return true;
    }

    public function fetchOne($sql) {
    	$begin_microtime = Debug::getTime();

        $res = $this->query($sql);
        if (!$res) {
        	return false;
        }
        $result = $this->fetch($res);

        $this->freeResult($res);

        Debug::db($this->getLinkDesc(), $this->dbname, $this->last_sql, Debug::getTime() - $begin_microtime, $result);

        return $result;
    }

    /**
     * 获取连接描述，用于Debug输出
     */
    private function getLinkDesc() {
    	$thread_id = mysqli_thread_id($this->link);
    	return "mysqli://{$this->arrDsn['user']}:{$this->arrDsn['port']}@{$this->arrDsn['host']} (thread_id: {$thread_id})";
    }

    /**
     * 执行一条SQL并返回此查询包含的所有数据(2维数组)
     *
     * @param string $sql
     * @param string $associateKey 如果指定了$associateKey，返回结果以 每条记录的$associateKey字段做数组下标
     * @return false | array
     */
    public function fetchAll($sql, $associateKey = null) {
    	$begin_microtime = Debug::getTime();

        $res = $this->query($sql);
        if (!$res) {
            return false;
        }

        $result = array();
        if ($associateKey) {
            while (true) {
            	$row = $this->fetch($res);
            	if (!$row) {
            		break;
            	}
            	if (isset($row[$associateKey])) {
            		$result[$row[$associateKey]] = $row;
            	} else {
            		$result[] = $row;
            	}
            }
        } else {
            while (true) {
            	$row = $this->fetch($res);
            	if (!$row) {
            		break;
            	}
                $result[] = $row;
            }
        }

        $this->freeResult($res);

        Debug::db($this->getLinkDesc(), $this->dbname, $this->last_sql, Debug::getTime() - $begin_microtime, $result);

        return $result;
    }

    /**
     * 执行SQL语句并返回第一行第一列
     *
     * @param string $sql
     * @return false | scala
     */
    public function fetchSclare($sql) {
    	$begin_microtime = Debug::getTime();

        $result = $this->fetchOne($sql);
        if (!$result) {
        	return false;
        }
        $result = array_shift($result);

        Debug::db($this->getLinkDesc(), $this->dbname, $this->last_sql, Debug::getTime() - $begin_microtime, $result);

        return $result;
    }

    /**
     * 返回上一步 INSERT 查询中产生的 AUTO_INCREMENT 的 ID 号；
     * 或者 返回 update 语句中 last_insert_id()函数中表达式的值。
     *
     * ！！请记住，一定紧接在insert 或 update 语句后执行该方法，否则$this->link可能已经指向别的服务器了
     *
     * @return int | NULL >0：成功取到；0：没取到；NULL：$this->link无效
     */
    public function insertId() {
        return mysqli_insert_id($this->link);
    }

    /**
     * $this->insertId() 的别名
     * ！！请记住，一定紧接在insert 或 update 语句后执行该方法，否则$this->link可能已经指向别的服务器了
     * @return int | NULL >0：成功取到；0：没取到；NULL：$this->link无效
     */
    public function getLastInsertId() {
    	return $this->insertId();
    }

    /**
     * 返回最近一次 INSERT，UPDATE 或 DELETE 查询所影响的记录行数。
     * @return int | null 返回值 >= 0：成功；等于 -1：最后一条查询错误；null：$this->link无效
     **/
    public function affectedRows()
    {
        return mysqli_affected_rows($this->link);
    }

    public function fetch($query, $resulttype = MYSQLI_ASSOC) {
        return mysqli_fetch_array($query, $resulttype);
    }

    protected function freeResult($query) {
        return mysqli_free_result($query);
    }

    /**
     * 生成唯一的字符串作为事务的唯一id
     *
     * @return String
     */
    static private function getUniqueTransactionId() {
        return self::getUniqueId('TAId');
    }

    /**
     * 生成唯一的字符串作为保存当前主服务器状态的唯一id
     *
     * @return String
     */
    static private function getUniqueMasterStatusId() {
        return self::getUniqueId('MSId');
    }

    /**
     * 生成唯一id
     *
     * @param String $prefix
     * @return String
     */
    static private function getUniqueId($prefix = '') {
        if(!is_string($prefix)) {
            $prefix = '';
        }
        return uniqid($prefix . '_'.rand());
    }

    /**
     * 返回上一个错误文本，如果没有出错则返回 ''（空字符串）。
     * 如果没有指定连接资源号，则使用上一个成功打开的连接从数据库服务器提取错误信息。
     *
     * @return String
     */
    public function error() {
        return @mysqli_error($this->link);
    }

    /**
     * 返回上一个错误号
     *
     * @return int | NULL
     */
    public function errno() {
        return @mysqli_errno($this->link);
    }

    /**
     * 返回上一个连接错误
     *
     * @return String
     */
    public function connect_error() {
        return @mysqli_connect_error();
    }

    /**
     * 返回上一个连接的错误号
     *
     * @return int
     */
    public function connect_errno() {
        return @mysqli_connect_errno();
    }

    /**
     * 根据 $this->debug_level 处理一些异常情况
     * 1 直接输出错误信息并中断程序
     * 2 直接中断程序
     * 其他情况不处理错误，返回flase，修改错误代号和本函数所提供的错误信息，最后的是MySQL服务器提供的信息
     *
     * @param String $msg
     * @param String $errorcode
     * @return Array
     */
    function _halt($msg, $errorcode = '00') {
        switch ($this->debug_level) {
            case 1:
                ob_clean();
                header("HTTP/1.0 500 Server Error");
                header("Expires: ".gmdate("D, d M Y H:i:s", time())." GMT");
                header("Last-Modified: ".gmdate("D, d M Y H:i:s", time())." GMT");
                header("Cache-Control: private");
                $out = file_get_contents(ROOT_PATH . '/mysql.html');
                $out = str_replace('$the_error', $msg.'<hr />'.$this->error().' No.'.$this->errno()."<!-- {$this->last_sql} -->", $out);

//                $this->addErrorLog(null, null, $msg);

                echo $out;
                exit;
                break;
            case 2:
                ob_clean();
                header("HTTP/1.0 500 Server Error");
                header("Expires: ".gmdate("D, d M Y H:i:s", time())." GMT");
                header("Last-Modified: ".gmdate("D, d M Y H:i:s", time())." GMT");
                header("Cache-Control: private");
                echo $this->connect_error(), "<br />";
                echo $this->connect_errno(), "<br />";
                echo "{$msg}<br />";
                exit('MySQL.');
                break;
            default:
                $this->errorcode = array($errorcode, $msg.':'.$this->last_sql, $this->errno().": ".$this->error());
                return false;
                break;
        }
    }

    ########### TRANSACTION ##########
    /**
     * 开启事务
     *
     * @return false | string false：失败；string：成功返回事务标志
     */
    public function startTransaction() {
        $strTransactionId = self::getUniqueTransactionId();

        if ($this->getTransactions()) {//已存在事务
            if ($this->setSavePoint($strTransactionId)) {
            	$this->masterDBInfo['transactionIds'][$strTransactionId] = false;
                return $strTransactionId;
            }
        } else {
	        # 初次开启事务
	        if (true === $this->query('START TRANSACTION;')) {//如果没有建立到当前主服务器的连接，该操作会隐式的建立
	            $this->masterDBInfo['transactionIds'][$strTransactionId] = true;
	            return $strTransactionId;
	        }
        }

        # 开启事务失败。返回一个独特的字符串，该字符串是不可能出现在 事务id数组中的
        return false;
    }

    /**
     * 回滚父事务
     *
     * @param String $strTransactionId
     * @return Boolean
     */
    private function _rollbackRootTransaction($strTransactionId) {
        if ($this->isRootTransaction($strTransactionId)) {//父事务
            $this->masterDBInfo['transactionIds'] = null;
            $this->masterDBInfo['arrTransactionSqls'] = array();
            return $this->query('ROLLBACK;');
        }
        return false;
    }

    /**
     * 回滚子事务
     *
     * @param String $strTransactionId
     * @return Boolean
     */
    private function _rollbackSubTransaction($strTransactionId) {
        if($this->isSubTransaction($strTransactionId)) {//子事务
            $boolStatusTmp = $this->rollbackToSavePoint($strTransactionId);
            $this->releaseSavePoint($strTransactionId);
            unset($this->masterDBInfo['transactionIds'][$strTransactionId]);
            return $boolStatusTmp;
        }
        return false;
    }

    /**
     * 撤消指定事务
     *
     * @param String $strTransactionId
     * @return Bollean true:成功；false:失败
     */
    public function rollback($strTransactionId) {
        if ($this->isRootTransaction($strTransactionId)) {//父事务
            return $this->_rollbackRootTransaction($strTransactionId);
        } elseif ($this->isSubTransaction($strTransactionId)) {//子事务
            return $this->_rollbackSubTransaction($strTransactionId);
        } else {
            return false;
        }
    }

    /**
     * 提交父事务
     *
     * @param String $strTransactionId
     * @return Boolean
     */
    private function _commitRootTransaction($strTransactionId) {
        if ($this->isRootTransaction($strTransactionId)) {//父事务
            $this->masterDBInfo['transactionIds'] = null;
            $this->masterDBInfo['arrTransactionSqls'] = array();
            return $this->query('COMMIT;');
        }
        return false;
    }

    /**
     * 提交子事务
     *
     * @param String $strTransactionId
     * @return Boolean
     */
    private function _commitSubTransaction($strTransactionId) {
        if ($this->isSubTransaction($strTransactionId)) {//子事务
            $this->releaseSavePoint($strTransactionId);
            unset($this->masterDBInfo['transactionIds'][$strTransactionId]);
            return true;
        }
        return false;
    }

    /**
     * 提交指定事务
     *
     * @param String $strTransactionId
     * @return Boolean true:成功；false:失败
     */
    public function commit($strTransactionId) {
        if ($this->isRootTransaction($strTransactionId)) {//父事务
            return $this->_commitRootTransaction($strTransactionId);
        } elseif ($this->isSubTransaction($strTransactionId)) {//子事务
            return $this->_commitSubTransaction($strTransactionId);
        } else {
            return false;
        }
    }

    /**
     * 设置子事务的保存点，用于支持子事务的回滚
     *
     * @param String $SPId 应该被传递的值是事务的唯一id，即调用self::getUniqueTransactionId()生成的
     * @return Boolean  true:成功；false:失败
     */
    private function setSavePoint($SPId) {
        if (true === $this->query("SAVEPOINT {$SPId}")) {
            return true;
        }

        return false;
    }

    /**
     * 获取指定事务的类型（父事务 还是 子事务）
     * 只有当前集群中主服务器的连接是可用的，才有事务可言
     *
     * @param String $strTransactionId
     * @return Boolean | null true：父事务；false：子事务；null：无效
     */
    private function getTransactionTypeById($strTransactionId) {
        if ($this->getCurrentMasterLink()) {
            if (isset($this->masterDBInfo['transactionIds'][$strTransactionId])) {
                return $this->masterDBInfo['transactionIds'][$strTransactionId];
            }
        }

        return null;
    }

    /**
     * 是否父事务
     *
     * @param String $strTransactionId
     * @return Boolean      true：是；false：否
     */
    private function isRootTransaction($strTransactionId) {
        if (true === $this->getTransactionTypeById($strTransactionId)) {
            return true;
        }
        return false;
    }

    /**
     * 是否子事务
     *
     * @param String $strTransactionId
     * @return Boolean      true：是；false：否
     */
    private function isSubTransaction($strTransactionId) {
        if (false === $this->getTransactionTypeById($strTransactionId)) {
            return true;
        }
        return false;
    }

    /**
     * 回滚到指定事务点
     *
     * @param String $SPId
     * @return Boolean  true:成功；false:失败
     */
    private function rollbackToSavePoint($SPId) {
        # 只对子事务的回滚点操作
        if ($this->isSubTransaction($SPId)) {
            if (true === $this->query("ROLLBACK TO SAVEPOINT {$SPId}")) {
                return true;
            }
        }
        return false;
    }

    /**
     * 释放事务保存点
     *
     * @param String $SPId
     * @return Boolean  true:成功；false:失败
     */
    private function releaseSavePoint($SPId) {
        # 只对子事务的回滚点操作
        if ($this->isSubTransaction($SPId)) {
            if (true === $this->query("RELEASE SAVEPOINT {$SPId}")) {
                return true;
            }
        }
        return false;
    }
}
