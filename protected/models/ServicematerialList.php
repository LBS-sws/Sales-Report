<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:56
 */

class ServicematerialList extends CListPageModel
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
    public $material_ids;
    public $material_names;
    public $creat_time;
    public function attributeLabels()
    {
        return array(
            'city'=>Yii::t('servicematerial','City'),
            'city_name'=>Yii::t('servicematerial','City_name'),
            'service_type'=>Yii::t('servicematerial','Service_type'),
            'service_name'=>Yii::t('servicematerial','Service_name'),
            'material_ids'=>Yii::t('servicematerial','Material_ids'),
            'material_names'=>Yii::t('servicematerial','Material_names'),
            'id'=>Yii::t('servicematerial','id'),
            'creat_time'=>Yii::t('servicematerial','Creat_time'),
        );
    }
    public function retrieveDataByPage($pageNum=1)
    {
        $city_allow = Yii::app()->user->city_allow();
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $se_suffix = Yii::app()->params['envSuffix'];
        $sql1 = "select m.*,s.ServiceName,b.name city_name from ".$tab_suffix."servicematerials as m left join service as s on m.service_type=s.ServiceType left join security".$se_suffix.".sec_city as b on m.city=b.code
				";
        $sql2 = "select count(m.id)
				from ".$tab_suffix."servicematerials as m left join service as s on m.service_type=s.ServiceType left join security".$se_suffix.".sec_city as b on m.city=b.code
				";
        $clause = "";
        if (!empty($this->searchField) && !empty($this->searchValue)) {
            $svalue = str_replace("'","\'",$this->searchValue);
            switch ($this->searchField) {
                case 'city':
                    $clause .= General::getSqlConditionClause('b.name',$svalue);
                    break;
                case 'service_name':
                    $clause .= General::getSqlConditionClause('s.ServiceName',$svalue);
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
                    $order .= " order by m.service_type ";
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
                $sql_eq = "select name from ".$tab_suffix."material_lists where id in(".$record['material_ids'].")";
                $sql_eq_datas =Yii::app()->db->createCommand($sql_eq)->queryAll();
                $material_names = '';
                if ($sql_eq_datas){
                    for($i=0;$i<count($sql_eq_datas);$i++){
                        if ($i==count($sql_eq_datas)-1){
                            $material_names .= $sql_eq_datas[$i]['name'];
                        }else{
                            $material_names .= $sql_eq_datas[$i]['name'].',';
                        }

                    }
                }
                $this->attr[] = array(
                    'id'=>$record['id'],
                    'city'=>$record['city'],
                    'city_name'=>$record['city_name'],
                    'service_type'=>$record['service_type'],
                    'service_name'=>$record['ServiceName'],
                    'material_ids'=>$record['material_ids'],
                    'material_names'=>$material_names,
                    'creat_time'=>$record['creat_time'],
                );
            }
        }
        $session = Yii::app()->session;
        $session['serviceequipment_os09'] = $this->getCriteria();
        return true;
    }


}