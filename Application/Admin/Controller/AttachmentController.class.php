<?php

/**
 * 附件模块
 * @author Lain
 *
 */
namespace Admin\Controller;
use Admin\Controller\AdminController;

class AttachmentController extends AdminController{
	public function _initialize(){
		$action = array(
				'permission'=>array('base64_upload', 'uploadJson', 'fileManagerJson'),
				//'allow'=>array('index')
		);
		B('Admin\\Behaviors\\Authenticate', '', $action);
	}
	
//上传
	public function uploadJson(){
		$dir = I('get.dir');
		
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     3145728 ;// 设置附件上传大小
		
		// 设置附件上传类型
		switch ($dir){
			case 'image':
				$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');
				break;
			case 'file':
				$upload->exts      =     array('pptx','ppt','docx','doc','txt','dotx','xlsx','xls','jpg','png');
				break;
			default:
				$this->ajaxReturn(array('error' => 1, 'message' => '参数错误'));
		}
		$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
		$upload->savePath  =     $dir.'/'; // 设置附件上传（子）目录
		// 上传文件
		$info   =   $upload->upload();
		$img_url = $upload->rootPath.$info['imgFile']['savepath'].$info['imgFile']['savename'];
		if(!$info) {
			// 上传错误提示错误信息
			$this->ajaxReturn(array('error' => 1, 'message' => $upload->getError()));
		}else{
			// 上传成功
			$downloadedfile = array('viewhost'=>'/Uploads/', 'filename'=>$info['imgFile']['name'], 'filepath'=>$img_url, 'filesize'=>$info['imgFile']['size'], 'fileext'=>$info['imgFile']['ext'], 'authcode' => $info['imgFile']['md5'], 'savepath'=>$info['imgFile']['savepath'], 'savename'=>$info['imgFile']['savename']);
			D('Attachment')->saveData($downloadedfile, $dir);
			$this->ajaxReturn(json_encode(array('error' => 0, 'url' => $img_url)), 'EVAL');
		}
	}
	
	//新版文件管理
	public function fileManagerJson(){
		$root_path = '';
		$module = I('get.dir');
		if (!in_array($module, array('image', 'flash', 'media', 'file'))) {
			echo "Invalid Directory name.";
			exit;
		}
		$path = I('get.path');

		$map['userid'] = session('userid');
		$map['module'] = $module;
		if(!$path){
			$current_dir_path = '';
			//返回目录(image)
			//取出viewhost
			/* $arr_paths = D('Attachment')->where($map)->group('viewhost')->field('viewhost')->select();
			foreach ($arr_paths as $k=>$v){
				$file_detail = array();
				//文件夹的名字, 去掉当前目录
				$file_detail['filename'] = $v['viewhost'];
					
				$file_detail['has_file'] = true;
				$file_detail['is_dir'] = true;
				$file_detail['is_photo'] = false;
					
				$file_list[$k] = $file_detail;
			} */
			//取出savepath
			$arr_paths = D('Attachment')->where($map)->group('savepath')->field('savepath')->select();
			foreach ($arr_paths as $k=>$v){
				$file_detail = array();
				//文件夹的名字, 去掉当前目录
				$file_detail['filename'] = str_replace(array('image/', 'flash/', 'media/', 'file/', '/'), '', $v['savepath']);
				
				$file_detail['has_file'] = true;
				$file_detail['is_dir'] = true;
				$file_detail['is_photo'] = false;
				
				$file_list[$k] = $file_detail;
			}
		}else{
			$current_dir_path = $path;
			//返回当前用户可以操作的图片
			//映射
			$field = 'savename, savepath, uploadtime, filepath, filesize, fileext, isimage';
			$map['savepath'] = $module.'/'.$path;
			if(I('get.order')){
				$order_field = I('get.order');
				switch ($order_field){
					case 'NAME':
						$order = 'savename DESC';
						break;
					case 'TYPE':
						$order = 'fileext DESC';
						break;
					case 'SIZE':
						$order = 'filesize DESC';
						break;
					default:
						$order = 'uploadtime DESC';
				}
			}
			$arr_attachments = D('Attachment')->where($map)->order($order)->field($field)->select();
			foreach ($arr_attachments as $k => $v){
				$file_detail = array();
				$file_detail['datetime'] = date('Y-m-d H:i:s', $v['uploadtime']);
				$file_detail['filename'] = $v['savename'];
				
				$file_detail['filesize'] = $v['filesize'];
				$file_detail['filetype'] = $v['fileext'];
				$file_detail['has_file'] = false;
				$file_detail['is_dir'] = false;
				$file_detail['is_photo'] = $v['isimage'] ? true : false;
				
				$file_list[$k] = $file_detail;
			}
		}
		$result = array();
		$current_url = '/Uploads/'.$module.'/'.$path;
		//相对于根目录的上一级目录
		$result['moveup_dir_path'] = '';
		//相对于根目录的当前目录
		$result['current_dir_path'] = $current_dir_path;
		//当前目录的URL
		$result['current_url'] = $current_url;
		//文件数
		$result['total_count'] = count($file_list);
		//文件列表数组
		$result['file_list'] = $file_list;
		$this->ajaxReturn($result);
	}
	
