<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/10/21
 * Time: 15:51
 */

class RisklabelFrom extends CFormModel
{
    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public $id = 0;
    public $label;
    public $creat_time;
    public function attributeLabels()
    {
        return array(
            'label'=>Yii::t('risk','Label'),
            'id'=>Yii::t('risk','id'),
            'creat_time'=>Yii::t('risk','Creat_time'),
        );
    }
    public function rules()
    {
        return array(
            array('id,creat_time','safe'),
            array('label','required'),
        );
    }
    function retrieveData($index) {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
        $rows = Yii::app()->db->createCommand()->select("*")
            ->from($tab_suffix."risk_label_lists")->where("id=:id",array(":id"=>$index))->queryAll();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $this->id = $row['id'];
                $this->label = $row['label'];
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
            $this->Risklabel($connection);
            $transaction->commit();
        }
        catch(Exception $e) {
            $transaction->rollback();
            throw new CHttpException(404,'Cannot update. ('.$e->getMessage().')');
        }
    }
    protected function Risklabel(&$connection)
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $sql = '';
        switch ($this->scenario) {
            case 'delete':
                $sql = "delete from ".$tab_suffix."risk_label_lists where id = :id";
                break;
            case 'new':
                $sql = "insert into ".$tab_suffix."risk_label_lists(
                        label,creat_time) values (
						:label,:creat_time)";
                break;
            case 'edit':
                $sql = "update  ".$tab_suffix."risk_label_lists set 
					label = :label 
					where id = :id";
                break;
        }
        $command=$connection->createCommand($sql);
        if (strpos($sql,':id')!==false)
            $command->bindParam(':id',$this->id,PDO::PARAM_INT);
        if (strpos($sql,':label')!==false)
            $command->bindParam(':label',$this->label,PDO::PARAM_STR);
        if (strpos($sql,':creat_time')!==false)
            $command->bindParam(':creat_time',date('Y-m-d H:i:s', time()),PDO::PARAM_STR);
        $command->execute();

        if ($this->scenario=='new')
            $this->id = Yii::app()->db->getLastInsertID();
        return true;
    }
}