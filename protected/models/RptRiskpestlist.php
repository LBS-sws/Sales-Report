<?php
class RptRiskpestlist extends CReport {
	public $show_report_title = false;
	
	protected function fields() {
		return array(
            'target'=>array('label'=>Yii::t('risk','Target'),'width'=>50,'align'=>'L'),
		);
	}

	public function genReport() {
		$tmp = array();
		foreach ($this->data as $row) {
			$tmp[] = $row;
		}
		$this->data = $tmp;
		return $this->exportExcel();
	}
}
?>
