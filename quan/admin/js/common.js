// JavaScript Document

function copy_tel(tel){
	alert('显示号码功能已取消,如有任何疑问，请及时与技术部联系，谢谢!');
	//$("#mytel").html(tel);
	return false;
}



function chedb(obj){
	if(obj.checked==true){
		document.getElementById("showdiv").style.display="";
	}else{
		document.getElementById("showdiv").style.display="none";
	}
}
function chedb2(obj){
	if(obj.checked==true){
		document.getElementById("showdiv2").style.display="";
	}else{
		document.getElementById("showdiv2").style.display="none";
	}
}

function chedb3(obj){
	if(obj.checked==true){
		document.getElementById("showdiv3").style.display="";
	}else{
		document.getElementById("showdiv3").style.display="none";
	}
}



function refund_click(){
	if(document.myform.refund.checked){
			$("#r01").show();
			$("#r02").show();
			
		}else{
			$("#r01").hide();
			$("#r02").hide();
			
	}	
	
}


function need_bukuan(myform){
	

	if(document.myform.needbukuan.checked){
		
			$("#zc").hide();
			$("#qk").hide();
			$("#cz").hide();
			$("#yy").hide();
			$("#sf").show();
			$("#sf2").show();
			$("#bk").show();	
		}else{
			$("#zc").hide();
			$("#qk").hide();
			$("#cz").hide();
			$("#yy").hide();
			$("#sf").hide();
			$("#sf2").hide();
			$("#bk").hide();	
	}
	
}


function unselectall()
{
    if(document.myform.chkAll.checked){
	document.myform.chkAll.checked = document.myform.chkAll.checked&0;
    } 	
}

function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if (e.Name != "chkAll"&&e.disabled==false)
       e.checked = form.chkAll.checked;
    }
  }
function ConfirmDel(url){
	if(confirm("此操作不可恢复,真的要删除吗?")){   
		location.href=url;
		return true;
	}else{
		return false;
	}
}

function funcDoAllData(msg,url,doid){ 

	if(confirm(msg)){
		var str = '';
		$("input[name='delid']:checked").each(function (){
			str += $(this).val()+',';
		});
		if(str == ""){
			alert('你还没有选择！');
			return false;
		}	
		url =url+"?action=delete&doid="+doid+"&sysid="+str+"";
		location.href=url;
		return true;
	}else{
		return false;	
	}
}

function two_dev_onclick(mode_from,did){

	switch(did){
		case '1':	
			$("#jifei").hide();//交费部分
			$("#zc").hide();//正常
			$("#qk").hide();//欠款
			$("#cz").hide();//充值
			$("#yy").hide();//预约
			$("#sf").hide();//收费方式
			$("#sf2").hide();//收费方式
			$("#bk").hide();//补款
		
			$("#ka").hide();
			break;		
		case '2':	
			$("#jifei").show();//交费部分
			$("#zc").show();//正常
			$("#qk").hide();//欠款
			$("#cz").hide();//充值
			$("#yy").hide();//预约
			$("#sf").show();//收费方式
			$("#sf2").show();//刷卡银行
			$("#bk").hide();//补款
			$("#ka").show();	
			break;				
		default:
			$("#ka").hide();
			break;	
		}	
}


	
	
