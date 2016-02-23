<?php
include_once "WeiXinAPI/WXBizMsgCrypt.php";
include_once "response/response.php";
include_once "response/DataBean.php";
include_once "response/User.php";
include_once "response/CreateConnection.php";
include_once "response/Chat.php";
/**
 * 这是入口
 * 本入口对应的应用是 “内部沟通”
 * 实现功能：
 *
 * 1、相互传递消息
 * 2、私聊消息传递
 */
$corpid = "wx0291b812dab0b77e";
$corpsecret = "HQGqvuauvM1YVzkJ-RQ6QgGbZuZKy8gwmAqOV2b5QhRB85ZSDs1uh22DSzEWh712";
$EncodingAESKey = "4fE3q8Cj7eOzqQIpLbAjBXgiTW5KBMIa66rsOJ8SrRR";
$Token = "DWVZ4EmJTSI7xN";
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
	switch ($bean->getMsgType ()) {
		case text :
			$keyword = $bean->Content ();
			$text = explode ( "@", $keyword );
			if ($text [1] == "资料") {
			} elseif ($text [1] == "私聊") {
				$createConnection = new CreateConnection ();
				$token = $createConnection->getAccessToken ( $corpid, $corpsecret );
				if ($token) {
					$chat = new Chat ( $token );
					$user = new User ( $token );
					$userdata = $user->getUserByName ( $text [0], TRUE );
					
					$obj = json_decode ( $userdata );
					$arry = $obj->{'userlist'};
					$senderID = $arry [0]->{'userid'};
					$toUserID = $bean->getfromUsername ();
					$jeson = $chat->sendText ( "single", "{$toUserID}", "{$senderID}", "{$text[2]}/:8-)" );
					$obj = json_decode ( $jeson );
					switch ($obj->{'errcode'}) {
						case 86221 :
							$str = "自己不能发给自己哦";
							break;
						case 0 :
							$str = "已发送";
							break;
						default :
							$str = "发送失败，网络故障；如果多次失败，请联系管理员，谢谢！";
							break;
					}
					$sRespData = $bean->TextHuiFuData ( $str );
					break;
				} else {
					$sRespData = $bean->TextHuiFuData ( "抱歉{$text [1]}未接通{$text [0]}" );
					break;
				}
			} else {
				$createConnection = new CreateConnection ();
				$token = $createConnection->getAccessToken ( $corpid, $corpsecret );
				if ($token) {
					$chat = new Chat ( $token );
					$toUserID = $bean->getfromUsername ();
					$chat->getChat ( "love" );
					// $jeson =$chat->createChat ( "love", "爱的连接聊天", '001', array ('001','005' ) );
					$jeson = $chat->sendText ( "group", "love", "{$toUserID}", "{$keyword}" );
					
					$obj = json_decode ( $jeson );
					// switch ($obj->{'errcode'}){
					// case 86221:
					// $str="自己不能发给自己哦";
					// break;
					// case 0:
					// $str = "已发送";
					// break;
					// default:
					// $str = "发送失败，网络故障；如果多次失败，请联系管理员，谢谢！";
					// break;
					// }
					$sRespData = $bean->TextHuiFuData ( "已经创建" );
					break;
				} else {
					$sRespData = $bean->TextHuiFuData ( "抱歉{$text [1]}未接通{$text [0]}" );
					break;
				}
				
				$sRespData = $bean->TextHuiFuData ( "系统错误，请重试" );
				break;
			}
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
			
			// switch ($bean->getEventKey ()==nter_agent) {
			// case "nter_agent":
			// $sRespData = $bean->TextHuiFuData ( "尉氏县" );
			// break;
			// default :
			// 此类用作获取，，注意是“有用的 AccessToken ”
			$createConnection = new CreateConnection ();
			$token = $createConnection->getAccessToken ( $corpid, $corpsecret );
			if ($token) {
				// 构造成员方法类传入初始化值也就是传入有效的AccessToke，为此类初始化
				$user = new User ( $token );
				// etile = $user->JieXiUser0 ( $user->getUserByName ( $text [0] ) );
				$detile = "做完任务记得签退哦";
				$userid = $bean->getfromUsername ();
				$www = "{$detile}\n\n\n&lt;a href=&quot;http://3.zhouxueweixin.sinaapp.com/UserCenter/View/userCenter.php?name={$userid}&quot;&gt;点击已查看详细信息&lt;/a&gt;";
				// $sRespData = $bean->TextHuiFuData ( $user->JieXiUser ( $user->getUserByName ( $text [0] ) ),false );
				$sRespData = $bean->TextHuiFuData ( "$www", false );
				// break;
			}
			// RespData = $bean->TextHuiFuData ( "此事件为实现，请联系管理员" );
			// }
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