<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:56
 */

class Material extends CListPageModel
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
    public $classify_id;
    public $classify;
    public $registration_no;
    public $validity;
    public $active_ingredient;
    public $ratio;
    public $brief;
    public $unit;
    public $sort;
    public $status;
    public $creat_time;
    public function attributeLabels()
    {
        return array(
            'city'=>Yii::t('material','City'),
            'city_name'=>Yii::t('material','City_name'),
            'name'=>Yii::t('material','Name'),
            'classify_id'=>Yii::t('material','Classify_id'),
            'classify'=>Yii::t('material','Classify'),
            'registration_no'=>Yii::t('material','Registration_no'),
            'validity'=>Yii::t('material','Validity'),
            'active_ingredient'=>Yii::t('material','Active_ingredient'),
            'ratio'=>Yii::t('material','Ratio'),
            'brief'=>Yii::t('material','Brief'),
            'unit'=>Yii::t('material','Unit'),
            'sort'=>Yii::t('material','Sort'),
            'status'=>Yii::t('material','Status'),
            'creat_time'=>Yii::t('material','Creat_time'),
        );
    }

    public function retrieveDataByPage($pageNum=1)
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $se_suffix = Yii::app()->params['envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
        $sql1 = "select m.*,c.name as classify,c.city,b.name as city_name
				from ".$tab_suffix."material_lists as m left join ".$tab_suffix."material_classifys as c on m.classify_id=c.id left join security".$se_suffix.".sec_city as b on c.city=b.code
				";
        $sql2 = "select count(m.id)
				from ".$tab_suffix."material_lists as m left join ".$tab_suffix."material_classifys as c on m.classify_id=c.id left join security".$se_suffix.".sec_city as b on c.city=b.code
				";
        $clause = "";
        if (!empty($this->searchField) && !empty($this->searchValue)) {
            $svalue = str_replace("'","\'",$this->searchValue);
            switch ($this->searchField) {
                case 'city':
                    $clause .= General::getSqlConditionClause('b.name',$svalue);
                    break;
                case 'classify':
                    $clause .= General::getSqlConditionClause('c.name',$svalue);
                    break;
                case 'name':
                    $clause .= General::getSqlConditionClause('m.name',$svalue);
                    break;
            }
        }

        $order = "";
        if (!empty($this->orderField)) {
            switch ($this->orderField) {
                case 'city':
                    $order .= " order by c.city ";
                    break;
                case 'classify':
                    $order .= " order by m.classify_id ";
                    break;
                case 'name':
                    $order .= " order by m.name ";
                    break;
            }
            if ($this->orderType=='D') $order .= "desc ";
        }

        $sql = $sql2.$clause;
        $this->totalRow = Yii::app()->db->createCommand($sql)->queryScalar();

        $ct_where = " where c.city in(".$city_allow.")";
        $sql = $sql1.$ct_where.$clause.$order."order by m.sort";
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
                    'name'=>$record['name'],
                    'classify_id'=>$record['classify_id'],
                    'classify'=>$record['classify'],
                    'registration_no'=>$record['registration_no'],
                    'validity'=>$record['validity'],
                    'active_ingredient'=>$record['active_ingredient'],
                    'ratio'=>$record['ratio'],
                    'brief'=>$record['brief'],
                    'unit'=>$record['unit'],
                    'sort'=>$record['sort'],
                    'status'=>$record['status'],
                    'creat_time'=>$record['creat_time'],
                );
            }
        }
        $session = Yii::app()->session;
        $session['materiallist_ms01'] = $this->getCriteria();
        return true;
    }
    function retrieveData($index) {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
        $rows = Yii::app()->db->createCommand()->select("*")
            ->from($tab_suffix."material_lists")->where("id=:id",array(":id"=>$index))->queryAll();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $this->id = $row['id'];
                $this->name = $row['name'];
                $this->classify_id = $row['classify_id'];
                $this->registration_no = $row['registration_no'];
                $this->validity = $row['validity'];
                $this->active_ingredient = $row['active_ingredient'];
                $this->ratio = $row['ratio'];
                $this->brief = $row['brief'];
                $this->unit = $row['unit'];
                $this->sort = $row['sort'];
                $this->creat_time = $row['creat_time'];
                break;
            }
        }
        return true;
    }

}