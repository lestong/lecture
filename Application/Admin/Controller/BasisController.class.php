<?php
namespace Admin\Controller;
use Admin\Controller\AdminController;
class BasisController extends AdminController {
    public function index(){
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
        
        $totalCount = D('Slides')->where($map)->count();
        $page ['totalCount'] = $totalCount;
        
        // 取数据
        $page_list = D('Slides')->where($map)->page($page['pageCurrent'], $page['pageSize'])->order($order)->select();
        $this->page_list = $page_list;
        $this->page = $page;
        $this->display ();
    }
    public function add(){
        if(IS_POST){
            $info = I('post.info');
            //后台发布不用审核
            $info['status'] 	= 99;
            $info['create_time'] = $info['updatetime'] = NOW_TIME;
            $info['uid'] 		= session('userid');
            $info['groupid']	= 1;	//教师分组
            	
            //验证规则
            $DB = D('Article');
            if(!$DB->create($info)){
                //如果不通过 ，输出错误报告
                $this->ajaxReturn(array('statusCode'=>300,'message'=>$DB->getError()));
            }else{
                $result = $DB->add_content($info);
            }
            if($result){
                $this->ajaxReturn(array('statusCode'=>200,'closeCurrent'=>true,'tabid'=>'Article_index','message'=>L('message_success_save')));
            }else{
                $this->ajaxReturn(array('statusCode'=>300,'message'=>L('message_error_contact_manager')));
            }
        }else{
            $map_sort['pid'] = 0;
            $this->sort_list = D('Slides')->where($map_sort)->index('id')->order('listorder')->select();
            $this->display('edit');
        }
    }
    public function uploadImg(){
        $this->display();
//         $this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }
}