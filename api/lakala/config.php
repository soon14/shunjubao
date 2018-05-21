<?php
/**
 * 拉卡拉支付 配置信息
 * @author lishuming@gaojie100.com
 */

/**
 * MACKEY 双方约定的值
 */
define(MACKEY, 'GRE567OKYTREW349IJKMMNH');

/**
 * 拉卡拉固定账单号
 */
define(FIXEDBILL, 312976);

/**
 * 商户号
 */ 
define(MERID, '3G050000801');

/**
 * 通知支付中心地址
 */
define(PAYCENTER_NOTIFY_URL, "http://paycenter.gaojie.com/provider/notify/lakala");

/**
 * 退款请求地址
 */
define(REFUND_URL, "http://pgs.lakala.com.cn/MerchantGateway/billRefound");