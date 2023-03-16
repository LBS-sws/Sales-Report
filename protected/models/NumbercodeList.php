<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:56
 */

class NumbercodeList extends CListPageModel
{
    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public $scenario;
    public $id = 0;
    public $city;
    public $city_name;
    public $name;
    public $number_code;
    public function attributeLabels()
    {
        return array(
            'id'=>Yii::t('equipment','id'),
            'city_name'=>Yii::t('equipment','City_name'),
            'city'=>Yii::t('equipment','City'),
            'name'=>Yii::t('equipment','Name'),
            'number_code'=>Yii::t('equipment','Number_code'),
        );
    }
    public function retrieveDataByPage($pageNum=1)
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $se_suffix = Yii::app()->params['envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
        $sql1 = "select m.id,m.city,m.name,m.number_code,b.name city_name from ".$tab_suffix."equipment_type as m left join security".$se_suffix.".sec_city as b on m.city=b.code
				";
        $sql2 = "select count(m.id)
				 from ".$tab_suffix."equipment_type as m left join security".$se_suffix.".sec_city as b on m.city=b.code
				";
        $clause = "";
        if (!empty($this->searchField) && !empty($this->searchValue)) {
            $svalue = str_replace("'","\'",$this->searchValue);
            switch ($this->searchField) {
                case 'city':
                    $clause .= General::getSqlConditionClause('b.name',$svalue);
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
                    $order .= " order by b.name ";
                    break;
                case 'name':
                    $order .= " order by m.name ";
                    break;
            }
            if ($this->orderType=='D') $order .= "desc ";
        }

        $ct_where = " where m.city in(".$city_allow.")";
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
                    'number_code'=>$record['number_code'],
                    'name'=>$record['name']
                );
            }
        }
        $session = Yii::app()->session;
        $session['numbercode_os11'] = $this->getCriteria();
        return true;
    }


}