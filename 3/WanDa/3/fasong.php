<?php
include_once "WeiXinAPI/WXBizMsgCrypt.php";
/**
 * 这是入口
 * 本入口对应的应用是	“内部沟通”
 * 实现功能：
 *
 * 1、相互传递消息
 * 2、私聊消息传递
 */

$corpsecret = "HQGqvuauvM1YVzkJ-RQ6QgGbZuZKy8gwmAqOV2b5QhRB85ZSDs1uh22DSzEWh712";
$corpid = "wx0291b812dab0b77e";
$EncodingAESKey = "jWmYm7qr5nMoAUwZRjGtBxmz3KA1tkAj3ykkR6q2B2C";
$Token = "QDG6eK";
$sReqMsgSig = $_GET ["msg_signature"];
$sReqTimeStamp = $_GET ["timestamp"];
$sReqNonce = $_GET ["nonce"];


  // 初始化的时候回调验证VerifyURL
  $sVerifyEchoStr = $_GET ["echostr"];
  $wxcpt = new WXBizMsgCrypt ( $Token, $EncodingAESKey, $corpid );
  $errCode = $wxcpt->VerifyURL ( $sReqMsgSig, $sReqTimeStamp, $sReqNonce, $sVerifyEchoStr, $sMsg );
  echo $errCode == 0 ? $sMsg : $errCode;
 