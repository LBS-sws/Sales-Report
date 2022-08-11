<?php
class ReportEmail {
	public static function getData($job_id, $job_type) {
		$rtn = array('message'=>'', 'data'=>array());
		
		$key = Yii::app()->params['xcxKey'];
		$root = Yii::app()->params['xcxRootURL'];
		$url = $root.'/sync/readreportmail.php';
		$data = array(
			"key"=>$key,
			"job_id"=>$job_id,
			"job_type"=>$job_type
		);
		$data_string = json_encode($data);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type:application/json',
			'Content-Length:'.strlen($data_string),
 		));
		$out = curl_exec($ch);
		if ($out===false) {
			$rtn['message'] = curl_error($ch);
		} else {
			$json = json_decode($out);
			$rtn['data'] = json_decode($out, true);
			$rtn['message'] = self::getJsonError(json_last_error());
		}
		
		return $rtn;
	}
	
	public static function addData($job_id, $job_type) {
		$rtn = array('message'=>'', 'code'=>0);
		
		$key = Yii::app()->params['xcxKey'];
		$root = Yii::app()->params['xcxRootURL'];
		$url = $root.'/sync/addreportmail.php';
		$data = array(
			"key"=>$key,
			"job_id"=>$job_id,
			"job_type"=>$job_type
		);
		$data_string = json_encode($data);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type:application/json',
			'Content-Length:'.strlen($data_string),
 		));
		$out = curl_exec($ch);
		if ($out===false) {
			$rtn['code'] = -1;
			$rtn['message'] = curl_error($ch);
		} else {
			$data = json_decode($out, true);
			$rtn['message'] = self::getJsonError(json_last_error());
			if ($rtn['message']=='Success') {
				$rtn['code']=$data['code'];
				$rtn['message']=$data['message'];
			} else {
				$rtn['code']=-1;
			}
		}
		
		return $rtn;
	}
	
	public static function getJsonError($error) {
		switch ($error) {
			case JSON_ERROR_NONE:
				return 'Success';
			case JSON_ERROR_DEPTH:
				return ' - Maximum stack depth exceeded';
			case JSON_ERROR_STATE_MISMATCH:
				return ' - Underflow or the modes mismatch';
			case JSON_ERROR_CTRL_CHAR:
				return ' - Unexpected control character found';
			case JSON_ERROR_SYNTAX:
				return ' - Syntax error, malformed JSON';
			case JSON_ERROR_UTF8:
				return ' - Malformed UTF-8 characters, possibly incorrectly encoded';
			default:
				return' - Unknown error ('.$error.')';
		}
	}
}
?>