<?php

class ReportjobList extends CListPageModel
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

	public function searchColumns() {
		$suffix = Yii::app()->params['envSuffix'];
		$search = array(
			'JobDate'=>"date_format(j.JobDate,'%Y-%m-%d')",
			'CustomerID'=>'j.CustomerID',
			'CustomerName'=>'j.CustomerName',
			'ServiceType'=>'s.ServiceName',
			'Staff01'=>'t.StaffName',
		);
		if (!Yii::app()->user->isSingleCity()) $search['City'] = 'b.name';
		return $search;
	}

	protected function getSQL($type) {
        $se_suffix = Yii::app()->params['envSuffix'];
        $tab_suffix = Yii::app()->params['table_envSuffix'];
		$city = Yii::app()->user->city_allow();
        $lainch_date_r = Yii::app()->db->createCommand()->select("*")
            ->from($tab_suffix."city_launch_date")->where("city=:city",array(":city"=>Yii::app()->user->city()))->queryRow();
        if ($lainch_date_r){
            $lainch_date = $lainch_date_r['launch_date'];
        }else{
            $lainch_date = '2022-02-10';
        }

		$sql = $type==1
			? "select j.*,b.name city_name,b.code,s.ServiceName, t.StaffName as Staff01Name, t2.StaffName as Staff02Name, t3.StaffName as Staff03Name
				from joborder as j 
				left join officecity as o on j.City=o.City  
				left join enums as e on e.EnumID=o.Office 
				left join service as s on s.ServiceType=j.ServiceType 
				left join staff as t on t.StaffID=j.Staff01 
				left join staff as t2 on t2.StaffID=j.Staff02 
				left join staff as t3 on t3.StaffID=j.Staff03 
				left join security$se_suffix.sec_city as b on e.Text=b.code 
				where e.EnumType=8 and j.Status=3 and e.Text in ($city) and j.JobDate>='$lainch_date'
				"
			: "select count(JobID) 
				from joborder as j 
				left join officecity as o on j.City=o.City  
				left join enums as e on e.EnumID=o.Office 
				left join service as s on s.ServiceType=j.ServiceType 
				left join staff as t on t.StaffID=j.Staff01 
				left join staff as t2 on t2.StaffID=j.Staff02 
				left join staff as t3 on t3.StaffID=j.Staff03 
				left join security$se_suffix.sec_city as b on e.Text=b.code 
				where e.EnumType=8 and j.Status=3 and e.Text in ($city) and j.JobDate>='$lainch_date'
				";

		$clause = "";
        $columns = $this->searchColumns();
        if (!empty($this->searchField) && (!empty($this->searchValue) || $this->isAdvancedSearch())) {
            if ($this->isAdvancedSearch()) {
                $clause = $this->buildSQLCriteria();
            } else {
                $svalue = str_replace("'","\'",$this->searchValue);
                $clause .= General::getSqlConditionClause($columns[$this->searchField],$svalue);
            }
        }
		$clause .= $this->getDateRangeCondition('j.JobDate');
		return $sql.$clause;
	}

	public function getDataSQL() {
		return $this->getSQL(1);
	}

	public function getCountSQL() {
		return $this->getSQL(2);
	}

	public function retrieveDataByPage($pageNum=1)
	{
        $se_suffix = Yii::app()->params['envSuffix'];
        $tab_suffix = Yii::app()->params['table_envSuffix'];
		$city = Yii::app()->user->city_allow();
        $lainch_date_r = Yii::app()->db->createCommand()->select("*")
            ->from($tab_suffix."city_launch_date")->where("city=:city",array(":city"=>Yii::app()->user->city()))->queryRow();
        if ($lainch_date_r){
            $lainch_date = $lainch_date_r['launch_date'];
        }else{
            $lainch_date = '2022-02-10';
        }

		$sql1 = "select *,cc.CustomerType,b.name city_name,b.code  from joborder as j left join customercompany cc ON cc.CustomerID = j.CustomerID left join officecity as o on j.City=o.City  left join enums as e on e.EnumID=o.Office left join service as s on s.ServiceType=j.ServiceType left join staff as t on t.StaffID=j.Staff01 left join security".$se_suffix.".sec_city as b on e.Text=b.code where e.EnumType=8 and j.Status=3 and e.Text in ($city) and j.JobDate>='".$lainch_date."'
			";
		$sql2 = "select count(JobID) from joborder as j left join customercompany cc ON cc.CustomerID = j.CustomerID  left join officecity as o on j.City=o.City  left join enums as e on e.EnumID=o.Office left join service as s on s.ServiceType=j.ServiceType left join staff as t on t.StaffID=j.Staff01 left join security".$se_suffix.".sec_city as b on e.Text=b.code where e.EnumType=8 and j.Status=3 and e.Text in ($city) and j.JobDate>='".$lainch_date."'
			";
		$clause = "";
        $columns = $this->searchColumns();
        if (!empty($this->searchField) && (!empty($this->searchValue) || $this->isAdvancedSearch())) {
            if ($this->isAdvancedSearch()) {
                $clause = $this->buildSQLCriteria();
            } else {
                $svalue = str_replace("'","\'",$this->searchValue);
                $clause .= General::getSqlConditionClause($columns[$this->searchField],$svalue);
            }
        }
		$clause .= $this->getDateRangeCondition('j.JobDate');
/*
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
                case 'CustomerID':
                    $clause .= General::getSqlConditionClause('j.CustomerID',$svalue);
                    break;
                case 'ServiceType':
                    $clause .= General::getSqlConditionClause('s.ServiceName',$svalue);
                    break;
			}
		}
*/
		$order = "";
		if (!empty($this->orderField)) {
			if ($this->orderField=='StartTime') {
				$order .= " order by concat(if(j.StartTime>=j.FinishTime, date_format(date_add(j.FinishDate, interval -1 day),'%Y-%m-%d'), date_format(j.FinishDate,'%Y-%m-%d')),' ',j.StartTime) ";
			} elseif ($this->orderField=='FinishTime') {
				$order .= " order by concat(date_format(j.FinishDate,'%Y-%m-%d'),' ',j.FinishTime) ";
			} elseif ($this->orderField=='ServiceType') {
				$order .= " order by s.ServiceName ";
			} else {
				$order .= " order by ".$this->orderField." ";
			}
			if ($this->orderType=='D') $order .= "desc ";
		}else{
		    $order ="order by JobDate desc,FinishTime desc";
        }
		$sql = $sql2.$clause;
		$this->totalRow = Yii::app()->db->createCommand($sql)->queryScalar();
		$sql = $sql1.$clause.$order;

		$sql = $this->sqlWithPageCriteria($sql, $this->pageNum);
		$records = Yii::app()->db->createCommand($sql)->queryAll();
//		print_r($sql);
		foreach($records as $key=>$val){
			$command1 = Yii::app()->db->createCommand('SELECT pics FROM lbs_invoice WHERE jobid="'.$val['JobID'].'" ')->queryRow();
			if($command1){
				$records[$key]['pics'] = $command1['pics'];
			}else{
				$records[$key]['pics'] = '';
			}

		}
		$list = array();
		$this->attr = array();
		if (count($records) > 0) {
			foreach ($records as $k=>$record) {
			    if($record['StartTime']>=$record['FinishTime']){
                    $FinishDate_s = date("Y-m-d",strtotime("-1 day",strtotime($record['FinishDate'])));
                }else{
                    $FinishDate_s = $record['FinishDate'];
                }
				$this->attr[] = array(
					'City'=>$record['city_name'],
                    'Citycode'=>$record['code'],
                    'JobID'=>$record['JobID'],
					'JobDate'=>$record['JobDate'],
					'CustomerID'=>$record['CustomerID'],
					'CustomerName'=>$record['CustomerName'],
                    'ServiceType'=>$record['ServiceName'],
                    'CustomerType'=>$record['CustomerType'],
                    'Staff01'=>$record['StaffName'],
                    'StartTime'=>$FinishDate_s.' '.$record['StartTime'],
                    'FinishTime'=>$record['FinishDate'].' '.$record['FinishTime'],
					'Pics'=>$record['pics']	// 发票预览字段

				);
			}
		}
		$session = Yii::app()->session;
		$session[$this->criteriaName()] = $this->getCriteria();
		return true;
	}

}