	//阿里云上传
	public function ali_uploadJson(){
		$dir = I('get.dir');
		try{
			/* request aliyun oss by jerry.z 2015-01-23 */
			define('OSS_ACCESS_ID', C('OSS_ACCESS_ID'));				//access_id
			define('OSS_ACCESS_KEY', C('OSS_ACCESS_KEY'));				//access_key
			define('ALI_LOG', C('ALI_LOG'));							//is_write_log
			define('ALI_LOG_PAHT', C('ALI_LOG_PATH'));					//log_path
			define('ALI_DISPLAY_LOG', C('ALI_DISPLAY_LOG'));			//is_display_log
			define('ALI_LANG', C('ALI_LANG'));							//language
			define('ALI_BUCKET',C('ALI_BUCKET'));						//oss_bucket: uu-hy
		
			//init
			vendor('Aliyun.Requestcore');
			vendor('Aliyun.Mimetypes');
			vendor('Aliyun.zh');
			vendor('Aliyun.SDK');
			$oss_sdk_service = new \ALIOSS();
			$oss_sdk_service->set_debug_mode(FALSE);
		
			//create folder
			$date_dir = date('Ymd');
			$bucket = ALI_BUCKET;
			$dir = $dir . '/'.$date_dir;
			$response  = $oss_sdk_service->create_object_dir($bucket,$dir);
			
			if($response->status!=200){
				$this->ajaxReturn(array('error' => 1, 'message' => '图片上传失败'));
			}
		
			foreach($_FILES as $key=>$v){
				$src_img = @file_get_contents($v['tmp_name']);
				$object = $dir . "/".md5( time().rand(100000,999999) ).'.jpg';//create_upload_path
				$upload_file_options = array('content'=>$src_img,'length'=>strlen($src_img));
				$oss_sdk_service->upload_file_by_content($bucket,$object,$upload_file_options);//upload pic to oss
		
				//$create_data[] = array("$key"=>$object);
				$this->ajaxReturn(array('error' => 0, 'url' => C('ALI_VIEW_HOST').$object));
			}
			//var_dump($create_data);exit;
			//$this->outputJSON(1,$create_data,1,null);
		} catch (\Exception $ex) {
			$this->ajaxReturn(array('error' => 1, 'message' => '图片上传失败'));
		}
	}
	public function base64_upload(){
		$uploader = new \Think\Upload\Driver\Local();
		$base64_image = $_POST['editor'];
		//仿禅道
		$dataLength = strlen($base64_image);
		if(ini_get('pcre.backtrack_limit') < $dataLength) ini_set('pcre.backtrack_limit', $dataLength);
		preg_match_all('/<img src="(data:image\/(\S+);base64,(\S+))".*\/>/U', $base64_image, $out);
		
		$rootPath = '/Uploads/';
		
		$save_path = 'image/'.date('Y-m-d').'/';

		foreach($out[3] as $key => $base64Image)
		{
		    //匹配成功
		    $extension = strtolower($out[2][$key]);
		    $image_name = uniqid().'.'. $extension;
		    $image_file = '.'.$rootPath.$save_path.$image_name;
		    
		    $imageData = base64_decode($base64Image);
		
		    if ($uploader->checkSavePath('.'.$rootPath.$save_path) && file_put_contents($image_file, $imageData)){
				// 上传成功
				$downloadedfile = array('viewhost'=>'/Uploads/', 'filename'=>$image_name, 'filepath'=>$image_file, 'filesize'=> strlen($imageData), 'fileext'=> $extension, 'authcode' => '', 'savepath'=>$save_path, 'savename'=>$image_name);
				D('Attachment')->saveData($downloadedfile);
			}else{
			    die();
			}
		
		    $base64_image = str_replace($out[1][$key], $rootPath.$save_path . $image_name, $base64_image);
		}
		
		$data = array('flag' => true, 'data' => $base64_image);
		$this->ajaxReturn($data);
		
	}
}