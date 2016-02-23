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
		  var place=$("#place").val();
		  var detail=$("#detail").val();
		  var id=$("#id").val();
		  var meeting=$("#meeting").val();
		  var tip=$("#tip").val();
		  if (place===""||id=="无"||meeting=="2015-10-23") {
			alert("注意：\n地点是否没有填写？\n员工没有添加吧？\n今天好像不是2015-10-23吧？")
		}else {
			var myDate=new Date();
			  $("#neirong").text(myDate.toLocaleDateString()+"的         任务详情");
			  $("#weiwancheng").text(myDate.toLocaleDateString()+"以前的         任务详情");

			  $("#neirong").attr("width","0px");
			  $("#weiwancheng").attr("width","0px");

			  $("#neirong").animate({width:"100%"},2000);
			  $("#weiwancheng").animate({width:"100%"},2000);
			  $(".seachform2").slideUp(2000);
			  $(".scbtn1").attr("value","更多细节");
			  $("tbody tr").remove();
			  getTask(place,detail,id,meeting,tip);
		}

		  });
	  $(".scbtn1").click(function(){
	  	    if( $(".scbtn1").attr("value")=='更多细节' ){
			    $(".scbtn1").attr("value","收起细节");
			    	$(".seachform2").slideDown(1000);
		    }
		    else{
		    	 $(".scbtn1").attr("value","更多细节");
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
</head>
<body>
	<div class="place">
		<span>位置：</span>
		<ul class="placeul">
			<li><a href="#">首页</a></li>
			<li><a href="#">任务管理</a></li>
			<li><a href="#">发布任务</a></li>
		</ul>
	</div>
	<div class="formbody">
		<div id="usual1" class="usual">
			<ul class="seachform1">
				<li><label>任务地点：</label><input id="place" name="" type="text"
					class="scinput1" /></li>
				<li><label>任务描述：</label><input id="detail" name="" type="text"
					class="scinput1" /></li>
				<li><label>ID分配</label>
					<div class="vocation">
						<select class="select3" id="id">
							<option>无</option>
							<option>一月</option>
							<option>二月</option>
							<option>三月</option>
						</select>
					</div></li>
				<li><label style="color: red;">发布日期</label>
					<div class="vocation">
						<input class="scinput1" id="meeting" type="date"
							value="2015-10-23" />
					</div></li>
				<li style="font-size: 7px; color: red; text-align: center;">(*必填)</li>
			</ul>
			<ul class="seachform2">
				<span style="font-size: 7px; color: red;"><br /> <br />注意：输入框建议请勿填写过多文字，一般100以下，过多导致数据库膨胀，服务器无法承受！<br />
				</span>
				</br>
				<li><label>任务提示：</label><input id="tip" name="" type="text"
					class="scinput1" /></li>
			</ul>
			<div>
				<li class="sarchbtn"><label>&nbsp;</label> <input name=""
					type="button" class="scbtn" value="添加任务" /> <input name=""
					type="button" class="scbtn1" value="更多细节" /> <input name=""
					type="button" class="scbtn2" value="删除勾选" /></li>
			</div>

			<span style="font-size: 7px; color: red;"><br />删除勾选：批量删除下方选中的项目，您也可以在操作选项中单条删除！<br />
			</span>
			<div class="formtitle">
				<span id="neirong">任务列表</span>
			</div>

			<!--今日任务 -->
			<table class="tablelist">
				<thead>
					<tr>
						<th><input name="" type="checkbox" value="" /></th>
						<th>是否完成<i class="sort"><img src="images/px.gif" /></i></th>
						<th>任务地点</th>
						<th>员工姓名</th>
						<th>员工ID</th>
						<th>发布时间</th>
						<th>当前接管人</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><input name="" type="checkbox" value="" /></td>
						<td>20130908</td>
						<td>王金平幕僚：马英九声明字字见血 人活着没意思</td>
						<td>admin</td>
						<td>江苏南京</td>
						<td>2013-09-09 15:05</td>
						<td>已审核</td>
						<td><a href="#" class="tablelink">查看</a> <a href="#"
							class="tablelink"> 删除</a></td>
					</tr>
				</tbody>
			</table>

			<div class="formtitle">
				<span id="weiwancheng">任务列表</span>
			</div>
			<span style="font-size: 7px; color: red;"><br />注意：由于历史数据量大，仅显示历史未完成任务，若查询历史已完成任务，请
				到管理后台数据库自行查询！<br /> <br /> <br /> </span>
			<!--历史未完成任务 -->
			<table class="tablelist">
				<thead>
					<tr>
						<th><input name="" type="checkbox" value="" /></th>
						<th>是否完成<i class="sort"><img src="images/px.gif" /></i></th>
						<th>任务地点</th>
						<th>员工姓名</th>
						<th>员工ID</th>
						<th>发布时间</th>
						<th>当前接管人</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><input name="" type="checkbox" value="" /></td>
						<td>20130908</td>
						<td>王金平幕僚：马英九声明字字见血 人活着没意思</td>
						<td>admin</td>
						<td>江苏南京</td>
						<td>2013-09-09 15:05</td>
						<td>已审核</td>
						<td><a href="#" class="tablelink">查看</a> <a href="#"
							class="tablelink"> 删除</a></td>
					</tr>
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
/**
 * 得到服务器任务数据
 */
  	function getTask(place,detail,id,meeting,tip){

 	 	alert("place:"+place+"detail:"+detail+"id"+id+"meeting"+meeting+"tip:"+tip);
//  		var xmlHttp = new XMLHttpRequest();
// 	    xmlHttp.open("GET","http://3.zhouxueweixin.sinaapp.com/admin/echo.php?type='Task'",true);
// 	    xmlHttp.send(null);
// 	    xmlHttp.onreadystatechange = function () {
// 	        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
// 			 var data = eval(xmlHttp.responseText);
// 	        }
// 	    }
}



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