<?php

class ReportfollowList extends CListPageModel
{
	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a labe l that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(	
			'number'=>Yii::t('invoice','Number'),
			'dates'=>Yii::t('invoice','Date'),
			'customer_account'=>Yii::t('invoice','Customer Account'),
			'invoice_company'=>Yii::t('invoice','Invoice Company'),
            'City'=>Yii::t('reportjob','City'),
            'city_name'=>Yii::t('reportjob','City'),
            'JobID'=>Yii::t('reportjob','JobID'),
            'JobDate'=>Yii::t('reportjob','JobDate'),
            'CustomerID'=>Yii::t('reportjob','CustomerID'),
            'CustomerName'=>Yii::t('reportjob','CustomerName'),
            'ServiceType'=>Yii::t('reportjob','ServiceType'),
            'Staff01'=>Yii::t('reportjob','Staff01'),
            'StartTime'=>Yii::t('reportjob','StartTime'),
            'FinishTime'=>Yii::t('reportjob','FinishTime'),
		);
	}
	
	public function retrieveDataByPage($pageNum=1)
	{
		$suffix = Yii::app()->params['envSuffix'];
        $se_suffix = Yii::app()->params['envSuffix'];
		$city = Yii::app()->user->city_allow();
		$sql1 = "select *,b.name city_name  from followuporder as j left join officecity as o on j.City=o.City  left join enums as e on e.EnumID=o.Office left join service as s on s.ServiceType=j.SType left join staff as t on t.StaffID=j.Staff01 left join security".$se_suffix.".sec_city as b on e.Text=b.code where e.EnumType=8 and j.Status=3 and e.Text in ($city) 
			";
		$sql2 = "select count(FollowUpID) from followuporder as j left join officecity as o on j.City=o.City  left join enums as e on e.EnumID=o.Office left join service as s on s.ServiceType=j.SType left join staff as t on t.StaffID=j.Staff01 where e.EnumType=8 and j.Status=3 and e.Text in ($city) 
			";
		$clause = "";
		if (!empty($this->searchField) && !empty($this->searchValue)) {
			$svalue = str_replace("'","\'",$this->searchValue);
			switch ($this->searchField) {
				case 'JobDate':
					$clause .= General::getSqlConditionClause('j.JobDate',$svalue);
					break;
				case 'CustomerName':
					$clause .= General::getSqlConditionClause('j.CustomerName',$svalue);
					break;
				case 'Staff01':
					$clause .= General::getSqlConditionClause('t.StaffName',$svalue);
					break;
                case 'city_name':
                    $clause .= General::getSqlConditionClause('b.name',$svalue);
                    break;
			}
		}

		$order = "";
		if (!empty($this->orderField)) {
			$order .= " order by ".$this->orderField." ";
			if ($this->orderType=='D') $order .= "desc ";
		}else{
		    $order ="order by JobDate desc";
        }
		$sql = $sql2.$clause;
		$this->totalRow = Yii::app()->db->createCommand($sql)->queryScalar();
		$sql = $sql1.$clause.$order;

		$sql = $this->sqlWithPageCriteria($sql, $this->pageNum);
		$records = Yii::app()->db->createCommand($sql)->queryAll();
//		print_r($sql);
		$list = array();
		$this->attr = array();
		if (count($records) > 0) {
			foreach ($records as $k=>$record) {
				$this->attr[] = array(
					'City'=>$record['city_name'],
                    'JobID'=>$record['FollowUpID'],
					'JobDate'=>$record['JobDate'],
					'CustomerID'=>$record['CustomerID'],
					'CustomerName'=>$record['CustomerName'],
                    'ServiceType'=>$record['ServiceName'],
                    'Staff01'=>$record['StaffName'],
                    'StartTime'=>$record['StartTime'],
                    'FinishTime'=>$record['FinishTime'],
				);
			}
		}
		$session = Yii::app()->session;
		$session['report_rq02'] = $this->getCriteria();
		return true;
	}

}
