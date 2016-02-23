<?php
include_once "WeiXinAPI/WXBizMsgCrypt.php";
include_once "response/response.php";
include_once "response/DataBean.php";
include_once "response/Department.php";
include_once "response/CreateConnection.php";
/**
 *
 * @author ZZ Love ZX
 *         这是入口
 *         这个入口对应的应用是 ”故障代码查询“
 *         功能：
 *         1、点击按钮进入网页版本的故障查询
 *         2、直接输入形式”CCX-2；012365“查询故障详细信息
 */

$corpid = "wx0291b812dab0b77e";
$EncodingAESKey = "TFdkfrdmlmx24qgWT1fGAOaQWLVxm208Kb4WRPhidJf";
$Token = "45rVOPGw1WDm7QNSiQkfiisTa";
$corpsecret = "HQGqvuauvM1YVzkJ-RQ6QgGbZuZKy8gwmAqOV2b5QhRB85ZSDs1uh22DSzEWh712";
$sReqMsgSig = $_GET ["msg_signature"];
$sReqTimeStamp = $_GET ["timestamp"];
$sReqNonce = $_GET ["nonce"];

/**
 * // 初始化的时候回调验证VerifyURL
 * $sVerifyEchoStr = $_GET ["echostr"];
 * $wxcpt = new WXBizMsgCrypt ( $Token, $EncodingAESKey, $corpid );
 * $errCode = $wxcpt->VerifyURL ( $sReqMsgSig, $sReqTimeStamp, $sReqNonce, $sVerifyEchoStr, $sMsg );
 * echo $errCode == 0 ? $sMsg : $errCode;
 */

$sReqData = $GLOBALS ["HTTP_RAW_POST_DATA"];
$wxcpt = new WXBizMsgCrypt ( $Token, $EncodingAESKey, $corpid );
$sMsg = "";
$errCode = $wxcpt->DecryptMsg ( $sReqMsgSig, $sReqTimeStamp, $sReqNonce, $sReqData, $sMsg );
if ($errCode == 0) {
	$bean = new DataBean ( $sMsg );
	$res = new response ();
	switch ($bean->getMsgType ()) {
		case text :
			$keyword = $bean->Content ();
			$sRespData = $bean->TextHuiFuData ( $keyword );
			break;
		case image :
			$sRespData = $bean->TextHuiFuData ( "图片很漂亮" );
			break;
		case location :
			$sRespData = $bean->TextHuiFuData ( "你的纬度是{$bean->getlatitude()},经度是{$bean->getlongitude()}" );
			break;
		case link :
			$sRespData = $bean->TextHuiFuData ( "您的连接是做什么的呢" );
			break;
		case voice :
			$sRespData = $bean->TextHuiFuData ( "声音很动听" );
			break;
			// case event :
			
			// switch ($bean->getEventKey () == enter_agent) {
			// case enter_agent :
			// $sRespData = $bean->TextHuiFuData ( "尉氏县" );
			// break;
			// default :
			// $sRespData = $bean->TextHuiFuData ( "此事件为实现，请联系管理员" );
			
			break;
		default :
			$sRespData = $bean->TextHuiFuData ( "无法判断你在干什么，请联系管理员" );
			break;
	}
	$errCode = $wxcpt->EncryptMsg ( $sRespData, $sReqTimeStamp, $sReqNonce, $sEncryptMsg );
	echo $errCode == 0 ? $sEncryptMsg : "加密错误";
} else {
	echo "解密错误";
}

// $mmc=memcache_init();
// if($mmc==false)
// echo "mc init failed\n";
// else
// {
// memcache_set($mmc,"key","value");
// echo memcache_get($mmc,"key");
// }

// 进入缓存判断用户所处级别
// $che = new CheChe ();
// // 判断发过来的是什么类型的内容
// switch ($bean->getMsgType ()) {
// case text :
// $keyword = $bean->Content ();
// if ($keyword == "部门信息") {
// $createConnection = new CreateConnection ();
// $token = $createConnection->getAccessToken ( $corpid, $corpsecret );
// if ($token) {
// $department = new Department ( $token );
// $sRespData = $bean->TextHuiFuData ( $department->getDepartmentList () );
// } else {
// $sRespData = $bean->TextHuiFuData ( "token is empty" );
// }
// } else {
// $sRespData = $bean->TextHuiFuData ( $keyword );
// }
// // if ($che->play($keyword)){
// // $sRespData="您当前在{$che->getvalue("floor")},可以回复上楼或者下楼继续游戏，回复其他，进行自己的业务";
// // }else {
// // // $data= $res->xiaojo ( $keyword )

// // }
// break;
// case image :
// $sRespData = $bean->TextHuiFuData ( "image" );
// break;
// case location :
// $sRespData = $bean->TextHuiFuData ( "你的纬度是{$bean->getlatitude()},经度是{$bean->getlongitude()}" );
// break;
// case link :
// $sRespData = $bean->TextHuiFuData ( "link" );
// break;
// case voice :
// $sRespData = $bean->TextHuiFuData ( "voice" );
// break;
// // case event :
// // $sRespData = $bean->TextHuiFuData("尉氏县");
// // break;

// // default :
// // $sRespData = $bean->TextHuiFuData("无法判断你发的是什么");;
// // break;
// }
// $errCode = $wxcpt->EncryptMsg ( $sRespData, $sReqTimeStamp, $sReqNonce, $sEncryptMsg );
// echo $errCode == 0 ? $sEncryptMsg : "jiamicuowu";
// } else {
// echo "jiemicuowu";
// }

// // $mmc=memcache_init();
// // if($mmc==false)
// // echo "mc init failed\n";
// // else
// // {
// // memcache_set($mmc,"key","value");
// // echo memcache_get($mmc,"key");
// // }

?>