<?php
class Route {

	/**
	 *
	 * 模式类别是之：正则
	 * @var string
	 */
	const PATTERN_TYPE_REGULAR	= 'regular';

    /**
     * 解析rewrite规则
     * @author gaoxiaogang@gmail.com
     * @return rewrite解析后对应的是静态文件，则返回null；否则返回动态php文件的路径
     */
    static public function rewrite($uri = null) {
        if (is_null($uri)) {
            $uri = $_SERVER['REQUEST_URI'];
        }

        if(($iPos = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $iPos);
        }
        $uri = str_replace(' ', '/', trim(str_replace('/', ' ', $uri)));
        $uri = urldecode($uri);

        $route_conf = include ROOT_PATH . '/include/route.php';
        do {
        	$tmpHasMatch = false;// 标准是否匹配到了

        	#####################################
        	#### 先判断是否简单路由配置 #########
	        if (isset($route_conf['normal'][$uri])) {
	        	$tmpHasMatch = true;

	        	$tmpInfo = $route_conf['normal'][$uri];
            	$filename = ROOT_PATH . DIRECTORY_SEPARATOR . $tmpInfo['file'];

            	if (isset($tmpInfo['callback'])) {
            		$tmpInfo['callback'](null);
            	}
                break;
	        }
	        #####################################

	        #####################################
	        #### 简单路由没有匹配到，通过正则路由配置
        	foreach ($route_conf['regular'] as $tmpPattern => $tmpV) {
	        	if (preg_match($tmpPattern, $uri, $match)) {
	        		$tmpHasMatch = true;
	            	$filename = ROOT_PATH . DIRECTORY_SEPARATOR . $tmpV['file'];

	        		if (isset($tmpV['callback'])) {
	            		$tmpV['callback']($match);
	            	}
	                break;
	            }
        	}
	        #####################################
        } while (false);

        if (!$tmpHasMatch) {
        	# 其他情况
            $filename = self::output($uri);
        }
        return $filename;
    }

    /**
     * 如果$path对应的是动态文件，则返回该文件名；如果是静态资源，则直接加载，返回null
     * @author gaoxiaogang@gmail.com
     * @param string $path
     * @return string | null
     */
    static private function output($path) {
    	$path = ROOT_PATH . DIRECTORY_SEPARATOR . $path;
        if (!file_exists($path)) {
            return self::output_404();
        }

        if (is_dir($path)) {
            $has_default_file = false;
            foreach (array('index.html', 'index.shtml', 'index.php') as $default) {
                $tmp_filename = $path . '/' . $default;
                if (file_exists($tmp_filename)) {
                    $path = $tmp_filename;
                    $has_default_file = true;
                    break;
                }
            }
            if (!$has_default_file) {
                return self::output_404();
            }
        }

        if (is_file($path)) {
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if ($ext == 'php') {
                return $path;
            } else {
                echo file_get_contents($path);
                return null;
            }
        }
    }

    /**
     * 输出404页面
     */
    static private function output_404() {
    	output_404();
    }
}
