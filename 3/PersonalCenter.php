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
		case 'text' :
			$keyword = $bean->getContent ();
			$arr = explode ( "@", $keyword );
			$REword = getcode ( $arr [0], $arr [1] );
			$sRespData = $bean->TextHuiFuData ( $REword );
			break;
		case 'image' :
			$sRespData = $bean->TextHuiFuData ( "图片很漂亮" );
			break;
		case 'location' :
			$sRespData = $bean->TextHuiFuData ( "你的纬度是{$bean->getlatitude()},经度是{$bean->getlongitude()}" );
			break;
		case 'link' :
			$sRespData = $bean->TextHuiFuData ( "您的连接是做什么的呢" );
			break;
		case 'voice' :
			$sRespData = $bean->TextHuiFuData ( "声音很动听" );
			break;
		case 'event' :
			switch ($bean->getEvent ()) {
				case 'enter_agent' :
					$sRespData = $bean->TextHuiFuData ( "欢迎进入个人中心您可能有三个任务未完成" );
					break;
				case 'LOCATION' :
					$sRespData = $bean->TextHuiFuData ( "你的纬度是{$bean->getLatitu()},经度是{$bean->getLongitu()},精度{$bean->getPrecision()}}" );
					break;
				case 'click' :
					switch ($bean->getEventKey ()) {
						case 'MEMU_BreakDown' :
							$sRespData = $bean->TextHuiFuData ( "您可以直接发送故障代码给我，我帮您解析\n例如：MP1810@SC101 \n快来试试吧！\n\n\n\n&lt;a href=&quot;http://wandaoa.f3322.org:7280/code/  &quot;&gt;点击我也可以进入网页版本哦&lt;/a&gt; " );
							break;
						case 'MENU_Person' :
							$sRespData = $bean->TextHuiFuData ( "&lt;a href=&quot;http://3.zhouxueweixin.sinaapp.com/UserCenter/View/userCenter.php?name={$bean->getfromUsername()}&quot;&gt;点击我查看详情&lt;/a&gt; \n系统状态分析：\n1、您今天还没签到\n2、今日有三条任务等着你哦");
							break;
						default :
							$sRespData = $bean->TextHuiFuData ( "此点击事件未知，敬请反馈管理员，谢谢您的参与完善！" );
							break;
					}
					break;
				default :
					$sRespData = $bean->TextHuiFuData ( "此事件未实现，请联系管理员" );
					break;
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
function getcode($dev_box, $code_box) {
	$post_string = '__VIEWSTATE=%2FwEPDwUJMzQ1OTM2MjY4ZGRHXhfY%2Bmx5rwVxsBTl13S3ZMfq%2B0Tm80d3u3cjIJAEEw%3D%3D&__VIEWSTATEGENERATOR=53579901&__EVENTVALIDATION=%2FwEdAAgn%2FckPqSTBOyN8IWuH2rvagG4%2FQ96yI2vClMUHwHbfZ%2FGAvZ%2F2bNpXUPdTcesnOAKx9blkKx6mEYBuT0kSdWXnD%2FHwDksZ%2BFIIFydjM61mCCMrMmVc%2FaFq%2FRd9qlmvjRguMCY5U84NCJfN58YXBJKYpA7D3VqgJhuNY%2F36bZPDZutCKAC75UbeeTXVGOhWjPR99xyY4lCql5qL7gAe5hii';
	$post_string = $post_string . '&dev_box=' . $dev_box . '&code_box=' . $code_box . '&button1=%E6%9F%A5%E8%AF%A2' . '&demo_box=' . '&jjff_box=';
	$data = request_by_curl ( 'http://wandaoa.f3322.org:7280/code/', $post_string );
	
	if ($data == null) {
		// echo "并没有数据返回";
		return "并没有数据返回";
	} else {
		$pa = '%<textarea.*?>(.*?)</textarea>%si';
		preg_match_all ( $pa, $data, $match );
		if ($match == null) {
			// echo "未找到匹配项目";
			return "未找到匹配项目";
		} else {
			return '错误摘要：' . $match [1] [0] . "\n\n详细信息：" . $match [1] [1];
			// print_r ($match [1]);
			// return $match [1];
		}
	}
}
function request_by_curl($remote_server, $post_string) {
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_URL, $remote_server );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_string );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt ( $ch, CURLOPT_TIMEOUT, 30 );
	curl_setopt ( $ch, CURLOPT_USERAGENT, "qianyunlai.com's CURL Example beta" );
	$date = curl_exec ( $ch );
	curl_close ( $ch );
	return $date;
}
?>