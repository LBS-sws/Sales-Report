<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/9/18
 * Time: 10:40
 */


class PapersstaffList extends CListPageModel
{  /**
 * Declares customized attribute labels.
 * If not declared here, an attribute would have a label that is
 * the same as its name with the first letter in upper case.
 */
    public $id = 0;
    public $city;
    public $city_name;
    public $staffid;
    public $signature;
    public $signature_file_type;
    public $creat_time;
    public $city_allow = "CN";
    // 列表对应字段
    public function attributeLabels()
    {
        return array(
            'id'=>Yii::t('papersstaff','id'),
            'city_name'=>Yii::t('papersstaff','City_name'),
            'city'=>Yii::t('papersstaff','City'),
            'staffid'=>Yii::t('papersstaff','Staff_Id'),
            'staffname'=>Yii::t('papersstaff','Staff_name'),
            'create_time'=>Yii::t('papersstaff','Create_time'),
            'update_time'=>Yii::t('papersstaff','Update_time'),

        );
    }
    // 数据列表
    public function retrieveDataByPage($pageNum=1)
    {

        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $se_suffix = Yii::app()->params['envSuffix'];

        $city_allow = Yii::app()->user->city_allow();

        //$sql1 = "select a.* from service".$se_suffix.".papersstaff as a left join security".$se_suffix.".sec_city as b on a.city = b.code where a.city IN ($city_allow) AND a.staff_status = 0 ";

        //$sql2 = "select count(a.id) from papersstaff a left join security".$se_suffix.".sec_city as b on a.city = b.code where a.city IN ($city_allow) AND a.staff_status = 0 ";
        $sql1 = "select a.* from service".$se_suffix.".papersstaff as a left join security".$se_suffix.".sec_city as b on a.city = b.code  ";

        $sql2 = "select count(a.id) from papersstaff a left join security".$se_suffix.".sec_city as b on a.city = b.code  ";

        $clause = "";
        if (!empty($this->searchField) && !empty($this->searchValue)) {
            $svalue = str_replace("'","\'",$this->searchValue);
            switch ($this->searchField) {
                case 'staffname':
                    $clause .= General::getSqlConditionClause('a.name',$svalue);
                    break;
                case 'staffid':
                    $clause .= General::getSqlConditionClause('a.code',$svalue);
                    break;
                case 'city':
                    $clause .= General::getSqlConditionClause('b.name',$svalue);
                    break;
            }
        }

        $order = "";
        if (!empty($this->orderField)) {
            $order .= " order by ".$this->orderField." ";
            if ($this->orderType=='D') $order .= "desc ";
        }else{
            $order .= " order by a.id asc ";
        }

        $ct_where = " where a.city in(".$city_allow.")";
        $sql = $sql2.$ct_where.$clause;
        $this->totalRow = Yii::app()->db->createCommand($sql)->queryScalar();

        $sql = $sql1.$ct_where.$clause.$order;
        $sql = $this->sqlWithPageCriteria($sql, $this->pageNum);
        $records = Yii::app()->db->createCommand($sql)->queryAll();


        foreach ($records as $key=>$val){

            $city = $val['city'];
            $sqlItem = "select * from security".$se_suffix.".sec_city where code='$city'";

            $item = Yii::app()->db->createCommand($sqlItem)->queryRow();

            $records[$key]['city_name'] = $item['name'];
        }

        $list = array();
        $this->attr = array();
        if (count($records) > 0) {
            foreach ($records as $k=>$record) {
                $this->attr[] = array(
                    'id'=>$record['id'],
                    'city'=>$record['city_name'],
                    'code'=>$record['code'],
                    'staffname'=>$record['name'],
                    'create_time'=>$record['create_time'],
                    'update_time'=>$record['update_time'],
                    //'city_name'=>$records['city_name']
                );
            }
        }
        $session = Yii::app()->session;
        $session['papersstaff_ss01'] = $this->getCriteria();
        return true;
    }


}