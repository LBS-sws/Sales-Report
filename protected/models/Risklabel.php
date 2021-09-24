<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:56
 */

class Risklabel extends CListPageModel
{
    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public $id = 0;
    public $label;
    public $creat_time;
    public function attributeLabels()
    {
        return array(
            'label'=>Yii::t('risk','Label'),
            'id'=>Yii::t('risk','id'),
            'creat_time'=>Yii::t('risk','Creat_time'),
        );
    }

    public function retrieveDataByPage($pageNum=1)
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
        $sql1 = "select * from ".$tab_suffix."risk_label_lists
				";
        $sql2 = "select count(id)
				from ".$tab_suffix."risk_label_lists 
				";
        $clause = "";
        if (!empty($this->searchField) && !empty($this->searchValue)) {
            $svalue = str_replace("'","\'",$this->searchValue);
            switch ($this->searchField) {
                case 'label':
                    $clause .= General::getSqlConditionClause('label',$svalue);
                    break;
                case 'creat_time':
                    $clause .= General::getSqlConditionClause('creat_time',$svalue);
                    break;
            }
        }

        $order = "";
        if (!empty($this->orderField)) {
            switch ($this->orderField) {
                case 'creat_time':
                    $order .= " order by creat_time ";
                    break;
                case 'label':
                    $order .= " order by label ";
                    break;
            }
            if ($this->orderType=='D') $order .= "desc ";
        }

        $sql = $sql2.$clause;
        $this->totalRow = Yii::app()->db->createCommand($sql)->queryScalar();

        $sql = $sql1.$clause.$order;
        $sql = $this->sqlWithPageCriteria($sql, $this->pageNum);
        $records = Yii::app()->db->createCommand($sql)->queryAll();

        $list = array();
        $this->attr = array();
        if (count($records) > 0) {
            foreach ($records as $k=>$record) {
                $this->attr[] = array(
                    'id'=>$record['id'],
                    'label'=>$record['label'],
                    'creat_time'=>$record['creat_time'],
                );
            }
        }
        $session = Yii::app()->session;
        $session['risklabel_rs04'] = $this->getCriteria();
        return true;
    }
    function retrieveData($index) {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
        $rows = Yii::app()->db->createCommand()->select("*")
            ->from($tab_suffix."risk_label_lists")->where("id=:id",array(":id"=>$index))->queryAll();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $this->id = $row['id'];
                $this->label = $row['label'];
                $this->creat_time = $row['creat_time'];
                break;
            }
        }
        return true;
    }

}