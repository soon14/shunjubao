<?php
/**
 * 图片处理类
 *
 */
class TMImage {
	/**
	 * 字体所在目录
	 *
	 * @var string
	 */
	private $fonts_dir;

	/**
	 * 建议多指定一些字体，这样的验证码会更多样性，更难穷举猜破
	 * @param string | null $fonts_dir 自定义字体所在目录。如果不指定，则使用系统默认的字体
	 */
	public function __construct($fonts_dir = null) {
		if (!is_null($fonts_dir)) {
			$this->fonts_dir = rtrim($fonts_dir, '/');
		}
	}

	/**
	 * 生成验证码
	 *
	 * @param string $text 验证码上的文字
	 *
	 */
	public function createVerificationCode($text) {
        $layer1  = new Imagick();

        # 计算背景图片的宽度。以6字母使用的背景宽200为标准，计算待渲染 $text 所需要的背景宽度
        $text_len = strlen($text);
        $bgWidth = ceil(200/6 * $text_len);
        $bgHeight = 80;
        $bgColor = '#FFFFFF';

        $layer1->newImage($bgWidth, $bgHeight, new ImagickPixel($bgColor));
        $layer1->setImageOpacity(1);//值0表示完全透明、值1表示完全不透明

        // 获取可供使用的字体集
        $fonts = array();
        if (file_exists($this->fonts_dir) && is_dir($this->fonts_dir)) {
	        $dir = dir($this->fonts_dir);
	        while (true) {
	        	$entry = $dir->read();
	        	if (!$entry) {
	        		break;
	        	}
	            if (preg_match('#\.ttf$#', $entry)) {
	                $fonts[] = $entry;
	            }
	        }
        }

        # 确保文字的颜色与背景颜色不相同，否则就看不到了。
        do {
            $color = '#'.dechex(rand(0, 15)).dechex(rand(0, 15)).dechex(rand(0, 15)).dechex(rand(0, 15)).dechex(rand(0, 15)).dechex(rand(0, 15));
        } while (strtoupper($color) == strtoupper($bgColor));

        # 加入贝赛尔曲线干扰
        $draw = new ImagickDraw();
	    $draw->setStrokeColor(new ImagickPixel($color));
	    $draw->setStrokeWidth(2);
	    $draw->setFillColor(new ImagickPixel('transparent'));
	    // will fail in an obscure manner if the input data is invalid
	    $points = array
	    (
	        array( 'x' => rand(0, floor($bgWidth/6)), 'y' => rand(round($bgHeight*(1/6)), round($bgHeight*(5/6))) ),//曲线左起点的坐标
	        array( 'x' => rand(0, $bgWidth), 'y' => rand(0, $bgHeight) ),
	        array( 'x' => rand(0, $bgWidth), 'y' => rand(0, $bgHeight) ),
	        array( 'x' => rand(round($bgWidth*(5/6)), $bgWidth), 'y' => rand(round($bgHeight*(1/6)), round($bgHeight*(5/6))) )//曲线右终点的坐标
	    );
	    $draw->bezier($points);
	    $layer1->drawImage( $draw );
	    $draw->destroy();

        # 对每个字符做处理
        for ($i = 0, $len = strlen($text); $i < $len; $i++) {
        	if (empty($fonts)) {
        		$font = null;//如果没有指定字体，则设为 null，系统会使用默认字体
        	} else {
                $font = "{$this->fonts_dir}/{$fonts[rand(0, count($fonts) - 1)]}";
        	}

	        // 生成扭曲角度
//	        $swirl = rand(-15, 15);
	        $swirl = rand(0, 1) ? rand(-15, -2) : rand(2, 15);

	        // 生成字体大小
	        $pointsize  = rand(45, 50);

	        $dw = new ImagickDraw();
	        if (isset($font)) {
	        	$dw->setFont($font);
	        }

	        $dw->setFontSize($pointsize);
	        $dw->setFillColor(new ImagickPixel($color));


	        $angle = rand(2, 14);//该参数设置文字的书写角度。值越大，越倾斜！

	        $layer1->annotateImage($dw, 2 + ($i*rand(28, 32)) , rand(40, 60) , $angle, $text{$i});// 之前是rand(45, 60)，调成 rand(36, 68)后，文字在高度上更不规律，更难破解
	        $dw->destroy();

	        $layer1->swirlImage($swirl);
        }

//        $layer1->gaussianBlurImage(2,4);//高斯模糊

//        $layer1->spreadImage(1);//发散效果，也就是使图片看起来模糊

//        $layer1->blurImage(2, 2);//使图片模糊
//            $layer1->sharpenImage(22, 22);

        $img_type = "gif";
        header("Content-Type: image/{$img_type}");
        $layer1->setImageFormat($img_type);
        echo_exit($layer1->getImageBlob());
	}

