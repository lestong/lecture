<?php
//前台用户通用入口

namespace Home\Controller;
use Think\Controller;
class ForeController extends Controller {
	var $categorys;
	public function __construct(){

		parent::__construct();
		//self::checkSchool();
		self::checkUser();
	}
	/**
	 * 判断用户是否已经登陆
	 */
	public function checkUser() {
		//登录界面不判断, Publics控制，预览页面不判断
		if(CONTROLLER_NAME =='Publics' || I('get.test')) {
			return true;
		} else {
			$userid = cookie('userid');
			
			if(!session('userid') || $userid != session('userid')){
				
				//redirect(U('Publics/login'));
				redirect(U('Publics/index'));
			}
		}
	}
	
	public function checkSchool(){
		checkDomain();
		C('SCHOOLID', 3);
		if(C('SCHOOLID')){
			//取出当前学校的设置 logo, 标题, 等
			$detail = M('School')->where('id='.C('SCHOOLID'))->find();
			//保存到cookie中
			if($detail['fore_logo'] == 0){
				$fore_logo = '/Images/fore_logo/logo.png';
			}else{
				$fore_logo = '/Images/fore_logo/'.$detail['domain'].'.png';
				if(!file_exists('.'.$fore_logo)){
					$fore_logo = '/Images/fore_logo/logo.png';
				}
			}
			cookie('fore_logo', $fore_logo);
			cookie('fore_logo_title', $detail['fore_logo_title']);
			return true;
		}else{
			header("HTTP/1.0 404 Not Found");
			$this->display('Publics:404');exit;
			//没有此学校, 跳转到默认的网址
			//self::error('您输入的网址有误', 'http://moban.my.anli.com');
		}
	}
}