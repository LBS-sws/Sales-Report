<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:56
 */

class PestType extends CListPageModel
{
    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */

    public $id = 0;
    //城市
    public $city_name;
    //飞虫名称
    public $type_name;
    //启用flag
    public $enabled_flag;
    public $delete_flag;
    public $created_at;
    public $updated_at;
    public $deleted_at;

    /**
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
    `city` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '城市',
    `type_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '飞虫名称',
    `enabled_flag` tinyint(1) DEFAULT '1' COMMENT '启用flag',
    `delete_flag` tinyint(1) DEFAULT '0' COMMENT '禁用flag',
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
    `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
    `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
     * */
    public function attributeLabels()
    {
        return array(
            'id'=>Yii::t('pesttype','id'),
            'city_name'=>Yii::t('pesttype','city_name'),
            'type_name'=>Yii::t('pesttype','type_name'),
            'enabled_flag'=>Yii::t('pesttype','enabled_flag'),
            'delete_flag'=>Yii::t('pesttype','delete_flag'),
            'created_at'=>Yii::t('pesttype','created_at'),
            'updated_at'=>Yii::t('pesttype','updated_at'),
            'deleted_at'=>Yii::t('pesttype','deleted_at'),
        );
    }

    public function retrieveDataByPage($pageNum=1)
    {
        $city_allow = Yii::app()->user->city_allow();
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $se_suffix = Yii::app()->params['envSuffix'];
        $sql1 = "select m.*,b.name city_name from lbs_pest_type as m left join security".$se_suffix.".sec_city as b on m.city=b.code";
        $sql2 = "select count(m.id) as num from lbs_pest_type as m left join security".$se_suffix.".sec_city as b on m.city=b.code";
        $clause = "";
        if (!empty($this->searchField) && !empty($this->searchValue)) {
            $svalue = str_replace("'","\'",$this->searchValue);
            switch ($this->searchField) {
                case 'city_name':
                    $clause .= General::getSqlConditionClause('b.name',$svalue);
                    break;
                case 'type_name':
                    $clause .= General::getSqlConditionClause('m.type_name',$svalue);
                    break;
                case 'enabled_flag':
                    $clause .= General::getSqlConditionClause('m.enabled_flag',$svalue);
                    break;
                case 'delete_flag':
                    $clause .= General::getSqlConditionClause('m.delete_flag',$svalue);
                    break;
            }
        }

        $order = "";
        if (!empty($this->orderField)) {
            switch ($this->orderField) {
                case 'city_name':
                    $order .= " order by b.name ";
                    break;
                case 'type_name':
                    $order .= " order by m.type_name ";
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
                    'city_name'=>$record['city_name'],
                    'type_name'=>$record['type_name'],
                    'enabled_flag'=>$record['enabled_flag'],
                    'delete_flag'=>$record['delete_flag'],
                    'created_at'=>$record['created_at'],
                    'updated_at'=>$record['updated_at'],
                    'deleted_at'=>$record['deleted_at'],
                );
            }
        }
        $session = Yii::app()->session;
        $session['pesttype_PE01'] = $this->getCriteria();
        return true;
    }
    function retrieveData($index) {
        $city_allow = Yii::app()->user->city_allow();
        $rows = Yii::app()->db->createCommand()->select("*")
            ->from('lbs_pest_type')->where("id=:id and city in($city_allow)",array(":id"=>$index))->queryAll();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $this->id = $row['id'];
                $this->city_name = $row['city_name'];
                $this->type_name = $row['type_name'];
                $this->delete_flag = $row['delete_flag']?'否':'是';
                $this->created_at = $row['created_at'];
                $this->updated_at = $row['updated_at'];
                $this->deleted_at = $row['deleted_at'];
                break;
            }
        }
        return true;
    }

}