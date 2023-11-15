<?php
class Utils {
    /**
     * 定义访问地址
     * */

    public $url = '';
    public $sign_url = '';

    public function __construct(){
        if(Yii::app()->params['envSuffix']){//测试服
            $this->url = 'https://operation.lbsapps.cn/index.php/api/index/getSignUrl?';
            $this->sign_url = 'https://operation.lbsapps.cn';
        }else{ //正式服
            $this->url = 'https://xcx.lbsapps.cn/index.php/api/index/getSignUrl?';
            $this->sign_url = 'https://xcx.lbsapps.cn';
        }
    }

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

    //从点评表中读取点评分数
    public function getScore($order_id, $order_type, $customer_grade=null){
        $score_sql = 'select score from lbs_evaluates where order_id='.$order_id.' and order_type='.$order_type;
        $score = Yii::app()->db->createCommand($score_sql)->queryRow();

        if($score){
            return $score['score'];
        }else{
            return $customer_grade;
        }
    }
}
?>