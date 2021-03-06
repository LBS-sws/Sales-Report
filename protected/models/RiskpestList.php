<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:56
 */

class RiskpestList extends CListPageModel
{
    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
/*
    public $id = 0;
    public $city;
    public $city_name;
    public $target;
    public $creat_time;
*/
	public $import_file;
    public function attributeLabels()
    {
        return array(
            'city'=>Yii::t('risk','City'),
            'city_name'=>Yii::t('risk','City_name'),
            'target'=>Yii::t('risk','Target'),
            'id'=>Yii::t('risk','id'),
            'creat_time'=>Yii::t('risk','Creat_time'),
			'import_file'=>Yii::t('import','Import File'),
        );
    }
 	public function rules()
	{
		return array(
			array('attr, pageNum, noOfItem, totalRow, searchField, searchValue, orderField, orderType, filter, dateRangeValue','safe',),
			array('import_file','file','types'=>'xls,xlsx','allowEmpty'=>false),
		);
	}
   public function retrieveDataByPage($pageNum=1)
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $se_suffix = Yii::app()->params['envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
        $sql1 = "select c.*,b.name city_name from ".$tab_suffix."risk_target_lists as c left join security".$se_suffix.".sec_city as b on c.city=b.code
				";
        $sql2 = "select count(c.id)
				from ".$tab_suffix."risk_target_lists as c left join security".$se_suffix.".sec_city as b on c.city=b.code
				";
        $clause = "";
        if (!empty($this->searchField) && !empty($this->searchValue)) {
            $svalue = str_replace("'","\'",$this->searchValue);
            switch ($this->searchField) {
                case 'city':
                    $clause .= General::getSqlConditionClause('b.name',$svalue);
                    break;
                case 'target':
                    $clause .= General::getSqlConditionClause('c.target',$svalue);
                    break;
            }
        }

        $order = "";
        if (!empty($this->orderField)) {
            switch ($this->orderField) {
                case 'city':
                    $order .= " order by c.city ";
                    break;
                case 'target':
                    $order .= " order by c.target ";
                    break;
            }
            if ($this->orderType=='D') $order .= "desc ";
        }

        $ct_where = " where c.city in(".$city_allow.")";
        $sql = $sql2.$ct_where.$clause;
        $this->totalRow = Yii::app()->db->createCommand($sql)->queryScalar();

        $sql = $sql1.$ct_where.$clause.$order;
        $sql = $this->sqlWithPageCriteria($sql, $this->pageNum);
        $records = Yii::app()->db->createCommand($sql)->queryAll();

        $list = array();
        $this->attr = array();
        if (count($records) > 0) {
            foreach ($records as $k=>$record) {
                $this->attr[] = array(
                    'id'=>$record['id'],
                    'city'=>$record['city'],
                    'city_name'=>$record['city_name'],
                    'target'=>$record['target'],
                    'creat_time'=>$record['creat_time'],
                );
            }
        }
        $session = Yii::app()->session;
        $session['riskpest_rs01'] = $this->getCriteria();
        return true;
    }


}