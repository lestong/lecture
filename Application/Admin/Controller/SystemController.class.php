<?php
namespace Admin\Controller;
use Admin\Controller\AdminController;
class SystemController extends AdminController{
	public function _initialize(){
		$action = array(
				'permission'=>array('changePassword', 'profile', 'ajax_checkUsername', 'ajax_schoolCheckName', 'ajax_schoolCheckDomain'),
				//'allow'=>array('index')
		);
		B('Admin\\Behaviors\\Authenticate', '', $action);
	}
	

	/**
	 * 修改个人资料
	 */
	public function profile(){
		$userid = session('userid');
		if(IS_POST){
			$data['nickname'] = I('post.nickname');
	
			D('Admin')->where('userid='.$userid)->save($data);
			//更新成功后， 重新登录
			$this->ajaxReturn(array('statusCode'=>200,'closeCurrent'=>'true','message'=>L('message_success')));
		}else{
	
			$detail = D('Admin')->where('userid='.session('userid'))->find();
			$this->assign('Detail', $detail);
			$this->display();
		}
	}

	/**
	 * 修改密码
	 */
	public function changePassword(){
		$userid = session('userid');
		if(IS_POST){
			
			$detail = D('Admin')->where('userid='.$userid)->field('username, password')->find();
			if ( md5(I('post.password_old')) != $detail['password'] )
				$this->ajaxReturn(array('statusCode'=>300,'message'=>'旧密码输入错误'));
			$password_new = I('post.password_new');
			if(isset($password_new) && !empty($password_new)) {
				$data['password'] = md5($password_new);
				D('Admin')->where('userid='.$userid)->save($data);
			}
			//更新成功后， 重新登录
			$this->ajaxReturn(array('statusCode'=>200,'closeCurrent'=>'true','message'=>'密码更改成功','forwardUrl'=>'/admin.php/Publics/Logout/'));
		}else{
			$this->display();
		}
	}
	
	public function adminManage(){
		$DB = D('admin');
		//检索条件
		if(I('post.username')){
			$this->username = $username = I('post.username');
			$map['username'] = array('like', "%$username%");
		}
		if(I('post.roleid')){
			$this->roleid = $roleid = I('post.roleid');
			$map['roleid'] = $roleid;
		}
		//分页相关
		$page['pageCurrent'] = max(1 , I('post.pageCurrent'));
		$page['pageSize']= I('post.pageSize') ? I('post.pageSize') : 30 ;
		
		$totalCount = $DB->where($map)->count();
		$page['totalCount']=$totalCount ? $totalCount : 0;
		 
		$this->page_list = $DB->order('userid')->where($map)->page($page['pageCurrent'], $page['pageSize'])->select();
		//获取角色
		$this->roles = S('role') ? S('role') : D('AdminRole')->get_role_list();
		$this->page = $page;
		
		$this->display();
	}
	public function adminEdit(){
		$userid = I('get.userid','','intval');
		if(IS_POST){			
			$info['nickname'] = I('post.nickname');
			$info['roleid'] = I('post.roleid');
			D('Admin')->where('userid='.$userid)->save($info);
			$this->ajaxReturn(array('statusCode'=>200,'closeCurrent'=>'true','tabid'=>'System_adminManage'));
		}else{	
			$this->Detail = D('Admin')->where('userid='.$userid)->find();
			//获取角色
			$this->roles = S('role') ? S('role') : D('AdminRole')->get_role_list();
			$this->display();
		}
	}
	public function adminAdd(){
		if(IS_POST){
			$info['username'] = I('post.username');
			$info['nickname'] = I('post.nickname');
			$info['roleid'] = I('post.roleid');
			//生成默认密码
			//$info = array_merge($info, password('1q2w3e4'));
			//$info['password'] = hash_hmac('sha256', '1q2w3e4', $info['username']);
			$info['password'] = md5('1q2w3e4');
			D('Admin')->add($info);
			$this->ajaxReturn(array('statusCode'=>200,'closeCurrent'=>'true','tabid'=>'System_adminManage'));
		}else{	
			//获取角色
			$this->roles = S('role') ? S('role') : D('AdminRole')->get_role_list();
			$this->display('adminEdit');
		}
	}
	
