<?php
include_once "Tools.php";
/**
 * 微信企业号
 * 创建连接
 */
class CreateConnection {
	private $tools = NULL;
	// CreateConnection的构造方法，，
	// 此方法初始化设定默认是FALSE，意思是当用户啊不传入
	// 值得时候默认有一个传入的参数$argument且值为false
	function __construct($argument = FALSE) {
		$this->tools = new Tools ();
	}
	
	/**
	 * 获取AccessToken
	 *
	 * @param $corpid 企业ID        	
	 * @param $corpsecret 管理组的凭证密钥        	
	 */
	public function getAccessToken($corpid = FALSE, $corpsecret = FALSE) {
		if (empty ( $corpid ) || empty ( $corpsecret )) {
			return false;
		}
		
		$result = $this->getLocalAccessToken ( $corpid, $corpsecret );
		// 从本地获取如果返回值$result是false说明无法获取本地的，则执行网络获取
		// 否则说明获取到了，直接返回AccessToken
		if (empty ( $result )) {
			
			// 从微信服务器获取
			$result = $this->getRemoteAccessToken ( $corpid, $corpsecret );
			// if判断是否成功获取
			if (empty ( $result )) {
				return FALSE;
			} else {
				return $result;
			}
		} else {
			return $result;
		}
	}
	
	/**
	 * 获取存储在本地的AccessToken
	 *
	 * @param $corpid 企业ID        	
	 * @param $corpsecret 管理组的凭证密钥        	
	 */
	private function getLocalAccessToken($corpid, $corpsecret) {
		if (empty ( $corpid ) || empty ( $corpsecret )) {
			return false;
		}
		
		return $this->tools->getAccessToken ( $corpid, $corpsecret );
	}
	
	/**
	 * 从服务器上获取AccessToken
	 *
	 * @param $corpid 企业ID        	
	 * @param $corpsecret 管理组的凭证密钥        	
	 */
	public function getRemoteAccessToken($corpid, $corpsecret) {
		if (empty ( $corpid ) || empty ( $corpsecret )) {
			return false;
		}
		// 准备好请求需要的地址和，值，
		// 让工具类去执行，结果返回fasle或者请求到token
		
		$url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken";
		$data = array (
				'corpid' => $corpid,
				'corpsecret' => $corpsecret 
		);
		// 让工具类去执行，结果返回的$result值为fasle或者请求到token
		$result = $this->tools->httpRequest ( $url, $data );
		if (isset ( $result ['access_token'] )) {
			$this->tools->saveAccessToken ( $corpid, $corpsecret, $result ['access_token'] );
			return $result ['access_token'];
		} else {
			// echo $result['errcode'].":".$result['errmsg'];
			return FALSE;
		}
	}
}

?>