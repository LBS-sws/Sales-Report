<?php
class RiskpestData {
	public function getDbFields() {
		return array(
            'target'=>Yii::t('risk','Target'),
		);
	}
	
	public function getDefaultMapping() {
	//	Db Field Name => Excel Column No.
		return array(
				'target'=>0,
			);
	}
	
	public function validateData($data) {
		$name = $this->getDbFields();
		$connection = Yii::app()->db;
		
		// Name
		$rtn = !empty($data['target']) 
				? (mb_strlen(trim($data['target']), 'UTF-8')>50 ? $name['target'].' '.Yii::t('import','is too long').' /' : '') 
				: $name['target'].' '.Yii::t('import','cannot be blank').' /';

		return empty($rtn) ? '' : Yii::t('import','ERROR').'- /'.Yii::t('import','Row No.').': '.$data['excel_row'].' /'.$rtn;
	}
	
	
	public function importData(&$connection, $data) {
		$target = trim($data['target']);
		$city = Yii::app()->user->city();

		$sql = "select id from lbs_service_risk_target_lists where target=:target and city=:city";
		$command=$connection->createCommand($sql);
		$command->bindParam(':target',$target,PDO::PARAM_STR);
		$command->bindParam(':city',$city,PDO::PARAM_STR);
		$row = $command->queryRow();
		$exist = ($row!==false);
		$id = (!$exist) ? 0 : $row['id'];
		
		if ($exist)
			return Yii::t('import','SKIP').'- /'.Yii::t('import','Row No.').': '.$data['excel_row']
				.' /'.Yii::t('risk','Target').': '.$target
				;
		
		
		$sql = "insert into lbs_service_risk_target_lists 
					(target, city, creat_time)
				values
					(:target, :city, now())
			";
		$command=$connection->createCommand($sql);
		if (strpos($sql,':target')!==false) 
			$command->bindParam(':target',$target,PDO::PARAM_STR);
		if (strpos($sql,':city')!==false) 
			$command->bindParam(':city',$city,PDO::PARAM_STR);
		$command->execute();
		
		return Yii::t('import','INSERT').'- /'.Yii::t('import','Row No.').': '.$data['excel_row']
			.' /'.Yii::t('risk','Target').': '.$target
			;
	}
}
?>