	public function ajax_checkUsername(){
		$username = I('post.username');
		
		$exist_username = D('Admin')->where(array('username' => $username))->find();
		if($exist_username){
			$this->ajaxReturn(array('error' => L('message_error_exist_username')));
			//echo '{"error":"用户名已存在"}';
		}else {
			$this->ajaxReturn(array('ok' => ''));
			//echo '{"ok":"名字很棒!"}';
		}
		exit;
		
	}
	
	/**
	 * 默认角色admin不能删除
	 */
	public function adminDelete(){
		$ids = I('get.ids');
		if(!$ids)
			$this->ajaxReturn(array('statusCode'=>300,'message'=>'没有选择'));
		$userids = explode(',', $ids);
		foreach ($userids as $userid){
			//过滤不需要删除的 角色 ID
			if($userid == 1)
				continue;
			//判断权限
			
			//删除角色,
			D('admin')->where('userid='.$userid)->delete();
		}
	
		$this->ajaxReturn(array('statusCode'=>200,'message'=>L('message_success'),'tabid'=>'System_adminManage'));
	}
	
	/**
	 * 系统设置-管理员设置-重置密码   已经修改
	 */
	public function adminResetPassword(){
		
		$userid = I('get.userid','','intval');
		//不能修改超级管理员
		if($userid == 1){
			$this->ajaxReturn(array('statusCode'=>300,'message'=>'该对象不可更改'));
		}
		//自己不能修改自己的角色
		if($userid == $_SESSION['authId']){
			$this->ajaxReturn(array('statusCode'=>300,'message'=>'重置自己的密码有啥意思嘛！'));
		}
		//修改规则
		$username = D('Admin')->where('userid='.$userid)->getField('username');
		//$data = password('1q2w3e4');
		$data['password'] = md5('1q2w3e4');
		$result = D('admin')->where('userid='.$userid)->save($data);
		
		$this->ajaxReturn(array('statusCode'=>200,'message'=>'重置密码为1q2w3e4。','tabid'=>'System_adminUserLists'));
	}
    /**
     * 系统设置-角色列表 已经修改
     */
    public function adminRoleList(){
    	$DB=M('admin_role');
    	//检索条件
    	$where=array();
    	if($_POST['name']!=''){
    		$sql=" and name='{$_POST['name']}'";
    	}
    	//分页相关
    	$page['pageCurrent']=max(1,I('post.pageCurrent',0,'intval'));
    	$page['pageSize']=I('post.pageSize',20,'intval');
    	$totalCount = $DB->count();
    	$page['totalCount']= $totalCount ? $totalCount : 0;
    	//取数据
    	$str=intval($page['pageCurrent']-1)*$page['pageSize'];
    	$roleList = $DB->limit($str,$page['pageSize'])->select();
    	$this->page_list = $roleList;
    	$this->page=$page;
    	$this->display();
    }
    /**
     * 系统设置-角色列表-添加角色 已经修改
     */
    public function adminRoleAdd(){
    	$DB=M('admin_role');
    	if(IS_POST){
    		$info = I('post.info');
    		
    		$info['disabled']=1;
    		$result = $DB->add($info);
    		if(!$result){
    			$this->ajaxReturn(array('statusCode'=>300,'message'=>'添加角色失败，请重试。ErrorNo:0001'));
    		}
    		//更新角色列表
    		D('AdminRole')->get_role_list();
    		$this->ajaxReturn(array('statusCode'=>200,'closeCurrent'=>'true','tabid'=>'System_adminRoleList'));
    	}
    	$this->display('adminRoleEdit');
    }
    /**
     * 系统设置-角色列表-编辑角色 已经修改
     */
    public function adminRoleEdit(){
    	$roleid = I('get.roleid','','intval');
    	if(IS_POST){
    	    //var_dump($_POST['info']);
    	    
    		$result = D('AdminRole')->where('roleid=' . $roleid)->save($_POST['info']);
    		if(!$result){//信息未修改时（其他情况也会进入这分支）将会报错，先取消此功能吧  
    			//$this->ajaxReturn(array('statusCode'=>300,'message'=>'保存角色信息失败，请重试。'));
    		}
    		//更新角色列表
    		D('AdminRole')->get_role_list();
    		$this->ajaxReturn(array('statusCode'=>200,'closeCurrent'=>'true','tabid'=>'System_adminRoleList'));
    	}else{
	    	$this->Detail = D('AdminRole')->where('roleid='.$roleid)->find();
	    	$this->display();
    	}
    }
    /**
     * 系统设置-角色列表-删除角色 已经修改
     */
    public function adminRoleDelete(){
    	$DB = M();
    	$roleid = I('get.roleid','','intval');
    	//不允许删除超级管理员
    	if($roleid == 1)
    		$this->ajaxReturn(array('statusCode'=>300,'message'=>'不允许删除超级管理员'));
    	$result = $DB->table('db_admin_role')->where('roleid='.$roleid)->delete();
    	
    	if(!$result){
    		$this->ajaxReturn(array('statusCode'=>300,'message'=>'删除角色失败，请重试。ErrorNo:0001'));
    	}

    	//删除权限表
    	$DB->table('db_admin_role_priv')->where('roleid='.$roleid)->delete();
    	
    	$this->ajaxReturn(array('statusCode'=>200,'tabid'=>'System_adminRoleList'));
    }
    /**
     * 系统设置-角色列表-禁用角色 已经修改
     */
    public function adminRoleForbid(){
    	$DB = M('admin_role');
    	$roleid = I('get.roleid','','intval');
    	
    	if(!$roleid)
    		$this->ajaxReturn(array('statusCode'=>300,'message'=>'参数错误，请重试'));
    	$disabled = $_GET['disabled'] ? 0 : 1;
    	//更新状态
    	$result = $DB->where('roleid='.$roleid)->save(array('disabled'=>$disabled));

    	if(!$result){
    		$this->ajaxReturn(array('statusCode'=>300,'message'=>'变更状态失败，请重试。ErrorNo:0001'));
    	}
    	$this->ajaxReturn(array('statusCode'=>200,'tabid'=>'System_adminRoleList'));
    }
    
    
    /**
     * 角色权限设置
     */
    public function adminPrivSetting(){

    	$this->roleid = $roleid = I('get.roleid','','intval');
    	$array_menu = M('admin_menu')->index('id')->select();
    	if(IS_POST){
    		//删除旧权限
    		
			M('admin_role_priv')->where('roleid='.$roleid)->delete();
			$ids = I('post.ids');
			$data['roleid'] = $roleid;
			if($ids){
				$ids = explode(',', $ids);
				foreach ($ids as $menu_id){
					//取出id的设置
					$detail = $array_menu[$menu_id];
					$data['menuid'] = $detail['id'];
					$data['m'] = strtolower($detail['m']);
					$data['c'] = strtolower($detail['c']);
					$data['a'] = strtolower($detail['a']);
					M('admin_role_priv')->add($data);
				}
			}
    		
    	}else{

    		
    		//$menus = list_to_tree($array_menu, 'id' ,'parentid', 'children');
    		$map['roleid'] = $roleid;
    		foreach ($array_menu as $menu_id => $menu){
    			$json_priv[$menu_id] = $menu;
    			//判断该权限是否拥有
    			$map['menuid'] = $menu['id'];
    			$exist_priv = M('admin_role_priv')->where($map)->find();
    			if($exist_priv){
    				$json_priv[$menu_id]['checked'] = true;
    			}
    		}
    		$menus = list_to_tree($json_priv, 'id' ,'parentid', 'children');
    		$this->json_priv = json_encode($menus);
    		//var_dump($menus);exit;
    		/* $priv_data = M('admin_role_priv')->select(); //获取权限表数据
    		$modules = 'admin,announce,vote,system';
    		foreach ($result as $n=>$t) {
    			$result[$n]['cname'] = $t['name'];
    			$result[$n]['checked'] = ($this->op->is_checked($t,$roleid,$priv_data))? ' checked' : '';
    			$result[$n]['level'] = $this->op->get_level($t['id'],$result);
    			$result[$n]['parentid_node'] = ($t['parentid'])? ' data-tt-parent-id="'.$t['parentid'].'"' : '';
    		}
    		$str  = "<tr data-tt-id='\$id' \$parentid_node>
						<td style='padding-left:30px;'>\$spacer<input type='checkbox' name='menuid[]' value='\$id' level='\$level' \$checked onclick='javascript:checknode(this);'> \$cname</td>
					</tr>";
    			
    		$menu->init($result);
    		$this->categorys = $menu->get_tree(0, $str); */
    		
    		
    		$this->display();
    	}
    }
    
