<?php
header("Content-type: text/html; charset=utf-8");
/**
 *功能：配置文件
 *版本：1.0
 *修改日期：2016-06-08
 '说明：
 '以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己的需要，按照技术文档编写,并非一定要使用该代码。
 '该代码仅供学习和研究派洛贝云计费接口使用，只是提供一个参考。
 */

final class pp_conf{
	// 商户在派洛贝的商户ID,
const APP_ID = 'aa10015db2dd430b';
const PP_MD5_KEY = '0e29fd72c1809f89c026cdf6f15847ed';

const PP_CREATE_ORDER_URL = 'https://api.peralppay.com/api/v1/create_order' ;
const PP_PAY_EXCHANGE_URL = 'https://api.peralppay.com/api/v1/pay_exchange' ;
const PP_QUERY_ORDER_URL = 'https://api.peralppay.com/api/v1/query_order' ;
const PP_QUERY_REFUND_URL = 'https://api.peralppay.com/api/v1/query_refund' ;
const PP_REFUND_ORDER_URL = 'https://api.peralppay.com/api/v1/refund_order' ;
const PP_DOWNLOAD_BILL_URL = 'https://api.peralppay.com/api/v1/download_bill' ;

// 私钥
const PP_APP_KEY =<<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQC1cUTz2cNx91dK7tTSj1GAXXn5gjuMAiN9HBWSBG6gn/U/M1D0
bp+l3OguVi8RdANV/CCYTHOs6BabokqUXJQ8z85lXYJBKyPWJ9gzE4m3FJJoBtJm
Yj3Djcf27YaxCgTDDNbyjWuA06kHsTOadCD1eyhF5G1+T2i8liGxjRsLRQIDAQAB
AoGAZ9kqw/8RdDtDBSppORK6bSQTWhGGD35x3XujhO1wfBLRhZjTbvOaAI7NfSfq
zKx/9EjYRxMK6h30QqPC1+OdG7JyNVxwt13d9z1G+6e5hzmK+dp2JqVbUClNPom1
rlXMsU2yTK5WRLFjFTvhl6MhCGHDcOYEGUrBCH6y/MXW54kCQQDdITKC+mEMOj7a
/O29wsZX7c4XtjN1kG4odHHowdmpkNUe0ZsQWPqHc9xC3BDhMskMPuqvh/Qeup3/
rTj2wbXHAkEA0g3vcnALX2XuotkbmmZSRTFxZfU/sLpYU4f2e2Wbas5S5NZbX9eG
CmrueoMHUtqoaHFbeDzHm6MOAVJrLXsGkwJBANpxofl7qAUxQMiKFb1gvRk9pVsN
NZaMwBWcuq5JWWFF3xMb0wf6LjtC/DLcPJyK08sSGDqgnksA5XYew+gXgh8CQE27
5HnoJv1F3psbV1C7PwTmOD3wFYLUYy1+amPeBTbwZdLT1PrR6oPecKSb6tDppFsK
YDxN2dyp6dvpYUpydcsCQQCf5YO+I3QyiuoP7aITk4I25syFE/rG4Lhb6A/Yv/qc
65D6gtsKf3A47J3lg2I2M648iHaFVSx/yuD2/KvJA95S
-----END RSA PRIVATE KEY-----
EOD;

// 公钥
const PP_PLATE_KEY =<<<EOD
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC1cUTz2cNx91dK7tTSj1GAXXn5
gjuMAiN9HBWSBG6gn/U/M1D0bp+l3OguVi8RdANV/CCYTHOs6BabokqUXJQ8z85l
XYJBKyPWJ9gzE4m3FJJoBtJmYj3Djcf27YaxCgTDDNbyjWuA06kHsTOadCD1eyhF
5G1+T2i8liGxjRsLRQIDAQAB
-----END PUBLIC KEY-----
EOD;


}

?>