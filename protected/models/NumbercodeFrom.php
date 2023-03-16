<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/10/22
 * Time: 17:51
 */

class NumbercodeFrom extends CFormModel
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
    public $number_code;

    public function attributeLabels()
    {
        return array(
            'id'=>Yii::t('equipment','id'),
            'city_name'=>Yii::t('equipment','City_name'),
            'city'=>Yii::t('equipment','City'),
            'name'=>Yii::t('equipment','Name'),
            'number_code'=>Yii::t('equipment','Number_code'),
        );
    }
    public function rules()
    {
        return array(
            array('id,city,city_name','safe'),
            array('name,number_code','required'),
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
                $this->city = $row['city'];
                $this->name = $row['name'];
                $this->number_code = $row['number_code'];
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
            $this->Numbercode($connection);
            $transaction->commit();
        }
        catch(Exception $e) {
            $transaction->rollback();
            throw new CHttpException(404,'Cannot update. ('.$e->getMessage().')');
        }
    }
    protected function Numbercode(&$connection)
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $sql = '';
        switch ($this->scenario) {
            case 'edit':
                $sql = "update  ".$tab_suffix."equipment_type set 
					number_code = :number_code 
					where id = :id";
                break;
        }
        $command=$connection->createCommand($sql);
        if (strpos($sql,':id')!==false)
            $command->bindParam(':id',$this->id,PDO::PARAM_INT);
        if (strpos($sql,':number_code')!==false)
            $command->bindParam(':number_code',$this->number_code,PDO::PARAM_STR);
        $command->execute();
        return true;
    }
}