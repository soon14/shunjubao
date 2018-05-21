<?php
/**
 * 封装了一些方法，用于方便的处理从客户端提交过来的数据
 * @author gaoxiaogang@gmail.com
 */
class Request {
	/**
	 * 获取ip地址
	 *
	 * @return string ip地址：如 59.151.9.90
	 */
    public function getIpAddress() {
        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            } else {
                $realip = $_SERVER['REMOTE_ADDR'];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")) {
                $realip = getenv("HTTP_X_FORWARDED_FOR");
            } elseif (getenv("HTTP_CLIENT_IP")) {
                $realip = getenv("HTTP_CLIENT_IP");
            } else {
                $realip = getenv("REMOTE_ADDR");
            }
        }
        $realip = preg_replace('#,.*$#', '', $realip);
        $realip = preg_replace('#[^\d\.]+#', '', $realip);// 从支付平台发现，有时会获取到这种ip，%20%2058.255.8.39，说明前面有有空格，处理一下
        return $realip;
    }

    /**
     * 从 REQUEST_URI 字段获取请求路径
     * 如：/article/index.php?id=857&action=show 会被处理成：article/index.php
     *
     * @param string | null $request_uri
     * @return string
     */
    public function getRequestPath($request_uri = null) {
    	if (is_null($request_uri)) {
            $request_uri = $_SERVER['REQUEST_URI'];
        }

        if (($iPos = strpos($request_uri, '?')) !== false) {
            $request_uri = substr($request_uri, 0, $iPos);
        }
        $request_uri = str_replace(' ', '/', trim(str_replace('/', ' ', $request_uri)));
        $request_uri = urldecode($request_uri);

        return $request_uri;
    }

    /**
     *
     * 获取当前请求的url
     */
    public function getCurUrl() {
    	$port = $_SERVER['SERVER_PORT'] == '80' ? '' : "{$_SERVER['SERVER_PORT']}:";
    	$url = "http://{$_SERVER['HTTP_HOST']}{$port}{$_SERVER['REQUEST_URI']}";
    	return $url;
    }

    /**
     * 获取请求url中的查询字符串
     *
     * @return string
     */
    public function getQueryString() {
    	return $_SERVER['QUERY_STRING'];
    }

    /**
     *
     * 获取请求的referer
     * @return string
     */
    public function getReferer() {
    	return $_SERVER['HTTP_REFERER'];
    }

    /**
     * 是否POST请求
     *
     * @return boolean
     */
    public function isPost() {
    	return strtoupper($_SERVER['REQUEST_METHOD']) == 'POST';
    }

    /**
     * 是否GET请求
     *
     * @return boolean
     */
    public function isGet() {
    	return strtoupper($_SERVER['REQUEST_METHOD']) == 'GET';
    }

    /**
     * 该请求是否由 蜘蛛 发出
     *
     * @return boolean
     */
    public function isSpider() {
        if (Runtime::isCLI()) {
            return false;
        }
        if (!isset($_SERVER['HTTP_USER_AGENT'])) {
            return false;
        }
        $bots = array(
            'Googebot', 'Baiduspider', 'Yahoo! Slurp', 'Sosospider', 'Sogou', 'Sogou-Test-Spider',
            'Sogou head spider', 'YoudaoBot', 'qihoobot', 'iaskspider', 'LeapTag', 'MSIECrawler'
        );
        foreach ($bots as $bot) {
            if (strpos($_SERVER['HTTP_USER_AGENT'], $bot) !== false) {
                return true;
            }
        }
        if (stristr($_SERVER['HTTP_USER_AGENT'], 'Windows') !== false) {
            return false;
        }
        $bots = array(
            'spider', 'bit', 'crawler', 'slurp', 'subscriber', 'http',
            'rssreader', 'blogline', 'greatnews', 'feed', 'alexa', 'php'
        );
        foreach ($bots as $bot) {
            if (stristr($_SERVER['HTTP_USER_AGENT'], $bot) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * 该请求是否从相同的主机过来，即来源页是否与当前页处于相同域下
     *
     * @return boolean
     */
    public function isFromSameHost() {
        if (!isset($_SERVER['HTTP_REFERER'])) {
            return true;
        }
        $url_parts = parse_url($_SERVER['HTTP_REFERER']);
        $host = $url_parts['host'];
        if ($_SERVER['HTTP_HOST'] == $host) {
        	return true;
        }
        return false;
    }

    /**
     * 从请求的 $_GET 变量里获取 变量的整数值，如果不存在该变量或不为整数，则返回 $default 值
     * @param string $varName 变量名
     * @param int $default 默认值
     * @return int
     */
    public function varGetInt($varName, $default = 0) {
    	if (!isset($_GET[$varName])) {
    		return $default;
    	}

    	if (!Verify::unsignedInt($_GET[$varName])) {
    		return $default;
    	}

    	return $_GET[$varName];
    }

    /**
     * 从请求的 $_POST 变量里获取 变量的整数值，如果不存在该变量或不为整数，则返回 $default 值
     * @param string $varName 变量名
     * @param int $default 默认值
     * @return int
     */
    public function varPostInt($varName, $default = 0) {
    	if (!isset($_POST[$varName])) {
            return $default;
        }

        if (!Verify::unsignedInt($_POST[$varName])) {
            return $default;
        }

        return $_POST[$varName];
    }

    /**
     * 从请求的 $_POST 变量里获取 变量的整数值，如果不存在该变量或不为整数，则返回 $default 值
     * @param string $varName 变量名
     * @param int $default 默认值
     * @return int
     */
    public function varRequestInt($varName, $default = 0) {
        if (!isset($_REQUEST[$varName])) {
            return $default;
        }

        if (!Verify::unsignedInt($_REQUEST[$varName])) {
            return $default;
        }

        return $_REQUEST[$varName];
    }

	/**
	 * 获取请求的参数集。依赖 REQUEST_METHOD 做判断
	 * @return array
	 */
	public function getRequestParams() {
	    $params = array();
	    if (self::isPost()) {
	        $params = $_POST;
	        if (!$params) {
	            $params = $_GET;
	        }
	    } else if (self::isGet()) {
	        $params = $_GET;
	    } else {
	        throw new Exception('NOT_SUPPORT_REQUEST_METHOD');
	    }
	    return $params;
	}

	/**
	 *
	 * 获取 $_GET 里指定key $name 的值，同时可以指定 $filters 过滤方法处理值
	 *
	 * 用法：
	 * 1、对值不做任何处理：Request::get('content', null);
	 * 2、对值做html转义处理：Request::get('name');
	 *
	 * @param string $name
	 * @param mixed $filters 默认使用html转义过滤。当值为null里，对值不做任何过滤。
	 * $filters支持以下格式：
	 * 1) 标量类型，如：
	 *    Filter::HTMLSPECIALCHARS;
	 * 2) 多个filter，如：
	 *    array(
	 *        Filter::HTMLSPECIALCHARS,
	 *        Filter::STRIP_TAGS,
	 *    );
	 * 3) 多个filter，并且某些filter另外指定参数，如：
	 *    array(
	 *        array(
	 *            Filter::HTMLSPECIALCHARS	=> ENT_QUOTES,
	 *        ),
	 *        array(
	 *            Filter::STRIP_TAGS	=> "<a>",
	 *        ),
	 *        Filter::STRIP_SELECTED_TAGS,
	 *    );
	 *
	 * @throws ParamsException "无效的过滤方法filter"
	 * @return string
	 */
	static public function get($name, $filters = array(Filter::HTMLSPECIALCHARS, Filter::TRIM)) {
		if (!isset($_GET[$name])) {
			return false;
		}

		$val = $_GET[$name];

		if (is_null($filters)) {
			return $val;
		}

		if (!is_array($filters)) {
			$filters = array($filters);
		}

		return self::filter($val, $filters);
	}

	/**
	 *
	 * get的别名方法
	 * @param string $name
	 * @param mixed $filters 默认使用html转义过滤。当值为null里，对值不做任何过滤。
	 * @throws ParamsException "无效的过滤方法filter"
	 * @return string
	 */
	static public function g($name, $filters = array(Filter::HTMLSPECIALCHARS, Filter::TRIM)) {
		return self::get($name, $filters);
	}

	/**
	 *
	 * 获取 $_POST 里指定key $name 的值，同时可以指定 $filters 过滤方法处理值
	 *
	 * 用法：
	 * 1、对值不做任何处理：Request::post('content', null);
	 * 2、对值做html转义处理：Request::post('name');
	 *
	 * @param string $name
	 * @param mixed $filters 默认使用html转义过滤。当值为null里，对值不做任何过滤。
	 * @throws ParamsException "无效的过滤方法filter"
	 * @return string
	 */
	static public function post($name, $filters = array(Filter::HTMLSPECIALCHARS, Filter::TRIM)) {
		if (!isset($_POST[$name])) {
			return false;
		}

		$val = $_POST[$name];

		if (is_null($filters)) {
			return $val;
		}

		if (!is_array($filters)) {
			$filters = array($filters);
		}

		return self::filter($val, $filters);
	}

	/**
	 *
	 * post的别名方法
	 * @param string $name
	 * @param mixed $filters 默认使用html转义过滤。当值为null里，对值不做任何过滤。
	 * @throws ParamsException "无效的过滤方法filter"
	 * @return string
	 */
	static public function p($name, $filters = array(Filter::HTMLSPECIALCHARS, Filter::TRIM)) {
		return self::post($name, $filters);
	}

	/**
	 *
	 * 获取 $_REQUEST 里指定key $name 的值，同时可以指定 $filters 过滤方法处理值
	 * !! 因为与类同名的方法会被认为是构造函数，所以这个方法名加个小字符 !!
	 *
	 * 用法：
	 * 1、对值不做任何处理：Request::requestV('content', null);
	 * 2、对值做html转义处理：Request::requestV('name');
	 *
	 * @param string $name
	 * @param mixed $filters 默认使用html转义过滤。当值为null里，对值不做任何过滤。
	 * @throws ParamsException "无效的过滤方法filter"
	 * @return string
	 */
	static public function requestV($name, $filters = array(Filter::HTMLSPECIALCHARS, Filter::TRIM)) {
		if (!isset($_REQUEST[$name])) {
			return false;
		}

		$val = $_REQUEST[$name];

		if (is_null($filters)) {
			return $val;
		}

		if (!is_array($filters)) {
			$filters = array($filters);
		}

		return self::filter($val, $filters);
	}

	/**
	 *
	 * requestV的别名方法
	 * @param string $name
	 * @param mixed $filters 默认使用html转义过滤。当值为null里，对值不做任何过滤。
	 * @throws ParamsException "无效的过滤方法filter"
	 * @return string
	 */
	static public function r($name, $filters = array(Filter::HTMLSPECIALCHARS, Filter::TRIM)) {
		return self::requestV($name, $filters);
	}

	/**
	 *
	 * 获取 $_COOKIE 里指定key $name 的值，同时可以指定 $filters 过滤方法处理值
	 *
	 * 用法：
	 * 1、对值不做任何处理：Request::cookie('content', null);
	 * 2、对值做html转义处理：Request::cookie('name');
	 *
	 * @param string $name
	 * @param mixed $filters 默认使用html转义过滤。当值为null里，对值不做任何过滤。
	 * @throws ParamsException "无效的过滤方法filter"
	 * @return string | false
	 */
	static public function cookie($name, $filters = array(Filter::HTMLSPECIALCHARS, Filter::TRIM)) {
		if (!isset($_COOKIE[$name])) {
			return false;
		}

		$val = $_COOKIE[$name];

		if (is_null($filters)) {
			return $val;
		}

		if (!is_array($filters)) {
			$filters = array($filters);
		}

		return self::filter($val, $filters);
	}

	/**
	 *
	 * cookie的别名方法
	 * @param string $name
	 * @param mixed $filters 默认使用html转义过滤。当值为null里，对值不做任何过滤。
	 * @throws ParamsException "无效的过滤方法filter"
	 * @return string | false
	 */
	static public function c($name, $filters = array(Filter::HTMLSPECIALCHARS, Filter::TRIM)) {
		return self::cookie($name, $filters);
	}

	/**
	 *
	 * 使用用户指定的 过滤方法，过滤值 $val
	 * @param string $val
	 * @param array $filters 过滤方法相关信息
	 * @throws ParamsException "无效的过滤方法filter"
	 * @return string
	 */
	static private function filter($val, array $filters) {
		foreach ($filters as $filter) {
			$params = array($val);
			if (is_array($filter)) {
				list($filter_name, $filter_options) = each($filter);
			} else {
				$filter_name = $filter;
				$filter_options = null;
			}
			if (!Filter::isValid($filter_name)) {
				throw new ParamsException("无效的过滤方法filter");
			}
			$val = call_user_func(array('Filter', $filter_name), $val, $filter_options);
		}

		return $val;
	}

	/**
     * 是否处于命令行下
     * @return Boolean
     */
    static public function isCLI() {
        if (php_sapi_name() == "cli"//PHP 4 >= 4.0.1, PHP 5 support php_sapi_name function
            || empty($_SERVER['PHP_SELF'])//If PHP is running as a command-line processor this variable contains the script name since PHP 4.3.0. Previously it was not available.
        ) {
            return true;
        } else {
            return false;
        }
    }
}