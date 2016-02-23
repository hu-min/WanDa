<?php
include_once "CreateConnection.php";
include_once "User.php";
header ( "Content-Type: text/html; charset=utf-8" );
// 此类用作获取，，注意是“有用的 AccessToken ”
$corpid = "wx0291b812dab0b77e";
$corpsecret = "HQGqvuauvM1YVzkJ-RQ6QgGbZuZKy8gwmAqOV2b5QhRB85ZSDs1uh22DSzEWh712";
$createConnection = new CreateConnection ();
$name = $_GET ["name"];
$token = $createConnection->getAccessToken ( $corpid, $corpsecret );
if ($token && ! empty ( $name )) {
	// 构造成员方法类传入初始化值也就是传入有效的AccessToke，为此类初始化
	$user = new User ( $token );
	$userjson = $user->getUserByID ( $name );
	$obj = json_decode ( $userjson );
	switch ($obj->{'gender'}) {
		case 0 :
			$gender = "未设置";
			break;
		case 1 :
			$gender = "男";
			break;
		case 2 :
			$gender = "女";
			break;
		default :
			$gender = "未识别";
			break;
	}
	switch ($obj->{'status'}) {
		case 0 :
			$status = "未关注企业，请与其联系";
			break;
		case 1 :
			$status = "已关注企业，正在部门任职";
			break;
		default :
			$status = "未识别";
			break;
	}
	switch ($obj->{'department'} [0]) {
		case 1 :
			$department = "系统内部，但不属于任何部门";
			break;
		case 2 :
			$department = " 系统维护";
			break;
		case 3 :
			$department = " 设备售后";
			break;
		case 4 :
			$department = " 运营管理";
			break;
		default :
			$department = "未识别";
			break;
	}
	
	$name = $obj->{'name'}; // 姓名
	$userid = $obj->{'userid'}; // 用户ID
	$mobile = $obj->{'mobile'}; // 手机
	$email = $obj->{'email'}; // 邮箱
	$weixinid = $obj->{'weixinid'}; // 微信号
	$position = $obj->{'position'}; // 职位
	
	$link = mysql_connect ( SAE_MYSQL_HOST_M . ':' . SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS );
	if ($link) {
		mysql_select_db ( SAE_MYSQL_DB, $link );
		
		// 查询签到信息
		$Da = date ( "Y-m-d" );
		$sql = "SELECT Type FROM  `Sign` WHERE  `SignTime` LIKE  '{$Da}%' AND  `UserId` ='{$userid}' LIMIT 0 , 30";
		// $sql = "SELECT `Type` FROM `Sign` WHERE `UserId` ={$userid} ";
		$query = mysql_query ( $sql );
		
		$Signed = mysql_fetch_array ( $query ); // 获取sql语句结果
		                                        
		// 查询此月签到的任务情况
		$dat=getdate();
		$sql2 = "select * from Sign where SignTime > DATE_SUB(CURDATE(), INTERVAL {$dat['mday']} DAY) and   `UserId` ='{$userid}' and `Type` ='0' LIMIT 0 , 30";
		$query2 = mysql_query ( $sql2 );
		$sum=0;
		while ( $rs = mysql_fetch_array ( $query2 ) ) {
			$sum++;
		}
		//查询今天任务多少件没做
		$sql3 = "SELECT done FROM  `Task` WHERE  `date` LIKE  '{$Da}%' AND  `id` ='{$userid}' LIMIT 0 , 30";
		$task=0;
		$query3 = mysql_query ( $sql3 );
			while ( $rs = mysql_fetch_array ( $query3 ) ) {
			$task++;
		}
		/* 显式关闭连接，非必须 */
		mysql_close ( $link );
	} else {
		die ( "Connect Server Failed: " . mysql_error () );
	}
} else {
	$name = "未知"; // 姓名
	$userid = "未知"; // 用户ID
	$department = "未知"; // 部门
	$gender = "未知"; // 性别
	$mobile = "未知"; // 手机
	$email = "未知"; // 邮箱
	$weixinid = "未知"; // 微信号
	$status = "未知"; // 是否关注公司
	$position = "未知"; // 职位
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="mobile_module.css"
	media="all">
<link rel="shortcut icon" href="favicon.ico">
<link href="userCenter.css" rel="stylesheet" type="text/css">
<title>
	<?php echo $name?>的个人信息
</title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<meta
	content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"
	name="viewport">
</head>


<body>
	<div class="container">
		<div class="box user_box">
			<div class="head">
				<img src="head.jpg" width="80" width="80" />
			</div>
			<p>
				<strong>姓名：&nbsp&nbsp<?php echo $name; ?></strong>
			</p>
			<p>
				<span>&nbspI&nbsp&nbsp&nbspD：</span>&nbsp&nbsp<?php echo $userid; ?></p>
			<p>
				<span>部门：&nbsp</span>&nbsp<?php echo $department; ?></p>
			<a class="edit" id="url1"
				onclick="seturl('<?php echo "{$Signed[0]}"?>')"
				<?php echo 'href="../../../SignIn/SignIn.php?'."name=$name&userid=$userid&department=$department&position=$position".'"' ?>><img
				src="icon_pencil.png" width="30px" width="30px" class="sign">
				<p class="sign"height:100% width:100% ><?php if (!$Signed[0]) {echo "签到";} else {echo "已签";} ?>
             	</p> </a>
		</div>
		<div class="box">
			<h6>个人详细资料：</h6>
			<a class="item"> <span class="td title">职&nbsp&nbsp&nbsp位：</span> <span
				class="td count"><?php echo $position?></span>
			</a> <a class="item"> <span class="td title">微信号：</span> <span
				class="td count"><?php echo $weixinid?></span>
			</a> <a class="item"> <span class="td title">手机号：</span> <span
				class="td count"><?php echo $mobile?></span>
			</a> <a class="item"> <span class="td title">邮&nbsp&nbsp&nbsp箱：</span>
				<span class="td count"><?php echo $email?></span>
			</a>
		</div>
		<div class="box">
			<h6>任务详情：</h6>
			<a class="item"
				<?php
				if (! $Signed)
					echo 'onclick="return edit();"';
				else
					echo 'href="../../../Card/exchange.php?'."userid=$userid".'"';
				?>> <span class="td title">今日任务：</span> <span class="td num">&nbsp&nbsp&nbsp&nbsp&nbsp
					<?php echo $task;?> 件</span> <span class="td to">查看详情&gt; </span>
			</a> <a class="item"> <span class="td title">放弃任务：</span> <span
				class="td num">&nbsp&nbsp&nbsp&nbsp数据暂不公开</span>
			</a>
		</div>
		<div class="box">
			<h6>签到打卡：</h6>
			<a class="item"
				<?php
				if (! $Signed)
					echo 'onclick="return edit();"';
				else
					echo 'onclick="return edit2();"';
				?>> <span class="td title">近七天打卡：</span> <span class="td num">&nbsp&nbsp&nbsp&nbsp数据暂不公开</span> <span class="td to">查看详情&gt; </span>
			</a> <a class="item"> <span class="td title">次月天打卡：</span> <span
				class="td num">&nbsp&nbsp&nbsp&nbsp&nbsp <?php echo $sum;?>天未到</span>
			</a>
		</div>
	</div>
	<p class="copyright">万达设备有限公司</p>
</body>
<script type="text/javascript">
function edit() {
		alert("这个。。您好象还没签过到耶，签到才能点击我哦！");
}
function edit2() {
	alert("数据暂时不公开，请勿再次点击");
}
function seturl(sign) {
	if (sign!=0) {
		alert("哇偶，您已经签过到了，还点击！！难道你想对我造成一万点伤害吗！");
		document.getElementById("url1").href="#";
	}
	
}

</script>
</html>