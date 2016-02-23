<?php

$appid="wxb391f9c7df494517";//填写appid
$secret="49e7715615a18f1a050c793609f48622";//填写secret

$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$secret}";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$a = curl_exec($ch);


$strjson=json_decode($a);
$token = $strjson->access_token;
$post="{
     \"button\":[
		{
			\"name\":\"最新消息\",
			\"sub_button\":[
            {
               \"type\":\"click\",
               \"name\":\"内部公告\",
               \"key\":\"V1001_GONG_GAO\"
            },
            {
               \"type\":\"click\",
               \"name\":\"最新机器\",
               \"key\":\"V1001_JI_QI\"
            },
			{
               \"type\":\"click\",
               \"name\":\"最新福利\",
               \"key\":\"V1001_FU_LI\"
            }]
		},
		{
			\"name\":\"自助服务\",
			\"sub_button\":[
            {
               \"type\":\"click\",
               \"name\":\"故障查询\",
               \"key\":\"V1002_GU_ZHANG\"
            },
			{
               \"type\":\"click\",
               \"name\":\"联系方式\",
               \"key\":\"V1002_LIAN_XI\"
            },
            {
               \"type\":\"click\",
               \"name\":\"个人信息\",
               \"key\":\"V1002_GE_REN\"
            }]
		},
	   	{
			\"name\":\"参与开发\",
			\"sub_button\":[
            {
               \"type\":\"click\",
               \"name\":\"错误反馈\",
               \"key\":\"V1003_FAN_KUI\"
            },
			{
               \"type\":\"click\",
               \"name\":\"提出建议\",
               \"key\":\"V1003_JIAN_YI\"
            },
            {
               \"type\":\"click\",
               \"name\":\"休闲娱乐\",
               \"key\":\"V1003_XIU_XIAN\"
            },
            {
               \"type\":\"click\",
               \"name\":\"更新个人\",
               \"key\":\"V1003_GENGXIN_GEREN\"
            }]
       }]
 }";  //提交内容
$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$token}"; //查询地址 
$ch = curl_init();//新建curl
curl_setopt($ch, CURLOPT_URL, $url);//url  
curl_setopt($ch, CURLOPT_POST, 1);  //post
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);//post内容  
curl_exec($ch); //输出   
curl_close($ch); 

?>