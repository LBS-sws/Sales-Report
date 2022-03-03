<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/9/18
 * Time: 10:40
 */

class CitylaunchdateList extends CListPageModel
{  /**
 * Declares customized attribute labels.
 * If not declared here, an attribute would have a label that is
 * the same as its name with the first letter in upper case.
 */
    public $id = 0;
    public $city;
    public $city_name;
    public $launch_date;
    public $creat_time;

    public function attributeLabels()
    {
        return array(
            'id'=>Yii::t('citylaunchdate','id'),
            'city_name'=>Yii::t('citylaunchdate','City_name'),
            'city'=>Yii::t('citylaunchdate','City'),
            'launch_date'=>Yii::t('citylaunchdate','Launch_date'),
            'creat_time'=>Yii::t('citylaunchdate','Creat_time'),
        );
    }
    public function retrieveDataByPage($pageNum=1)
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $se_suffix = Yii::app()->params['envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
        $sql1 = "select c.*,b.name city_name from ".$tab_suffix."city_launch_date as c left join security".$se_suffix.".sec_city as b on c.city=b.code";
        $sql2 = "select count(c.id) from ".$tab_suffix."city_launch_date as c left join security".$se_suffix.".sec_city as b on c.city=b.code";
        $clause = "";
        if (!empty($this->searchField) && !empty($this->searchValue)) {
            $svalue = str_replace("'","\'",$this->searchValue);
            switch ($this->searchField) {
                case 'city':
                    $clause .= General::getSqlConditionClause('b.name',$svalue);
                    break;
            }
        }

        $order = "";
        if (!empty($this->orderField)) {
            switch ($this->orderField) {
                case 'city':
                $order .= " order by b.name ";
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
                    'launch_date'=>$record['launch_date'],
                    'creat_time'=>$record['creat_time'],
                );
            }
        }
        $session = Yii::app()->session;
        $session['citylaunchdate_ss01'] = $this->getCriteria();
        return true;
    }


}