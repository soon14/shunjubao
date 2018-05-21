<?php
$z[0]=Array("field","",106,125);
$z[0][4]['name']="title";
$z[1]=Array("global","",126,152);
$z[1][4]['name']="cfg_webname";
$z[2]=Array("include","",1132,1166);
$z[2][4]['file']="header.htm";
$z[3]=Array("arclist","\r\n        <dl>\r\n          <dt><a href=\"[field:arcurl/]\" target=\"_blank\">[field:title function=\"( strlen('@me')>100 ? cn_substr('@me',80).'…' : '@me' )\" /]</a><span>[field:pubdate function=\"MyDate('m-d',@me)\"/]</span></dt>\r\n          <dd>[field:description function='cn_substr(@me,700)'/] ...</dd>\r\n        </dl>\r\n        ",1819,2248);
$z[3][4]['channelid']="1";
$z[3][4]['typeid']="4";
$z[3][4]['titlelen']="50";
$z[3][4]['orderby']="id";
$z[3][4]['orderway']="desc";
$z[3][4]['row']="20";
$z[4]=Array("pagelist","",2311,2389);
$z[4][4]['listitem']="info,index,end,pre,next,pageno,option";
$z[4][4]['listsize']="5";
$z[5]=Array("myad","",2577,2602);
$z[5][4]['name']="retou";
$z[6]=Array("arclist","\r\n            <li><b>•</b><a href=\"[field:arcurl/]\">[field:title/]</a></li>\r\n            ",2862,3010);
$z[6][4]['flag']="c";
$z[6][4]['titlelen']="60";
$z[6][4]['row']="12";
$z[7]=Array("include","",3193,3228);
$z[7][4]['file']="footer.html";

?>