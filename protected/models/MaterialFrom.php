<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/10/20
 * Time: 16:44
 */

class MaterialFrom extends CFormModel
{
    public $id;
    public $city;
    public $city_name;
    public $name;
    public $classify_id;
    public $classify;
    public $registration_no;
    public $validity;
    public $active_ingredient;
    public $ratio;
    public $brief;
    public $unit;
    public $sort;
    public $status;
    public $creat_time;
    public function attributeLabels()
    {
        return array(
            'id'=>Yii::t('material','ID'),
            'city'=>Yii::t('material','City'),
            'city_name'=>Yii::t('material','City_name'),
            'name'=>Yii::t('material','Name'),
            'classify_id'=>Yii::t('material','Classify'),
            'classify'=>Yii::t('material','Classify'),
            'registration_no'=>Yii::t('material','Registration_no'),
            'validity'=>Yii::t('material','Validity'),
            'active_ingredient'=>Yii::t('material','Active_ingredient'),
            'ratio'=>Yii::t('material','Ratio'),
            'brief'=>Yii::t('material','Brief'),
            'unit'=>Yii::t('material','Unit'),
            'sort'=>Yii::t('material','Sort'),
            'status'=>Yii::t('material','Status'),
            'creat_time'=>Yii::t('material','Creat_time'),
        );
    }
    public function rules()
    {
        return array(
            array('id,city,city_name,classify_id,classify,registration_no,validity,active_ingredient,active_ingredient,ratio,brief,status,creat_time','safe'),
            array('name,classify_id,unit,sort','required'),
            array('sort','numerical'),
        );
    }
    function retrieveData($index) {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
        $rows = Yii::app()->db->createCommand()->select("*")
            ->from($tab_suffix."material_lists")->where("id=:id",array(":id"=>$index))->queryAll();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $this->id = $row['id'];
                $this->name = $row['name'];
                $this->classify_id = $row['classify_id'];
                $this->registration_no = $row['registration_no'];
                $this->validity = $row['validity'];
                $this->active_ingredient = $row['active_ingredient'];
                $this->ratio = $row['ratio'];
                $this->brief = $row['brief'];
                $this->unit = $row['unit'];
                $this->sort = $row['sort'];
                $this->status = $row['status'];
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
            $this->saveMaterial($connection);
            $transaction->commit();
        }
        catch(Exception $e) {
            $transaction->rollback();
            throw new CHttpException(404,'Cannot update. ('.$e->getMessage().')');
        }
    }
    protected function saveMaterial(&$connection)
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $sql = '';
        switch ($this->scenario) {
            case 'delete':
                $sql = "delete from ".$tab_suffix."material_lists where id = :id";
                break;
            case 'new':
                $sql = "insert into ".$tab_suffix."material_lists(
                        name,classify_id, registration_no, validity, active_ingredient,ratio,brief,unit,status,sort,creat_time) values (
						:name,:classify_id, :registration_no, :validity, :active_ingredient,:ratio,:brief,:unit,:status,:sort,:creat_time)";
                break;
            case 'edit':
                $sql = "update  ".$tab_suffix."material_lists set 
					name = :name,
					classify_id = :classify_id,
					registration_no = :registration_no, 
					validity = :validity,
					active_ingredient = :active_ingredient,
					ratio = :ratio,
					brief = :brief,
					unit = :unit, 
					status = :status, 
					sort = :sort
					where id = :id";
                break;
        }
        $command=$connection->createCommand($sql);
        if (strpos($sql,':id')!==false)
            $command->bindParam(':id',$this->id,PDO::PARAM_INT);
        if (strpos($sql,':name')!==false)
            $command->bindParam(':name',$this->name,PDO::PARAM_STR);
        if (strpos($sql,':classify_id')!==false)
            $command->bindParam(':classify_id',$this->classify_id,PDO::PARAM_STR);
        if (strpos($sql,':registration_no')!==false)
            $command->bindParam(':registration_no',$this->registration_no,PDO::PARAM_STR);
        if (strpos($sql,':validity')!==false)
            $command->bindParam(':validity',$this->validity,PDO::PARAM_STR);
        if (strpos($sql,':active_ingredient')!==false)
            $command->bindParam(':active_ingredient',$this->active_ingredient,PDO::PARAM_STR);
        if (strpos($sql,':ratio')!==false)
            $command->bindParam(':ratio',$this->ratio,PDO::PARAM_STR);
        if (strpos($sql,':brief')!==false)
            $command->bindParam(':brief',$this->brief,PDO::PARAM_STR);
        if (strpos($sql,':unit')!==false)
            $command->bindParam(':unit',$this->unit,PDO::PARAM_STR);
        if (strpos($sql,':status')!==false)
            $command->bindParam(':status',$this->status,PDO::PARAM_STR);
        if (strpos($sql,':sort')!==false)
            $command->bindParam(':sort',$this->sort,PDO::PARAM_STR);
        if (strpos($sql,':creat_time')!==false)
            $command->bindParam(':creat_time',date('Y-m-d h:i:s', time()),PDO::PARAM_STR);
        $command->execute();

        if ($this->scenario=='new')
            $this->id = Yii::app()->db->getLastInsertID();
        return true;
    }

}