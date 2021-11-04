<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/9/18
 * Time: 10:40
 */

class EmployeesignatureFrom extends CFormModel
{  /**
 * Declares customized attribute labels.
 * If not declared here, an attribute would have a label that is
 * the same as its name with the first letter in upper case.
 */
    public $id = 0;
    public $city;
    public $city_name;
    public $staffid;
    public $signature;
    public $signature_file_type;
    public $creat_time;

    public function attributeLabels()
    {
        return array(
            'id'=>Yii::t('employeesignature','id'),
            'city_name'=>Yii::t('employeesignature','City_name'),
            'city'=>Yii::t('employeesignature','City'),
            'staffid'=>Yii::t('employeesignature','Staff_Id'),
            'staffname'=>Yii::t('employeesignature','Staff_name'),
            'signature'=>Yii::t('employeesignature','Signature'),
            'creat_time'=>Yii::t('employeesignature','Creat_time'),
        );
    }
    public function rules()
    {
        return array(
            array('id,city,city_name,staffid,creat_time','safe'),
            array('staffid,signature','required'),
        );
    }
    function retrieveData($index) {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
        $rows = Yii::app()->db->createCommand()->select("*")
            ->from($tab_suffix."employee_signature")->where("id=:id",array(":id"=>$index))->queryAll();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $this->id = $row['id'];
                $this->city = $row['city'];
                $this->staffid = $row['staffid'];
                $this->signature = $row['signature'];
                $this->creat_time = $row['creat_time'];
                break;
            }
        }
        return true;
    }
    public function getSignatureString() {
        $rtn = '';
        if (!empty($this->signature)) {
            $type = ($this->signature_file_type=='jpg') ? 'jpeg' : $this->signature_file_type;
            $rtn = "data:image/$type;base64,".$this->signature;
        }
        return $rtn;
    }
    public function saveData()
    {
        $connection = Yii::app()->db;
        $transaction=$connection->beginTransaction();
        try {
            $this->saveEmployeesignature($connection);
            $transaction->commit();
        }
        catch(Exception $e) {
            $transaction->rollback();
            throw new CHttpException(404,'Cannot update. ('.$e->getMessage().')');
        }
    }
    protected function saveEmployeesignature(&$connection)
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $sql = '';
        switch ($this->scenario) {
            case 'delete':
                $sql = "delete from ".$tab_suffix."employee_signature where id = :id";
                break;
            case 'new':
                $sql = "insert into ".$tab_suffix."employee_signature(
                        city,staffid, signature,creat_time) values (
						:city,:staffid, :signature,:creat_time)";
                break;
            case 'edit':
                $sql = "update  ".$tab_suffix."employee_signature set 
					city = :city,
					staffid = :staffid,
					signature = :signature
					where id = :id";
                break;
        }
        //查询是否存在
        $sql1 = "select e.Text from staff  as s left join officecity as o on o.City = s.City left join enums as e on e.EnumID = o.Office where  e.EnumType=8 and s.StaffID =".$this->staffid;
        $row = Yii::app()->db->createCommand($sql1)->queryRow();
        $city = $row['Text'];
        $command=$connection->createCommand($sql);
        if (strpos($sql,':id')!==false)
            $command->bindParam(':id',$this->id,PDO::PARAM_INT);
        if (strpos($sql,':city')!==false)
            $command->bindParam(':city',$this->city?$this->city:$city,PDO::PARAM_STR);
        if (strpos($sql,':staffid')!==false)
            $command->bindParam(':staffid',$this->staffid,PDO::PARAM_STR);
        if (strpos($sql,':signature')!==false)
            $command->bindParam(':signature',$this->signature,PDO::PARAM_STR);
        if (strpos($sql,':creat_time')!==false)
            $command->bindParam(':creat_time',date('Y-m-d H:i:s', time()),PDO::PARAM_STR);
        $command->execute();

        if ($this->scenario=='new')
            $this->id = Yii::app()->db->getLastInsertID();
        return true;
    }
}