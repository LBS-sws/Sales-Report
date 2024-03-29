<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:56
 */

class UseareaList extends CListPageModel
{
    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public $id = 0;
    public $city;
    public $city_name;
    public $area_type;
    public $use_area;
    public $creat_time;
    public function attributeLabels()
    {
        return array(
            'id'=>Yii::t('usearea','id'),
            'city'=>Yii::t('usearea','City'),
            'city_name'=>Yii::t('equipment','City_name'),
            'area_type'=>Yii::t('usearea','Area_type'),
            'use_area'=>Yii::t('usearea','Use_area'),
            'creat_time'=>Yii::t('usearea','Creat_time'),
        );
    }
    public function retrieveDataByPage($pageNum=1)
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $se_suffix = Yii::app()->params['envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
        $sql1 = "select m.*,b.name city_name from ".$tab_suffix."use_areas as m left join security".$se_suffix.".sec_city as b on m.city=b.code
				";
        $sql2 = "select count(m.id)
				from ".$tab_suffix."use_areas as m left join security".$se_suffix.".sec_city as b on m.city=b.code
				";
        $clause = "";
        if (!empty($this->searchField) && !empty($this->searchValue)) {
            $svalue = str_replace("'","\'",$this->searchValue);
            switch ($this->searchField) {
                case 'city':
                    $clause .= General::getSqlConditionClause('b.name',$svalue);
                    break;
                case 'use_area':
                    $clause .= General::getSqlConditionClause('m.use_area',$svalue);
                    break;
            }
        }

        $order = "";
        if (!empty($this->orderField)) {
            switch ($this->orderField) {
                case 'city':
                    $order .= " order by b.name ";
                    break;
                case 'use_area':
                    $order .= " order by m.use_area ";
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
                    'area_type'=>$record['area_type']=='material'?'物料使用':'设备放置区域',
                    'use_area'=>$record['use_area'],
                    'creat_time'=>$record['creat_time'],

                );
            }
        }
        $session = Yii::app()->session;
        $session['usearea_os05'] = $this->getCriteria();
        return true;
    }


}