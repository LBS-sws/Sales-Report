<?php
// Common Functions

class General extends CGeneral {

/* SAMPLE CODE
// ===========
	public static function getAcctTypeList()
	{
		$list = array();
		$sql = "select id, acct_type_desc from acc_account_type order by acct_type_desc";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		if (count($rows) > 0) {
			foreach ($rows as $row) {
				$list[$row['id']] = $row['acct_type_desc'];
			}
		}
		return $list;
	}
*/
	public function getUpdateDate() {
		$file = Yii::app()->basePath.'/config/lud.php';
		if (file_exists($file)) {
			$lud = require($file);
			return $lud;
		} else {
			return '2016/01/01';
		}
	}

    /*
     * 獲取必須測驗的測驗單id
     */
    public static function getQuizIdForMust(){
        $suffix = Yii::app()->params['envSuffix'];
        $quiz_id = Yii::app()->db->createCommand()
            ->select("id")->from("quiz$suffix.exa_quiz")
            ->order("join_must desc,id asc")->queryScalar();
        return $quiz_id?$quiz_id:0;
    }

    /*
     * 判斷系統位置
     * @return int  0：大陸。 1：台灣。2：新加坡。 3：吉隆坡
     */
    public static function SystemIsCN(){
        $suffix = Yii::app()->params['envSuffix'];
        $value = Yii::app()->db->createCommand()->select("set_value")
            ->from("hr$suffix.hr_setting")->where("set_name='systemId'")->queryScalar();
        return $value?$value:0;
    }

    public static function isWebImageValid($webpath) {
        $headers = get_headers($webpath);
        $statusCode = substr($headers[0], 9, 3); // 获取状态码
        if ($statusCode == "200") {
            $contentType = "";
            foreach ($headers as $header) {
                if (strpos($header, "Content-Type:") === 0) {
                    $contentType = trim(substr($header, 14));
                    break;
                }
            }
            // 检查资源类型
            if (strpos($contentType, "image/") === 0) {
                // 图片资源
                return true;
            } else {
                // 其他类型的资源
                return false;
            }
        } else {
            // 请求失败或资源不存在
            return false;
        }
    }
}

?>
