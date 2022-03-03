<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/9/18
 * Time: 10:40
 */

class CitylaunchdateFrom extends CFormModel
{  /**
 * Declares customized attribute labels.
 * If not declared here, an attribute would have a label that is
 * the same as its name with the first letter in upper case.
 */
    public $id = 0;
    public $city;
    public $city_name;
    public $launch_date;
    public $creat_time;
    public $signature;

    public function attributeLabels()
    {
        return array(
            'id'=>Yii::t('citylaunchdate','id'),
            'city_name'=>Yii::t('citylaunchdate','City_name'),
            'city'=>Yii::t('citylaunchdate','City'),
            'launch_date'=>Yii::t('citylaunchdate','Launch_date'),
            'creat_time'=>Yii::t('citylaunchdate','Creat_time'),
        );
    }
    public function rules()
    {
        return array(
            array('id,city,city_name,launch_date,creat_time','safe'),
            array('launch_date,city','required'),
            array('launch_date','date','allowEmpty'=>false,
                'format'=>array('yyyy/MM/dd','yyyy-MM-dd','yyyy/M/d','yyyy-M-d',),
            ),
        );
    }
    function retrieveData($index) {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
        $rows = Yii::app()->db->createCommand()->select("*")
            ->from($tab_suffix."city_launch_date")->where("id=:id",array(":id"=>$index))->queryAll();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $this->id = $row['id'];
                $this->city = $row['city'];
                $this->launch_date = $row['launch_date'];
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
            $this->saveCitylaunchdate($connection);
            $transaction->commit();
        }
        catch(Exception $e) {
            $transaction->rollback();
            throw new CHttpException(404,'Cannot update. ('.$e->getMessage().')');
        }
    }
    protected function saveCitylaunchdate(&$connection)
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];

        $sql = '';
        switch ($this->scenario) {
            case 'delete':
                $sql = "delete from ".$tab_suffix."city_launch_date where id = :id";
                break;
            case 'new':
                $sql = "insert into ".$tab_suffix."city_launch_date(
                        city,launch_date,creat_time) values (
						:city,:launch_date,:creat_time)";
                break;
            case 'edit':
                $sql = "update  ".$tab_suffix."city_launch_date set 
					city = :city,
					launch_date = :launch_date
					where id = :id";
                break;
        }
        $command=$connection->createCommand($sql);
        if (strpos($sql,':id')!==false)
            $command->bindParam(':id',$this->id,PDO::PARAM_INT);
        if (strpos($sql,':city')!==false)
            $command->bindParam(':city',$this->city,PDO::PARAM_STR);
        if (strpos($sql,':launch_date')!==false)
            $command->bindParam(':launch_date',$this->launch_date,PDO::PARAM_STR);
        if (strpos($sql,':creat_time')!==false)
            $command->bindParam(':creat_time',date('Y-m-d H:i:s', time()),PDO::PARAM_STR);
        $command->execute();

        if ($this->scenario=='new')
            $this->id = Yii::app()->db->getLastInsertID();
        return true;
    }
}