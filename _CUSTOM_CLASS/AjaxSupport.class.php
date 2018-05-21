<?php
/**
 * Ajax 支持类
 * @author gaoxiaogang@gmail.com
 *
 */
class AjaxSupport {
    /**
     * 对ajax提交上来的请求信息解析后的数组
     * @var array
     */
    protected $request;

    public function __construct() {
        if(!isset($_REQUEST['request'])) {
            $this->request = null;
        } else {
            $tmp = stripslashes($_REQUEST['request']);
            $tmp = json_decode($tmp, true);
            if(!is_array($tmp)) {
                $this->request = false;
            } else {
                $this->request = $tmp;
            }
        }
    }

    /**
     * 获取ajax请求的数据
     * @return null | false | array null：未请求；false：解析请求格式失败；array：解析后的请求数据
     */
    public function getReqVal($key = null, $default = null) {
        if(is_null($key)) {
            return $this->request;
        }

        if(!isset($this->request[$key])) {
            return $default;
        }
        return $this->request[$key];
    }

    /**
     * 输出Ajax错误响应
     * @param string $errmsg 错误消息文本
     * @return string json_encode对数组编码后的字符串
     */
    public function responseError($errmsg) {
        $response = array();
        $response['message'] = array(
            'content'   => $errmsg,
            'type'      => 'error',
        );
        $response['status']['ok'] = 0;
        echo json_encode($response);
        exit;
    }

    /**
     * 输出Ajax正确响应
     * @param string $successMsg 正确消息文本
     * @param array $result 需要输出的结果
     */
    public function responseSuccess($successMsg = null, array $result = null) {
        $response = array();
        if($result) {
            if(array_key_exists('status', $result)) {
                unset($result['status']);
            }
            if(array_key_exists('message', $result)) {
                unset($result['message']);
            }
            foreach ($result as $tmpK => $tmpV) {
                $response[$tmpK] = $tmpV;
            }
        }
        $response['status']['ok'] = 1;
        if(isset($successMsg)) $response['message'] = array(
            array(
                'content'   => $successMsg,
                'type'      => 'success',
            ),
        );
        echo json_encode($response);
        exit;
    }
}