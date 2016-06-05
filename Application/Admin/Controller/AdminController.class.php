<?php
namespace Admin\Controller;
use Think\Controller;
class AdminController extends Controller {
	/**
	 * 后台执行的一些判断
	 */
	public function __construct(){
		parent::__construct();
		self::checkAdmin();
		self::checkSchool();
		//self::check_priv();
		//self::check_hash();
	}
	/**
	 * 判断用户是否已经登陆
	 */
	public function checkAdmin() {
		//登录界面不判断, Publics控制，不判断
		if(MODULE_NAME =='Admin' && CONTROLLER_NAME =='Publics' ) {
			return true;
		} else {
			$userid = cookie('userid');
			//var_dump(session('roleid'));exit;
			if(!session('userid') || !session('roleid') || $userid != session('userid')){
				//redirect('/admin.php/Publics/Login/');
				$this->error('请登录', U('Publics/login'), 1);
				//$this->ajaxReturn(array('statusCode'=> 301, 'message'=> '会话超时，请重新登录', ));
			}
		}
	}
	
	/**
	 * 检测域名所在的学校id, 调出学校相关设置
	 * @return boolean
	 */
	public function checkSchool(){
		//测试
		//C('SCHOOLID', 3);
		//checkDomain();
		//取出当前学校的设置 logo, 标题, 等
	//	$detail = M('School')->where('id='.C('SCHOOLID'))->find();var_dump(M('School')->getLastSql());

		$admin_logo_login = '/Public/images/admin_logo/login.png';
		cookie('admin_logo_login', $admin_logo_login);
	//	cookie('admin_logo_title', $detail['admin_logo_title']);
		cookie('web_title', 'res test');
	//	cookie('admin_logo', $admin_logo);
		
		
		//设置当前语言
		//C('DEFAULT_LANG', $language);
		if(!cookie('think_language')){
			$language = $detail['language'] ? $detail['language'] : 'zh-cn';
			cookie('think_language', $language);
		}
		
		B('Behavior\\CheckLang');
		return true;
	}
}