<?php
class RptShortcutcontentlist extends CReport {
	public $show_report_title = false;
	
	protected function fields() {
		$part1 = array(
            'city_name'=>array('label'=>Yii::t('material','City_name'),'width'=>10,'align'=>'C'),
		);
		$part2 = array(
            'shortcut_name'=>array('label'=>Yii::t('shortcut','Shortcut_name'),'width'=>30,'align'=>'L'),
            'content'=>array('label'=>Yii::t('shortcut','Content'),'width'=>100,'align'=>'L'),
		);
		return Yii::app()->user->isSingleCity() ? $part2 : array_merge($part1, $part2);
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
