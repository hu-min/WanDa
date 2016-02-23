<?php

/**
 * 写的转们用作消息回复的调用函数
 *
 */
class response {
	
	/**
	 * 提取出xml数据包中的加密消息
	 *
	 * @param string $xmltext
	 *        	待提取的xml字符串
	 * @return string 提取出的加密消息字符串
	 */
	public function huifu($keyword) {
		switch ($keyword) {
			case "马云" :
				$mycontent = "您好，马云！我知道您创建了阿里巴巴！";
				break;
			case "马化腾" :
				$mycontent = "您好，马化腾！我知道创建了企鹅帝国！";
				break;
			case "史玉柱" :
				$mycontent = "您好，史玉柱！我知道您创建了巨人网络！";
				break;
			default :
				$mycontent = "你是谁啊？！一边凉快去！";
				break;
		}
		return $mycontent;
	}
	
	// 此方法是用来请求指定的网址，或者请求网址返回的内容，
	// pratm $keyword传入值，类型是字符串，
	// @pratm $data返回的类型是字符串
	public function xiaojo($keyword) {
		$curlPost = array (
				"chat" => $keyword 
		);
		$ch = curl_init (); // 初始化curl
		curl_setopt ( $ch, CURLOPT_URL, 'http://wandaoa.f3322.org:8081/yanzheng2.php' ); // 抓取指定网页
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 ); // 设置header
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 ); // 要求结果为字符串且输出到屏幕上
		curl_setopt ( $ch, CURLOPT_POST, 1 ); // post提交方式
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $curlPost );
		$data = curl_exec ( $ch ); // 运行curl
		curl_close ( $ch );
		if (! empty ( $data )) {
			return $data;
		} else {
			$ran = rand ( 1, 5 );
			switch ($ran) {
				case 1 :
					return "小鸡鸡今天累了，明天再陪你聊天吧。";
					break;
				case 2 :
					return "小鸡鸡睡觉喽~~";
					break;
				case 3 :
					return "呼呼~~呼呼~~";
					break;
				case 4 :
					return "你话好多啊，不跟你聊了";
					break;
				case 5 :
					return "感谢您关注【卓锦苏州】" . "\n" . "微信号：zhuojinsz" . "\n" . "卓越锦绣，万代不朽";
					break;
				default :
					return "感谢您关注【卓锦苏州】" . "\n" . "微信号：zhuojinsz" . "\n" . "卓越锦绣，万代不朽";
					break;
			}
		}
	}
}

?>