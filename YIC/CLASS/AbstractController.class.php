<?php
abstract class AbstractController {
    /**
     *
     * @var Template
     */
    protected $tpl;
    
    protected $charset = 'utf-8';
	protected $contentType = 'text/html';

	public function __construct() {
		header("Vary: Accept-Encoding");
        header("Content-Type: {$this->contentType}; charset={$this->charset}");
        
        $this->tpl = new Template();
	}
    
    public function run($action) {
    	global $TEMPLATE;
    	# 将action导出到模板
    	$TEMPLATE['action'] = $action;
    	
        $action = 'action' . ucfirst($action);
        if (!method_exists($this, $action)) {
        	throw new Exception('不存在的动作：'. $action);
        }
        return $this->$action();
    }
    
	protected function getPostReq($key, $default = null) {
        do {
            if(!isset($_POST[$key])) break;
            $val = trim($_POST[$key]);
            if(empty($val)) break;
            return $val;
        } while(false);

        if(isset($default)) return $default;
        return false;
    }

    protected function getGetReq($key, $default = null) {
        do {
            if(!isset($_GET[$key])) break;
            $val = trim($_GET[$key]);
            if(empty($val)) break;
            return $val;
        } while(false);

        if(isset($default)) return $default;
        return false;
    }
    
	/**
     * 将用于表单元素的数组格式转换
     *
     * @param array $arr
     */
    protected function convertToTemplateFormat(array & $arr) {
        foreach($arr as $key => $val) {
            $arr[$key] = array('val' => $val);
        }
    }

    protected static function setFormVal($formName, & $arrFormInfo, $val = null) {
        if(!isset($val)) {
            $val = trim($_POST[$formName]);
        }
        return $arrFormInfo[$formName]['val'] = $val;
    }

    protected static function setFormMsg($formName, $msg, & $arrFormInfo) {
        return $arrFormInfo[$formName]['msg'] = $msg;
    }
}