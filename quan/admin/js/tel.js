 
function AddInfo(sInf)
{
  document.getElementById("TestInfo").value += sInf+"\r";
}
 
//////////////////////////////////////////////////
//函数与方法
//////////////////////////////////////////////////
function ec_Connect()
{
  myOCX.EC_Connect("192.168.0.200");
}
 
function ec_DisConnect()
{
  myOCX.EC_DisConnect();
}
 
function ec_DownLoadFile()
{
  myOCX.EC_DownLoadFile(document.getElementById("txtPlay").value, "C:\\mytest.wav");
  AddInfo("下载后的文件是：C:\\mytest.wav");
}
 
function ec_PlayFile()
{
  myOCX.EC_PlayFile(document.getElementById("txtPlay").value);
}
 
function ec_StartMonitor()
{
  myOCX.EC_StartMonitor1(document.getElementById("lbxMonitorCh").value);
}
 
function ec_StopMonitor()
{
  myOCX.EC_StopMonitor();
}
 
function ec_SoftDialOut()
{
  myOCX.EC_SoftDialOut(document.getElementById("txtLocal").value,document.getElementById("txtRemote").value);
  //myOCX.EC_SoftDialOutNavig(document.getElementById("txtRemote").value,"ttt");
}
 
function ec_StopSoftDialOut()
{
  myOCX.EC_StopSoftDialOut(document.getElementById("txtLocal").value);
}
 
function ec_SetLoginInfo()
{
  myOCX.EC_SetLoginInfo(document.getElementById("txtUser").value, document.getElementById("txtPassWord").value);
}
 
function ec_SetLimitedTel()
{
  myOCX.EC_SetLimitedTel(document.getElementById("txtLimitedUser").value, document.getElementById("txtLimitedNum").value);
}
 
//////////////////////////////////////////////////
//事件与消息
//////////////////////////////////////////////////
function MyFuncConnect(sHost){
	document.getElementById("show_status").innerHTML='连接成功!';
  //AddInfo("连接成功："+sHost);
}
 
function MyFuncDisConnect(sHost)
{
	document.getElementById("show_status").innerHTML='连接失败!';
}
 
function MyFuncCallIn(s1,s2)
{
  //AddInfo(s1+" 来电："+s2);
  fPopUpCallCstDlg(s1,s2);
} 
 
function MyFuncCallOut(s1,s2)
{
  AddInfo(s1+" 拨出号码："+s2);
}
 
function MyFuncRecFile(s1,s2,sDT,iIO,iLen,sNum)
{
  AddInfo(s1+" 形成录音文件："+s2+","+sDT+","+iIO+","+iLen+","+sNum);
  document.getElementById("txtPlay").value = s2
}
 
function MyFuncNoAnswer(s1,s2)
{
  AddInfo(s1+" 未接来电："+s2);
}
 
function MyFuncLeaveMessage(s1,s2,sDT,iLen)
{
  AddInfo(s1+" 留言文件："+s2+","+sDT+","+iLen);
  document.getElementById("txtPlay").value = s2
}
 
function MyFuncHookOff(s1,s2)
{
  AddInfo(s1+" 摘机："+s2);
}
 
function MyFuncHookOn(s1,s2)
{
  AddInfo(s1+" 挂机："+s2);
}
 
function MyFuncRing(s1,s2)
{
  AddInfo(s1+" 振铃："+s2);
}
 
function MyFuncTransOut(s1,s2,s3)
{
  AddInfo(s1+" 转其他电话：From:"+s2+"->"+s3);
}
 
function fPopUpCallCstDlg(s1, s2)
{
	//var s3='15920123313';
  //var retval = window.showModalDialog("search_customer2.php?sphone="+s3,window,"dialogWidth=800px;dialogHeight=600px;status=yes");
}
 
function MyFuncPlayClick(s1,s2)
{
  //点击控件上的绿色三角形的播放按钮后产生的事件
  s1 = document.getElementById("txtHost").value; //jsp不支持这样直接复制，因为这样复制，上层程序收不到，请高手指教
  s2 = document.getElementById("txtPlay").value;
}