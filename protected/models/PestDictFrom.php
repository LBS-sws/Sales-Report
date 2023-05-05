<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/10/22
 * Time: 17:15
 */

class PestDictFrom extends CFormModel
{
    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */

    public $id = 0;
    //城市
    public $city;
    public $city_name;
    //飞虫名称
    public $type_id = 0;
    public $type_name;
    //启用flag
    public $insect_name;
    public $analysis_result;
    public $suggestion;
    public $measure;
    public $disabled_flag = 0;
    public $created_at;
    public $updated_at;
    /**
     * @var string
     */
    private $delete_flag;
    /**
     * @var mixed
     */
    private $deleted_at;

    /**
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
    `city` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '城市',
    `type_id` int(11) DEFAULT NULL COMMENT '类型id（1，昆虫；2，老鼠）',
    `insect_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '飞虫名称',
    `analysis_result` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '分析结果',
    `suggestion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '建议',
    `measure` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '措施',
    `enabled_flag` tinyint(1) DEFAULT '1' COMMENT '启用flag',
    `disabled_flag` tinyint(1) DEFAULT '0' COMMENT '禁用flag',
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
    `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
    `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
     * */
    public function attributeLabels()
    {
        return array(
            'id'=>Yii::t('pestdict','id'),
            'city'=>Yii::t('pestdict','city'),
            'type_id'=>Yii::t('pestdict','type_id'),
            'type_name'=>Yii::t('pestdict','type_name'),
            'insect_name'=>Yii::t('pestdict','insect_name'),
            'analysis_result'=>Yii::t('pestdict','analysis_result'),
            'suggestion'=>Yii::t('pestdict','suggestion'),
            'measure'=>Yii::t('pestdict','measure'),
            'disabled_flag'=>Yii::t('pestdict','disabled_flag'),
            'created_at'=>Yii::t('pestdict','created_at'),
            'updated_at'=>Yii::t('pestdict','updated_at'),
            'deleted_at'=>Yii::t('pestdict','deleted_at'),
        );
    }
    public function rules()
    {
        return array(
            array('id,city,type_id,type_name,insect_name,analysis_result,suggestion,measure,delete_flag,created_at','safe'),
//            array('type_id','required'),
        );
    }
    function retrieveData($index) {
        $city_allow = Yii::app()->user->city_allow();
        $rows = Yii::app()->db->createCommand()->select("*")
            ->from('lbs_pest_dict')->where("id=:id and city in($city_allow)",array(":id"=>$index))->queryAll();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $this->id = $row['id'];
                $this->type_id = $row['type_id'];
                $this->type_name = $row['city'];
                $this->insect_name = $row['insect_name'];
                $this->analysis_result = $row['analysis_result'];
                $this->suggestion = $row['suggestion'];
                $this->measure = $row['measure'];
                $this->delete_flag = $row['delete_flag']?'否':'是';
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
            $this->pestdict($connection);
            $transaction->commit();
        }
        catch(Exception $e) {
            $transaction->rollback();
            throw new CHttpException(404,'Cannot update. ('.$e->getMessage().')');
        }
    }
    protected function pestdict(&$connection)
    {
        $sql = '';
        switch ($this->scenario) {
            case 'delete':
                $sql = "delete from lbs_pest_dict where id = :id";
                break;
            case 'new':
                $sql = "insert into lbs_pest_dict(
                        city,type_id,insect_name,analysis_result,suggestion,measure,created_at) values (
						:city,:type_id,:insect_name,:analysis_result,:suggestion,:measure,:created_at)";
                break;
            case 'edit':
                $sql = "update lbs_pest_dict set type_id=:type_id,insect_name=:insect_name,analysis_result=:analysis_result,suggestion =:suggestion,measure=:measure,updated_at=:updated_at
    where id = :id";
                break;
        }
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
//        var_dump($this->type_name);exit();
        $command=$connection->createCommand($sql);
        if (strpos($sql,':id')!==false)
            $command->bindParam(':id',$this->id,PDO::PARAM_INT);
        if (strpos($sql,':city')!==false)
            $command->bindParam(':city',Yii::app()->user->city(),PDO::PARAM_STR);
        if (strpos($sql,':type_id')!==false)
            $command->bindParam(':type_id',intval($this->type_id),PDO::PARAM_INT);
        if (strpos($sql,':insect_name')!==false)
            $command->bindParam(':insect_name',$this->insect_name,PDO::PARAM_STR);
        if (strpos($sql,':analysis_result')!==false)
            $command->bindParam(':analysis_result',$this->analysis_result,PDO::PARAM_STR);
        if (strpos($sql,':suggestion')!==false)
            $command->bindParam(':suggestion',$this->suggestion,PDO::PARAM_STR);
        if (strpos($sql,':measure')!==false)
            $command->bindParam(':measure',$this->measure,PDO::PARAM_STR);
        if (strpos($sql,':updated_at')!==false)
            $command->bindParam(':updated_at',$this->updated_at,PDO::PARAM_STR);
        if (strpos($sql,':created_at')!==false)
            $command->bindParam(':created_at',$this->created_at,PDO::PARAM_STR);
//        var_dump($command);exit();
        $command->execute();
        if ($this->scenario=='new')
            $this->id = Yii::app()->db->getLastInsertID();
        return true;
    }


}