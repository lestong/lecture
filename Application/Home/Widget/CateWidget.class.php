<?php
namespace Home\Widget;
use Home\Controller\ForeController;

class CateWidget extends ForeController {
	
	//左侧菜单
	public function sidebar(){
		//$this->userid = 1;
		$map['display'] = 1;
		$menu_list = M('menu')->where($map)->select();//var_dump( M('admin_menu')->getlastsql());
		$menus = list_to_tree($menu_list, 'id', 'parentid');//var_dump($menus);
		
		$this->assign('menu_list', $menus);
		$this->display('Publics:sidebar');
	}
	
}
