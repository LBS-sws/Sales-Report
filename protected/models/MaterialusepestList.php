<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:56
 */

class MaterialusepestList extends CListPageModel
{
    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public $id = 0;
    public $city;
    public $city_name;
    public $service_type;
    public $service_name;
    public $targets;
    public $creat_time;
    public function attributeLabels()
    {
        return array(
            'city'=>Yii::t('material','City'),
            'city_name'=>Yii::t('material','City_name'),
            'service_type'=>Yii::t('material','Service_type'),
            'service_name'=>Yii::t('material','Service_name'),
            'targets'=>Yii::t('material','Targets'),
            'id'=>Yii::t('material','id'),
            'creat_time'=>Yii::t('material','Creat_time'),
        );
    }
    public function retrieveDataByPage($pageNum=1)
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $se_suffix = Yii::app()->params['envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
        $sql1 = "select m.*,s.ServiceName,b.name city_name from ".$tab_suffix."material_target_lists as m left join service as s on m.service_type=s.ServiceType left join security".$se_suffix.".sec_city as b on m.city=b.code
				";
        $sql2 = "select count(m.id)
				from ".$tab_suffix."material_target_lists as m left join service as s on m.service_type=s.ServiceType left join security".$se_suffix.".sec_city as b on m.city=b.code
				";
        $clause = "";
        if (!empty($this->searchField) && !empty($this->searchValue)) {
            $svalue = str_replace("'","\'",$this->searchValue);
            switch ($this->searchField) {
                case 'city':
                    $clause .= General::getSqlConditionClause('b.name',$svalue);
                    break;
                case 'service_type':
                    $clause .= General::getSqlConditionClause('s.ServiceName',$svalue);
                    break;
                case 'targets':
                    $clause .= General::getSqlConditionClause('m.targets',$svalue);
                    break;
            }
        }

        $order = "";
        if (!empty($this->orderField)) {
            switch ($this->orderField) {
                case 'city':
                    $order .= " order by b.name ";
                    break;
                case 'service_type':
                    $order .= " order by s.ServiceName ";
                    break;
                case 'targets':
                    $order .= " order by m.targets ";
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
                    'service_type'=>$record['service_type'],
                    'service_name'=>$record['ServiceName'],
                    'targets'=>$record['targets'],
                    'creat_time'=>$record['creat_time'],
                );
            }
        }
        $session = Yii::app()->session;
        $session['materialusepest_ms04'] = $this->getCriteria();
        return true;
    }

}