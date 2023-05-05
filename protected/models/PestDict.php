<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:56
 */

class PestDict extends CListPageModel
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
    public $type_id;
    public $type_name;
    //启用flag
    public $insect_name;
    public $analysis_result;
    public $suggestion;
    public $measure;
    public $created_at;
    public $updated_at;
    /**
     * @var string
     */
    private $delete_flag;
    /**
     * @var mixed
     */
    private $deleted_at;

    /**
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
    `city` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '城市',
    `type_id` int(11) DEFAULT NULL COMMENT '类型id（1，昆虫；2，老鼠）',
    `insect_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '飞虫名称',
    `analysis_result` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '分析结果',
    `suggestion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '建议',
    `measure` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '措施',
    `enabled_flag` tinyint(1) DEFAULT '1' COMMENT '启用flag',
    `disabled_flag` tinyint(1) DEFAULT '0' COMMENT '禁用flag',
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
    `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
    `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
     * */
    public function attributeLabels()
    {
        return array(
            'id'=>Yii::t('pestdict','id'),
            'city_name'=>Yii::t('pestdict','city_name'),
            'type_id'=>Yii::t('pestdict','type_id'),
            'type_name'=>Yii::t('pestdict','type_name'),
            'insect_name'=>Yii::t('pestdict','insect_name'),
            'analysis_result'=>Yii::t('pestdict','analysis_result'),
            'suggestion'=>Yii::t('pestdict','suggestion'),
            'measure'=>Yii::t('pestdict','measure'),
            'disabled_flag'=>Yii::t('pestdict','disabled_flag'),
            'created_at'=>Yii::t('pestdict','created_at'),
            'updated_at'=>Yii::t('pestdict','updated_at'),
            'deleted_at'=>Yii::t('pestdict','deleted_at'),
        );
    }

    public function retrieveDataByPage($pageNum=1)
    {
        $city_allow = Yii::app()->user->city_allow();
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $se_suffix = Yii::app()->params['envSuffix'];
        $sql1 = "select m.*,lpt.id as type_id,type_name,b.name city_name from lbs_pest_dict as m left join security".$se_suffix.".sec_city as b on m.city=b.code left join  lbs_pest_type lpt on lpt.id = m.type_id";
        $sql2 = "select count(m.id) as num from lbs_pest_dict as m left join security".$se_suffix.".sec_city as b on m.city=b.code left join  lbs_pest_type lpt on lpt.id = m.type_id";
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
                    'type_id'=>$record['type_id'],
                    'type_name'=>$record['type_name'],
                    'insect_name'=>$record['insect_name'],
                    'analysis_result'=>$record['analysis_result'],
                    'suggestion'=>$record['suggestion'],
                    'measure'=>$record['measure'],
                    'disabled_flag'=>$record['disabled_flag'],
                    'created_at'=>$record['created_at'],
                    'updated_at'=>$record['updated_at'],
                    'deleted_at'=>$record['deleted_at'],
                );
            }
        }
        $session = Yii::app()->session;
        $session['pestdict_PE01'] = $this->getCriteria();
        return true;
    }


}