//图片滚动列表 
var Speed_1 = 1; //速度(毫秒)
var Space_1 = 20; //每次移动(px)
var fill_1 = 0; //整体移位
var PageWidth_1 = 900;
var MoveLock_1 = false;
var MoveTimeObj_1;
var MoveWay_1="right";
var Comp_1 = 0;
var AutoPlayObj_1=null;
var contId = 'remaishangpinlist';
var listId = 'List1_1';
function GetObj(objName){
	if(document.getElementById){
		return eval('document.getElementById("'+objName+'")');
	}else{
		return eval('document.all.'+objName);
	}
}
function ISL_GoUp_1(){
	if(MoveLock_1)return;
	clearInterval(AutoPlayObj_1);
	MoveLock_1=true;
	MoveWay_1="left";
	ISL_ScrUp_1();
	ISL_StopUp_1();
}
function ISL_StopUp_1(){
	if(MoveWay_1 == "right"){return};
	clearInterval(MoveTimeObj_1);
	if((GetObj(contId).scrollLeft-fill_1)%PageWidth_1!=0){
		Comp_1=fill_1-(GetObj(contId).scrollLeft%PageWidth_1);
		CompScr_1();
	}else{
		MoveLock_1=false;
	}
}
function ISL_ScrUp_1(){
	if(GetObj(contId).scrollLeft<=0){
		return;
	}
	GetObj(contId).scrollLeft -= Space_1;
}
function ISL_GoDown_1(){
	clearInterval(MoveTimeObj_1);
	if(MoveLock_1)return;
	clearInterval(AutoPlayObj_1);
	MoveLock_1=true;
	MoveWay_1="right";
	ISL_ScrDown_1();
	ISL_StopDown_1();
}
function ISL_StopDown_1(){
	if(MoveWay_1 == "left"){return};
	clearInterval(MoveTimeObj_1);
	if(GetObj(contId).scrollLeft%PageWidth_1-(fill_1>=0?fill_1:fill_1+1)!=0){
		Comp_1=PageWidth_1-GetObj(contId).scrollLeft%PageWidth_1+fill_1;
		CompScr_1();
	}else{
		MoveLock_1=false;
	}
}
function ISL_ScrDown_1(){
	if(GetObj(contId).scrollLeft >= (GetObj(listId).offsetWidth - GetObj(contId).offsetWidth)){
		return ;
	}
	GetObj(contId).scrollLeft+=Space_1;
}
function CompScr_1(){
	if(GetObj(contId).scrollLeft >= (GetObj(listId).offsetWidth - GetObj(contId).offsetWidth)){
		document.getElementById('rightImgId').src = TMJF.conf.cdn_i+"/brand_ss_right_h.jpg";
	} else {
		document.getElementById('rightImgId').src = TMJF.conf.cdn_i+"/brand_ss_right.jpg";
	}
	if(GetObj(contId).scrollLeft <= 0) {
		document.getElementById('leftImgId').src = TMJF.conf.cdn_i+"/brand_ss_left.jpg";
	} else {
		document.getElementById('leftImgId').src = TMJF.conf.cdn_i+"/brand_ss_left_h.jpg";
	}
	if(Comp_1==0){
		MoveLock_1=false;
		return;
	}
	var num,TempSpeed=Speed_1,TempSpace=Space_1;
	if(Math.abs(Comp_1)<PageWidth_1/2){
		TempSpace=Math.round(Math.abs(Comp_1/Space_1));
		if(TempSpace<1){
			TempSpace=1;
		}
	}
	if(Comp_1<0){
		if(Comp_1<-TempSpace){
		Comp_1+=TempSpace;
		num=TempSpace;
		}else{
			num=-Comp_1;
			Comp_1=0;
		}
		GetObj(contId).scrollLeft-=num;
		setTimeout('CompScr_1()',TempSpeed);
	}else{
		if(Comp_1>TempSpace){
			Comp_1-=TempSpace;
			num=TempSpace;
		}else{
			num=Comp_1;
			Comp_1=0;
		}
		GetObj(contId).scrollLeft+=num;
		setTimeout('CompScr_1()',TempSpeed);
	}
}

TMJF(function($){
	if (GetObj('remaishangpinlist') != null) {
		if(GetObj('remaishangpinlist').scrollLeft >= (GetObj('List1_1').offsetWidth - GetObj('remaishangpinlist').offsetWidth)){
			document.getElementById("rightImgId").src = TMJF.conf.cdn_i+"/brand_ss_right_h.jpg";
		}
	}
	$(".LeftBotton").mousedown(function(){
		ISL_GoUp_1('remaishangpinlist', 'List1_1');
	});
	$(".RightBotton").mousedown(function(){
		ISL_GoDown_1('remaishangpinlist', 'List1_1');
	});
});