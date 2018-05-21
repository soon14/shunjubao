$(function(){
	$('#frm_login').submit(function(){
		if($("#u_name").val() == '')	{
			alert('用户名不能为空');
			return false;
		}
		if($("#u_pwd").val() == '')	{
			alert('密码不能为空');
			return false;
		}
		return true;
	});
});



