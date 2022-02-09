<?php
class RptMateriallist extends CReport {
	public $show_report_title = false;
	
	protected function fields() {
		$part1 = array(
            'city_name'=>array('label'=>Yii::t('material','City_name'),'width'=>10,'align'=>'C'),
		);
		$part2 = array(
            'name'=>array('label'=>Yii::t('material','Name'),'width'=>30,'align'=>'L'),
            'classify'=>array('label'=>Yii::t('material','Classify'),'width'=>15,'align'=>'L'),
            'registration_no'=>array('label'=>Yii::t('material','Registration_no'),'width'=>30,'align'=>'L'),
            'validity'=>array('label'=>Yii::t('material','Validity'),'width'=>20,'align'=>'L'),
            'active_ingredient'=>array('label'=>Yii::t('material','Active_ingredient'),'width'=>30,'align'=>'L'),
            'ratio'=>array('label'=>Yii::t('material','Ratio'),'width'=>20,'align'=>'L'),
            'unit'=>array('label'=>Yii::t('material','Unit'),'width'=>15,'align'=>'C'),
            'status'=>array('label'=>Yii::t('material','Status'),'width'=>15,'align'=>'C'),
            'sort'=>array('label'=>Yii::t('material','Sort'),'width'=>15,'align'=>'C'),
            'brief'=>array('label'=>Yii::t('material','Brief'),'width'=>50,'align'=>'L'),
		);
		return Yii::app()->user->isSingleCity() ? $part2 : array_merge($part1, $part2);
	}

	public function genReport() {
		$tmp = array();
		foreach ($this->data as $row) {
			$row['status'] = $row['status']==1 ? '启用' : '未启用';
			$tmp[] = $row;
		}
		$this->data = $tmp;
		return $this->exportExcel();
	}
}
?>
