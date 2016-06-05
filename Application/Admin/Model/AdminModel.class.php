<?php 
/*
 * 后台管理员模型
 */
namespace Admin\Model;
use Think\Model;
class AdminModel extends Model {
	protected $tableName = 'administrator';
	/*
	 * 登录验证部分
	 * @garam 验证码/密码
	 * @return
	 *  1用户名错误 
	 *  2账号禁用
	 *  3密码错误
	 *  
	 */
	public function login($username, $password, $randomKey) {
		//检测用户名
		$map['username'] = $username;
		$detail = $this->where($map)->find();
		if (! $detail)
			return -1;
		
		//验证密码
		
		if (hash_hmac('sha256', $detail['password'], $randomKey) == $password){
			//更新登录时间
			return $detail;
		} else
			return -3;
	}
	
	/**
	 * 修改密码
	 * @param unknown $userid 	用户ID
	 * @param unknown $password	密码
	 * @return boolean
	 */
	public function edit_password($userid, $password){

		$userid = intval($userid);
		if($userid < 1) return false;
		if(!is_password($password))
		{
			return false;
		}
		$passwordinfo = password($password);
		return $this->where('userid='.$userid)->save($passwordinfo);
		
	}
	
	//给教师添加class
	public function addClass($userid, $classid){
		//取出当前教师的class
	}
	
	/*
	 * 取出本学校可以批阅该班级的教师列表
	*/
	public function get_class_teacher($class){
		//取出该学校的所有教师（不包括管理员）
		$map['schoolid'] = C('SCHOOLID');
		$map['enable'] = 1;
		
		$teacherList = $this->where($map)->select();
		//$teacherList = $DB->Select('SELECT id,username,nickname,class FROM db_administrator WHERE enable="1" AND schoolid = ' . $classDetail['schoolid']);
		/* if(is_array($teacherList)){
			foreach ($teacherList as $k => $v){
				//判断教师角色等级
				if(adminLevel($v['id']) == 3){
					//教师权限， 则判断班级是否是所在管理
					if(!$v['class'] || !preg_match("/^(".str_replace(',', '|', $v['class']).")$/", $class)){
						unset($teacherList[$k]);
					}
				}else{
					unset($teacherList[$k]);
				}
			}
		} */
		return $teacherList;
	}
}
