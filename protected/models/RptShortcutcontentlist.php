<?php
class RptShortcutcontentlist extends CReport {
	public $show_report_title = false;
	
	protected function fields() {
		return array(
            'shortcut_name'=>array('label'=>Yii::t('shortcut','Shortcut_name'),'width'=>30,'align'=>'L'),
            'content'=>array('label'=>Yii::t('shortcut','Content'),'width'=>100,'align'=>'L'),
		);
	}

	public function genReport() {
		$tmp = array();
		foreach ($this->data as $row) {
			$row['shortcut_name'] = $row['service_name']."-".$row['shortcut_name'];
			$tmp[] = $row;
		}
		$this->data = $tmp;
		return $this->exportExcel();
	}
}
?>
