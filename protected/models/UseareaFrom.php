<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/10/25
 * Time: 10:29
 */

class UseareaFrom extends CFormModel
{
    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public $id = 0;
    public $city;
    public $city_name;
    public $area_type;
    public $use_area;
    public $creat_time;
    public function attributeLabels()
    {
        return array(
            'id'=>Yii::t('usearea','id'),
            'city'=>Yii::t('usearea','City'),
            'city_name'=>Yii::t('equipment','City_name'),
            'area_type'=>Yii::t('usearea','Area_type'),
            'use_area'=>Yii::t('usearea','Use_area'),
            'creat_time'=>Yii::t('usearea','Creat_time'),
        );
    }
    public function rules()
    {
        return array(
            array('id,city,city_name,creat_time','safe'),
            array('area_type,use_area','required'),
        );
    }
    function retrieveData($index) {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
        $rows = Yii::app()->db->createCommand()->select("*")
            ->from($tab_suffix."use_areas")->where("id=:id",array(":id"=>$index))->queryAll();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $this->id = $row['id'];
                $this->city = $row['city'];
                $this->area_type = $row['area_type'];
                $this->use_area = $row['use_area'];
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
            $this->Usearea($connection);
            $transaction->commit();
        }
        catch(Exception $e) {
            $transaction->rollback();
            throw new CHttpException(404,'Cannot update. ('.$e->getMessage().')');
        }
    }
    protected function Usearea(&$connection)
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $sql = '';
        switch ($this->scenario) {
            case 'delete':
                $sql = "delete from ".$tab_suffix."use_areas where id = :id";
                break;
            case 'new':
                $sql = "insert into ".$tab_suffix."use_areas(
                        city,area_type,use_area,creat_time) values (
						:city,:area_type,:use_area,:creat_time)";
                break;
            case 'edit':
                $sql = "update  ".$tab_suffix."use_areas set 
					area_type = :area_type,
					use_area = :use_area
					where id = :id";
                break;
        }
        $command=$connection->createCommand($sql);
        if (strpos($sql,':id')!==false)
            $command->bindParam(':id',$this->id,PDO::PARAM_INT);
        if (strpos($sql,':city')!==false)
            $command->bindParam(':city',Yii::app()->user->city(),PDO::PARAM_STR);
        if (strpos($sql,':area_type')!==false)
            $command->bindParam(':area_type',$this->area_type,PDO::PARAM_STR);
        if (strpos($sql,':use_area')!==false)
            $command->bindParam(':use_area',$this->use_area,PDO::PARAM_STR);
        if (strpos($sql,':creat_time')!==false)
            $command->bindParam(':creat_time',date('Y-m-d h:i:s', time()),PDO::PARAM_STR);
        $command->execute();

        if ($this->scenario=='new')
            $this->id = Yii::app()->db->getLastInsertID();
        return true;
    }
}