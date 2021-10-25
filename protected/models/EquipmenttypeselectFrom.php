<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/10/25
 * Time: 9:33
 */

class EquipmenttypeselectFrom extends CFormModel
{
    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public $id = 0;
    public $city_name;
    public $equipment_type_id;
    public $check_targt;
    public $check_selects;
    public $creat_time;
    public function attributeLabels()
    {
        return array(
            'id'=>Yii::t('equipment','id'),
            'city'=>Yii::t('equipment','City'),
            'city_name'=>Yii::t('equipment','City_name'),
            'equipment_type_name'=>Yii::t('equipment','Equipment_type_name'),
            'equipment_type_id'=>Yii::t('equipment','Equipment_type_id'),
            'check_targt'=>Yii::t('equipment','Check_project'),
            'check_selects'=>Yii::t('equipment','Check_selects'),
            'creat_time'=>Yii::t('equipment','Creat_time'),
        );
    }
    public function rules()
    {
        return array(
            array('id,city,equipment_type_id,creat_time','safe'),
            array('check_targt,check_selects','required'),
        );
    }
    function retrieveData($index) {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
        $rows = Yii::app()->db->createCommand()->select("*")
            ->from($tab_suffix."equipment_type_selects")->where("id=:id",array(":id"=>$index))->queryAll();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $this->id = $row['id'];
                $this->equipment_type_id = $row['equipment_type_id'];
                $this->check_targt = $row['check_targt'];
                $this->check_selects = $row['check_selects'];
                $this->creat_time = $row['creat_time'];
                break;
            }
        }
        return true;
    }
    public function saveData()
    {
        $connection = Yii::app()->db;
        $transaction=$connection->beginTransaction();
        try {
            $this->Equipmenttypeselect($connection);
            $transaction->commit();
        }
        catch(Exception $e) {
            $transaction->rollback();
            throw new CHttpException(404,'Cannot update. ('.$e->getMessage().')');
        }
    }
    protected function Equipmenttypeselect(&$connection)
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $sql = '';
        switch ($this->scenario) {
            case 'delete':
                $sql = "delete from ".$tab_suffix."equipment_type_selects where id = :id";
                break;
            case 'new':
                $sql = "insert into ".$tab_suffix."equipment_type_selects(
                        equipment_type_id,check_targt,check_selects,creat_time) values (
						:equipment_type_id,:check_targt,:check_selects,:creat_time)";
                break;
            case 'edit':
                $sql = "update  ".$tab_suffix."equipment_type_selects set 
					check_targt = :check_targt,
					check_selects = :check_selects
					where id = :id";
                break;
        }
//        var_dump($sql);die();
        $command=$connection->createCommand($sql);
        if (strpos($sql,':id')!==false)
            $command->bindParam(':id',$this->id,PDO::PARAM_INT);
        if (strpos($sql,':equipment_type_id')!==false)
            $command->bindParam(':equipment_type_id',$this->equipment_type_id,PDO::PARAM_STR);
        if (strpos($sql,':check_targt')!==false)
            $command->bindParam(':check_targt',$this->check_targt,PDO::PARAM_STR);
        if (strpos($sql,':check_selects')!==false)
            $command->bindParam(':check_selects',$this->check_selects,PDO::PARAM_STR);
        if (strpos($sql,':creat_time')!==false)
            $command->bindParam(':creat_time',date('Y-m-d h:i:s', time()),PDO::PARAM_STR);
        $command->execute();

        if ($this->scenario=='new')
            $this->id = Yii::app()->db->getLastInsertID();
        return true;
    }
}