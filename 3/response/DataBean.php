<?php
class DataBean {
	// 被动消息中的共有参数
	private $fromUsername, $AgentID, $toUsername, $MsgType, $Event, $EventKey;
	
	// text消息特有参数
	private $Content;
	
	// 服务器本地时间，发送封保用的
	private $time;
	
	// 进入应用上报地理位置事件
	private $Latitu, $Longitu, $Precision;
	
	// 被动消息中的location消息特有参数 $latitude地理位置纬度$longitude地理位置经度$Scale地图缩放大小$Label地理位置信息$AgentID当前应用ID
	private $latitude, $longitu, $Scale, $Label;
	public function DataBean($sMsg) {
		$postObj = simplexml_load_string ( $sMsg, 'SimpleXMLElement', LIBXML_NOCDATA );
		
		// 进入应用上报地理位置事件参数
		$this->Latitu = $postObj->Latitude;
		$this->Longitu = $postObj->Longitude;
		$this->Precision = $postObj->Precision;
		
		
		// location消息特殊参数
		$this->latitude = $postObj->Location_X;
		$this->longitude = $postObj->Location_Y;
		$this->Scale = $postObj->Scale;
		$this->Label = $postObj->Label;
		
		// 公有参数获取
		$this->AgentID = $postObj->AgentID;
		$this->fromUsername = $postObj->FromUserName;
		$this->toUsername = $postObj->ToUserName;
		$this->Content = trim ( $postObj->Content );
		$this->MsgType = $postObj->MsgType;
		$this->Event = $postObj->Event;
		$this->EventKey = $postObj->EventKey;
		$this->time = time ();
	}
	public function TextHuiFuData($mycontent, $type = TRUE) {
		if ($type = fase) {
			$sRespData = "<xml>
					<ToUserName><![CDATA[" . $this->toUsername . "]]></ToUserName>
					<FromUserName><![CDATA[" . $this->fromUsername . "]]></FromUserName>
					<CreateTime>" . $this->time . "</CreateTime>
					<MsgType><![CDATA[text]]></MsgType>
					<Content>$mycontent</Content>
					</xml>";
		} else {
			$sRespData = "<xml>
					<ToUserName><![CDATA[" . $this->toUsername . "]]></ToUserName>
					<FromUserName><![CDATA[" . $this->fromUsername . "]]></FromUserName>
					<CreateTime>" . $this->time . "</CreateTime>
					<MsgType><![CDATA[text]]></MsgType>
					<Content><![CDATA[" . $mycontent . "]]></Content>
					</xml>";
		}
		
		return $sRespData;
	}
	public function getMsgType() {
		return $this->MsgType;
	}
	public function getEvent() {
		return $this->Event;
	}
	public function getEventKey() {
		return $this->EventKey;
	}
	public function getlongitude() {
		return $this->longitude;
	}
	public function getlatitude() {
		return $this->latitude;
	}
	public function getContent() {
		return $this->Content;
	}
	public function getfromUsername() {
		return $this->fromUsername;
	}
	public function getScale() {
		return $this->Scale;
	}
	public function getLabel() {
		return $this->Label;
	}
	public function getAgentID() {
		return $this->AgentID;
	}
	public function getLatitu() {
		return $this->Latitu;
	}
	public function getLongitu() {
		return $this->Longitu;
	}
	public function getPrecision() {
		return $this->Precision;
	}
}

?>