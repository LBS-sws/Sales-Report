<?php
class Import {
	public $dataModel;
	public $fileName;
	public $readerType = 'Excel2007';
	
	public function run() {
		$data = $this->formatData();
		$log = $this->importData($data);
		return $log;
	}
	
	public function getReaderTypefromFileExtension($ext) {
		return strtolower($ext)=='xlsx' ? 'Excel2007' : 'Excel5';
	}
	
	protected function importData($data) {
		$model = $this->dataModel;
		$logmsgErr = '';
		$logmsgOk = '';
		$logmsg = '';
		$cnt = 0;
		
		$connection = Yii::app()->db;
		$transaction=$connection->beginTransaction();
		try {
			foreach ($data as $row) {
				$msgErr = $model->validateData($row);
				$msgOk = '';
				if ($msgErr=='') {
					$cnt++;
					$msgOk = $model->importData($connection, $row);
				}
				
				$logmsgErr .= (empty($logmsgErr) ? "" : (empty($msgErr) ? "" : "\n")).$msgErr;
				$logmsgOk .= (empty($logmsgOk) ? "" : (empty($msgOk) ? "" : "\n")).$msgOk;
				
				if ($cnt == 500) {
					$logmsg = empty($logmsgErr) ? Yii::t('import','Import Success!') : Yii::t('import','Import Error:')."\n".$logmsgErr;
					$logmsg .= "\n\n".Yii::t('import','Imported Rows:')."\n".$logmsgOk;
					
					$transaction->commit();
					$transaction=$connection->beginTransaction();
					$cnt = 0;
				}
			}
			$logmsg = empty($logmsgErr) ? Yii::t('import','Import Success!') : Yii::t('import','Import Error:')."\n".$logmsgErr;
			$logmsg .= "\n\n".Yii::t('import','Imported Rows:')."\n".$logmsgOk;
			$transaction->commit();

		} catch(Exception $e) {
			$transaction->rollback();
			$logmsg .= "\n\n".Yii::t('import','ERROR').' '.$e->getMessage();
		}
		return $logmsg;
	}

	protected function formatData() {
		$rtn = array();
		
		$excel = new ExcelTool();
		$excel->start();
		$excel->readFileByType($this->fileName, $this->readerType);

		$map = $this->dataModel->getDefaultMapping();
		$mapping = array();
		foreach ($map as $field=>$column) {
			$mapping[] = array('dbfieldid'=>$field, 'filefield'=>$column);
		}
		$emptycnt = 0;
		$rowidx = 2;
		$ws = $excel->setActiveSheet(0);
		do {
			$fields = array();
			$emptyrow = true;
			foreach ($mapping as $item) {
				if ($item['filefield'] >= 0) {
					$value = $excel->getCellValue($excel->getColumn($item['filefield']),$rowidx); 
					$fields[$item['dbfieldid']] = $value;
					if ($emptyrow && !empty($value)) $emptyrow = false;
				}
			}
			if ($emptyrow) {
				$emptycnt++;
			} else {
				if (!isset($fields['excel_row'])) $fields['excel_row'] = $rowidx;
				if (!isset($fields['city'])) $fields['city'] = Yii::app()->user->city();
				$rtn[] = $fields;
				$emptycnt = 0;
			}
			$rowidx++;
		} while ($emptycnt <= 2);
		
		$excel->end();
		
		return $rtn;
	}
}
?>