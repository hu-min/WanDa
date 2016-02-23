<?php
include_once 'SendMessage.php';

// 获取ACC_TOKEN
$APPID = "wx0291b812dab0b77e";
$APPSECRET = "HQGqvuauvM1YVzkJ-RQ6QgGbZuZKy8gwmAqOV2b5QhRB85ZSDs1uh22DSzEWh712";
$TOKEN_URL = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=" . $APPID . "&corpsecret=" . $APPSECRET;
$json = file_get_contents ( $TOKEN_URL );
$result = json_decode ( $json );
$ACC_TOKEN = $result->access_token;

// 发送对象构建
$touser = $_POST ['UserId'];
$agentid = $_POST ['agentid'];
$sendMessage = new SendMessage ( $ACC_TOKEN );
if ($_POST ['content'] == "") {
	
	// 构建curl对象
	$file_name = $_FILES ['upload'] ['name'];
	$uplodetime = date ( "ymdHis" );
	$file_ext = explode ( ".", $file_name );
	$file_ext = array_pop ( $file_ext );
	$file_ext = trim ( $file_ext );
	$file_ext = strtolower ( $file_ext );
	$new_file_name = $uplodetime . "." . $file_ext;
	$url = "https://qyapi.weixin.qq.com/cgi-bin/media/upload?access_token={$ACC_TOKEN}&type={$_POST ['file']}";
	$info_str = "@{$_FILES["upload"]["tmp_name"]};filename={$new_file_name};type={$_POST ['file']}";
	$fields ['media'] = $info_str;
	$ch = curl_init ( $url ); // 准备POST
	curl_setopt ( $ch, CURLOPT_HEADER, false );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt ( $ch, CURLOPT_POST, 1 );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
	$responce = curl_exec ( $ch ); // 执行POST
	$responce = json_decode ( $responce );
	echo "<br>";
	$id = $responce->media_id;
	if ($_POST ['file'] == 'image') {
		$result = $sendMessage->sendImage ( $agentid, $id, $touser );
	}elseif ($_POST ['file'] =='voice'){
		$result = $sendMessage->sendVoice($agentid,$id,$touser );
		
	}elseif ($_POST ['file'] =='video'){
		$result =$sendMessage->sendVideo($agentid,$id, "一条视频消息", "来了一个视频消息",$touser);
	}elseif ($_POST ['file'] =='file'){
		$result =$sendMessage->sendFile($agentid, $id,$touser);
	}
} else {
	$result = $sendMessage->sendText ( $agentid, $_POST ['content'], $touser );
}

json_decode ( $result, TRUE );
if (isset ( $result ['errcode'] ) && intval ( $result ['errcode'] ) != 0) {
	echo '<p style="font-size:24pt;color:red;text-align:center">发送失败<p>';
} else {
	echo '<p style="font-size:24pt;color:red;text-align:center">发送成功<p>';
}

// $material = new Material ( $ACC_TOKEN );

// $Sae = new SaeStorage();
// $name =$_FILES['upload']['name'];
// echo $name.'</br>';
// $Sae->upload('uploadweixin',$name,$_FILES['upload']['tmp_name']);
// $Url=$Sae->getUrl("uploadweixin",$name);
// echo $Url;//输出文件在storage的访问路径
// echo '<br/>';
// echo $Sae->errmsg(); //输出storage的返回信息

// $varname = 'media';//上传到$_FILES数组中的 key
// $name ='aaaa.png';//文件名
// $type = "image/png";//文件类型
// $key = "$varname\"; filename=\"$name\r\nContent-Type: $type\r\n";
// $re=new SaeStorage('1yyllmljko','jywixwl1i5jhi2255wllji2h42m2w3whwl0l1h04');
// $ss=$re->read("uploadweixin","aaaa.png");
// $fields[$key] = $ss;
// $url = "https://qyapi.weixin.qq.com/cgi-bin/media/upload?access_token=BizJ1n2vppJEyDDJ74Vye6touKKbrNKTWsplLLzx-EMOHlqHv8KNb4Gdfo2dPZl2LoJ-jJwZqx1Iyq_b5gJsYQ&type=image"; //上传地址
// $ch = curl_init($url);
// curl_setopt($ch, CURLOPT_POST, 1); //模拟POST
// curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);//POST内容
// curl_setopt($ch, CURLOPT_VERBOSE,1);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
// $result=curl_exec($ch);
// $result = json_decode($result);
// curl_close($ch);
// $txt = "";
// foreach ($result as $key => $value) {
// $txt = $txt . $key . ' => ' . $value . "\n";
// }
// echo $txt;

// $domain = "uploadweixin";
// $upload_dir = 'saestor://' . $domain . '/';
// if (! is_dir ( $upload_dir )) {
// echo "不存在输出路径".'</br>';
// }
// if ($_files ['upload'] ['error'] > 0) {
// echo '上传错误：' . $_FILES[upload][error] . '<br />';
// } else {
// echo '临时位置：' . $_FILES ['upload'] ['tmp_name'].'</br>';
// }
// if (move_uploaded_file ( $_FILES ['upload'] ['tmp_name'], $upload_dir . $_FILES['upload'] ['name'] )) {
// echo "上传成功".'</br>';
// }
// else {
// echo "上传失败".'</br>';
// }

