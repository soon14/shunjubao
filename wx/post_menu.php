<?php
ini_set('default_charset', "utf-8");
include_once("include/wxfunction2.php");

$weixin = new class_weixin("wxa1e319fccc9b03c8", "b3aea5a5d76e8aa336476bf43bc7fb1d");
//var_dump($weixin->get_user_list());exit();


$menu_data='{
    "button": [
        {
            "name": "资讯中心", 
            "sub_button": [
				{
                    "type": "view", 
                    "name": "独家推荐", 
                     "url": "http://news.zhiying365.com/tuijian/"
                },
				{
                    "type": "view", 
                    "name": "投注技巧", 
                     "url": "http://news.zhiying365.com/touzhujiqiao/"
                },
                {
                    "type": "view", 
                    "name": "行业资讯", 
                    "url": "http://news.zhiying365.com/zixun/"
                },
                {
                    "type": "view", 
                    "name": "水手专访", 
                    "url": "http://news.zhiying365.com/zixun/2015/1113/21832.html"
                }
            ]
        },
		{
            "name": "晒单中心", 
            "sub_button": [
				{
                    "type": "view", 
                    "name": "晒单中心", 
                    "url": "http://mp.zhiying365.com/ticket/show.php"
                }
            ]
        },{
            "name": "投注区", 
            "sub_button": [
				{
                    "type": "view", 
                    "name": "竞彩足球", 
                    "url": "http://mp.zhiying365.com/football/hhad_list.php"
                },
				 {
                    "type": "view", 
                    "name": "竞彩篮球", 
                    "url": "http://mp.zhiying365.com/basketball/hdc_list.php"
                }
            ]
		}
        
    ]

}';


var_dump($weixin->create_menu($menu_data));


?>