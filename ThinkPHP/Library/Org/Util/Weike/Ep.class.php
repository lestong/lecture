<?php

namespace Org\Util\Weike;

class Ep implements IWeike{
	public $weikeid = 2;
	function checkProcess(){
		//先检查db_gather_cron表.
		$map['weikeid'] = $this->weikeid;
		$detail_cron = M('GatherCron')->where($map)->find();
		if(!$detail_cron){
			//生成
		}
		
		//计划执行时间小于当前时间, 则开始执行
		if($detail_cron['cronnextrun'] < NOW_TIME){
			//如果是第一次执行(时间在2分钟, 120秒以外), 则更新执行时间为当前时间
			if($detail_cron['cronlastrun'] < NOW_TIME - 60*2){
				M('GatherCron')->where($map)->save(array('cronlastrun' => NOW_TIME));
				//初始化db_gather_list_cron表的状态
				$map_init['weikeid'] = $this->weikeid;
				$map_init['available'] = 1;
				M('GatherListCron')->where($map_init)->save(array('status' =>  1));
			}
			return true;
		}else 
			return false;
		
	}
	
	function updateList(){
		//取出任务的起始时间
		$detail_cron = M('GatherCron')->where('weikeid = '.$this->weikeid)->find();
		//取出db_gather_list_cron, 还未启动
		$map['weikeid'] = $this->weikeid;
		$map['cronnextrun'] = array('lt', $detail_cron['cronlastrun']);
		$map['status'] = 1;
		$type_cron = M('GatherListCron')->where($map)->find();
		if($type_cron){
			//获取该任务下的N条记录, 缺少个时间戳的判断, 还未完成
			$list_url = $this->createListUrl($type_cron['type'], $page, $pagesize, $create_time);
			$task_list_data = $this->GatherList($list_url);
			
			//暂时更新10条就结束
			if($task_list_data['state'] == 1 && $task_list_data['data']){
				//添加到gather表
				foreach ($task_list_data['data'] as $gather_data){
					D('Gather')->addGather($gather_data, $this->weikeid, $type_cron['type']);
				}
			}
			
			//更新此次的状态
			M('GatherListCron')->where('id='.$type_cron['id'])->save(array('status' => 0));
			
			//判断是否还有需要更新的, 如果没有, 则更新下一次任务执行时间
			$type_next_cron = M('GatherListCron')->where($map)->find();
			if(!$type_next_cron){
				M('GatherCron')->where('weikeid='.$this->weikeid)->save(array('cronnextrun' => NOW_TIME+60*30));
			}
			
			return $type_cron['type'];
			
		}else{
			//没有任务, 更新下一次任务执行时间, 半小时一次
			M('GatherCron')->where('weikeid='.$this->weikeid)->save(array('cronnextrun' => NOW_TIME+60*30));
		}
		//只获取一次
		return true;
	}
	
	public function createListUrl($type, $page, $pagesize, $create_time){
		//组合地址
		//$url = 'http://www.epweike.com/api/uulian.php?do=latest_task&type=*&model=*&status=*&ordertype=*&pageindex=*&pagesize=*';
		$url = 'http://www.epweike.com/api/uulian.php?do=latest_task&status=2';
		
		if($type)
			$url .= '&type='.$type;
		return $url;
	}
	
	public function GatherList($url, $timeout = 3){
		//获取url内容
		$opts=array(
				'http'=>array(
						'timeout'=>$timeout,
						'method'=>"GET",
						'header'=>"$url"."Accept-language: zh-cn\r\n"."User-Agent: mozilla/5.0 (windows; u; windows nt 5.1; zh-cn; rv:1.9.2.3) gecko/20100401 firefox/3.6.3"."Accept: *//*"
				)
		
		);
		$context=stream_context_create($opts);
		return json_decode(file_get_contents($url,0,$context), true);
	}
}

?>