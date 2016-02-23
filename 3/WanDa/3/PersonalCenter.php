<?php
include_once "WeiXinAPI/WXBizMsgCrypt.php";
include_once "response/response.php";
include_once "response/DataBean.php";
/**
 * 这是入口
 * 本入口对应的应用是 “个人中心”
 * 实现功能：
 *
 * 1、签到功能
 * 2、任务进度
 * 3、。。。。。。
 * 4、。。。。。。
 */
$CorpID = "wx0291b812dab0b77e";
$EncodingAESKey = "PJ5alfmE0prM7g2YUjrPjirzcKVtxWWkb8NBg9II7rL";
$Token = "I51BqdtcVgm";
$corpsecret = "HQGqvuauvM1YVzkJ-RQ6QgGbZuZKy8gwmAqOV2b5QhRB85ZSDs1uh22DSzEWh712";
$sReqMsgSig = $_GET ["msg_signature"];
$sReqTimeStamp = $_GET ["timestamp"];
$sReqNonce = $_GET ["nonce"];

/**
 * // 初始化的时候回调验证VerifyURL
 * $sVerifyEchoStr = $_GET ["echostr"];
 * $wxcpt = new WXBizMsgCrypt ( $Token, $EncodingAESKey, $CorpID );
 * $errCode = $wxcpt->VerifyURL ( $sReqMsgSig, $sReqTimeStamp, $sReqNonce, $sVerifyEchoStr, $sMsg );
 * echo $errCode == 0 ? $sMsg : $errCode;
 */

$sReqData = $GLOBALS ["HTTP_RAW_POST_DATA"];
$wxcpt = new WXBizMsgCrypt ( $Token, $EncodingAESKey, $CorpID );
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
		case event :
			
			switch ($bean->getEventKey () == enter_agent) {
				case enter_agent :
					$sRespData = $bean->TextHuiFuData ( "尉氏县" );
					break;
				default :
					$sRespData = $bean->TextHuiFuData ( "此事件为实现，请联系管理员" );
			}
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

?>