<?php
class MaterialData {
	public function getDbFields() {
		return array(
            'name'=>Yii::t('material','Name'),
            'classify_id'=>Yii::t('material','Classify'),
            'classify'=>Yii::t('material','Classify'),
            'registration_no'=>Yii::t('material','Registration_no'),
            'validity'=>Yii::t('material','Validity'),
            'active_ingredient'=>Yii::t('material','Active_ingredient'),
            'ratio'=>Yii::t('material','Ratio'),
            'brief'=>Yii::t('material','Brief'),
            'unit'=>Yii::t('material','Unit'),
            'sort'=>Yii::t('material','Sort'),
            'status'=>Yii::t('material','Status'),
		);
	}
	
	public function getDefaultMapping() {
	//	Db Field Name => Excel Column No.
		return array(
				'name'=>0,
				'classify'=>1,
				'registration_no'=>2,
				'validity'=>3,
				'active_ingredient'=>4,
				'ratio'=>5,
				'brief'=>9,
				'unit'=>6,
				'sort'=>8,
				'status'=>7,
			);
	}
	
	public function validateData($data) {
		$name = $this->getDbFields();
		$connection = Yii::app()->db;
		
		// Validity
		$dt = is_numeric($data['validity']) ? $this->convertExcelDate($data['validity']) : $data['validity'];
		$rtn = empty($dt)
				? $name['validity'].' '.Yii::t('import','cannot be blank').' /'
				: ($this->validateDate($dt,'Y-m-d') ? '' : $name['validity'].' '.Yii::t('import','is not valid').' /');
		// Name
		$rtn .= !empty($data['name']) 
				? (mb_strlen(trim($data['name']), 'UTF-8')>20 ? $name['name'].' '.Yii::t('import','is too long').' /' : '') 
				: $name['name'].' '.Yii::t('import','cannot be blank').' /';
		// Classify		
		$rtn .= empty($data['classify'])
				? $name['validity'].' '.Yii::t('import','cannot be blank').' /'
				: ($this->getClassifyId($connection, trim($data['classify']), $data['city'])!=0 ? '' : $name['classify'].' '.Yii::t('import','cannot be found in system').' /');
		// Registration No
		$rtn .= !empty($data['registration_no']) && mb_strlen($data['registration_no'], 'UTF-8')>100 ? $name['registration_no'].' '.Yii::t('import','is too long').' /' : '';
		// Ingredient
		$rtn .= !empty($data['active_ingredient']) && mb_strlen($data['active_ingredient'], 'UTF-8')>20 ? $name['active_ingredient'].' '.Yii::t('import','is too long').' /' : '';
		// Ratio
		$rtn .= !empty($data['ratio']) && mb_strlen(trim($data['ratio']), 'UTF-8')>20 ? $name['ratio'].' '.Yii::t('import','is too long').' /' : '';
		// Unit
		$rtn .= !empty($data['unit']) 
				? (strlen($data['unit'])>11 ? $name['unit'].' '.Yii::t('import','is too long').' /' : '') 
				: $name['unit'].' '.Yii::t('import','cannot be blank').' /';
		// Status
		$rtn .= empty($data['status']) || (trim($data['status'])!='启用' && trim($data['status'])!='未启用') ? $name['status'].' '.Yii::t('import','is not valid').' /' : '';
		// Sort
		$rtn .= !empty($data['sort']) && is_numeric($data['sort']) && $data['sort']<=100 && $data['sort']>=1 ? '' : $name['sort'].' '.Yii::t('import','is not valid').' /';
		// Brief
		$rtn .= !empty($data['brief']) && mb_strlen($data['brief'], 'UTF-8')>255 ? $name['brief'].' '.Yii::t('import','is too long').' /' : '';

		return empty($rtn) ? '' : Yii::t('import','ERROR').'- /'.Yii::t('import','Row No.').': '.$data['excel_row'].' /'.$rtn;
	}
	
	
	public function importData(&$connection, $data) {
		$name = trim($data['name']);
		$validity = is_numeric($data['validity']) ? $this->convertExcelDate($data['validity']) : $data['validity'];
		$registration_no= $data['registration_no'];
		$classify_id = $this->getClassifyId($connection, trim($data['classify']), $data['city']);
		$active_ingredient = $data['active_ingredient'];
		$ratio = $data['ratio'];
		$unit = $data['unit'];
		$sort = empty($data['sort']) ? null : $data['sort'];
		$status = trim($data['status'])=='未启用' ? 0 : 1;
		$brief = $data['brief'];

//		$sql = "select id from lbs_service_material_lists where name=:name and classify_id=:classify_id";
		$sql = "select id from lbs_service_material_lists where name=:name";
		$command=$connection->createCommand($sql);
		$command->bindParam(':name',$name,PDO::PARAM_STR);
//		$command->bindParam(':classify_id',$classify_id,PDO::PARAM_INT);
		$row = $command->queryRow();
		$exist = ($row!==false);
		$id = (!$exist) ? 0 : $row['id'];
		
		$action = (!$exist) ? Yii::t('import','INSERT') : Yii::t('import','UPDATE');
		$sql = (!$exist)
				? "insert into lbs_service_material_lists 
						(name, classify_id, registration_no, validity, active_ingredient, ratio, brief, unit, sort, status, creat_time)
					values
						(:name, :classify_id, :registration_no, :validity, :active_ingredient, :ratio, :brief, :unit, :sort, :status, now())
				"
				: "update lbs_service_material_lists 
					set registration_no = :registration_no,
						validity = :validity, 
						active_ingredient = :active_ingredient, 
						ratio = :ratio, 
						brief = :brief, 
						unit = :unit, 
						sort = :sort, 
						status = :status
					where
						id = :id  
				"
				;
		$command=$connection->createCommand($sql);
		if (strpos($sql,':id')!==false)
			$command->bindParam(':id',$id,PDO::PARAM_INT);
		if (strpos($sql,':name')!==false) 
			$command->bindParam(':name',$name,PDO::PARAM_STR);
		if (strpos($sql,':classify_id')!==false)
			$command->bindParam(':classify_id',$classify_id,PDO::PARAM_INT);
		if (strpos($sql,':registration_no')!==false)
			$command->bindParam(':registration_no',$registration_no,PDO::PARAM_STR);
		if (strpos($sql,':validity')!==false)
			$command->bindParam(':validity',$validity,PDO::PARAM_STR);
		if (strpos($sql,':active_ingredient')!==false)
			$command->bindParam(':active_ingredient',$active_ingredient,PDO::PARAM_STR);
		if (strpos($sql,':ratio')!==false)
			$command->bindParam(':ratio',$ratio,PDO::PARAM_STR);
		if (strpos($sql,':brief')!==false)
			$command->bindParam(':brief',$brief,PDO::PARAM_STR);
		if (strpos($sql,':unit')!==false)
			$command->bindParam(':unit',$unit,PDO::PARAM_STR);
		if (strpos($sql,':sort')!==false)
			$command->bindParam(':sort',$sort,PDO::PARAM_INT);
		if (strpos($sql,':status')!==false)
			$command->bindParam(':status',$status,PDO::PARAM_INT);
		$command->execute();
		
		return $action.'- /'.Yii::t('import','Row No.').': '.$data['excel_row']
			.' /'.Yii::t('material','Name').': '.$name
			.' /'.Yii::t('material','Classify').': '.$data['classify']
			.' /'.Yii::t('material','Validity').': '.$validity
			.' /'.Yii::t('material','Unit').': '.$unit
			.' /'.Yii::t('material','Status').': '.$data['status']
			;
	}
	
	protected function getClassifyId(&$connection, $name, $city) {
		$sql = "select id from lbs_service_material_classifys where city='$city' and name='$name'";
		$row = $connection->createCommand($sql)->queryRow();
		return ($row===false) ? 0 : $row['id'];
	}
	
	protected function validateDate($date, $format = 'Y-m-d H:i:s') {
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}
	
	protected function convertExcelDate($value) {
		$uxdate = ($value - 25569) * 86400;
		return gmdate('Y-m-d', $uxdate);
	}
}
?>