function tohpayment_onclick(mode_from,did){
	
	
	$("#xiaofei").val("");
	$("#shiji").val("");
	$("#yingjiaoje").val("");
	$("#yijiao").val("");
	$("#chongzhi").val("");
	$("#shiyong").val("");
	$("#yuer").val("");	
	$("#yingjiaok").val("");	
	$("#yuyue").val("");	
	$("#chaer").val("");	
	$("#yibukuan").val("");		
	$("#shibu").val("");	
	$("#qiankuan").val("");		
	$("#dingjin").val("");		
	$("#dingjin_chaer").val("");		
				
	switch(did){
		case '1':	
			$("#zc").show();//正常
			$("#qk").hide();//欠款
			$("#cz").hide();//充值
			$("#yy").hide();//预约
			$("#sf").show();//收费方式
			$("#sf2").show();//银行
			$("#bk").hide();//补款
			$("#dj").hide();//订金
			break;
		case '2':	
			$("#zc").hide();
			$("#qk").show();
			$("#cz").hide();
			$("#yy").hide();
			$("#sf").show();
			$("#sf2").show();
			$("#bk").hide();
			$("#dj").hide();//订金
			break;			
		case '3':	
			$("#zc").hide();
			$("#qk").hide();
			$("#cz").show();
			$("#yy").hide();
			$("#sf").show();
			$("#sf2").show();
			$("#bk").hide();
			$("#dj").hide();//订金
			break;				
		case '4':	
			$("#zc").hide();
			$("#qk").hide();
			$("#cz").hide();
			$("#yy").show();
			$("#sf").show();
			$("#sf2").show();
			$("#bk").hide();
			$("#dj").hide();//订金
			break;	
		case '5':	
			$("#zc").hide();
			$("#qk").hide();
			$("#cz").hide();
			$("#yy").hide();
			$("#sf").show();
			$("#sf2").show();
			$("#bk").show();
			$("#dj").hide();//订金
			break;	
		case '6':	
			$("#zc").hide();//正常
			$("#qk").hide();//欠款
			$("#cz").hide();//充值
			$("#yy").hide();//预约
			$("#sf").hide();//收费方式
			$("#sf2").hide();//收费方式
			$("#bk").hide();//补款
			$("#dj").hide();//订金
			break;				
		case '7':	
			$("#zc").hide();//正常
			$("#qk").hide();//欠款
			$("#cz").hide();//充值
			$("#yy").hide();//预约
			$("#sf").show();//收费方式
			$("#sf2").show();
			$("#bk").hide();//补款
			$("#dj").show();//订金
			break;				
		default:
			$("#zc").show();//正常
			$("#qk").hide();//欠款
			$("#cz").hide();//充值
			$("#yy").hide();//预约
			$("#sf").show();//收费方式
			$("#sf2").show();//收费方式
			$("#bk").hide();//补款
			$("#dj").hide();//订金
			break;	
		}	
	
}


function return_mode_onclick(mode_from,did){
	
	switch(did){
		case '2':	
			$("#msm").show();
			break;	
		default:
			$("#msm").hide();
			break;	
		}	
	
}


function info_from_onclick(info_from,did){//信息来源

	switch(did){
		case '4':
			//alert('网络!');
			$("#netid").show();
			$("#kid").show();
			$("#nid").show();
			$("#jstel").hide();
			$("#paperid").hide();
			break;
		case '9'://电话
			//alert('电话!');
			$("#netid").hide();
			$("#kid").hide();
			$("#nid").hide();
			$("#jstel").show();
			
			break;	
		
		default:
			
			break;	
			
		}	
}


function net_from_onclick(info_from,did){//电话来源

	switch(did){
		case '9':
			//alert('报纸!');
			$("#addressid").show();
			$("#nid").hide();
			$("#kid").hide();
			$("#paperid").hide();
			break;
		case '10':
			//alert('报纸!');
			$("#addressid").show();
			$("#nid").hide();
			$("#kid").hide();
			$("#paperid").hide();
			break;
			

		default:
		
			$("#nid").show();
			$("#kid").show();
			$("#addressid").hide();
			break;	
			
		}	
}






function tel_from_onclick(info_from,did){//电话来源

	switch(did){
		case '4':
			//alert('报纸!');
			$("#paperid").show();
			$("#addressid").hide();

			break;
			
		case '10'://电话里面的网络
			$("#netid").show();
		
			$("#paperid").hide();
			$("#addressid").hide();

			break;			

		default:
			$("#paperid").hide();
			break;	
			
		}	
}


function treat_status_onclick(treat_status,did){//回访过程中，根据状态控制表单

	switch(did){
		case '1':
		//	alert('下单!');
			$("#booking_dateid").hide();
			$("#sh_dateid").hide();
			break;
		case '2'://下次回访
			$("#booking_dateid").hide();
			$("#sh_dateid").show();
		//	alert('已来院!');
			break;		
		case '3'://结束回
			$("#booking_dateid").hide();
			$("#sh_dateid").hide();
		//	alert('结束回访!');
			break;	
		
		default:
			
			break;	
			
		}	
}