    public function adminNodeLists(){
		$DB = M();
    	$tree = new \Lain\Phpcms\tree();
    	$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
    	$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
    	
    	$result = $DB->table('db_admin_menu')->order('listorder ASC,id ASC')->select();
    	$array = array();
    	foreach($result as $r) {
    		$r['icon'] = $r['icon'] ? '<i class="fa fa-'.$r['icon'].'"></i>' : '';
    		$r['cname'] = $r['name'];
    		$r['display_icon'] = $r['display'] ? '' : ' <img src ="/Public/images/gear_disable.png" title="不在菜单显示">';
    		$r['str_manage'] = '<a href="'.U('System/adminNodeAdd').'/parentid/'.$r['id'].' " class="btn btn-green" data-toggle="dialog" data-width="520" data-height="290" data-id="dialog-mask" data-mask="true">添加下级菜单</a> <a class="btn btn-green" href="'.U('System/adminNodeEdit').'/id/'.$r['id'].'/pc_hash/'.$this->pc_hash.'" data-toggle="dialog" data-width="520" data-height="290" data-id="dialog-mask" data-mask="true">修改</a> <a href="'.U('System/adminNodeDelete').'/id/'.$r['id'].'/pc_hash/'.$this->pc_hash.'" class="btn btn-red" data-toggle="doajax" data-confirm-msg="确定要删除该行信息吗？">删</a> ';
    		$array[] = $r;
    	}
    	
    	$str  = "<tr data-id='\$id'>
			    	<td>\$id</td>
			    	<td>\$spacer\$cname \$display_icon</td>
			    	<td>\$listorder</td>
			    	<td>\$icon</td>
    				<td align='center'>\$str_manage</td>
    	</tr>";
    	$tree->init($array);
    	$this->categorys = $tree->get_tree(0, $str);
    	$this->display();
    }
    //图标,查找带回
    public function adminNodeIcon(){
    	//取出图标集
    	//检索条件
		if(I('post.name')){
			$this->name = $name = I('post.name');
			$map['name'] = array('like', "%$name%");
		}
		
		//分页相关
		$page['pageCurrent'] = max(1 , I('post.pageCurrent'));
		$page['pageSize']= I('post.pageSize') ? I('post.pageSize') : 30 ;
		$page['totalCount'] = M('admin_icon')->where($map)->count();
    	$icons = M('admin_icon')->where($map)->select();
    	
    	$this->assign('page', $page);
    	$this->assign('page_list', $icons);
    	$this->display();
    }
    /**
     * 系统设置-节点设置-增加节点  已经修改
     */
    public function adminNodeAdd(){
    	if(IS_POST){
    		$info = I('post.info');
    		$info['icon'] = I('post.icon');
    		
    		if(!D('AdminMenu')->create($info)){
    			$this->ajaxReturn(array('statusCode'=>300,'message'=>D('AdminMenu')->getError()));
    		}else{
	    		D('AdminMenu')->add($info);
				$this->ajaxReturn(array('statusCode'=>200,'closeCurrent'=>'true','tabid'=>'System_adminNodeLists'));
    		}
    	}else{
    		//取出父级菜单信息
    		$parentid = I('get.parentid','','intval');
    		if($parentid)
    			$this->Detail = D('AdminMenu')->where('id='.$parentid)->field('c, display, icon')->find();
	    	$tree = new \Lain\Phpcms\tree();
	    	$result = D('AdminMenu')->select();
	    	$array = array();
	    	foreach($result as $r) {
	    		$r['cname'] = $r['name'];
	    		$r['selected'] = $r['id'] == $parentid ? 'selected' : '';
	    		$array[] = $r;
	    	}
	    	$str  = "<option value='\$id' \$selected>\$spacer \$cname</option>";
	    	$tree->init($array);
	    	$this->select_categorys = $tree->get_tree(0, $str);
	    	$this->display('adminNodeEdit');
    	}
    }
    /**
     * 系统设置-节点设置-编辑节点 已经修改
     */
    public function adminNodeEdit(){
    	$DB = M('admin_menu');
    	$id = I('get.id','','intval');
    	if(IS_POST){
    		$info = I('post.info');
    		//新增图标
    		if(I('post.icon')){
    			$info['icon'] = I('post.icon');
    		}
    		if(!$DB->create($info)){
    			$this->ajaxReturn(array('statusCode'=>300,'message'=>$DB->getError()));
    		}else{
	    		$DB->where('id='.$id)->save($info);
	    		$this->ajaxReturn(array('statusCode'=>200,'closeCurrent'=>'true','tabid'=>'System_adminNodeLists'));
    		}
    		
    	}else{
	    	$this->Detail = $DB->where('id='.$id)->find();
	    	$tree = new \Lain\Phpcms\tree();
	    	$result = $DB->select();
	    	foreach($result as $r) {
	    		$r['cname'] = $r['name'];
	    		$r['selected'] = $r['id'] == $this->Detail['parentid'] ? 'selected' : '';
	    		$array[] = $r;
	    	}
	    	$str  = "<option value='\$id' \$selected>\$spacer \$cname</option>";
	    	$tree->init($array);
	    	$this->select_categorys = $tree->get_tree(0, $str);
	    	$this->display();
    	}
    }
    /**
     * 系统设置-节点设置-删除节点 已经修改
     */
    public function adminNodeDelete(){
    	$DB = D('AdminMenu');
    	$id = I('get.id','','intval');
    	$result = $DB->where('id='.$id)->delete();
    	if(!$result){
    		$this->ajaxReturn(array('statusCode'=>300,'message'=>'删除节点失败，请重试。ErrorNo:0001'));
    	}
    	$this->ajaxReturn(array('statusCode'=>200,'tabid'=>'System_adminNodeLists'));
    }
    /*
     * 取出学校列表
    */
    public function schoolManage(){
    	//取出所在分类
    
    	// 检索条件
    		
    	if(isset($_POST['start_time']) && $_POST['start_time']) {
    		$this->start_time = $_POST['start_time'];
    		$start_time = strtotime($_POST['start_time']);
    		$sql .= " AND `inputtime` > '$start_time'";
    	}
    	if(isset($_POST['end_time']) && $_POST['end_time']) {
    		$this->end_time = $_POST['end_time'];
    		$end_time = strtotime($_POST['end_time']);
    		$sql .= " AND `inputtime` < '$end_time'";
    	}
    	if( ($start_time && $end_time) &&$start_time>$end_time)
    		$this->ajaxReturn(array('statusCode'=>300,'message'=>L('message_error_datetime')));
    
    	if(I('post.keyword')) {
    			
    		$type_array = array('title','description','username');
    		$this->keyword = $keyword = I('post.keyword');
    		$this->searchtype = $searchtype = I('post.searchtype');
    		if($searchtype < 3) {
    			$searchtype = $type_array[$searchtype];
    			$map[$searchtype] = array('like', "%$keyword%");
    		} elseif($searchtype == 3) {
    			$keyword = intval($_POST['keyword']);
    		}
    	}
    	//排序
    	if(I('post.orderField')){
    		$this->orderField = $orderField = I('post.orderField');
    		$this->orderDirection = $orderDirection = I('post.orderDirection') ? I('post.orderDirection') : 'asc';
    		$order = $orderField . ' ' . $orderDirection;
    	}else{
    		$order = 'id desc';
    	}
    
    	// 分页相关
    	$page['pageCurrent'] = max(1 , I('post.pageCurrent'));
    	$page['pageSize']= I('post.pageSize') ? I('post.pageSize') : 30 ;
    
    	$totalCount = D('School')->where($map)->count();
    	$page ['totalCount'] = $totalCount;
    
    	// 取数据
    	$page_list = D('School')->where($map)->page($page['pageCurrent'], $page['pageSize'])->order($order)->select();
    
    	$this->page_list = $page_list;
    	$this->page = $page;
    	$this->display ();
    }
    
