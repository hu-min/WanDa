<html>
<head>
<meta charset="utf-8">

<link rel="stylesheet" type="text/css" href="mobile_module.css"
	media="all">
<link rel="shortcut icon" href="favicon.ico">
<link href="css.css" rel="stylesheet" type="text/css">
<title>修改资料</title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<meta
	content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"
	name="viewport">
<meta content="application/xhtml+xml;charset=UTF-8"
	http-equiv="Content-Type">
<meta content="no-cache,must-revalidate" http-equiv="Cache-Control">
<meta content="no-cache" http-equiv="pragma">
<meta content="0" http-equiv="expires">
<meta content="telephone=no, address=no" name="format-detection">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style"
	content="black-translucent">
</head>
<link href="css.css" rel="stylesheet" type="text/css">
<body>
	<div id="container" class="container">
		<img src="finish.jpg" width="100%" />
		<div class="lead_over">
			<if condition="empty($info['finish_tip'])">调研完成，谢谢参与<else />{$info.finish_tip}</if>
		</div>

		<php>$event_url = event_url ( '微调研', $info[id] );
		if(!empty($event_url)) { </php>
		<a class="share_btn" href="{$event_url}">参加抽奖活动</a>
		<php> } </php>

		<a href="javascript:;" onClick="closepage();" class="share_btn">返回微信</a>

		<p class="copyright">{$system_copy_right}</p>
		<script type="text/javascript">
function closepage(){
	WeixinJSBridge.call('closeWindow');
}
</script>

</body>
</html>
