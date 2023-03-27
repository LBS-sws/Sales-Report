<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:56
 */

class EquipmentnumberList extends CListPageModel
{
    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public $id = 0;
    public $city;
    public $city_name;
    public $name;
    public $eq_type_id;
    public $equipment_number;
    public $status;
    public $downcount;
    public $creat_time;
    public function attributeLabels()
    {
        return array(
            'id'=>Yii::t('equipment','id'),
            'city_name'=>Yii::t('equipment','City_name'),
            'city'=>Yii::t('equipment','City'),
            'eq_type_id'=>Yii::t('equipment','Eq_type_id'),
            'equipment_number'=>Yii::t('equipment','Equipment_number'),
            'name'=>Yii::t('equipment','Name'),
            'status'=>Yii::t('equipment','Status'),
            'downcount'=>Yii::t('equipment','Downcount'),
            'creat_time'=>Yii::t('equipment','Creat_time'),
        );
    }
    public function retrieveDataByPage($pageNum=1)
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $se_suffix = Yii::app()->params['envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
        $sql1 = "select m.*,t.city,b.name city_name from ".$tab_suffix."equipment_numbers as m left join ".$tab_suffix."equipment_type as t on t.id=m.eq_type_id  left join security".$se_suffix.".sec_city as b on t.city=b.code
				";
        $sql2 = "select count(m.id)
				 from ".$tab_suffix."equipment_numbers as m left join  ".$tab_suffix."equipment_type as t on t.id=m.eq_type_id  left join security".$se_suffix.".sec_city as b on t.city=b.code
				";
                $order .= " order by m.equipment_number ";$clause = "";
        if (!empty($this->searchField) && !empty($this->searchValue)) {
            $svalue = str_replace("'","\'",$this->searchValue);
            switch ($this->searchField) {
                case 'city':
                    $clause .= General::getSqlConditionClause('b.name',$svalue);
                    break;
                case 'name':
                    $clause .= General::getSqlConditionClause('m.name',$svalue);
                    break;
                case 'equipment_number':
                    $clause .= General::getSqlConditionClause('m.equipment_number',$svalue);
                    break;
                case 'downcount':
                    $clause .= General::getSqlConditionClause('m.downcount',$svalue);
                    break;
            }
        }elseif($this->searchField=='downcount' && $this->searchValue==0){
            $clause .= " AND m.downcount=0 ";
            // var_dump('ss');die();
        }
        
        $order = "";
        if (!empty($this->orderField)) {
            switch ($this->orderField) {
                case 'city':
                    $order .= " order by b.name ";
                    break;
                case 'name':
                    $order .= " order by m.name ";
                    break;
                case 'equipment_number':
                    $order .= " order by m.equipment_number ";
                    break;
                case 'downcount':
                    $order .= " order by m.downcount ";
                    break;
            }
            if ($this->orderType=='D') $order .= "desc ";
        }

        $ct_where = " where t.city in(".$city_allow.")";
        $sql = $sql2.$ct_where.$clause;
        $this->totalRow = Yii::app()->db->createCommand($sql)->queryScalar();

        if ($order==""){
            $order = " order by m.creat_time desc,m.equipment_number desc";
        }
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
                    'creat_time'=>$record['creat_time'],
                    'name'=>$record['name'],
                    'equipment_number'=>$record['equipment_number'],
                    'status'=>$record['status']==0?"未下载":"已下载",
                    'downcount'=>$record['downcount'],
                );
            }
        }
        $session = Yii::app()->session;
        $session['equipmentnumber_os10'] = $this->getCriteria();
        return true;
    }


}