<?php
/**
 * 出票公司
 */
class TicketCompany {
	
	/**
	 * 华阳创美 
	 */
	CONST COMPANY_HUAYANG = 1;
	
	/**
	 * 尊傲
	 */
	CONST COMPANY_ZUNAO = 2;
	
	/**
	 * 人工出票
	 */
	CONST COMPANY_MANUAL = 3;
	
	/**
	 * 聚宝科技
	 */
	CONST COMPANY_ZHIYING = 4;
	
	static public function getTicketCompany() {
		return array(
				self::COMPANY_HUAYANG	=> array(
					'desc'	=> '华阳',
					'kw'	=> 'COMPANY_HUAYANG',
				),
				self::COMPANY_ZUNAO		=> array(
					'desc'	=> '尊傲',
					'kw'	=> 'COMPANY_ZUNAO',
				),
				self::COMPANY_MANUAL	=> array(
						'desc'	=> '人工出票',
						'kw'	=> 'COMPANY_MANUAL',
				),
				self::COMPANY_ZHIYING	=> array(
						'desc'	=> '聚宝',
						'kw'	=> 'COMPANY_ZHIYING',
				),
			);
	}
}