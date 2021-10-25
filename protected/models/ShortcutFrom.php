<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/10/22
 * Time: 17:15
 */

class ShortcutFrom extends CFormModel
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
    public function rules()
    {
        return array(
            array('id,city,city_name,service_name,creat_time','safe'),
            array('service_type,shortcut_type,shortcut_name','required'),
        );
    }
    function retrieveData($index) {
        $city_allow = Yii::app()->user->city_allow();
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $rows = Yii::app()->db->createCommand()->select("*")
            ->from($tab_suffix.'shortcuts')->where("id=:id and city in($city_allow)",array(":id"=>$index))->queryAll();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $this->id = $row['id'];
                $this->city = $row['city'];
                $this->service_type = $row['service_type'];
                $this->shortcut_type = $row['shortcut_type'];
                $this->shortcut_name = $row['shortcut_name'];
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
            $this->Shortcut($connection);
            $transaction->commit();
        }
        catch(Exception $e) {
            $transaction->rollback();
            throw new CHttpException(404,'Cannot update. ('.$e->getMessage().')');
        }
    }
    protected function Shortcut(&$connection)
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $sql = '';
        switch ($this->scenario) {
            case 'delete':
                $sql = "delete from ".$tab_suffix."shortcuts where id = :id";
                break;
            case 'new':
                $sql = "insert into ".$tab_suffix."shortcuts(
                        city,service_type,shortcut_type,shortcut_name,creat_time) values (
						:city,:service_type,:shortcut_type,:shortcut_name,:creat_time)";
                break;
            case 'edit':
                $sql = "update  ".$tab_suffix."shortcuts set 
					service_type = :service_type,
					shortcut_type = :shortcut_type,
					shortcut_name = :shortcut_name
					where id = :id";
                break;
        }
        $command=$connection->createCommand($sql);
        if (strpos($sql,':id')!==false)
            $command->bindParam(':id',$this->id,PDO::PARAM_INT);
        if (strpos($sql,':city')!==false)
            $command->bindParam(':city',Yii::app()->user->city(),PDO::PARAM_STR);
        if (strpos($sql,':service_type')!==false)
            $command->bindParam(':service_type',$this->service_type,PDO::PARAM_STR);
        if (strpos($sql,':shortcut_type')!==false)
            $command->bindParam(':shortcut_type',$this->shortcut_type,PDO::PARAM_STR);
        if (strpos($sql,':shortcut_name')!==false)
            $command->bindParam(':shortcut_name',$this->shortcut_name,PDO::PARAM_STR);
        if (strpos($sql,':creat_time')!==false)
            $command->bindParam(':creat_time',date('Y-m-d h:i:s', time()),PDO::PARAM_STR);
        $command->execute();

        if ($this->scenario=='new')
            $this->id = Yii::app()->db->getLastInsertID();
        return true;
    }
}