    //学校添加
    public function schoolAdd(){
    	if(IS_POST){
    		$info = I('post.info');
    		//判断域名是否唯一
    		$result = D('School')->add($info);
    		if($result){
    			$this->ajaxReturn(array('statusCode'=>200,'message'=>L('message_success_save'), 'closeCurrent'=>true, 'tabid'=>'System_schoolManage'));
    		}else{
    			$this->ajaxReturn(array('statusCode'=>300,'message'=>L('message_error_contact_manager'), 'closeCurrent'=>true, 'tabid'=>'System_schoolManage'));
    		}
    	}else{
    		$this->display('schoolEdit');
    	}
    }
    
    //学校编辑
    public function schoolEdit(){
    	$id = I('get.id');
    	$map['id'] = $id;
    
    	$detail = D('School')->where($map)->find();
    	if(!$detail){
    		$this->ajaxReturn(array('statusCode'=>300,'message'=>L('message_error_paramter')));
    	}
    	if(IS_POST){
    		$info = I('post.info');
    		//保存信息
    		D('School')->where($map)->save($info);
    		$this->ajaxReturn(array('statusCode'=>200,'message'=>L('message_success_save'), 'closeCurrent'=>true, 'tabid'=>'System_schoolManage'));
    	}else{
    			
    		$this->assign('Detail', $detail);
    		$this->display();
    	}
    }
    
