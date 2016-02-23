<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/select.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.idTabs.min.js"></script>
<script type="text/javascript" src="js/select-ui.min.js"></script>
<script type="text/javascript" src="editor/kindeditor.js"></script>
<script type="text/javascript">
$(document).ready(function() 
{ 
	  $(".scbtn").click(function(){
		  var out=" ";
		  var startDate = document.getElementById ("meeting");
		  var mouth = document.getElementById ("yuefen");
		  var name=$("#name").attr("value");
		  if(name!=""){
		  out+=name;
		  }else{
			  out="所有员工";
			  }
		  if(mouth.value=='无'){
			  out+=startDate.value;
			  }else{
				  out+=mouth.value;
				  }
			  $("#neirong").text(out+"的签到详情");
			  $("#neirong").attr("width","0px"); 
			  $("#neirong").animate({width:"100%"},2000);
			  $(".seachform2").slideUp(2000);
			  $(".scbtn1").attr("value","高级检索"); 
			  $("tbody tr").remove();
			  getrequest();	  
		  }); 
	  $(".scbtn1").click(function(){
	  	    if( $(".scbtn1").attr("value")=='高级检索' ){ 
			    $(".scbtn1").attr("value","普通检索");
			    	$(".seachform2").slideDown(1000);
		    } 
		    else{ 
		    	 $(".scbtn1").attr("value","高级检索");
		    		 $(".seachform2").slideUp(1000); 	    	
		    } 
	  }); 	  
		$(".scbtn2").click(function(){
			  $(".tip").fadeIn(500);
  		}); 
		$(".tiptop a").click(function(){
			$(".tip").fadeOut(500);
		});

		$(".sure").click(function(){
			$(".tip").fadeOut(500);
		});
		$(".cancel").click(function(){
			$(".tip").fadeOut(500);
		});
	  
	$(".select3").uedSelect({
		width : 152
	});
}); 
</script>
<?php
$id = $_GET ["id"];
$name = $_GET ["name"];
?>
</head>
<body>
	<div class="place">
		<span>位置：</span>
		<ul class="placeul">
			<li><a href="#">首页</a></li>
			<li><a href="#"><?php if ($id==null) {echo"签到信息";} else {echo $name;}?></a></li>
			<li><a href="#">签到内容</a></li>
		</ul>
	</div>
	<div class="formbody">
		<div id="usual1" class="usual">
			<ul class="seachform1">
			<?php if ($id!=null){?>
			<span>员工ID：</span>
				<span id="name" style="margin-left: 20px">员工姓名：</span>
			<?php
			} else {
				?>
				<li><label>员工ID：</label>
					<div class="vocation">
						<select class="select3">
							<option>全部</option>
							<option>其他</option>
						</select>
					</div></li>
				<li><label>员工姓名：</label><input id="name" name="" type="text"
					class="scinput1" /></li>
			<?php }?>
			</ul>
			<ul class="seachform2">
				<span style="font-size: 7px; color: red;">注意：高级检索模式下不填写具体&nbsp;&nbsp;用户信息&nbsp;&nbsp;。将只按照日期或者月份检索所有员工</span>
				</br>
				<li><label>月份检索</label>
					<div class="vocation">
						<select class="select3" id="yuefen">
							<option>无</option>
							<option>一月</option>
							<option>二月</option>
							<option>三月</option>
							<option>四月</option>
							<option>五月</option>
							<option>六月</option>
							<option>七月</option>
							<option>八月</option>
							<option>九月</option>
							<option>十月</option>
							<option>十一月</option>
							<option>十二月</option>
						</select>
					</div></li>
				<li><label>日期检索</label>
					<div class="vocation">
						<input class="scinput1" id="meeting" type="date"
							value="2015-10-23" />
					</div></li>
			</ul>
			<div>
				<li class="sarchbtn"><label>&nbsp;</label> <input name=""
					type="button" class="scbtn" value="立即检索" /> <input name=""
					type="button" class="scbtn1" value="高级检索" /> <input name=""
					type="button" class="scbtn2" value="导出表格" /></li>
			</div>
			<div class="formtitle">
				<span id="neirong">签到详情</span>
			</div>

			<table class="tablelist">
				<thead>
					<tr>
						<th><input name="" type="checkbox" value="" /></th>
						<th>员工ID<i class="sort"><img src="images/px.gif" /></i></th>
						<th>打卡备注</th>
						<th>姓名</th>
						<th>签到/请假</th>
						<th>请假/签到时间</th>
						<th>状态</th>
						<th>（30天内请假次数大于7则警告状态）</th>
					</tr>
				</thead>
				<tbody id="tbody">
				</tbody>
			</table>
		</div>
	</div>
	<div class="tip">
		<div class="tiptop">
			<span>提示信息</span><a></a>
		</div>
		<div class="tipinfo">
			<span><img src="images/ticon.png" /></span>
			<div class="tipright">
				<p>抱歉，导出失败！</p>
				<cite>请检查接入数据库部分并点击确定按钮 ，否则请点取消。</cite>
			</div>
		</div>
		<div class="tipbtn">
			<input name="" type="button" class="sure" value="确定" />&nbsp; <input
				name="" type="button" class="cancel" value="取消" />
		</div>
	</div>
	<script type="text/javascript">
	function getrequest(){
		var xmlHttp = new XMLHttpRequest();
	    xmlHttp.open("GET","http://3.zhouxueweixin.sinaapp.com/admin/echo.php?type='sign'",true);
	    xmlHttp.send(null);
	    xmlHttp.onreadystatechange = function () {
	        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
			 var data = eval(xmlHttp.responseText);
				for(var index in data){

					addElementDiv("tr","tbody",index,0,"");
					addElementDiv("td","tr"+index,index,1,"");
					addElementDiv("input","td"+index,index,0,"");
					addElementDiv("td","tr"+index,index,0,data[index].id); 
					addElementDiv("td","tr"+index,index,0,data[index].beizhu);
					addElementDiv("td","tr"+index,index,0,data[index].name);
					addElementDiv("td","tr"+index,index,0,data[index].sign);
		 			addElementDiv("td","tr"+index,index,0,data[index].date);
		 			addElementDiv("td","tr"+index,index,0,data[index].warring);
		 			addElementDiv("td","tr"+index,index,0,data[index].times);
		 			$("#tr"+index).hide(); 
		 			$("#tr"+index).fadeIn("slow"); 
	      }		  			
	        }
	    }
	};
	/**
	type:插入的类型
	obj:被插入的对象
	num:当前第几个仅仅在tr有用
	fist：决定此是否为此对象指定ID，仅仅在第一个td有用
	*/
    function addElementDiv(type,obj,num,fist,string) {
    	var parent = document.getElementById(obj);
        switch (type) {
		case "tr":
			{
			   var neww = document.createElement("tr");
			   neww.setAttribute("id", "tr"+num);
			   parent.appendChild(neww);
			}
			break;
		case "td":
			{    if(fist==1){
			         var neww = document.createElement("td");
				     neww.setAttribute("id", "td"+num);
				     parent.appendChild(neww);
				     }
			     else{
					var neww = document.createElement("td");
					if(string=='请假'||string=='警告'||string.indexOf('标记')>=0){
						neww.setAttribute("style",'color:red');
						}
					neww.innerHTML =string;
					parent.appendChild(neww);
					}
			}
			break;
		case "input":
			{
			  var neww = document.createElement("input");
			  neww.setAttribute("type", "checkbox");
			  parent.appendChild(neww);
			}
		break;
		default:
			break;
		} 	   
}
</script>
</body>
</html>
