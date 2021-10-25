<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/10/21
 * Time: 14:27
 */

class MaterialclassFrom extends CFormModel
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
    public $creat_time;
    public function attributeLabels()
    {
        return array(
            'city'=>Yii::t('material','City'),
            'city_name'=>Yii::t('material','City_name'),
            'name'=>Yii::t('material','Name'),
            'id'=>Yii::t('material','id'),
            'creat_time'=>Yii::t('material','Creat_time'),
        );
    }
    public function rules()
    {
        return array(
            array('id,city,city_name,creat_time', 'safe'),
            array('name', 'required'),
        );
    }
    function retrieveData($index) {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
        $rows = Yii::app()->db->createCommand()->select("*")
            ->from($tab_suffix."material_classifys")->where("id=:id and city in($city_allow)",array(":id"=>$index))->queryAll();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $this->id = $row['id'];
                $this->name = $row['name'];
                $this->city = $row['city'];
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
            $this->Materialclass($connection);
            $transaction->commit();
        }
        catch(Exception $e) {
            $transaction->rollback();
            throw new CHttpException(404,'Cannot update. ('.$e->getMessage().')');
        }
    }
    protected function Materialclass(&$connection)
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $sql = '';
        switch ($this->scenario) {
            case 'delete':
                $sql = "delete from ".$tab_suffix."material_classifys where id = :id";
                break;
            case 'new':
                $sql = "insert into ".$tab_suffix."material_classifys(
                        name,city,creat_time) values (
						:name,:city,:creat_time)";
                break;
            case 'edit':
                $sql = "update  ".$tab_suffix."material_classifys set 
					name = :name 
					where id = :id";
                break;
        }
        $command=$connection->createCommand($sql);
        if (strpos($sql,':id')!==false)
            $command->bindParam(':id',$this->id,PDO::PARAM_INT);
        if (strpos($sql,':name')!==false)
            $command->bindParam(':name',$this->name,PDO::PARAM_STR);
        if (strpos($sql,':city')!==false)
            $command->bindParam(':city',Yii::app()->user->city(),PDO::PARAM_STR);
        if (strpos($sql,':creat_time')!==false)
            $command->bindParam(':creat_time',date('Y-m-d h:i:s', time()),PDO::PARAM_STR);
        $command->execute();

        if ($this->scenario=='new')
            $this->id = Yii::app()->db->getLastInsertID();
        return true;
    }
}