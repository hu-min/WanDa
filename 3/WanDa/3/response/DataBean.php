<?php
class DataBean {
	private $fromUsername;
	private $toUsername;
	private $Content;
	private $time;
	private $MsgType;
	private $Event;
	private $EventKey;
	private $latitude;
	private $longitude;
	public function DataBean($sMsg) {
		$postObj = simplexml_load_string ( $sMsg, 'SimpleXMLElement', LIBXML_NOCDATA );
		$this->fromUsername = $postObj->FromUserName;
		$this->toUsername = $postObj->ToUserName;
		$this->Content = trim ( $postObj->Content );
		$this->latitude = $postObj->Location_X;
		$this->longitude = $postObj->Location_Y;
		$this->MsgType = $postObj->MsgType;
		// $this->Event = $postObj->Event;
		// $this->EventKey = $postObj->EventKey;
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
	public function Content() {
		return $this->Content;
	}
	public function getMsgType() {
		return $this->MsgType;
	}
	public function getEvent() {
		return $this->$Event;
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
		return $this->$Content;
	}
	public function getfromUsername() {
		return $this->fromUsername;
	}
}

?>