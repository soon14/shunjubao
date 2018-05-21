
//-----------
var			OSIPERR_NOTLOGIN					=-100;
//------------

var			OSIPLOGIN_FAILED					=0;
var			OSIPLOGIN_SUCCESS					=1;

//------------
var			OSIPCALLOUT_STEP_NULL				=0;
var			OSIPCALLOUT_STEP_CREATE				=1;
var			OSIPCALLOUT_STEP_INVITE				=2;
var			OSIPCALLOUT_STEP_TRYING				=3;//对方已经接收到请求
var			OSIPCALLOUT_STEP_RINGING			=4;
var			OSIPCALLOUT_STEP_FAILED				=5;
var			OSIPCALLOUT_STEP_ESTABLISHED		=6;

var			OSIPCALLOUT_STEP_DOCANCEL			=10;//本地挂机
var			OSIPCALLOUT_STEP_DOBYE				=11;//本地挂机
var			OSIPCALLOUT_STEP_DOHOLD				=12;//呼叫保持

var			OSIPCALLOUT_STEP_REMOTEHANG			=20;//对方挂机
var			OSIPCALLOUT_STEP_FINISHED			=21;//错误或者结束

var			OSIPCALLOUT_STEP_DELETE				=30;

//------------

var			OSIPCALLIN_STEP_NULL				=0;
var			OSIPCALLIN_STEP_CREATE				=51;
var			OSIPCALLIN_STEP_INVITE				=52;
var			OSIPCALLIN_STEP_TRYING				=53;
var			OSIPCALLIN_STEP_RINGING				=54;
var			OSIPCALLIN_STEP_CONNECTING			=55;
var			OSIPCALLIN_STEP_FAILED				=56;
var			OSIPCALLIN_STEP_STOPCALLIN			=57;
var			OSIPCALLIN_STEP_ESTABLISHED			=58;

var			OSIPCALLIN_STEP_DOBYE				=60;//本地挂机
var			OSIPCALLIN_STEP_DOREFUSE			=61;//本地挂机
var			OSIPCALLIN_STEP_DOHOLD				=62;//呼叫保持

var			OSIPCALLIN_STEP_REMOTEHANG			=70;//对方挂机
var			OSIPCALLIN_STEP_FINISHED			=71;//错误或者结束

var			OSIPCALLIN_STEP_DELETE				=80;

//==============================
//事件
var			OSIPEVENT_LOGIN						=20000;

var			OSIPEVENT_CALLOUT					=20001;

var			OSIPEVENT_CALLIN					=20002;

var			OSIPEVENT_RECVDTMF				=20003;
//
//==============================
//API操作
var			OSIP_CTRL_SETLICENSE				=1;
var			OSIP_CTRL_SETSERVER					=2;
var			OSIP_CTRL_LOGIN						=3;
var			OSIP_CTRL_LOGOUT					=4;
var			OSIP_CTRL_ISLOGON					=5;


//======================
//呼叫
var			OSIP_CALL_START						=3;
var			OSIP_CALL_STOP						=4;
var			OSIP_CALL_STOPALL					=5;
var			OSIP_CALL_SENDRING					=6;
var			OSIP_CALL_ANSWER					=7;
var			OSIP_CALL_DOHOLD					=8;//呼叫保持,c=(0.0.0.0)
var			OSIP_CALL_GETSTEP					=9;

var			OSIP_CALL_SETWAVEIN					=20;
var			OSIP_CALL_GETWAVEIN					=21;
var			OSIP_CALL_SETWAVEOUT				=22;
var			OSIP_CALL_GETWAVEOUT				=23;
//======================
