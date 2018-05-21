<?php
/**
 * 华阳各类配置信息
 */
return array(
	//玩法
	'lottery'	=> array(
		//传统足彩
		108	=> array(
			'code'	=> '108',
			'desc'	=> '14胜负彩'
		),
		109	=> array(
			'code'	=> '109',
			'desc'	=> '胜负彩9场'
		),
		111	=> array(
			'code'	=> '111',
			'desc'	=> '四场进球彩'
		),
		110	=> array(
			'code'	=> '110',
			'desc'	=> '六场半全场'
		),
		
		//11选5
		112	=> array(
			'code'	=> '112',
			'desc'	=> '山东11选5'
		),
		
		//北单玩法
		200 => array(
			'code'	=> '200',
			'desc'	=> '北单胜平负'
		),
		201	=> array(
			'code'	=> '201',
			'desc'	=> '北单上下单双'
		),
		202	=> array(
			'code'	=> '202',
			'desc'	=> '北单总进球'
		),
		203=> array(
			'code'	=> '203',
			'desc'	=> '北单全场比分'
		),
		204=> array(
			'code'	=> '204',
			'desc'	=> '北单半全场',
		),
		
		//竞彩足球
		208	=> array(
			'code'	=> '208',
			'desc'	=> '竞彩足球_混合投注'
		),
		209	=> array(
			'code'	=> '209',
			'desc'	=> '竞彩足球_胜平负'
		),
		210	=> array(
			'code'	=> '210',
			'desc'	=> '竞彩足球_让球胜平负'
		),
		211	=> array(
			'code'	=> '211',
			'desc'	=> '竞彩足球_比分'
		),
		212	=> array(
			'code'	=> '212',
			'desc'	=> '竞彩足球_总进球'
		),
		213	=> array(
			'code'	=> '213',
			'desc'	=> '竞彩足球_半全场'
		),
		
		//竞彩篮球
		214	=> array(
			'code'	=> '214',
			'desc'	=> '篮彩_让分胜负'
		),
		215	=> array(
			'code'	=> '215',
			'desc'	=> '篮彩_大小分'
		),
		216	=> array(
			'code'	=> '216',
			'desc'	=> '篮彩_胜负注'
		),
		217	=> array(
			'code'	=> '217',
			'desc'	=> '篮彩_胜分差'
		),
		
		218	=> array(
			'code'	=> '218',
			'desc'	=> '篮彩_混合过关球'
		),
		
	),
	//交易类型
	'transactiontype'	=> array(
		13001	=> array(
			'code'	=> '13001',
			'desc'	=> '用户注册',
		),
		13002	=> array(
			'code'	=> '13002',
			'desc'	=> '账户余额查询',
		),
		13003	=> array(
			'code'	=> '13003',
			'desc'	=> '投注历史、中奖数据查询',
		),
		13004	=> array(
			'code'	=> '13004',
			'desc'	=> '票状态查询',
		),
		13011	=> array(
			'code'	=> '13011',
			'desc'	=> '中奖数据查询',
		),
		13013	=> array(
			'code'	=> '13013',
			'desc'	=> '查询当前期信息',
		),
		13005	=> array(
			'code'	=> '13005',
			'desc'	=> '投注',
		),
		13007	=> array(
			'code'	=> '13007',
			'desc'	=> '查询奖期信息',
		),
		13009	=> array(
			'code'	=> '13009',
			'desc'	=> '奖金等级明细查询',
		),
		13010	=> array(
			'code'	=> '13010',
			'desc'	=> '竞彩投注',
		),
		13006	=> array(
			'code'	=> '13006',
			'desc'	=> '彩票落地通知',
		),
		13008	=> array(
			'code'	=> '13008',
			'desc'	=> '奖期通知',
		),
		13012	=> array(
			'code'	=> '13012',
			'desc'	=> '北单赛程信息',
		),
		13999	=> array(
			'code'	=> '13999',
			'desc'	=> '北单各彩种SP值查询',
		),
		13012	=> array(
			'code'	=> '13012',
			'desc'	=> '北单赛程信息',
		),
	),
	//竞彩足球串关
	'fbcg'	=> array(
		'101'	=> array(
			'code'	=> '101',
			'desc'	=> '1串1',
		),
		'102'	=> array(
			'code'	=> '102',
			'desc'	=> '2串1',
		),
		'103'	=> array(
			'code'	=> '103',
			'desc'	=> '3串1',
		),
		'603'	=> array(
			'code'	=> '603',
			'desc'	=> '3串3',
		),
		'118'	=> array(
			'code'	=> '118',
			'desc'	=> '3串4',
		),
		'104'	=> array(
			'code'	=> '104',
			'desc'	=> '4串1',
		),
		'604'	=> array(
			'code'	=> '604',
			'desc'	=> '4串4',
		),
		'120'	=> array(
			'code'	=> '120',
			'desc'	=> '4串5',
		),
		'605'	=> array(
			'code'	=> '605',
			'desc'	=> '4串6',
		),
		'121'	=> array(
			'code'	=> '121',
			'desc'	=> '4串11',
		),
		'105'	=> array(
			'code'	=> '105',
			'desc'	=> '5串1',
		),
		'606'	=> array(
			'code'	=> '606',
			'desc'	=> '5串5',
		),
		'123'	=> array(
			'code'	=> '123',
			'desc'	=> '5串6',
		),
		'607'	=> array(
			'code'	=> '607',
			'desc'	=> '5串10',
		),
		'124'	=> array(
			'code'	=> '124',
			'desc'	=> '5串16',
		),
		'608'	=> array(
			'code'	=> '608',
			'desc'	=> '5串20',
		),
		'125'	=> array(
			'code'	=> '125',
			'desc'	=> '5串26',
		),
		'106'	=> array(
			'code'	=> '106',
			'desc'	=> '6串1',
		),
		'609'	=> array(
			'code'	=> '609',
			'desc'	=> '6串6',
		),
		'127'	=> array(
			'code'	=> '127',
			'desc'	=> '6串7',
		),
		'610'	=> array(
			'code'	=> '610',
			'desc'	=> '6串15',
		),
		'611'	=> array(
			'code'	=> '611',
			'desc'	=> '6串20',
		),
		'128'	=> array(
			'code'	=> '128',
			'desc'	=> '6串22',
		),
		'612'	=> array(
			'code'	=> '612',
			'desc'	=> '6串35',
		),
		'129'	=> array(
			'code'	=> '129',
			'desc'	=> '6串42',
		),
		'613'	=> array(
			'code'	=> '613',
			'desc'	=> '6串50',
		),
		'602'	=> array(
			'code'	=> '602',
			'desc'	=> '6串57',
		),
		'107'	=> array(
			'code'	=> '107',
			'desc'	=> '7串1',
		),
		'702'	=> array(
			'code'	=> '702',
			'desc'	=> '7串7',
		),
		'703'	=> array(
			'code'	=> '703',
			'desc'	=> '7串8',
		),
		'704'	=> array(
			'code'	=> '704',
			'desc'	=> '7串21',
		),
		'705'	=> array(
			'code'	=> '705',
			'desc'	=> '7串35',
		),
		'706'	=> array(
			'code'	=> '706',
			'desc'	=> '7串120',
		),
		'108'	=> array(
			'code'	=> '108',
			'desc'	=> '8串1',
		),
		'802'	=> array(
			'code'	=> '802',
			'desc'	=> '8串8',
		),
		'803'	=> array(
			'code'	=> '803',
			'desc'	=> '8串9',
		),
		'804'	=> array(
			'code'	=> '804',
			'desc'	=> '8串28',
		),
		'805'	=> array(
			'code'	=> '805',
			'desc'	=> '8串56',
		),
		'806'	=> array(
			'code'	=> '806',
			'desc'	=> '8串70',
		),
		'807'	=> array(
			'code'	=> '807',
			'desc'	=> '8串247',
		),	
	),	
	//北单串关
	'bdcg'	=> array(
		02	=> array(
			'code'	=> '02',
			'desc'	=> '单关',
		),
		03	=> array(
			'code'	=> '03',
			'desc'	=> '2串1',
		),
		04	=> array(
			'code'	=> '04',
			'desc'	=> '3串1',
		),
		05	=> array(
			'code'	=> '05',
			'desc'	=> '4串1',
		),
		06	=> array(
			'code'	=> '06',
			'desc'	=> '5串1',
		),
		07	=> array(
			'code'	=> '07',
			'desc'	=> '6串1',
		),
		08	=> array(
			'code'	=> '08',
			'desc'	=> '7串1',
		),
		09	=> array(
			'code'	=> '09',
			'desc'	=> '8串1',
		),
		10	=> array(
			'code'	=> '10',
			'desc'	=> '9串1',
		),
		11	=> array(
			'code'	=> '11',
			'desc'	=> '10串1',
		),
		12	=> array(
			'code'	=> '12',
			'desc'	=> '11串1',
		),
		13	=> array(
			'code'	=> '13',
			'desc'	=> '12串1',
		),
		14	=> array(
			'code'	=> '14',
			'desc'	=> '13串1',
		),
		15	=> array(
			'code'	=> '15',
			'desc'	=> '14串1',
		),
		16	=> array(
			'code'	=> '16',
			'desc'	=> '15串1',
		),
		17	=> array(
			'code'	=> '17',
			'desc'	=> '2串3',
		),
		18	=> array(
			'code'	=> '18',
			'desc'	=> '3串4',
		),
		19	=> array(
			'code'	=> '19',
			'desc'	=> '3串7',
		),
		20	=> array(
			'code'	=> '20',
			'desc'	=> '4串5',
		),
		21	=> array(
			'code'	=> '21',
			'desc'	=> '4串11',
		),
		22	=> array(
			'code'	=> '22',
			'desc'	=> '4串15',
		),
		23	=> array(
			'code'	=> '23',
			'desc'	=> '5串6',
		),
		24	=> array(
			'code'	=> '24',
			'desc'	=> '5串16',
		),
		25	=> array(
			'code'	=> '25',
			'desc'	=> '5串26',
		),
		26	=> array(
			'code'	=> '26',
			'desc'	=> '5串31',
		),
		27	=> array(
			'code'	=> '27',
			'desc'	=> '6串7',
		),
		28	=> array(
			'code'	=> '28',
			'desc'	=> '6串22',
		),
		29	=> array(
			'code'	=> '29',
			'desc'	=> '6串42',
		),
		30	=> array(
			'code'	=> '30',
			'desc'	=> '6串57',
		),
		31	=> array(
			'code'	=> '31',
			'desc'	=> '6串63',
		),
	),
	
);