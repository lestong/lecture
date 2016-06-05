<?php 
/**
 * 用户权限
 * @author Lain
 *
 */
namespace Admin\Behaviors;
class AuthenticateBehavior extends \Think\Behavior {
	protected $options = array();
	
	public function run(&$params) {
		$m = MODULE_NAME;
		$c = CONTROLLER_NAME;
		$a = ACTION_NAME;
		$allow = $params['allow'];
		$permission = $params['permission'];
		if (session('?admin')) {
			return true;
		}
		
		if (in_array($a, $permission)) {
			return true;
		} elseif (session('?roleid')) {
			if (in_array($a, $allow)) {
				return true;
			} else {
				
				$map['c'] = strtolower($c);
				$map['a'] = strtolower($a);
				$map['roleid'] = session('roleid');
				
				$priv = M('admin_role_priv')->where($map)->find();
				
				if (is_array($priv) && !empty($priv)) {
					return true;
				} else {
					$this->ajaxReturn();
				}
			}
		} else {
			$this->ajaxReturn();
		}
		return true;
	}
	
	public function ajaxReturn(){
		header('Content-Type:application/json; charset=utf-8');
		exit(json_encode(array('statusCode'=>300,'message'=>'您没有此权限！')));
	}
}