	/**
	 * @desc 缩放图片
	 * @param string $src 图片源地址(全路径)
	 * @param int $dst_w 目标宽度
	 * @param int $dst_h 目标高度
	 * @param string $dst 目标地址(全路径) 如果指定，则把缩放后的图片直接写入到$dst指定的路径；否则则返回图片的二进制值
	 * @param boolean $isHold 是否锁定原图的高宽比。如果false（不锁定），则严格按照指定的$dst_w和$dst_h生成新的图片
	 * @param string $format 缩放后图片的格式。如果不指定，则使用原图的格式
	 * @return InternalResultTransfer
	 */
	static function resize($src, $dst_w, $dst_h, $dst = null, $isHold = false, $format = null) {
		if (empty($src)) {
			return InternalResultTransfer::fail("请指定原图");
		}
		if (!file_exists($src)) {
			return InternalResultTransfer::fail("{$src} 该图片文件不存在");
		}

		$objImagick = new Imagick();
		$objImagick ->readImage($src);
		if ($isHold) {
			$src_h = $objImagick->getImageHeight();
			$src_w = $objImagick->getImageWidth();
			/// 源图片比目标图片要小
			if ($src_w < $dst_w && $src_h < $dst_h) {
				$hratio = $dst_h / $src_h;
				$wratio = $dst_w / $src_w;
				$ratio = $hratio < $wratio ? $hratio : $wratio;
				$dst_h = $src_h * $ratio;
				$dst_w = $src_w * $ratio;
				$isHold = false;
			}
		}
		$objImagick->resizeImage($dst_w, $dst_h, Imagick::FILTER_UNDEFINED, 1, $isHold);

		if (is_null($format)) {
			$format = $objImagick->getImageFormat();
		}
		$objImagick->setImageFormat($format);

		if (is_null($dst)) {// 返回图像内容
			$data = $objImagick->getImageBlob();
			$ret = InternalResultTransfer::success($data);
		} else {
			$tmpWriteResult = $objImagick->writeImage($dst);
			if ($tmpWriteResult) {
				$ret = InternalResultTransfer::success(array(
					'w' => $objImagick->getImageWidth(),
                	'h' => $objImagick->getImageHeight(),
				));
			} else {
				$ret = InternalResultTransfer::fail("写入目标地址失败");
			}
		}

		$objImagick->destroy();

		return $ret;
	}


	/**
	 * 加给图片加水印(基于imagick加水印)
	 *
	 * @param strimg $groundImage 要加水印地址
	 * @param string $waterImage 水印图片地址
	 * @param int $posX 距离右下角的距离
	 * @param int $posY 距离右下角的距离
	 * @param string $newImage    新图片名称[包含路径]
	 * @param int $minWidth 小于此值不加水印
	 * @param int $minHeight 小于此值不加水印
	 * @param float $alpha 透明度	/// 如果是PNG透明背景水印，此处最后设置为1.0 by alfa@YOKA
	 * @return InternalResultTransfer 对象
	 */
	static function imageWaterMark($groundImage ,$waterImage , $posX , $posY ,$newImage='' , $minWidth=100 ,$minHeight=100 ,$alpha=1.0)
	{
		$bg_h = $bg_w = $water_h = $water_w = 0;
		//获取背景图的高，宽
		if(!file_exists($groundImage) || empty($groundImage)) return InternalResultTransfer::fail("背景图片不存在");
		$bg = new Imagick();
		$bg ->readImage($groundImage);
		$bg_h = $bg->getImageHeight();
		$bg_w = $bg->getImageWidth();

		//获取水印图的高，宽
		if(!file_exists($waterImage) || empty($waterImage)) return InternalResultTransfer::fail("水印图片不存在");
		$water = new Imagick($waterImage);
		$water_h = $water->getImageHeight();
		$water_w = $water->getImageWidth();

		//如果背景图的高宽小于水印图的高宽或指定的高和宽则不加水印
		if($bg_h < $minHeight || $bg_w < $minWidth || $bg_h < $water_h || $bg_w < $water_w )
		{
			return InternalResultTransfer::fail("背景图太小");
		}
		//图片加水印
		$dw = new ImagickDraw();
		 #如果使用png图片，此值一定要传递 1.0
		if($alpha != 1.0)
		{
			$water->setImageOpacity($alpha);//设置透明度
		}
		//$dw -> setGravity($waterPos);//设置对齐方式 9为底部对

		$x = $bg_w -$posX - $water_w;
		$y = $bg_h - $posY - $water_h;
		$dw -> composite($water->getImageCompose(),$x,$y,0,0,$water);//合成当前图像
		$bg -> drawImage($dw);
		$new_image = $groundImage;
		if(!empty($newImage))
		{
			$new_image = $newImage;
		}
		if(!$bg -> writeImage($new_image))
		{
			 return InternalResultTransfer::fail("写入图片失败");
		}
		return InternalResultTransfer::success($new_image);
	}
}
