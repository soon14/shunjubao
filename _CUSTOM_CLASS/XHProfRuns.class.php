<?php
class XHProfRuns {
	/**
	 * @var XHProfLogs
	 */
	protected $objXHProfLogs;

	public function __construct() {
        $this->objXHProfLogs = new XHProfLogs();
	}

	/**
	 * 触发记录
	 * @param int $namespaceId
	 */
	static public function trigger($namespaceId) {
		if (isset($_REQUEST['xhprof']) && $_REQUEST['xhprof'] == 1) {
			if (function_exists('xhprof_enable')) {
				xhprof_enable(XHPROF_FLAGS_MEMORY);
                register_shutdown_function(array('XHProfRuns', 'complete'), $namespaceId);
			}
		}
	}

    public function get_run($run_id, $namespaceId, &$run_desc) {
    	if (!SqlHelper::isValidPK($run_id)) {
    		return false;
    	}

        $profLogs = $this->objXHProfLogs->get($run_id);
        if (!$profLogs) {
        	return false;
        }

        $data = $profLogs['data'];

        return unserialize($data);
    }

    public function save_run($namespaceId, array $xhprof_data, array $context) {
    	$tableInfo = array(
    	    'namespace' => $namespaceId,
    	    'data'     => serialize($xhprof_data),
    	    'context'  => serialize($context),
    	    'created'  => time(),
    	    'alive_ts' => $xhprof_data['main()']['wt'],
    	);
        return $this->objXHProfLogs->create($tableInfo);
    }

    /**
     * 从$xhprof_data数据里，分析出执行最慢的函数
     * 注：$xhprof_data是由xhprof_disable函数产生的数据
     * @param array $xhprof_data
     * @return string $slowest_func 函数名，如：mysql_query、echo_exit、curl_exec等
     */
    public function getSlowestFunc($xhprof_data) {
    	$slowest_func = null;//最慢的函数

        # 判断是哪个函数导致慢的
        $xhprof_lib_file = $GLOBALS['XHPROF_LIB_ROOT'] . '/utils/xhprof_lib.php';
        if (file_exists($xhprof_lib_file)) {
            include_once $xhprof_lib_file;
            $tmp_totals = array();
            $detail_xhprof_data = xhprof_compute_flat_info($xhprof_data, $tmp_totals);
            $excl_wts = array();
            foreach ($detail_xhprof_data as $tmpK => $tmpV) {
                $excl_wts[$tmpK] = $tmpV['excl_wt'];
            }
            array_multisort($excl_wts, SORT_DESC, $detail_xhprof_data);
            list($slowest_func) = each($detail_xhprof_data);
        }
        ########################

        return $slowest_func;
    }

    static public function complete($namespaceId) {
    	$tmp_current_url = Request::getCurUrl();
		$tmp_context = array(
		    'url' => $tmp_current_url,
		    'uid' => Runtime::getUid(),
		    'uname' => Runtime::getUname(),
		    'ts'    => time(),
		    'client_ip' => getClientIp(),
		    'get'     => $_GET,
		    'post'    => $_POST,
		);

		$xhprof_data = xhprof_disable();
		$alive_ts = $xhprof_data['main()']['wt'];
		if ($alive_ts >= 1000000) {//总运行时间超过1秒，才记录
			$objXHProfRuns = new self();
            $objXHProfRuns->save_run($namespaceId, $xhprof_data, $tmp_context);
		}
    }
}