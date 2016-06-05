<?php
namespace Admin\Controller;
use Admin\Controller\AdminController;

/**
 * 后台公共部分
 * @author Lain
 *
 */
class PublicsController extends AdminController {
	public function logout(){
		session('[destroy]');
		$this->success('您已经成功退出! 欢迎您再次登陆!', U('Publics/login'),2);
	}
	public function login(){
		
	    if($_POST){
			$username = I('post.username');
			$password = I('post.password');
			
			$rtime = D('Times')->where(array('username'=>$username,'isadmin'=>1))->find();
			//如果登录密码错误次数大于， 则检测验证码
			/* if($rtime['times'] >= 5){
				$code = I('post.code');
		    	$verify = new \Think\Verify();
				if(!$code)
					$this->error('请输入验证码');
				if(!$verify->check($code)){
					$this->error('验证码输入有误');
				}
			}
			//密码错误10次，则需要等待1小时后，才能再次登录
			if($rtime['times'] >= 8) {
				$minute = 60-floor((time()-$rtime['logintime'])/60);
				if($minute>0) $this->error('请等待'.$minute.'分钟后再次登录');
			} */
			
			$map['username'] = $username;
			$detail = D('Admin')->where($map)->find();
			if (! $detail)
				$this->error('用户名，密码错误');

			//验证密码
			if ($detail['password'] != md5($password)){
				//增加错误次数
				$ip = get_client_ip(0, true);
				if($rtime && $rtime['times'] < 8) {
					$times = 8-intval($rtime['times']);
					$result = D('Times')->where(array('username'=>$username))->save(array('ip'=>$ip,'isadmin'=>1,'times'=>array('exp', 'times+1')));
				} else {
					D('Times')->where(array('username'=>$username,'isadmin'=>1))->delete();
					$result = D('Times')->add(array('username'=>$username,'ip'=>$ip,'isadmin'=>1,'logintime'=>time(),'times'=>1));
				
					$times = 8;
				}
				$this->error('用户名，密码错误');
			} else{
				//更新登录信息
				D('Admin')->where('userid='.$detail['userid'])->save(array('last_login_ip'=>$ip ? $ip : get_client_ip(0, true),'last_login_time'=>NOW_TIME));
				//删除登录错误次数
				D('Times')->where(array('username' => $username,'isadmin' => 1))->delete();
				
				//记录session
				session('userid',$detail['userid']);
				session('roleid',$detail['roleid']);
				session('schoolid', $detail['schoolid']);
				session('class', $detail['class']);
				
				if($detail['roleid'] == '1'){
					session('admin',1);
				}
					
				$cookie_time = 86400*30;
				cookie('username',$username,$cookie_time);
				cookie('nickname',$detail['nickname'],$cookie_time);
				cookie('userid', $detail['userid'],$cookie_time);
				
				redirect(__ROOT__.'/admin.php');
			}
		}else {
			$this->display();
		}
	}
	public function loginDialog(){

		/* if ($_SESSION['authId'])
		 redirect('/admin.php'); */
		if($_POST){
			$Admin = D('Admin');
			$username=I('post.UserName');
			$password=I('post.Password');
			$adminInfo = $Admin->Login ( addslashes($username), $password );
			switch ($adminInfo){
				case -1:
					$this->error('用户名，密码错误');
					break;
				case -2:
					$this->error('账号被禁用，请联系管理员 ');
					break;
				case -3:
					$this->error('用户名，密码错误');
					break;
				default:
						
					//更新登录信息
					//$Admin->where('userid='.$adminInfo['userid'])->save(array('lastloginip'=>ip(),'lastlogintime'=>SYS_TIME));
						
					//记录session
					session('userid',$adminInfo['userid']);
					session('roleid',$adminInfo['roleid']);
					session('AccountInfo',$adminInfo);
						
					$cookie_time = 86400*30;
					cookie('admin_username',$username,$cookie_time);
					cookie('userid', $adminInfo['userid'],$cookie_time);
						
					$this->ajaxReturn(array('statusCode'=>200,'callbackType'=>'closeCurrent','message'=>'登录成功'));
					break;
			}
		}else {
		
			$this->display();
		}
		
	}
	//登录页面的用户名检测, 如果没有次数限制, 则返回真.
	public function ajax_check_username(){
		if($_POST){
			$username = I('post.username');
			
			//检测次数表，是否有当前用户的信息， 如果次数〉指定次数 ， 则返回假。
			$times = D('Times')->check_username($username);
			if($times >= 5){
				$return['flag'] = false;
			}else{
				$return['flag'] = true;
			}
			echo json_encode($return);exit;
		}
	}
	public function verfy(){
		$Verify = new \Think\Verify();
		$Verify->entry();
		
	}
	