function visit_status_onclick(visit_status,did){//回访过程中，根据状态控制表单

	switch(did){
		case '1':
		//	alert('下单!');
			$("#booking_dateid").hide();
			$("#sh_dateid").hide();
			break;
		case '2'://预约来院
			$("#sh_dateid").hide();
			$("#booking_dateid").show();
			//alert('回访中!');
			break;			
		case '3'://已来院
			$("#booking_dateid").hide();
			$("#sh_dateid").hide();
			
			//alert('未定来院时间!');
			break;
		case '4'://下次回访
			$("#booking_dateid").hide();
			$("#sh_dateid").show();
		//	alert('已来院!');
			break;		
		case '5'://结束回
			$("#booking_dateid").hide();
			$("#sh_dateid").hide();
		//	alert('结束回访!');
			break;	
		case '6'://结束回
			$("#booking_dateid").hide();
			$("#sh_dateid").hide();
		//	alert('结束回访!');
			break;			
		default:
			
			break;	
			
		}	
}



function from_booking(){

	if($("#username").val()==""){
		alert('姓名不能为空!');
		return false;	
	}
	
	if($("#province").val()==""){
		alert('省份不能为空!');
		return false;	
	}
	
	if($("#qq").val()=="" && $("#email").val()==""){
		alert('QQ和Email至少要填一项!');
		return false;	
	}
	
	
	if($("#phone").val()=="" && $("#tel").val()==""){
		alert('手机和电话至少要填写一个!');
		return false;	
	}
	
/*	if($("#projectsort").val()=="" || $("#projectsort2").val()==""){
		alert('预约项目不能为空!');
		return false;	
	}	*/
		//预约单状态
	$("input[name='booking_status']:checked").each(function (){	var booking_status = $(this).val();});		

	if(booking_status=="2"){
		
		if($("#booking_time").val()=="" ){
			alert('来院时间不能为空!');
			return false;	
		}
	
	}
		
	return true;
}


function from_customers(){

	if($("#username").val()==""){
		alert('姓名不能为空!');
		return false;	
	}
	
	if($("#province").val()==""){
		alert('省份不能为空!');
		return false;	
	}
	
	if($("#phone").val()=="" && $("#tel").val()==""){
		alert('手机和电话至少要填写一个!');
		return false;	
	}
	
	return true;

}



function from_inquirie(){
	if($("#province").val()==""){
		alert('省份不能为空!');
		return false;	
	}
	
	if($("#projectsort").val()=="" || $("#projectsort2").val()==""){
		alert('项目不能为空!');
		return false;	
	}	

	return true;

}


function from_tohospital2(){
	
	

	
	if($("#qq").val()=="" && $("#email").val()==""){
		alert('QQ和Email至少要填写一个!');
		return false;	
	}
	
	if($("#phone").val()=="" && $("#tel").val()==""){
		alert('手机和电话至少要填写一个!');
		return false;	
	}
	
	

	
/*	if($("#pre_guangban").val()==""){
		$("#pre_guangban").focus();
		alert('请输入治疗前光斑数!');
		return false;	
	}	

	
	if($("#late_guangban").val()==""){
		$("#late_guangban").focus();
		alert('请输入治疗后光斑数!');
		return false;	
	}	
	*/
	
	return true;

}


