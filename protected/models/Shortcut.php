<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:56
 */

class Shortcut extends CListPageModel
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
    public $shortcut_type;
    public $shortcut_name;
    public $creat_time;
    public function attributeLabels()
    {
        return array(
            'city'=>Yii::t('shortcut','City'),
            'city_name'=>Yii::t('shortcut','City_name'),
            'service_type'=>Yii::t('shortcut','Service_type'),
            'service_name'=>Yii::t('shortcut','Service_name'),
            'shortcut_type'=>Yii::t('shortcut','Shortcut_type'),
            'shortcut_name'=>Yii::t('shortcut','Shortcut_name'),
            'id'=>Yii::t('shortcut','id'),
            'creat_time'=>Yii::t('shortcut','Creat_time'),
        );
    }

    public function retrieveDataByPage($pageNum=1)
    {
        $city_allow = Yii::app()->user->city_allow();
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $se_suffix = Yii::app()->params['envSuffix'];
        $sql1 = "select m.*,s.ServiceName,b.name city_name from ".$tab_suffix."shortcuts as m left join service as s on m.service_type=s.ServiceType left join security".$se_suffix.".sec_city as b on m.city=b.code
				";
        $sql2 = "select count(m.id)
				from ".$tab_suffix."shortcuts as m left join service as s on m.service_type=s.ServiceType left join security".$se_suffix.".sec_city as b on m.city=b.code
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
                case 'shortcut_type':
                    $clause .= General::getSqlConditionClause('m.shortcut_type',$svalue);
                    break;
                case 'shortcut_name':
                    $clause .= General::getSqlConditionClause('m.shortcut_name',$svalue);
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
                case 'shortcut_type':
                    $order .= " order by m.shortcut_type ";
                    break;
                case 'shortcut_name':
                    $order .= " order by m.shortcut_name ";
                    break;
            }
            if ($this->orderType=='D') $order .= "desc ";
        }

        $sql = $sql2.$clause;
        $this->totalRow = Yii::app()->db->createCommand($sql)->queryScalar();

        $ct_where = " where m.city in(".$city_allow.")";
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
                    'shortcut_type'=>$record['shortcut_type'],
                    'shortcut_name'=>$record['shortcut_name'],
                    'creat_time'=>$record['creat_time'],
                );
            }
        }
        $session = Yii::app()->session;
        $session['shortcut_OS01'] = $this->getCriteria();
        return true;
    }
    function retrieveData($index) {
        $city_allow = Yii::app()->user->city_allow();
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $rows = Yii::app()->db->createCommand()->select("*")
            ->from($tab_suffix.'shortcuts')->where("id=:id and city in($city_allow)",array(":id"=>$index))->queryAll();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $this->id = $row['id'];
                $this->service_type = $row['service_type'];
                $this->shortcut_type = $row['shortcut_type'];
                $this->shortcut_name = $row['shortcut_name'];
                $this->creat_time = $row['creat_time'];
                break;
            }
        }
        return true;
    }

}