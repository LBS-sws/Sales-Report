<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/10/22
 * Time: 17:15
 */

class PestTypeFrom extends CFormModel
{
    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */

    public $id = 0;
    //城市
    public $city_name;
    public $city;
    //飞虫名称
    public $type_name;
    //启用flag
    public $enabled_flag;
    public $delete_flag = 0;
    public $created_at;
    public $updated_at;
    public $deleted_at;
    public $city_allow = "CN";
    /**
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
    `city` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '城市',
    `type_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '飞虫名称',
    `enabled_flag` tinyint(1) DEFAULT '1' COMMENT '启用flag',
    `delete_flag` tinyint(1) DEFAULT '0' COMMENT '禁用flag',
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
    `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
    `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
     * */
    public function attributeLabels()
    {
        return array(
            'id'=>Yii::t('pesttype','id'),
            'city_name'=>Yii::t('pesttype','city_name'),
            'type_name'=>Yii::t('pesttype','type_name'),
            'enabled_flag'=>Yii::t('pesttype','enabled_flag'),
            'delete_flag'=>Yii::t('pesttype','delete_flag'),
            'created_at'=>Yii::t('pesttype','created_at'),
            'updated_at'=>Yii::t('pesttype','updated_at'),
            'deleted_at'=>Yii::t('pesttype','deleted_at'),
        );
    }
    public function rules()
    {
        return array(
            array('id,city,city_name,type_name,delete_flag,created_at','safe'),
            array('type_name','required'),
        );
    }
    function retrieveData($index) {
//        $city_allow = 'CN';//Yii::app()->user->city_allow();
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $rows = Yii::app()->db->createCommand()->select("*")
            ->from('lbs_pest_type')->where("id=:id and city = '".$this->city_allow."'",array(":id"=>$index))->queryAll();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $this->id = $row['id'];
                $this->city = $row['city'];
                $this->type_name = $row['type_name'];
                $this->delete_flag = $row['delete_flag'];
                $this->created_at = $row['created_at'];
                $this->updated_at = $row['updated_at'];
                $this->deleted_at = $row['deleted_at'];
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
            $this->pesttype($connection);
            $transaction->commit();
        }
        catch(Exception $e) {
            $transaction->rollback();
            throw new CHttpException(404,'Cannot update. ('.$e->getMessage().')');
        }
    }
    protected function pesttype(&$connection)
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $sql = '';
        switch ($this->scenario) {
            case 'delete':
                $sql = "delete from lbs_pest_type where id = :id";
                break;
            case 'new':
                $sql = "insert into lbs_pest_type(
                        city,type_name,created_at) values (
						:city,:type_name,:created_at)";
                break;
            case 'edit':
                $sql = "update lbs_pest_type set 
					city = :city,
					type_name = :type_name,
					updated_at = :updated_at
					where id = :id";
                break;
        }
        $this->updated_at = date('Y-m-d H:i:s');
        $this->created_at = date('Y-m-d H:i:s');
        $command=$connection->createCommand($sql);
        if (strpos($sql,':id')!==false)
            $command->bindParam(':id',$this->id,PDO::PARAM_INT);
        if (strpos($sql,':city')!==false)
            $command->bindParam(':city',$this->city_allow,PDO::PARAM_STR);
        if (strpos($sql,':type_name')!==false)
            $command->bindParam(':type_name',$this->type_name,PDO::PARAM_STR);
//        if (strpos($sql,':delete_flag')!==false)
//            $command->bindParam(':delete_flag',$this->delete_flag,PDO::PARAM_STR);
        if (strpos($sql,':updated_at')!==false)
            $command->bindParam(':updated_at',$this->updated_at,PDO::PARAM_STR);
        if (strpos($sql,':created_at')!==false)
            $command->bindParam(':created_at',$this->created_at,PDO::PARAM_STR);
        $command->execute();
        if ($this->scenario=='new')
            $this->id = Yii::app()->db->getLastInsertID();
        return true;
    }
}
