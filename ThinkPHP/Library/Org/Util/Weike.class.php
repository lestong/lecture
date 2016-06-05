<?php

namespace Org\Util;

class Weike {
	/**
	 * 威客实例
	 * @var Object
	 */
	private $weiker;
	private $type_list;
	
	public function __construct($weiker, $weike_config = null){
		//设置威客
		$this->setWeike($weiker, $weike_config);
	}
	
	//设置威客实例
	private function setWeike($weiker = null, $config = null){
		$class = strpos($weiker,'\\')? $weiker : 'Org\\Util\\Weike\\'.ucfirst(strtolower($weiker));
		$this->weiker = new $class($config);
		if(!$this->weiker){
			E("不存在此威客：{$name}");
		}
		//获取威客列表
	}
	
	//判断当前威客是否需要更新列表, 如果需要更新, 则返回真, 否则为假
	public function checkProcess($type = null, $now_page = 1){
		//取出该威客的类型列表
		return $this->weiker->checkProcess();
		//return true;
		//检查上一次各个类型更新的进度
		
		//如果当前类型还未更新完成, 则从当前页继续更新
		
		//
		
	}
	
	//更新任务列表
	public function updateList($type = null, $now_page = 1){
		return $this->weiker->updateList();
	}
}