    //查看学校名是否重复
    public function ajax_schoolCheckName(){
    	if(IS_POST){
    		$id = I('post.id');
    		$info = I('post.info');
    		$name = $info['name'];
    		
    		$map['name'] = $name;
    		$map['id'] = array('neq', $id);
    		$exist_school = D('School')->where($map)->find();
    		if(!$exist_school){
    			$this->ajaxReturn(array('ok' => ''));
    		}else{
    			$this->ajaxReturn(array('error' => L('message_error_exist')));
    		}
    	}
    }
    //查看学校域名是否重复
    public function ajax_schoolCheckDomain(){
    	if(IS_POST){
    		$id = I('post.id');
    		$info = I('post.info');
    		$domain = $info['domain'];
    		
    		$map['domain'] = $domain;
    		$map['id'] = array('neq', $id);
    		$exist_school = D('School')->where($map)->find();
    		if(!$exist_school){
    			$this->ajaxReturn(array('ok' => ''));
    		}else{
    			$this->ajaxReturn(array('error' =>  L('message_error_exist')));
    		}
    	}
    }
    
    //网站管理
    public function webManage(){
		//检索条件
		//分页相关
		$page['pageCurrent'] = max(1 , I('post.pageCurrent'));
		$page['pageSize']= I('post.pageSize') ? I('post.pageSize') : 30 ;
		
		$totalCount = D('Bbs')->where($map)->count();
		$page['totalCount']=$totalCount ? $totalCount : 0;
		 
		$this->page_list = D('Bbs')->order('id')->where($map)->page($page['pageCurrent'], $page['pageSize'])->select();
		
		$this->page = $page;
		
		$this->display();
	}
}