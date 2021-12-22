<?php
class ReportData {
	public $criteria;
	
	
	public function getSelectString() {
	}
	
	public function getReportName() {
	
		return $this->getItemList('label');
	}

	public function getWidthList() {
		return $this->getItemList('width');
	}

	public function getAlignList() {
		return $this->getItemList('align');
	}

	protected function getItemList($item) {
		$rtn = array();
		$fields = $this->fields();
		foreach ($fields as $key=>$field) {
			$rtn[] = $field[$item];
		}
		return $rtn;
	}

	public function getLabel($field) {
		$fields = $this->fields();
		return (array_key_exists($fields,$field) ? $fields[$field]['align'] : 'L');
	}
	
	public function fields() {
	public function groups() {
		return array();
	}
	
?>