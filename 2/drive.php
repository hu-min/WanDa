<?php
/**
  * wechat php test
  */
//define your token
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
$wechatObj->responseMsg();
class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

	public function responseMsg()
				{
					//get post data, May be due to the different environments
					$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

					//extract post data
					if (!empty($postStr)){
						//取出微信发个过来的值
						$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
						$fromUsername = $postObj->FromUserName;
						$toUsername = $postObj->ToUserName;
						$type = $postObj->MsgType;
						$customrevent = $postObj->Event;
						$latitude  = $postObj->Location_X;
						$longitude = $postObj->Location_Y;
						$keyword = trim($postObj->Content);
						$time = time();
						$textTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[text]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						<FuncFlag>0</FuncFlag>
						</xml>";      
						
						//分析如何回复
                        
                        if($keyword!="")
                        {
                      		  $contentStr =$this->KeyWord($keyword);   
                        }
                        if($event=="CLICK")
                        {
                      		  $contentStr =$this->Menu($EventKey);   
                        }
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time,$contentStr);
						echo $resultStr;

				}else {
						echo "写点吧";
						exit;
					 }
				}

    //TOKEN验证函数
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	 		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}

					//连接数库，查询数据，返回内容  函数			
					private function QueryMySql($str){
						
						$link=mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
						if(!$link) {
								die("Connect Server Failed: " . mysql_error());
						}
						
						if($link)
						{				
							/*至此连接已完全建立，就可对当前数据库进行相应的操作了*/
							/*！！！注意，无法再通过本次连接调用mysql_select_db来切换到其它数据库了！！！*/
							/* 需要再连接其它数据库，请再使用mysql_connect+mysql_select_db启动另一个连接*/

							/**
							* 接下来就可以使用其它标准php mysql函数操作进行数据库操作
							*/
                            if($str[0]!=""&&$str[1]!=""){
							mysql_select_db(SAE_MYSQL_DB,$link);
							$sql = "SELECT * FROM `zhouxueweixin` WHERE  `BreakDownId` ={$str[0]} AND  `DeviceId` LIKE  '{$str[1]}' LIMIT 0 , 30";
                          //$sql = "SELECT * FROM `zhouxueweixin` WHERE  `keywords` LIKE  '{$str}' LIMIT 0, 30 ";
							$query=mysql_query($sql);//执行sql语句
							$rs=mysql_fetch_array($query);//获取sql语句结果
							/*显式关闭连接，非必须*/
							mysql_close($link);
                            $BreakDownId=$rs['BreakDownId'];
                            $one=$rs['one'];
                            $two=$rs['two'];
                            $three=$rs['three'];
                            $four=$rs['four'];
                            $DeviceId=$rs['DeviceId'];
                            $contentStr="设备名称：{$DeviceId} \n 故障代码：{$BreakDownId} \n 描述一：{$one} \n 描述二：{$two} \n 描述三：{$three} \n 描述四：{$four}";
                            if($contentStr==""){
                            
                            }
                                
							return $contentStr;
                            
                            }else{
                            $contentStr ="抱歉，输入格式不正确！";
                                return $contentStr;
                            }
						}
					}

					//拆分关键词函数比如：错误代码；设备型号->>得到数组arry【0】=错误代码，arry【1】=设备型号函数
					private function WhatKeyWords($keyword){
						$arr = explode("；",$keyword);
						return $arr;
					}
    
    
    				//关键词回复函数		
    				private function KeyWord($keyword){
						
						 switch ($keyword)
							{
							case "个人信息";
								$contentStr = "嗯，暂时不开放，目前没写";
								break;
							case "今日任务";
								$contentStr = "今还没写";
                             	break;
							default;
                             {$Str =$this->WhatKeyWords($keyword);
                              $contentStr = $this->QueryMySql($Str);
                             break;}
                            }	
                         return $contentStr;
					}
    
    
    				//菜单功能按钮实现函数
   					 private function Menu($EventKey){
                     switch($EventKey)
                            {
                                case "V1001_GONG_GAO";
                               		$contentStr="内部公告功能未实现";
                                	break;
                                case "V1001_JI_QI";
                             	    $contentStr="最新机器功能未实现";
                                	break;
                                case "V1001_FU_LI";
                             	    $contentStr="最新福利功能未实现";
                                	break;
                                case "V1002_GU_ZHANG";
                              	   $contentStr="故障查询功能未实现";
                                	break;
                                case "V1002_LIAN_XI";
                               	  $contentStr="联系方式功能未实现";
                                	break;
                                case "V1002_GE_REN";
                              	   $contentStr="个人信息功能未实现";
                                	break;
                                case "V1003_FAN_KUI";
                             	    $contentStr="错误反馈功能未实现";
                                	break;
                            	case "V1003_JIAN_YI";
                             	    $contentStr="提出建议功能未实现";
                                	break;
                                case "V1003_XIU_XIAN";
                             	    $contentStr="休闲娱乐功能未实现";
                                	break;
                                case "V1003_GENGXIN_GEREN";
                              	   $contentStr="更新个人功能未实现";
                                	break;
                                default;
                              	   $contentStr="内部错误，希望你能反馈信息";
                                	break;
                            }
                      return $contentStr;
                     }

}

?>