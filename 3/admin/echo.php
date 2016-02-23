<?php
require_once (dirname ( __FILE__ ) . '/DepartmentTool/Tools.php');
require_once (dirname ( __FILE__ ) . '/DepartmentTool/Department.php');
require_once (dirname ( __FILE__ ) . '/DepartmentTool/CreateConnection.php');
header ( "Content-Type: text/html; charset=utf-8" );
$corpid = "wx0291b812dab0b77e";
$corpsecret = "HQGqvuauvM1YVzkJ-RQ6QgGbZuZKy8gwmAqOV2b5QhRB85ZSDs1uh22DSzEWh712";
$createConnection = new CreateConnection ();
$token = $createConnection->getAccessToken ( $corpid, $corpsecret );
$url = "http://www.weather.com.cn/adat/cityinfo/101310101.html";
$type = $_GET ["type"];
switch ($type) {
	case "getToken" :
		echo $token;
		break;
	case "Contact" :
		Contact ();
		break;
	case "Task" :
		Task ();
		break;
	case "sign" :
		sign ();
		break;
	case "getweather" :
		getweather ();
		break;
	case "getuser" :
		getuser ( $token );
		break;
	default :
		echo "获取你请求的参数错误";
		break;
}
function Task() {
	$link = mysql_connect ( SAE_MYSQL_HOST_M . ':' . SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS );
	if ($link) {
		mysql_select_db ( SAE_MYSQL_DB, $link );
		$place = $_GET ["place"];
		$meeting = date ( 'y-m-d h:i:s' ); // $_GET ["meeting"];
		$id = $_GET ["id"];
		$detail = $_GET ["detail"];
		if ($place != "") {
			$sql = "INSERT INTO `app_zhouxueweixin`.`Task` (`date`, `done`, `place`, `name`, `id`, `people`, `detail`) VALUES ('$meeting', '0', '$place', '暂无', '$id', '暂无','$detail')";
			$he = mysql_query ( $sql );
			if ($he <= 0) {
				echo "抱歉添加任务失败";
			} else {
				echo "添加任务成功";
			}
		} else {
			$dat = date ( 'Y-m-d' );
			$sql2 = "SELECT * FROM `Task` WHERE `date` LIKE '{$dat}%' LIMIT 0, 30 ";
			$query2 = mysql_query ( $sql2 );
			$ReturnDate = '[';
			while ( $r = mysql_fetch_array ( $query2 ) ) {
				$done = $r ['done'];
				$place = $r ['place'];
				$name = $r ['name'];
				$id = $r ['id'];
				$date = $r ['date'];
				$people = $r ['people'];
				$ReturnDate = $ReturnDate . '{done:"' . "$done" . '",place:"' . "$place" . '",name:"' . "$name" . '",id:"' . "$id" . '",date:"' . "$date" . '",people:"' . "$people" . '"},';
			}
			$ReturnDate = $ReturnDate . ']';
			echo $ReturnDate;
		}
		/* 显式闭连接，非必须 */
		mysql_close ( $link );
	} else {
		echo "数据库连接失败";
		die ( "Connect Server Failed: " . mysql_error () );
	}
}
function sign() {
	$link = mysql_connect ( SAE_MYSQL_HOST_M . ':' . SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS );
	if ($link) {
		mysql_select_db ( SAE_MYSQL_DB, $link );
		$Id = $_GET ["Id"];
		$Mouth = "";
		$Mouth = $_GET ["Mouth"];
		$Date = "";
		$Date = $_GET ["Date"];
		if ($Id == "all") {
			$ID = '%';
		} else {
			$ID = $Id;
		}
		$Mouth = $_GET ["Mouth"];
		if ($Mouth == '无') {
			$sql = "SELECT * FROM `Sign` WHERE `SignTime` LIKE '{$Date}%' AND `UserId` LIKE '{$ID}' LIMIT 0, 30 ";
			// echo $sql;
		} else {
			$years = date ( 'Y' );
			switch ($Mouth) {
				case '一月' :
					$Mouth = '01';
					break;
				case '二月' :
					$Mouth = '02';
					break;
				case '三月' :
					$Mouth = '03';
					break;
				case '四月' :
					$Mouth = '04';
					break;
				case '五月' :
					$Mouth = '05';
					break;
				case '六月' :
					$Mouth = '06';
					break;
				case '七月' :
					$Mouth = '07';
					break;
				case '八月' :
					$Mouth = '08';
					break;
				case '九月' :
					$Mouth = '09';
					break;
				case '十月' :
					$Mouth = '10';
					break;
				case '十一月' :
					$Mouth = '11';
					break;
				case '十二月' :
					$Mouth = '12';
					break;
			}
			$DA = $years . '-' . "$Mouth" . '%';
			$sql = "SELECT * FROM `Sign` WHERE `SignTime` LIKE '{$DA}' AND `UserId` LIKE '{$ID}' LIMIT 0, 30 ";
		}
		$query = mysql_query ( $sql );
		/* 显式闭连接，非必须 */
		mysql_close ( $link );
		$ReturnDate = '[';
		while ( $rs = mysql_fetch_array ( $query ) ) {
			$id = $rs ['UserId'];
			$beizhu = $rs ['Mark'];
			$name = $rs ['UserName'];
			$sign = $rs ['Type'];
			$date = $rs ['SignTime'];
			$warring = '警告';
			$times = '标记此员工（累计请假12天 ）';
			$ReturnDate = $ReturnDate . '{id:"' . "$id" . '",beizhu:"' . "$beizhu" . '",name:"' . "$name" . '",sign:"' . "$sign" . '",date:"' . "$date" . '",warring:"' . "$warring" . '",times:"' . "$times" . '"},';
		}
		$ReturnDate = $ReturnDate . ']';
		echo $ReturnDate;
	} else {
		echo "数据库连接失败";
		die ( "Connect Server Failed: " . mysql_error () );
	}
}
function getweather() {
	$tool = new Tools ();
	if ($tool == null) {
		$weather2 = "TOOL初始化失败";
	}
	$obj = $tool->httpRequest ( $url );
	if ($obj == null) {
		$weather2 = "obj请求直往数据失败";
	} else {
		$weather2 = $obj . length;
	}
	$weatherinfo = $obj ['weatherinfo'];
	$weather = $weatherinfo ['weather'];
	$temp1 = $weatherinfo ['temp1'];
	$temp2 = $weatherinfo ['temp2'];
	$ptime = $weatherinfo ['ptime'];
	echo $weather;
}
function getuser($token) {
	if ($token) {
		$word = "";
		$depart = new Department ( $token );
		$deparList = $depart->getDepartmentList ();
		$arry = json_decode ( $deparList )->department;
		foreach ( $arry as $url ) {
			$word = "$word" . "{$url->id}";
		}
	} else {
		
		echo "获取用户失败";
	}
	echo $word;
}
function Contact() {

	
}
?>