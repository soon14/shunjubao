<?php

//文件上传类

class upfile{

	public $uptypes;//上传文件类型

	public $max_file_size=5000000; //上传文件大小限制, 单位BYTE 

    public $destination_folder="./upload/"; //上传文件路径 

    public $watermark=0; //是否附加水印(1为加水印,其他为不加水印); 

    public $watertype=1; //水印类型(1为文字,2为图片) 

    public $waterposition=2; //水印位置(1为左下角,2为右下角,3为左上角,4为右上角,5为居中); 

    public $waterstring="hgwto.com"; //水印字符串 

    public $waterimg="xplore.gif"; //水印图片 

    public $imgpreview=1; //是否生成预览图(1为生成,其他为不生成); 

    public $imgpreviewsize=0.5; //缩略图比例

    public $file;//上传文件

    function __construct($file,$uptypes){

    	$this->file=$file;

    	$this->uptypes=$uptypes;

    }

    function Juge_file(){ //判断文件是否合法

    	$msg="";

    	if (!is_uploaded_file($this->file["tmp_name"])) //是否存在文件 

		{ 

		$msg="文件不存在"; 

		}

		if($this->max_file_size <$this->file["size"]) //检查文件大小 

		{ 

        $msg="文件太大";

		} 

		if(!in_array($this->file["type"], $this->uptypes)) //检查文件类型 

		{ 

		$msg="不支持此文件类型上传！";

		}

		return $msg; 

    }

    function up_file($i){ //上传文件方法

    	$msg=self::Juge_file();

    	if($msg==""){

        if(!file_exists($this->destination_folder)) 

        mkdir($this->destination_folder); //创建文件保存目录

        $filename=$this->file["tmp_name"]; 

		$pinfo=pathinfo($this->file["name"]); 

		$ftype=$pinfo[extension]; 

		$destination =$this->destination_folder.time().$i.".".$ftype; //命名上传的文件名

		if(!move_uploaded_file ($filename, $destination)) 

		{ 

			$msg="上传文件失败";	

		}

		else {

			$msg=$destination;

		}

      }

      return $msg;

    } 

    function add_water(){

    		$destination=$this->up_file();

    		$water_position=$this->waterposition;

    		$water_type=$this->watertype;

    		$water_string=$this->waterstring;

    		$water_imge=$this->waterimg;

    		$image_size=getimagesize($destination);

    		$iinfo=getimagesize($destination,$iinfo); 

			$nimage=imagecreatetruecolor($image_size[0],$image_size[1]); 

			$white=imagecolorallocate($nimage,255,255,255); 

			$black=imagecolorallocate($nimage,0,0,0); 

			$red=imagecolorallocate($nimage,255,0,0); 

			imagefill($nimage,0,0,$white); 

			switch ($iinfo[2]) 

			{ 

			case 1: 

			$simage =imagecreatefromgif($destination); 

			break; 

			case 2: 

			$simage =imagecreatefromjpeg($destination); 

			break; 

			case 3: 

			$simage =imagecreatefrompng($destination); 

			break; 

			case 6: 

			$simage =imagecreatefromwbmp($destination); 

			break; 

			default: 

			exit; 

    	}

    	imagecopy($nimage,$simage,0,0,0,0,$image_size[0],$image_size[1]); 

		imagefilledrectangle($nimage,1,$image_size[1]-15,80,$image_size[1],$white); 

		

		switch($watertype) 

		{ 

		case 1: //加水印字符串 

		imagestring($nimage,2,3,$image_size[1]-15,$waterstring,$black); 

		break; 

		case 2: //加水印图片 

		$simage1 =imagecreatefromgif("hgwto.com"); 

		imagecopy($nimage,$simage1,0,0,0,0,85,15); 

		imagedestroy($simage1); 

		break; 

		} 

		

		switch ($iinfo[2]) 

		{ 

		case 1: 

		//imagegif($nimage, $destination); 

		imagejpeg($nimage, $destination); 

		break; 

		case 2: 

		imagejpeg($nimage, $destination); 

		break; 

		case 3: 

		imagepng($nimage, $destination); 

		break; 

		case 6: 

		imagewbmp($nimage, $destination); 

		//imagejpeg($nimage, $destination); 

		break; 

		} 

		//覆盖原上传文件 

		imagedestroy($nimage); 

		imagedestroy($simage); 

    }

}

?>