function from_tohospital(){
	

	if($("#xiaofei").val()!="" || $("#yingjiaoje").val()!="" || $("#chongzhi").val()!="" || $("#yingjiaok").val()!="" || $("#dingjin").val()!=""){

		if($("input[name='ccpaymnet']:checked").val()=="3"){
			alert('请选择收费方式!');
			return false;		
		}
		
	}
	
	
	if($("#tdesc").val()==""){
		alert('备注不能为空!');
		return false;	
	}
	if($("#username").val()==""){
		alert('姓名不能为空!');
		return false;	
	}
	
	if($("#province").val()==""){
		alert('省份不能为空!');
		return false;	
	}
	
	if($("#certno").val()=="" && $("#birthday").val()==""){
		alert('生日或者身份证至少要录入一项!');
		return false;	
	}
	
	if($("#qq").val()=="" && $("#email").val()==""){
		alert('QQ和Email至少要填写一个!');
		return false;	
	}
	
	if($("#phone").val()=="" && $("#tel").val()==""){
		alert('手机和电话至少要填写一个!');
		return false;	
	}
	
/*	if($("#tohospitaltimes").val()=="0"){
		alert('请选择第几次来院!');
		return false;	
	}	*/
	if($("#pre_guangban").val()==""){
		$("#pre_guangban").focus();
		alert('请输入治疗前光斑数!');
		return false;	
	}	

	
	if($("#late_guangban").val()==""){
		$("#late_guangban").focus();
		alert('请输入治疗后光斑数!');
		return false;	
	}
	
	

		
	
	//检查金额是否对得上
	/*   var ckb = document.getElementsByName("choseproject");
	
		var checkstr="";
		var mvalue  =0;
        for(var i=0;i<ckb.length;i++){
            if(ckb[i].checked){
				checkstr = ckb[i].value;
				mvalue+=parseInt($("#"+checkstr+"_money").val());
			}
        }
		
		var totalm = parseInt($("#money").val());
		if(totalm!=mvalue){
			alert('请检查录入的金额是否正确!');
	 		return false;		
		}*/

	
	return true;

}

function from_flow(){
	if($("#ipnum").val()==""){
		alert('独立IP不能为空!');
		return false;	
	}	
	if($("#pvnum").val()==""){
		alert('PV流量不能为空!');
		return false;	
	}	
	if($("#gtime").val()==""){
		alert('统计日期不能为空!');
		return false;	
	}	

	return true;
}

function from_market(){
	if($("#projectsort").val()=="" || $("#projectsort2").val()==""){
		alert('项目不能为空!');
		return false;	
	}	
	if($("#pointnum").val()==""){
		alert('点击量不能为空!');
		return false;	
	}
	if($("#money").val()==""){
		alert('推广金额不能为空!');
		return false;	
	}	
	if($("#gtime").val()==""){
		alert('统计日期不能为空!');
		return false;	
	}	

	return true;
}



function from_visit(){
	
	var return_mode;
	$("input[name='return_mode']:checked").each(function (){ return_mode = $(this).val();});

	if(!return_mode){
		alert('请选择回访方式!');
		return false;	
	}
	
	

	$("input[name='visit_status']:checked").each(function (){ visit_status = $(this).val();});
	
	

	
	if(visit_status==1){
		alert('请重新选回访状态，不需要修改请返回!');
		return false;
	}
	if(visit_status==2){
		
		if($("#booking_time").val()==""){	
			alert('请选择预约来院日期!');
			return false;
		}
	}
	
	if($("#tdesc").val()==""){
		alert('请输入备注!');
		return false;
	}
	return true;
}

function ccpaymnet_onclick(ccpaymnet,did){
	
	if(did==4){
		$("#kaandmoney").show();
		$("#transfer_desc_show").hide();
	}else if(did==6){
		$("#transfer_desc_show").show();
		$("#kaandmoney").hide();
	}else{
		$("#kaandmoney").hide();
		$("#transfer_desc_show").hide();
	}

	
	
}

function from_treat_visit(){
	
	var return_mode;
	$("input[name='return_mode']:checked").each(function (){ return_mode = $(this).val();});

	if(!return_mode){
		alert('请选择回访方式!');
		return false;	
	}

	$("input[name='treat_status']:checked").each(function (){ treat_status = $(this).val();});
	if(treat_status==1){
		alert('请重新选回访状态，不需要修改请返回!');
		return false;
	}
	if(treat_status==2){
		
		if($("#sh_date").val()==""){	
			alert('下次回访日期不能为空!');
			return false;
		}
	}
	
	if($("#tdesc").val()==""){
		alert('请输入备注!');
		return false;
	}
	return true;
}


