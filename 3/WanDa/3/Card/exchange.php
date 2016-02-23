<?php
$num = 5;
?>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="mobile_module.css"
	media="all">
<link rel="shortcut icon" href="favicon.ico">
<title>今日任务</title>
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
<link href="card.css" rel="stylesheet" type="text/css">
<body>
	<div class="container body">
		<h5 class="page_title">个人今日任务</h5>
		<!-- 任务列表循环自增 -->
		<ul class="toggle_list" style="margin-top: 40px">		
	<?php
	for(; $num > 0; $num --) {
		?>
			<li id="<?php echo 'li'."$num";?>"
				class="single_item m_15 p_10 toggle_list_open">
				<div class="title icon_arrow_right">
					<img width="30" id="<?php echo 'im'."$num";?>"
						onclick="im(this.id)" class="fl" src="pause.png" />
					<p>
						<strong onclick="change('<?php echo 'L'."$num";?>')">哈哈有限公司维修打印机</strong>
						<img width="30px" class=" flr" src="done.png"
							onclick="dispay('<?php echo 'li'."$num";?>')" />
					</p>
					<span class="colorless">有效期至2015-10-10</span>
				</div>
				<div class="content" id="<?php echo 'L'."$num";?>">
					<p>北京二货有限公司，需要维修某某，记得带上XXX零件，初步判断是用户使用错误故障，
						到地方去检查说明，并且指导用户使用，恩，就是这样，这是详细去维修的说明</p>
				</div>
			</li>
			<?php
	}
	?>	
		</ul>
		<p class="copyright">版权&copy;万达设备有限公司</p>
	</div>

	<script language="javascript">
 function change(L){
	 if (document.getElementById(L).style.display=="none") {
		 document.getElementById(L).style.display="block";
	}else {
		document.getElementById(L).style.display="none";
	}
	 }
 function dispay(L){
		 document.getElementById(L).style.visibility="hidden";
	 }
 function im(L){
	 alert('您无法完成此任务，此任务已经终止')
	 document.getElementById(L).src="pause2.png";
 }
</script>
</body>
</html>
