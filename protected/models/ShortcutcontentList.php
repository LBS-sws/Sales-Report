<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:56
 */

class ShortcutcontentList extends CListPageModel
{
    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public $id = 0;
    public $city_name;
    public $service_name;
    public $shortcut_id;
    public $shortcut_name;
    public $content;
    public $creat_time;
    public function attributeLabels()
    {
        return array(
            'city'=>Yii::t('shortcut','City'),
            'city_name'=>Yii::t('shortcut','City_name'),
            'shortcut_id'=>Yii::t('shortcut','Shortcut_name'),
            'service_name'=>Yii::t('shortcut','Service_name'),
            'shortcut_name'=>Yii::t('shortcut','Shortcut_name'),
            'content'=>Yii::t('shortcut','Content'),
            'id'=>Yii::t('shortcut','id'),
            'creat_time'=>Yii::t('shortcut','Creat_time'),
        );
    }
    public function retrieveDataByPage($pageNum=1)
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $se_suffix = Yii::app()->params['envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
        $sql1 = "select m.*,s.ServiceName,t.shortcut_name,b.name city_name from ".$tab_suffix."shortcut_contents as m left join ".$tab_suffix."shortcuts as t on t.id=m.shortcut_id left join service as s on t.service_type=s.ServiceType left join security".$se_suffix.".sec_city as b on t.city=b.code
				";
        $sql2 = "select count(m.id)
				from ".$tab_suffix."shortcut_contents as m left join ".$tab_suffix."shortcuts as t on t.id=m.shortcut_id left join service as s on t.service_type=s.ServiceType left join security".$se_suffix.".sec_city as b on t.city=b.code
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
                case 'shortcut_name':
                    $clause .= General::getSqlConditionClause('t.shortcut_name',$svalue);
                    break;
                case 'content':
                    $clause .= General::getSqlConditionClause('m.content',$svalue);
                    break;
            }
        }

        $order = "";
        if (!empty($this->orderField)) {
            switch ($this->orderField) {
                case 'city':
                    $order .= " order by b.name ";
                    break;
                case 'service_name':
                    $order .= " order by s.ServiceName ";
                    break;
                case 'shortcut_name':
                    $order .= " order by t.shortcut_name ";
                    break;
                case 'content':
                    $order .= " order by m.content ";
                    break;
            }
            if ($this->orderType=='D') $order .= "desc ";
        }

        $ct_where = " where t.city in(".$city_allow.")";
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
                    'city_name'=>$record['city_name'],
                    'shortcut_id'=>$record['shortcut_id'],
                    'shortcut_name'=>$record['shortcut_name'],
                    'service_name'=>$record['ServiceName'],
                    'content'=>$record['content'],
                    'creat_time'=>$record['creat_time'],
                );
            }
        }
        $session = Yii::app()->session;
        $session['shortcutcontent_os02'] = $this->getCriteria();
        return true;
    }


}