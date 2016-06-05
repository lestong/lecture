<?php
namespace Home\Controller;
use Home\Controller\ForeController;

class PublicsController extends ForeController {
	//前台首页
	public function index(){
	    $this->display();
	}
	//用户登录
	public function login(){
		
		if(IS_POST){
			//测试部分
			//###############################
			/* $username = I('post.username');
			$password = I('post.password');
			
			
			$map['loginname'] = $username;
			$map['schoolid'] = C('SCHOOLID');
			$detail = D('User')->where($map)->find();
			
			//检查本站user库
			if(!$detail){
				alert('danger', '用户不存在', U('Publics/login'));
			}
			//是否被禁用
			if($detail['status'] == 0){
				alert('danger', '此账号被禁用', U('Publics/login'));
			}
			//验证密码hash_hmac('sha256', '888888', $info['username']);	//默认密码888888
			if ($detail['password'] != md5(md5($password))){
				alert('danger', '用户名，密码错误', U('Publics/login'));
			}else{
				//更新记录
				D('User')->where('uid='.$detail['uid'])->save(array('last_login_time'=>NOW_TIME));
				//记录session
				session('userid',$detail['uid']);
				session('classid', $detail['classid']);
				
				$cookie_time = 86400*30;
				cookie('username',$detail['loginname'],$cookie_time);
				cookie('userid', $detail['uid'],$cookie_time);
				cookie('nickname', $detail['real_name'],$cookie_time);
				redirect(U('Task/lists'));
			} */
			
		}else{
			//取出班级列表
		//	$class_list = D('Admin/Class')->getSchoolClasses();
			$class_list=1;
			$this->assign('class_list', $class_list);
			//var_dump($class_list);
			$alert = parseAlert();
			$this->assign('alert', $alert);
			$this->display();
		}
	}
	
	/**
	 * 学生ajax登录
	 *  错误返回errorCode
	 *  	-2	用户名不存在
	 *  	-3	用户禁用
	 *  	-4	密码错误
	 *  	-5	班级禁用
	 */
	public function ajax_handleLoginN(){
		
		if(IS_POST){
			//测试部分
			//###############################
			$username = I('post.username');
			$password = I('post.password');
				
				
			$map['loginname'] = $username;
			$map['schoolid'] = C('SCHOOLID');
			$detail = D('User')->where($map)->find();
			$return['flag'] = false;
			//检查本站user库
			if(!$detail){
				$this->ajaxReturn(array('errorCode' => -2));
			}
			//是否被禁用
			if($detail['status'] == 0){
				$this->ajaxReturn(array('errorCode' => -3));
			}
			//判断班级是否禁用
			$status_class = D('Class')->where('id='.$detail['classid'])->getField('status');
			if($status_class != 1){
				$this->ajaxReturn(array('errorCode' => -5));
			}
			
			//验证密码hash_hmac('sha256', '888888', $info['username']);	//默认密码888888
			if ($detail['password'] != md5(md5($password))){
				$this->ajaxReturn(array('errorCode' => -4));
			}else{
				//更新记录
				D('User')->where('uid='.$detail['uid'])->save(array('last_login_time'=>NOW_TIME));
				//记录session
				session('userid',$detail['uid']);
				session('classid', $detail['classid']);
		
				$cookie_time = 86400*30;
				cookie('username',$detail['loginname'],$cookie_time);
				cookie('userid', $detail['uid'],$cookie_time);
				cookie('nickname', $detail['real_name'],$cookie_time);
				$return['flag'] = true;
			}
			
			$this->ajaxReturn($return);
				
		}
		
		
	}

	//退出
	public function logout(){

		cookie(null);
		session(null);
		redirect(U('Publics/login'));
		
	}
	
	//用户注册
	public function register(){
		
		if(IS_POST){
			
			$info['username'] = I('post.username');
			$info['password'] = hash_hmac('sha256', I('post.password'), I('post.username'));
			$info['classid'] = I('post.classid');
			$info['gender'] = I('post.gender');
			$info['schoolid'] = C('SCHOOLID');
			
			//检查该班级是否需要审核
			$map_class['id'] = $info['classid'];
			$map_class['schoolid'] = C('SCHOOLID');
			$class_detail = D('Class')->where($map_class)->field('enable_check')->find();
			if(!$class_detail){
				$this->error('不存在此班级');
			}
			if($class_detail['enable_check'] == 1 ){
				//审核状态为0
				$info['ischeck'] = 0;
			}else{
				$info['ischeck'] = 1;
			}
			
			if(D('User')->create($info)){
				
				D('User')->add($info);
				if($info['ischeck'] == 0 ){
					$this->success('注册成功, 等待管理员审核', U('Publics/login'));
				}else{
					$this->success('注册成功, 请登录', U('Publics/login'));
				}
				
			}else{
				$this->error(D('User')->getError(), U('Publics/login'));
			}
		}
	}
	
	public function ajax_handleRegister(){
		if(IS_POST){
			//验证密码
			
			$info['loginname'] = I('post.loginname');
			$info['password'] = md5(md5(I('post.password')));
			$info['classid'] = I('post.classid');
			$info['real_name'] = I('post.real_name');
			$info['studentNO'] = I('post.studentNO');
			$info['schoolid'] = C('schoolid');
			
			//检查该班级是否存在, 是否需要审核
			$map_class['id'] = $info['classid'];
			$map_class['schoolid'] = C('SCHOOLID');
			$class_detail = D('Class')->where($map_class)->find();
			if(!$class_detail){
				$this->error('不存在此班级');
			}
			if($class_detail['enable_check'] == 1 ){
				//审核状态为0
				$info['ischeck'] = 0;
			}else{
				$info['ischeck'] = 1;
			}
			
			if(D('User')->create($info)){
				$userid = D('User')->add($info);
				$return['flag'] = true;
				$return['ischeck'] = $info['ischeck'];
			}else{
				$return['flag'] = false;
				$return['msg'] = D('User')->getError();
			}
		
			echo json_encode($return);
		}
		exit;
	}
	
	//验证用户名是否注册
	public function ajax_handleVerifyUsernameOnRegister(){
		if(IS_POST){
			$map['loginname'] = I('post.loginname');
			$map['schoolid'] = C('SCHOOLID');
			
			$exist_detail = D('User')->where($map)->find();
			if($exist_detail){
				echo 'false';
			}else{
				echo 'true';
			}
			exit;
		}
	}
	
	public function ajax_handleVerifyClassid(){
		$classid = I('get.classid');
		if($classid < 0){
			$data['flag'] = false;
		}else{
			$data['flag'] = true;
		}
		$this->ajaxReturn($data);
	}
	
	//检测学生用户名是否重复, 存在返回1, 否则为0
	public function ajax_checkStuName(){

		$map['username'] = I('get.username');
		$map['schoolid'] = C('SCHOOLID');
	
		$exist_username = D('User')->where($map)->find();
		if($exist_username){
			 echo 'false';
		}else {
			echo 'true';
		}
		exit;
		//$this->ajaxReturn($return);
	}
	
	//验证邮箱是否被占用
	public function ajax_handleVerifyEmail(){
		
	}
	
}