	public function updateAdminMenu(){
		$translation = array(
				'系统设置'=>'系統設置',
				'管理员设置'=>'管理員設置',
				'菜单设置'=>'菜單設置',
				'角色列表'=>'角色列表',
				'菜单列表'=>'菜單列表',
				'添加菜单'=>'添加菜單',
				'修改菜单'=>'修改菜單',
				'删除菜单'=>'刪除菜單',
				'管理员管理'=>'管理員管理',
				'添加管理员'=>'添加管理員',
				'修改管理员'=>'修改管理員',
				'重置密码'=>'重置密碼',
				'删除管理员'=>'刪除管理員',
				'添加角色'=>'添加角色',
				'禁用角色'=>'禁用角色',
				'权限设置'=>'許可權設置',
				'修改角色'=>'修改角色',
				'删除角色'=>'刪除角色',
				'学校设置'=>'學校設置',
				'学校管理'=>'學校管理',
				'教师管理'=>'教師管理',
				'添加'=>'添加',
				'修改'=>'修改',
				'班级管理'=>'班級管理',
				'添加'=>'添加',
				'修改'=>'修改',
				'学校设置'=>'學校設置',
				'学生管理'=>'學生管理',
				'添加'=>'添加',
				'修改'=>'修改',
				'批量导入'=>'批量導入',
				'添加'=>'添加',
				'修改'=>'修改',
				'系统管理'=>'系統管理',
				'任务通知设置'=>'任務通知設置',
				'公告管理'=>'公告管理',
				'学习情景'=>'學習情景',
				'学习情景'=>'學習情景',
				'文章管理'=>'文章管理',
				'栏目管理'=>'欄目管理',
				'话题'=>'話題',
				'话题'=>'話題',
				'话题管理'=>'話題管理',
				'情景设置'=>'情景設置',
				'任务中心'=>'任務中心',
				'任务中心'=>'任務中心',
				'任务管理'=>'任務管理',
				'实战任务'=>'實戰任務',
				'网址管理'=>'網址管理',
				'审核管理'=>'審核管理',
				'状态修改'=>'狀態修改',
				'状态修改'=>'狀態修改',
				'状态修改'=>'狀態修改',
				'修改'=>'修改',
				'删除'=>'刪除',
				'添加'=>'添加',
				'修改'=>'修改',
				'删除'=>'刪除',
				'添加'=>'添加',
				'编辑'=>'編輯',
				'删除'=>'刪除',
				'查看'=>'查看',
				'添加'=>'添加',
				'修改'=>'修改',
				'删除'=>'刪除',
				'添加'=>'添加',
				'修改'=>'修改',
				'删除'=>'刪除',
				'更新'=>'更新',
				'添加'=>'添加',
				'修改'=>'修改',
				'任务设置'=>'任務設置',
				'查看'=>'查看',
				'批阅'=>'批閱',
				'下载'=>'下載',
				'审核'=>'審核',
				'状态修改'=>'狀態修改',
		);
		$menu_list = M('AdminMenu')->order('id')->select();
		foreach ($menu_list as $menu){
			if(!$menu['name_zh-tw']){
				M('AdminMenu')->where('id='.$menu['id'])->save(array('name_zh-tw' => $translation[$menu['name']]));
			}
		}
		
		
	}
}