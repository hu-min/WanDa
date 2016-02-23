<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="js/jquery.js"></script>
<script type="text/javascript">
$(function(){	
	//导航切换
	$(".menuson .header").click(function(){
		var $parent = $(this).parent();
		$(".menuson>li.active").not($parent).removeClass("active open").find('.sub-menus').hide();
		
		$parent.addClass("active");
		if(!!$(this).next('.sub-menus').size()){
			if($parent.hasClass("open")){
				$parent.removeClass("open").find('.sub-menus').hide();
			}else{
				$parent.addClass("open").find('.sub-menus').show();	
			}
			
			
		}
	});
	
	// 三级菜单点击
	$('.sub-menus li').click(function(e) {
        $(".sub-menus li.active").removeClass("active")
		$(this).addClass("active");
    });
	
	$('.title').click(function(){
		var $ul = $(this).next('ul');
		$('dd').find('.menuson').slideUp();
		if($ul.is(':visible')){
			$(this).next('.menuson').slideUp();
		}else{
			$(this).next('.menuson').slideDown();
		}
	});
	// 通讯录点击
	$('.lefttop span').click(function() {
		
		var list = document.getElementsByTagName("dd");
		var bg=document.getElementById("span");
		for(var i=0;i<list.length;i++){
					if(list[i].style.display=="block"){
						bg.style.backgroundImage = 'url(images/leftup.png)';
						list[i].style.display='none';												
					}
			else{
			bg.style.backgroundImage = 'url(images/leftico.png)';
					list[i].style.display='block';
			}
		}
    });
});
</script>

<?php
require_once (dirname ( __FILE__ ) . '/DepartmentTool/Department.php');
require_once (dirname ( __FILE__ ) . '/DepartmentTool/CreateConnection.php');
$corpid = "wx0291b812dab0b77e";
$corpsecret = "HQGqvuauvM1YVzkJ-RQ6QgGbZuZKy8gwmAqOV2b5QhRB85ZSDs1uh22DSzEWh712";
$createConnection = new CreateConnection ();
$token = $createConnection->getAccessToken ( $corpid, $corpsecret );

?>

</head>

<body style="background: #fff3e1;">
	<div class="lefttop">
		<span id="span"></span>通讯录 (点击以展开)
	</div>

	<dl class="leftmenu">
		<!--动态创建第一层-->
    
 <?php
	if ($token) {
		$depart = new Department ( $token );
		$deparList = $depart->getDepartmentList ();
		$arry = json_decode ( $deparList )->department;
		foreach ( $arry as $url ) {
			if ($url->id > 1) {
				PrinDepartmentlist ( $url, $depart );
			}
		}
	} else {
		
		echo '    <div class="title">出现错误请联系管理员</div>';
	}
	?>
    
    
    
 <?php
	function PrinDepartmentlist($url, $depart) {
		$usres = $depart->getUserList ( $url->id, 0, 0 );
		?>
 	
 	<dd>
			<div id="tittle" class="title">
				<span><img src="images/leftico02.png" /></span><?php echo $url->name?>
 			</div>
			<ul class="menuson">
			<?php
		$user = json_decode ( $usres )->userlist;
		foreach ( $user as $ur ) {
			PrinUserList ( $ur );
		}
		?>
			</ul>
		</dd>
 <?php
	}
	function PrinUserList($ur) {
		?> 
		<li>
			<div class="header">
				<cite></cite><a href="#"><?php echo $ur->name?></a> <i></i>
			</div>
			<ul class="sub-menus">
				<li>员工号:<?php echo $ur->id?></li>
				<li><a href="#" target="rightFrame">分配任务</a></li>
				<li><a href="#" target="rightFrame">任务进度</a></li>
				<li><a href="sign.php?id=<?php echo $ur->id?>" target="rightFrame">查看签到</a></li>
				<li><a href="#" target="rightFrame">历史签到</a></li>
				<li><a href="#" target="rightFrame">发送消息</a></li>
			</ul>
		</li>
 	<?php
	}
	
	?>   

	</dl>

</body>
</html>
