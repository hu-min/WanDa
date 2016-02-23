<?php
$name = $_GET ["name"];
$userid = $_GET ["userid"];
$department = $_GET ["department"];
$position = $_GET ["position"];
$name = empty ( $name ) ? "未知" : $name;
$userid = empty ( $userid ) ? "未知" : $userid;
$department = empty ( $department ) ? "未知" : $department;
$position = empty ( $position ) ? "未知" : $position;
?>
<html>
<head>
<link rel="shortcut icon" href="favicon.ico">
<link href="css.css" rel="stylesheet" type="text/css">
<title>打卡签退</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1.0, user-scalable=no">
</head>
<body>
	<img src="suggest_head.png" width="100%" />
	<form method="post">
		<!-- 姓名工号部门职位组 -->
		<div id="tab1" class="p_10">
			<!-- 姓名工号组 -->
			<div class="form-item" style="margin-top: 10px;">
				<div class="text1">
					<label style="font-size: 17px; margin-left: 20px">姓名:</label> <label><?php echo $name;?></label>
				</div>
				<div class="text2">
					<label style="font-size: 17px; margin-left: 20px">工号ID:</label> <label><?php echo $userid;?></label>
				</div>
			</div>
			<!-- 部门职能组 -->
			<div class="form-item" style="margin-bottom: 6px">
				<div class="text1">
					<label style="font-size: 17px; margin-left: 20px">部门:</label> <label><?php echo $department;?></label>
				</div>
				<div class="text2">
					<label style="font-size: 17px; margin-left: 20px">职&nbsp&nbsp位:&nbsp</label>
					<label><?php echo $position;?></label>
				</div>
			</div>
			<!-- 定位组件 -->
			<div style="height: 30px;">
				<lbs-geo id="geo" city="北京" enable-modified="false"></lbs-geo>
			</div>
			<!--备注组件  -->
			<div class="form-item" style="height: 105px">
				<label class="item-label">备注内容：</label>
				<textarea rows="1" cols="18"></textarea>
			</div>
			<!-- 提交按钮 -->
			<button id="submit" onclick="updata()">提 交</button>
		</div>
	</form>
	<!-- 版权行 -->
	<p class="copyright" style="font-size: 12px;">版权&copy;万达设备有限公司</p>

	<script>
// 先获取元素
var lbsGeo = document.getElementById('geo');
//监听定位失败事件 geofail	
lbsGeo.addEventListener("geofail",function(evt){ 
	alert("定位失败请重新签到，否则无法记录个人状态");
});
//监听定位成功事件 geosuccess
lbsGeo.addEventListener("geosuccess",function(evt){ 
	console.log(evt.detail);
	var address = evt.detail.address;
	var coords = evt.detail.coords;
	var x = coords.lng; 
	var y = coords.lat;
	alert("测试显示当前地址："+address);
	alert("测试显示当前地理坐标："+x+','+y);
});
</script>
	<script>
		 function updata(){
			<?php
			$link = mysql_connect ( SAE_MYSQL_HOST_M . ':' . SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS );
			if ($link) {
				mysql_select_db ( SAE_MYSQL_DB, $link );
				$sql = " UPDATE  `app_zhouxueweixin`.`SignIn` SET  `Signed` =  '1' WHERE  `SignIn`.`UserId` ={$userid} ";
				$query = mysql_query ( $sql );
				
				/* 显式关闭连接，非必须 */
				mysql_close ( $link );
				?><?php

				header ( "../UserCenter/View/UserCenter.php" );
			} else {
				?><?php

				die ( "Connect Server Failed: " . mysql_error () );
			}
			?>
			
		 }
</script>
</body>
</html>
