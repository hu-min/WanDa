<?php
$userid = $_GET['userid'];
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
	
	$link = mysql_connect ( SAE_MYSQL_HOST_M . ':' . SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS );
	if ($link) {
		mysql_select_db ( SAE_MYSQL_DB, $link );
	
		// 查询所以今日任务信息
		$Da = date ( "Y-m-d" );
		// 查询今天具体任务没做的任务
		$sql3 = "SELECT * FROM  `Task` WHERE  `date` LIKE  '{$Da}%' AND  `id` ='{$userid}' AND  `done` =0 LIMIT 0 , 30";
		$query3 = mysql_query ( $sql3 );
		$num=0;
		while ( $rs = mysql_fetch_array ( $query3 ) ) {
				?>
						<li id="<?php echo 'li'."$num";?>"
							class="single_item m_15 p_10 toggle_list_open">
							<div class="title icon_arrow_right">
								<img width="30" id="<?php echo 'im'."$num";?>"
									onclick="im(this.id)" class="fl" src="pause2.png" />
								<p>
									<strong onclick="change('<?php echo 'L'."$num";?>')"><?php echo $rs['place']?></strong>
									<img width="30px" class=" flr" src="done.png"
										onclick="dispay('<?php echo 'li'."$num";?>')" />
								</p>
								<span class="colorless">得到任务时间:<?php echo $rs['date']?></span>
							</div>
							<div class="content" id="<?php echo 'L'."$num";?>">
								<p><?php echo $rs['detail']?></p>
							</div>
						</li>
						<?php
						$num++;

		}
		/* 显式关闭连接，非必须 */
		mysql_close ( $link );	
	} else {
		die ( "Connect Server Failed: " . mysql_error () );
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
	 //$("#L").slideUp(1000);
	 document.getElementById(L).style.visibility="hidden";
	 }
 function im(L){
	 alert('您无法完成此任务，此任务已经终止')
	 document.getElementById(L).src="pause.png";
 }
</script>
</body>
</html>
