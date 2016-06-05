<?php

/**
 * 会员部分
 * @author Lain
 *
 */
namespace Home\Controller;


class UserController extends ForeController {
	public function _initialize(){
		
	}
	
	//欢迎界面, 首页
	public function welcome(){
		//取出最新公告
		$map_announcement['schoolid'] = C('SCHOOLID');
		$map_announcement['status'] = 1;
		$last_announcement = D('AdminAnnouncement')->where($map_announcement)->order('updatetime DESC')->find();
		
		//var_dump($last_announcement);exit;
		$this->assign('last_announcement', $last_announcement);
		$this->display();
	}
	
	//会员个人信息
	public function profile(){
		//取出个人信息
		$map['schoolid'] = C('SCHOOLID');
		$map['uid']  = session('userid');
		$detail = D('User')->where($map)->find();
		
		//取出威客信息, 暂时只取一品威客
		$map_weike['uid'] = session('userid');
		$map_weike['weikeid'] = 2;
		$detail_weike = D('UserWeike')->where($map_weike)->find();
		
		$this->assign('detail_weike', $detail_weike);
		$this->assign('Detail', $detail);
		$this->display();
	}
	
	//修改个人信息
	public function ajax_handleInfo(){
		if(IS_POST){
			$info['real_name'] = I('post.real_name');
			$info['email'] = I('post.email');
			$info['phone'] = I('post.phone');
			$info['description'] = I('post.description');
			
			if(D('User')->create($info)){
				D('User')->where('uid')->save($info);
				$this->ajaxReturn(array('flag' => true));
			}else{
				$this->ajaxReturn(array('flag' => false, 'msg' => D('User')->getError()));
			}
		}
	}
	
	//修改密码
	public function ajax_handleChangePassword(){
		if(IS_POST){
			$password 				= I('post.password');
			$new_password 			= I('post.new_password');
			$new_password_confirm 	= I('post.new_password_confirm');
			
			//验证旧密码
			$detail = D('User')->where('uid='.session('userid'))->field('password')->find();
			if(md5(md5($password)) != $detail['password']){
				$this->ajaxReturn(array('flag' => false, 'msg' => '当前密码错误, 请重试'));
			}
			
			//新密码不能和旧密码一样
			if($password == $new_password){
				$this->ajaxReturn(array('flag' => false, 'msg' => '密码无改变'));
			}
			//更新密码
			$info['password'] = md5(md5($new_password));
			$result = D('User')->where('uid='.session('userid'))->save($info);
			if($result){
				$this->ajaxReturn(array('flag' => true));
			}else{
				$this->ajaxReturn(array('flag' => false, 'msg' => '修改失败, 请联系管理员'));
			}
			
		}
	}
	
	//修改威客信息, 暂时只有一品威客
	public function ajax_handleWeike(){
		if(IS_POST){
			//取出威客信息
			$map['uid'] = session('userid');
			$map['weikeid'] = 2;
			$detail = M('UserWeike')->where($map)->find();
			
			$info['username'] = I('post.username');
			
			if($detail){	//修改信息
				$result = M('UserWeike')->where($map)->save($info);
			}else{			//首次添加
				$info['uid'] = session('userid');
				$info['weikeid'] = 2;
				$info['create_time'] = NOW_TIME;
				
				$result = M('UserWeike')->add($info);
			}
			$this->ajaxReturn(array('flag' => true));
			
		}
	}
	
	//验证密码
	public function ajax_handleVerifyPassword(){
		$password = I('post.password');
		$detail = D('User')->where('uid='.session('userid'))->field('password')->find();
		if($detail['password'] == md5(md5($password))){
			echo 'true';
		}else{
			echo 'false';
		}
		exit;
	}
}