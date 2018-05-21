<?php
/**
 * 图片处理类
 */
class ZYImgs {
	
	//用户头像上传目录
	CONST IMGPATH_USER_HEAD = 'user_head_img';
	//留言墙上传目录
	CONST IMGPATH_USER_MESSAGE = 'user_message';
	
	/**
	 * 上传图片
	 * 机制：移动临时文件到目的地，如果目的地文件夹不存在则自动创建一个；
	 * 原理：利用$_FILES变量上传图片
	 * @param string $filename 新的文件名
	 * @param string $path 上传路径文件夹;默认root/upload/user_head_img
	 * @param string $upload_dir 上传文件目录
	 * @return InternalResultTransfer 失败返回出错原因，成功返回图片地址
	 */
	static public function upload($filename, $path = 'user_head_img' , $upload_dir = 'upload') {
		
		$file_path = ROOT_PATH . '/' . $upload_dir . '/' . $path;
		
		if (!is_dir($file_path)) {
			if(!mkdir($file_path,'0766')) return InternalResultTransfer::fail('自动创建目录失败');
		}
		
		$fileField = self::getFileKey();
		
		$type = $_FILES[$fileField]['type'];//type=>image/png
		
		if (substr($type, 0, 5) == 'image') {
			//补全图片文件后缀
			$filename .= '.' .substr($type, 6);
		}
		
		$upload_file_path = $file_path .'/' .$filename;
		
		if(!is_uploaded_file($_FILES[$fileField]['tmp_name'])) {
			return InternalResultTransfer::fail('不是上传文件！');
		}
		
		if(!move_uploaded_file($_FILES[$fileField]['tmp_name'], $upload_file_path)) {
			return InternalResultTransfer::fail('移动文件失败！');
		}
		
		
		$upload_file_url = ROOT_DOMAIN . '/' . $upload_dir . '/' . $path . '/'. $filename;
		
		
		return InternalResultTransfer::success($upload_file_url);
	}
	
	/**
	 * 判断单张图片是否满足上传条件
	 * 原理：利用$_FILES变量上传图片
	 * @param int $max_size 大小限制，单位kb
	 * @param array $type 类型限制，所有可以用的类型:jpeg=>jpg
	 * @param array $size  array('width'=>100,'height'=>200) 限制的宽高,0为不限制
	 * @return InternalResultTransfer 失败返回出错原因|成功返回$_FILES
	 */
	static public function isImgFile($max_size = '20', $type = array('jpeg','png','gif') ,$size = array('width'=>0,'height'=>0)) {
		
		$org_size = $max_size;
		$max_size = $max_size*1024;
		
		$img_error = '';
		
		$fileField = self::getFileKey();
		
		do{
			if($_FILES[$fileField]['error'] > 0){
				switch($_FILES[$fileField]['error']) {
					case 1: $img_error =  '文件大小超过服务器限制';
						break;
					case 2: $img_error =  '文件太大！';
						break;
					case 3: $img_error =  '文件只加载了一部分！';
						break;
					case 4: $img_error =  '文件加载失败！';
						break;
					default: $img_error = '未知错误';
						break;
				}
				break;
			}
			 
			if($_FILES[$fileField]['size'] > $max_size){
				$img_error =  '文件大于'.$org_size.'kb！';
				break;
			}
			
			$is_type_correct = false;
			$ext = '';//文件后缀
			foreach ($type as $value) {
				if ($value == 'jpg') {
					$value = 'jpeg';
				}
				if($_FILES[$fileField]['type'] == 'image/'.$value){
					$is_type_correct = true;
					$ext = $value;
					break;
				}
			}
			
			if (!$is_type_correct) {
				$img_error =  '文件不是JPG、GIF或者PNG图片！';
				break;
			}
			
			//防止图片伪装
			$ImageInfo = getimagesize($_FILES[$fileField]['tmp_name']);
			if ($ImageInfo == false) {
				$img_error =  '图片错误！';
				break;
			}
			//宽高截取
			if ($size['width'] && $size['height']) {
				if ($ImageInfo[0] > $size['width'] || $ImageInfo[1] > $size['height']) {
					$img_error = '图片尺寸不合要求错误！';
					break;
				};
			}
		}while (false);
		
		if ($img_error) {
			return InternalResultTransfer::fail($img_error);
		}
		return InternalResultTransfer::success($_FILES);
	}
	
	private function getFileKey() {
		if (!$_FILES) {
			return 'fileField';
		}
		return array_pop(array_keys($_FILES));
	}
}