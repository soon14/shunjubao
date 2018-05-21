<?php
/**
 * 所有sphinx搜索类的公共类
 * 把一些公共的地方统一放这
 * @author gaoxiaogang@gmail.com
 *
 */
abstract class CommonSphinx {
	/**
     * 保存全文检索的实例
     * @var SphinxClient
     */
    protected $objSphinxClient;

    /**
     * 获取最后查询的错误
     */
    public function getLastError() {
        return $this->objSphinxClient->GetLastError();
    }

    /**
     *
     * @param string $queryString 待构造关键词
     * @param string $index 哪个索引。只能是一个
     * @param boolean $hits 结果里是否显示 关键词命中文档数和命中次数信息
     */
    public function buildKeywords($queryString, $index="main", $hits = false) {
    	if (is_null($index)) {
    		$index = 'main';
    	}
    	$begin_microtime = Debug::getTime();

		$result = $this->objSphinxClient->BuildKeywords($queryString, $index, $hits);

		Debug::sphinx((array) $this->objSphinxClient, Debug::getTime() - $begin_microtime, $result, 'buildKeywords');

		return $result;
    }

    /**
     *
     * @param array $attrs 格式：array(
     *     (string),//属性名
     *     ...
     * );
     * @param array $vals 格式：array(
     *     (int) docId => array(
     *         (val),//与$attrs中一一对应的属性值
     *     ),
     *     ...
     * );
     * @param string $indexs 索引
     * @return false | -1 | int(>=0) false：参数错误；-1：更新失败；int：更新到的条数
     */
    public function update(array $attrs, array $vals, $indexs = 'main, delta') {
        if (empty($attrs)) {
            return false;
        }

        if (empty($vals)) {
            return false;
        }
        return $this->objSphinxClient->UpdateAttributes($indexs, $attrs, $vals);
    }

    /**
     * 设置匹配的记录范围
     * @param mixed $limit 与mysql的limit语法一致
     * @param int $max_matches 设置单个查询在搜索过程中，searchd在内存所保存的最优的匹配项数目
     * @param int $cutoff
     */
    public function setLimit($limit, $max_matches = null, $cutoff = null) {
        if (!isset($limit)) {
			throw new Exception('请设置$limit参数');
        }

        # 解析 $limit
    	if (!preg_match('#^(?:(\d+)\s*,\s*)?(\d+)$#', $limit, $tmp_matches)) {
            throw new Exception('无效的$limit参数');
        }
        if (empty($tmp_matches[1])) {
        	$offset = 0;
        } else {
        	$offset = (int) $tmp_matches[1];
        }
        $length = (int) $tmp_matches[2];

        /**
         * 设置单个查询在搜索过程中，searchd在内存所保存的最优的匹配项数目
         * 经过试验，发现该值对分页有影响。当值为2000时，如果$limit设为"2000, 20"时，不会返回任何结果。因为内存中只有2000条信息驻留。
         * sphinx中，如果不指定该指，默认为1000
         * @var int
         */
        if(isset($max_matches)) {
            if(!isInt($max_matches)  || $max_matches < 1) {
                throw new Exception('$max_matches 参数必须是大于0的正整数！');
            }
        } else {
            $max_matches = 10000;//没有设置时，1000为默认值
        }

        if($max_matches > 10000) $max_matches = 10000;//因为配置文件里每查询允许最大的匹配 数是10000，所以超过该数的，全部置为10000

        # 该参数为高级性能优化而设置。它告诉searchd在找到并处理$cutoff个匹配后就强制停止。
        if(isset($cutoff)) {
            if(!isInt($cutoff)  || $cutoff < 1) {
                throw new Exception('$cutoff 参数必须是大于0的正整数！');
            }
        } else {
            $cutoff = 0;//0表示不设置
        }

        $this->objSphinxClient->SetLimits($offset, $length, $max_matches, $cutoff);
    }

	/**
	 *
	 * 搜索
	 * @param string $query
	 * @param string $index
	 * @param string $comment
	 * @return false | array
	 */
	public function search($query = '', $index = "*", $comment = "") {
		$begin_microtime = Debug::getTime();

		if(!empty($query) && !$this->objSphinxClient->_sortby) {
			$this->objSphinxClient->SetSortMode(SPH_SORT_EXTENDED, "@relevance DESC");
		}
		
		$result = $this->objSphinxClient->Query($query ,$index, $comment);

		Debug::sphinx((array) $this->objSphinxClient, Debug::getTime() - $begin_microtime, $result, 'query');

		if($this->objSphinxClient->GetLastError()) {
			return false;//有错误发生
		}
		return $result;
	}

	/**
	 *
	 * 添加子查询
	 * @param string $query
	 * @param string $index
	 * @param string $comment
	 */
	public function addQuery($query = '', $index = "*", $comment = "") {
		if(!empty($query) && !$this->objSphinxClient->_sortby) {
			$this->objSphinxClient->SetSortMode(SPH_SORT_EXTENDED, "@relevance DESC");
		}
		$this->objSphinxClient->AddQuery($query, $index, $comment);
	}

	/**
	 *
	 * 在子查询基础上，执行批量查询
	 * @return array
	 */
	public function runQueries() {
		$begin_microtime = Debug::getTime();

		$result = $this->objSphinxClient->RunQueries();

		Debug::sphinx((array) $this->objSphinxClient, Debug::getTime() - $begin_microtime, $result, 'batch_query');

		return $result;
	}

	/**
	 *
	 * 清除之前的过滤规则
	 * @return true
	 */
	public function resetFilters() {
		$this->objSphinxClient->ResetFilters();
		return true;
	}
}