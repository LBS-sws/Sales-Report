<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/10/22
 * Time: 17:15
 */

class ServicematerialFrom extends CFormModel
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
    public $material_ids;
    public $material_names;
    public $creat_time;
    public function attributeLabels()
    {
        return array(
            'city'=>Yii::t('servicematerial','City'),
            'city_name'=>Yii::t('servicematerial','City_name'),
            'service_type'=>Yii::t('servicematerial','Service_type'),
            'service_name'=>Yii::t('servicematerial','Service_name'),
            'material_ids'=>Yii::t('servicematerial','Material_ids'),
            'material_names'=>Yii::t('servicematerial','Material_names'),
            'id'=>Yii::t('servicematerial','id'),
            'creat_time'=>Yii::t('servicematerial','Creat_time'),
        );
    }
    public function rules()
    {
        return array(
            array('id,city,city_name,service_name,creat_time','safe'),
            array('service_type,material_ids','required'),
        );
    }
    function retrieveData($index) {
        $city_allow = Yii::app()->user->city_allow();
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $rows = Yii::app()->db->createCommand()->select("*")
            ->from($tab_suffix.'servicematerials')->where("id=:id and city in($city_allow)",array(":id"=>$index))->queryAll();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $this->id = $row['id'];
                $this->city = $row['city'];
                $this->service_type = $row['service_type'];
                $this->material_ids = explode(',',$row['material_ids']);
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
            $this->Serviceequipment($connection);
            $transaction->commit();
        }
        catch(Exception $e) {
            $transaction->rollback();
            throw new CHttpException(404,'Cannot update. ('.$e->getMessage().')');
        }
    }
    protected function Serviceequipment(&$connection)
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $sql = '';
        switch ($this->scenario) {
            case 'delete':
                $sql = "delete from ".$tab_suffix."servicematerials where id = :id";
                break;
            case 'new':
                $sql = "insert into ".$tab_suffix."servicematerials(
                        city,service_type,material_ids,creat_time) values (
						:city,:service_type,:material_ids,:creat_time)";
                break;
            case 'edit':
                $sql = "update  ".$tab_suffix."servicematerials set 
					service_type = :service_type,
					material_ids = :material_ids
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
        if (strpos($sql,':material_ids')!==false)
            $command->bindParam(':material_ids',implode(',',$this->material_ids),PDO::PARAM_STR);
        if (strpos($sql,':creat_time')!==false)
            $command->bindParam(':creat_time',date('Y-m-d H:i:s', time()),PDO::PARAM_STR);
        $command->execute();

        if ($this->scenario=='new')
            $this->id = Yii::app()->db->getLastInsertID();
        return true;
    }
}