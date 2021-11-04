<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/10/21
 * Time: 15:18
 */

class RiskpestFrom extends CFormModel
{
    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public $id = 0;
    public $city;
    public $city_name;
    public $target;
    public $creat_time;
    public function attributeLabels()
    {
        return array(
            'city'=>Yii::t('risk','City'),
            'city_name'=>Yii::t('risk','City_name'),
            'target'=>Yii::t('risk','Target'),
            'id'=>Yii::t('risk','id'),
            'creat_time'=>Yii::t('risk','Creat_time'),
        );
    }
    public function rules()
    {
        return array(
            array('id,city,city_name,creat_time','safe'),
            array('target','required'),
        );
    }
    function retrieveData($index) {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
        $rows = Yii::app()->db->createCommand()->select("*")
            ->from($tab_suffix."risk_target_lists")->where("id=:id and city in($city_allow)",array(":id"=>$index))->queryAll();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $this->id = $row['id'];
                $this->target = $row['target'];
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
            $this->Riskpest($connection);
            $transaction->commit();
        }
        catch(Exception $e) {
            $transaction->rollback();
            throw new CHttpException(404,'Cannot update. ('.$e->getMessage().')');
        }
    }
    protected function Riskpest(&$connection)
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $sql = '';
        switch ($this->scenario) {
            case 'delete':
                $sql = "delete from ".$tab_suffix."risk_target_lists where id = :id";
                break;
            case 'new':
                $sql = "insert into ".$tab_suffix."risk_target_lists(
                        target,city,creat_time) values (
						:target,:city,:creat_time)";
                break;
            case 'edit':
                $sql = "update  ".$tab_suffix."risk_target_lists set 
					target = :target 
					where id = :id";
                break;
        }
        $command=$connection->createCommand($sql);
        if (strpos($sql,':id')!==false)
            $command->bindParam(':id',$this->id,PDO::PARAM_INT);
        if (strpos($sql,':target')!==false)
            $command->bindParam(':target',$this->target,PDO::PARAM_STR);
        if (strpos($sql,':city')!==false)
            $command->bindParam(':city',Yii::app()->user->city(),PDO::PARAM_STR);
        if (strpos($sql,':creat_time')!==false)
            $command->bindParam(':creat_time',date('Y-m-d H:i:s', time()),PDO::PARAM_STR);
        $command->execute();

        if ($this->scenario=='new')
            $this->id = Yii::app()->db->getLastInsertID();
        return true;
    }
}