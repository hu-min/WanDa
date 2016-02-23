<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<?php
require_once (dirname ( __FILE__ ) . '/DepartmentTool/Tools.php');
$url = "http://www.weather.com.cn/adat/cityinfo/101310101.html";
?>
</head>
<body>
	<div class="place">
		<span>位置：</span>
		<ul class="placeul">
			<li><a href="#">首页</a></li>
		</ul>
	</div>
	<div class="mainindex">
		<!--欢迎使用系统  -->
		<div class="welinfo">
			<b>Admin早上好，欢迎使用信息管理系统</b>(万达设备有限公司) <a href="#">帐号设置</a>
		</div>
		<!-- 上次登录时间 -->
		<div class="welinfo">
			<span><img src="images/time.png" alt="时间" /></span> <i>您上次登录的时间：2013-10-09
				15:22</i> （不是您登录的？<a href="#">请点这里</a>）
		</div>
    <?php
				$tool = new Tools ();
				$obj = $tool->httpRequest ( $url );
				$weatherinfo = $obj ['weatherinfo'];
				$weather = $weatherinfo ['weather'];
				$temp1 = $weatherinfo ['temp1'];
				$temp2 = $weatherinfo ['temp2'];
				$ptime = $weatherinfo ['ptime'];
				?>
		<!-- 天气标签 -->
		<div class="welinfo">
			<span><img src="images/sun.png" alt="天气" /></span> <b>今日&nbsp;海口天气:&nbsp;&nbsp;<?php echo $weather?>&nbsp;&nbsp;&nbsp;温度<?php echo "$temp2".'~'."$temp1"?>&nbsp;&nbsp;</b>(最后更新时间<?php echo $ptime ?>)
		</div>
		<!-- 下划线 -->
		<div class="xline"></div>
		<!-- 使用指南 -->
		<div class="welinfo">
			<span><img src="images/dp.png" alt="提醒" /></span> <b>万达设备微信管理系统使用指南</b>
		</div>
		<ul class="infolist">
			<li><span>您可以快速找到联系人资料</span></li>
			<li><span>您可以快速分配任务给任何人</span></li>
			<li><span>您可以快速查询任何人的任务进度</span></li>
			<li><span>您可以快速查询任何人今日签到</span></li>
			<li><span>您可以快速查询任何人的历史签到</span></li>
			<li><span>您可以快速发送消息给任何人</span></li>
		</ul>
		<!-- 下划线 -->
		<div class="xline"></div>
		<!-- 使用帮助 -->
		<div class="uimakerinfo">
			<b>如果您在使用过程中有任何问题，您可以向系统维护人员请求帮助！</b> (<a href="http://www.baidu.com"
				target="_blank">www.baidu.com</a>) <br /> <b>租用规模服务器较小，若使用发生明显错误，请刷新页面！</b>
			<br /> <b>请勿多次刷新首页，造成服务器巨大负担，无法为您提供优质服务！！</b>
		</div>
		<!-- 实现功能 -->
		<b style="padding-left: 40px; padding-bottom: 20px">当前系统实现功能：</b>
		<ul class="umlist">
			<li><a href="#">成员资料</a></li>
			<li><a href="#">分配任务</a></li>
			<li><a href="#">查看任务进度</a></li>
			<li><a href="#">查看今日签到</a></li>
			<li><a href="#">查看历史签到</a></li>
			<li><a href="#">对员工发送消息</a></li>
		</ul>
	</div>
</body>

</html>
