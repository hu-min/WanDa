<?php
require_once (dirname ( __FILE__ ) . '/Tools.php');
/**
 * 部门管理类
 * 
 * @author faith whh306318848@126.com
 *         @createtime 2015-07-23 02:34:12
 */
class Department {
	private $token;
	private $tools;
	public function __construct($token) {
		$this->token = $token;
		$this->tools = new Tools ();
	}
	
	/**
	 * 设置token
	 */
	public function setToken($token = NULL) {
		$this->token = $token;
	}
	
	/**
	 * 获取token
	 */
	public function getToken() {
		return $this->token;
	}
	
	/**
	 * 根据部门ID获取该部门下的所有子部门
	 * 
	 * @param $id 部门ID，如果是获取顶级部门，则不需要        	
	 */
	public function getDepartmentList($id = FALSE) {
		$url = "https://qyapi.weixin.qq.com/cgi-bin/department/list";
		$data = array (
				'access_token' => $this->token 
		);
		if (! empty ( $id )) {
			$data ['id'] = $id;
		}
		$result = $this->tools->httpRequest ( $url, $data );
		if ($result) {
			if ($result ['errcode'] == 0) {
				$result ['success'] = TRUE;
				return json_encode ( $result );
			} else {
				$result ['success'] = FALSE;
				return json_encode ( $result );
			}
		} else {
			return json_encode ( array (
					'success' => FALSE,
					'errmsg' => 'Query fails!',
					'errcode' => - 2,
					'department' => array () 
			) );
		}
	}
	/*
	 * 获取部门下所有成员
	 * @$department_id部门ID
	 * @$fetch_child是否获取子部门
	 * @$status那些状态的成员0获取全部成员，1获取已关注成员列表，2获取禁用成员列表，4获取未关注成员列表。status可叠加，未填写则默认为4
	 */
	public function getUserList($department_id = 1, $fetch_child = 0, $status = 0) {
		if (intval ( $department_id ) < 1) {
			return json_encode ( array (
					'success' => FALSE,
					'errmsg' => 'Department_id must be greater than zero!',
					'errcode' => - 2,
					'userlist' => array () 
			) );
		}
		
		$url = "https://qyapi.weixin.qq.com/cgi-bin/user/simplelist";
		$data = array (
				'access_token' => $this->token,
				'department_id' => $department_id 
		);
		if (intval ( $fetch_child ) > - 1) {
			$data ['fetch_child'] = $fetch_child;
		}
		if (intval ( $status ) > - 1) {
			$data ['status'] = $status;
		}
		
		$result = $this->tools->httpRequest ( $url, $data );
		if ($result) {
			if ($result ['errcode'] == 0) {
				$result ['success'] = TRUE;
				return json_encode ( $result );
			} else {
				$result ['success'] = FALSE;
				return json_encode ( $result );
			}
		} else {
			return json_encode ( array (
					'success' => FALSE,
					'errmsg' => 'Query fails!',
					'errcode' => - 2,
					'userlist' => array () 
			) );
		}
	}
}
?>