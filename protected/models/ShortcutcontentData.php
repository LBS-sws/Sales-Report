<?php
class ShortcutcontentData {
	public function getDbFields() {
		return array(
            'shortcut_name'=>Yii::t('shortcut','Shortcut_name'),
            'content'=>Yii::t('shortcut','Content'),
		);
	}
	
	public function getDefaultMapping() {
	//	Db Field Name => Excel Column No.
		return array(
				'shortcut_name'=>0,
				'content'=>1,
			);
	}
	
	public function validateData($data) {
		$name = $this->getDbFields();
		$connection = Yii::app()->db;
		$city = Yii::app()->user->city();
		
		// Name
		$rtn = empty($data['shortcut_name'])
				? $name['shortcut_name'].' '.Yii::t('import','cannot be blank').' /'
				: ($this->getShortcutId($connection, trim($data['shortcut_name']), $city)!=0 ? '' : $name['shortcut_name'].' '.Yii::t('import','cannot be found in system').' /');
		$rtn .= !empty($data['content']) 
				? (mb_strlen(trim($data['content']), 'UTF-8')>255 ? $name['content'].' '.Yii::t('import','is too long').' /' : '') 
				: $name['content'].' '.Yii::t('import','cannot be blank').' /';

		return empty($rtn) ? '' : Yii::t('import','ERROR').'- /'.Yii::t('import','Row No.').': '.$data['excel_row'].' /'.$rtn;
	}
	
	public function importData(&$connection, $data) {
		$city = Yii::app()->user->city();
		$sc_id = $this->getShortcutId($connection, $data['shortcut_name'], $city);
		$content = trim($data['content']);

		$sql = "select id from lbs_service_shortcut_contents where content=:content and shortcut_id=:shortcut_id";
		$command=$connection->createCommand($sql);
		$command->bindParam(':shortcut_id',$sc_id,PDO::PARAM_INT);
		$command->bindParam(':content',$content,PDO::PARAM_STR);
		$row = $command->queryRow();
		$exist = ($row!==false);
		$id = (!$exist) ? 0 : $row['id'];
		
		if ($exist)
			return Yii::t('import','SKIP').'- /'.Yii::t('import','Row No.').': '.$data['excel_row']
				.' /'.Yii::t('shortcut','Shortcut_name').': '.$data['shortcut_name']
				.' /'.Yii::t('shortcut','Content').': '.$content
				;
		
		$sql = "insert into lbs_service_shortcut_contents  
					(shortcut_id, content, creat_time)
				values
					(:shortcut_id, :content, now())
			";
		$command=$connection->createCommand($sql);
		if (strpos($sql,':shortcut_id')!==false) 
			$command->bindParam(':shortcut_id',$sc_id,PDO::PARAM_INT);
		if (strpos($sql,':content')!==false) 
			$command->bindParam(':content',$content,PDO::PARAM_STR);
		$command->execute();
		
		return Yii::t('import','INSERT').'- /'.Yii::t('import','Row No.').': '.$data['excel_row']
			.' /'.Yii::t('shortcut','Shortcut_name').': '.$data['shortcut_name']
			.' /'.Yii::t('shortcut','Content').': '.$content
			;
	}

	protected function getShortcutId(&$connection, $name, $city) {
		$name = str_replace(' ','',$name);
		$sql = "
				select a.id from lbs_service_shortcuts a, service b
				where a.city='$city' and a.service_type=b.ServiceType 
				and concat(replace(b.ServiceName,' ',''),'-',replace(a.shortcut_name,' ',''))='$name'
			";
		$row = $connection->createCommand($sql)->queryRow();
		return ($row===false) ? 0 : $row['id'];
	}
}
?>