// $json2 = $material->uploadTemporaryMaterial ( Material::MEDIA_TYPE_IMAGE, '/s/uploadweixin/'.$_FILES['upload']['$name']);
// $array = explode ( ',', $json2 );
// $array = explode ( ':', $array [1] );
// echo 'Media_Id:::::::::' . $array [1] . '</br></br></br>';
// var_dump($material->getTemporaryMaterial("1I_FViSA9hArOZWzKJ0idhTaGwjbYARNscDwfsESs-wfpeDgOCMAj7Av2VuUvTnt7T5aSf-XoaSlOVDi-_s2lFw"));
// var_dump($material->uploadPermanentMaterial(4, Material::MEDIA_TYPE_IMAGE, dirname( __FILE__ )."/b.png"));
// var_dump($material->getPermanentMaterial("2_AL2HYxmlBDgDV9UT8uoMWJOC-7hzIKOUZQ8Thcof-Eg8wxT6TkOpnxs1VXOJmqJw_G8xI4QZrJs1L-EB0khsQ", 4));
// var_dump($material->deletePermanentMaterial("2_AL2HYxmlBDgDV9UT8uoMWJOC-7hzIKOUZQ8Thcof-Eg8wxT6TkOpnxs1VXOJmqJw_G8xI4QZrJs1L-EB0khsQ", 4));
// var_dump($material->getMaterialCount(4));
// var_dump($material->getMaterialList(Material::MEDIA_TYPE_MPNEWS, 4, 0, 50));

// $sendMessage = new SendMessage ( $ACC_TOKEN );
// var_dump($sendMessage->sendFile(4, "1KQuH3LMcYGIj3t0nM-i1wyZMo-TpULxFnkEoYpB2r15Th6P86R5EUnzATFSK_Uq0rB1yPX8IhwOglcqSbhUSgA"));
// var_dump($sendMessage->sendText(4, "Holiday Request For Pony(\"http://xxxxx\")"));
// var_dump ( $sendMessage->sendImage ( $agentid, $array [1], $touser ) );
// var_dump($sendMessage->sendVoice(4, "2pAg95-1xk2v-GK7veGVhz6Zoe8qZj20bu8ixRV6M9j_mdgrYMF16p0DTdSCOuASo1gjmOcgafj3Gd4LAEfzciw"));
// var_dump($sendMessage->sendVideo(4, "2hHlbQB5q0fr8z-hF8KyyPYiSZAMizYmeezRkpKxK4uu5fF0endeI81_2dfyRwBW4Y4oPP4fJqZTXPN3KCo9pwg", "测试视频接口", "我就是测试一下视频发送接口"));
// var_dump($sendMessage->sendNews(4, array(array('title'=>'我用爬虫一天时间“偷了”知乎一百万用户，只为证明PHP是世界上最好的语言', 'description'=>'来源： 爱编程', 'url'=>'http://www.w2bc.com/Article/54923'))));
// var_dump($sendMessage->sendMpnewsByMediaID(4, "2N53V20kxM_83rjCKTsncW-0WhBLRQsPVxXhtElFyUGXJGSWk0FwKSw-IeV56srH3"));
// var_dump($sendMessage->sendMpnewsByContent(4, array(array('title'=>'测试消息1', 'thumb_media_id'=>'271UhK8-pLZ1gy1G5z4ccTUJKPrFn7iFD2GsPk8mt6d5vJTYVANmxHSzF1wkM_qB_C3ggzMKcZhZl-Nmpx0e8QQ', 'author'=>'faith', 'content_source_url'=>'http://www.youarebug.com', 'content'=>'测试消息1', 'digest'=>'测试信息，你信吗？', 'show_cover_pic'=>1), array('title'=>'测试消息2', 'thumb_media_id'=>'271UhK8-pLZ1gy1G5z4ccTUJKPrFn7iFD2GsPk8mt6d5vJTYVANmxHSzF1wkM_qB_C3ggzMKcZhZl-Nmpx0e8QQ', 'author'=>'faith', 'content_source_url'=>'http://www.aiurbia.net', 'content'=>'测试消息2', 'digest'=>'测试信息，你信吗？', 'show_cover_pic'=>1))));

// $data = '{
// "touser":"' . $touser . '",
// "msgtype":"text",
// "agentid": "' . $agentid . '",
// "text":
// {
// "content":"' . $content . '"
// }
// }';

// $url = "https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=" . $ACC_TOKEN;

// $curl = curl_init ();
// curl_setopt ( $curl, CURLOPT_URL, $url );
// curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, FALSE );
// curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, FALSE );
// curl_setopt ( $curl, CURLOPT_POST, 1 );
// curl_setopt ( $curl, CURLOPT_POSTFIELDS, $data );
// curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
// $result = curl_exec ( $curl );
// if (curl_errno ( $curl )) {
// echo 'Errno' . curl_error ( $curl );
// }
// curl_close ( $curl );
// // {"errcode":82001,"errmsg":"All touser & toparty & totag invalid"}
// // {"errcode":44004,"errmsg":"empty content"}
// $obj = json_decode ( $result );
// if ($obj->errcode == '82001') {
// echo '<p style="font-size:24pt;color:red;text-align:center">没有填写用户信息<p>';
// } elseif ($obj->errcode == '44004') {
// echo '<p style="font-size:24pt;color:red;text-align:center">没有填写内容,失败了哦<p>';
// }else {
// echo '<p style="font-size:24pt;color:red;text-align:center">发送成功<p>';
// }
?>