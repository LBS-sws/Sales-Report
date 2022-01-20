<?php
class RptRiskpestlist extends CReport {
	public $show_report_title = false;
	
	protected function fields() {
		$part1 = array(
            'city_name'=>array('label'=>Yii::t('material','City_name'),'width'=>10,'align'=>'C'),
		);
		$part2 = array(
            'target'=>array('label'=>Yii::t('risk','Target'),'width'=>50,'align'=>'L'),
		);
		return Yii::app()->user->isSingleCity() ? $part2 : array_merge($part1, $part2);
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
