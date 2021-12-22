<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/10/22
 * Time: 17:51
 */

class EquipmenttypeFrom extends CFormModel
{
    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public $id = 0;
    public $city;
    public $city_name;
    public $name;
    public $type;
    public $check_targt;
    public $check_handles;
    public $creat_time;
    public function attributeLabels()
    {
        return array(
            'id'=>Yii::t('equipment','id'),
            'city_name'=>Yii::t('equipment','City_name'),
            'city'=>Yii::t('equipment','City'),
            'type'=>Yii::t('equipment','Type'),
            'name'=>Yii::t('equipment','Name'),
            'check_targt'=>Yii::t('equipment','Check_targt'),
            'check_handles'=>Yii::t('equipment','Check_handle'),
            'creat_time'=>Yii::t('equipment','Creat_time'),
        );
    }
    public function rules()
    {
        return array(
            array('id,city,city_name,creat_time','safe'),
            array('type,name,check_targt,check_handles','required'),
        );
    }
    function retrieveData($index) {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
        $rows = Yii::app()->db->createCommand()->select("*")
            ->from($tab_suffix."equipment_type")->where("id=:id",array(":id"=>$index))->queryAll();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $this->id = $row['id'];
                $this->type = $row['type'];
                $this->city = $row['city'];
                $this->name = $row['name'];
                $this->check_targt = $row['check_targt'];
                $this->check_handles = $row['check_handles'];
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
            $this->Equipmenttype($connection);
            $transaction->commit();
        }
        catch(Exception $e) {
            $transaction->rollback();
            throw new CHttpException(404,'Cannot update. ('.$e->getMessage().')');
        }
    }
    protected function Equipmenttype(&$connection)
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $sql = '';
        switch ($this->scenario) {
            case 'delete':
                $sql = "delete from ".$tab_suffix."equipment_type where id = :id";
                break;
            case 'new':
                $sql = "insert into ".$tab_suffix."equipment_type(
                        type,city,name,check_targt,check_handles,creat_time) values (
						:type,:city,:name,:check_targt,:check_handles,:creat_time)";
                break;
            case 'edit':
                $sql = "update  ".$tab_suffix."equipment_type set 
					type = :type,
					name = :name,
					check_targt = :check_targt,
					check_handles = :check_handles
					where id = :id";
                break;
        }
        $command=$connection->createCommand($sql);
        if (strpos($sql,':id')!==false)
            $command->bindParam(':id',$this->id,PDO::PARAM_INT);
        if (strpos($sql,':type')!==false)
            $command->bindParam(':type',$this->type,PDO::PARAM_STR);
        if (strpos($sql,':city')!==false)
            $command->bindParam(':city',Yii::app()->user->city(),PDO::PARAM_STR);
        if (strpos($sql,':name')!==false)
            $command->bindParam(':name',$this->name,PDO::PARAM_STR);
        if (strpos($sql,':check_targt')!==false)
            $command->bindParam(':check_targt',$this->check_targt,PDO::PARAM_STR);
        if (strpos($sql,':check_handles')!==false)
            $command->bindParam(':check_handles',$this->check_handles,PDO::PARAM_STR);
        if (strpos($sql,':creat_time')!==false)
            $command->bindParam(':creat_time',date('Y-m-d H:i:s', time()),PDO::PARAM_STR);
        $command->execute();

        if ($this->scenario=='new')
            $this->id = Yii::app()->db->getLastInsertID();
        return true;
    }
}