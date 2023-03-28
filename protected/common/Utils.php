<?php
class Utils {
    /**
     * 定义访问地址
     * */

    //正式版
	// public $url = 'https://xcx.lbsapps.cn/index.php/api/index/getSignUrl?';

	// public $sign_url = 'https://xcx.lbsapps.cn';
    
    //测试版
    public $url = 'https://operation.lbsapps.cn/index.php/api/index/getSignUrl?';

	public $sign_url = 'https://operation.lbsapps.cn';


    /**
    $url 访问地址
    $postfields 请求参数（json字符串）
    $headers 请求头
     */
    public  function httpCurl($url, $postfields = '', $headers =['Content-Type:application/json;charset=UTF-8'])
    {

        $ci = curl_init();
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 50);
        curl_setopt($ci, CURLOPT_TIMEOUT, 600);
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ci, CURLOPT_URL, $url);
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'GET' );
        curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
        $response = curl_exec($ci);
        curl_close($ci);
        return $response;
    }

    public  function pic_rotating($degrees, $url)
    {
        $srcImg = imagecreatefrompng($url);     //获取图片资源
        $rotate = imagerotate($srcImg, $degrees, 0);        //原图旋转

        //获取旋转后的宽高
        $srcWidth = imagesx($rotate);
        $srcHeight = imagesy($rotate);

        //创建新图
        $newImg = imagecreatetruecolor($srcWidth, $srcHeight);

        //分配颜色 + alpha，将颜色填充到新图上
        $alpha = imagecolorallocatealpha($newImg, 0, 0, 0, 127);
        imagefill($newImg, 0, 0, $alpha);

        //将源图拷贝到新图上，并设置在保存 PNG 图像时保存完整的 alpha 通道信息
        imagecopyresampled($newImg, $rotate, 0, 0, 0, 0, $srcWidth, $srcHeight, $srcWidth, $srcHeight);
        imagesavealpha($newImg, true);

        //生成新图
        imagepng($newImg, $url);
    }
}
?>