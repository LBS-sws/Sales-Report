<?php
class Utils {
    /**
     * 定义访问地址
     * */
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
}
?>