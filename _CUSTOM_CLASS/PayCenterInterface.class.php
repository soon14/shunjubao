<?php
/**
 * 支付中心接口
 * @author gaoxiaogang@gmail.com
 *
 */
Interface PayCenterInterface {
	public function __construct(array $config);
	
	/**
     * 获取支付表单数组信息
     * 这些信息返回给调用方，供生成提交表单
     * @param array $params
     * @return array 返回值格式：array(
     *     'action'    => (string)//作为html form元素的action属性值
     *     'params'      => (array)//处理后的支付有关的参数集
     * );
     */
	public function getPayFormArray(array $params);
	
	/**
     * 验证通知的有效性
     * @param array $request_params 请求的参数
     * @return InternalResultTransfer 失败：返回数据是String型描述；成功：格式为 array(
     *     'total_fee' => (int),//交易金额，单位分
     *     'inner_out_trade_no'  => (string),//平台传给财付通的交易号
     *     'trade_status' => (string),//本次通知的交易状态
     * );
     */
	public function verify_notify(array $request_params);
	
	/**
	 * 给支付商确认本次通知成功
	 */
	public function response_notify_success();
	
	/**
	 * 
	 * @param array $params 
	 * @return InternalResultTransfer
	 */
	public function closeTrade(array $params);
}