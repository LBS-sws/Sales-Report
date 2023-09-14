<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/10/22
 * Time: 17:33
 */

class ShortcutcontentFrom extends CFormModel
{
    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public $id = 0;
    public $city_name;
    public $service_name;
    public $shortcut_id;
    public $shortcut_name;
    public $content;
    public $creat_time;
    public function attributeLabels()
    {
        return array(
            'city'=>Yii::t('shortcut','City'),
            'city_name'=>Yii::t('shortcut','City_name'),
            'shortcut_id'=>Yii::t('shortcut','Shortcut_name'),
            'service_name'=>Yii::t('shortcut','Service_name'),
            'shortcut_name'=>Yii::t('shortcut','Shortcut_name'),
            'content'=>Yii::t('shortcut','Content'),
            'id'=>Yii::t('shortcut','id'),
            'creat_time'=>Yii::t('shortcut','Creat_time'),
        );
    }
    public function rules()
    {
        return array(
            array('id,city,city_name,shortcut_id,service_name,shortcut_name,creat_time','safe'),
            array('shortcut_id,content','required'),
        );
    }
    function retrieveData($index) {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
        $rows = Yii::app()->db->createCommand()->select("*")
            ->from($tab_suffix."shortcut_contents")->where("id=:id",array(":id"=>$index))->queryAll();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                $this->id = $row['id'];
                $this->shortcut_id = $row['shortcut_id'];
                $this->content = $row['content'];
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
            $this->Shortcutcontent($connection);
            $transaction->commit();
        }
        catch(Exception $e) {
            $transaction->rollback();
            throw new CHttpException(404,'Cannot update. ('.$e->getMessage().')');
        }
    }


    protected function Shortcutcontent(&$connection)
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $sql = '';
        switch ($this->scenario) {
            case 'delete':
                $sql = "delete from ".$tab_suffix."shortcut_contents where id = :id";
                break;
            case 'new':
                $sql = "insert into ".$tab_suffix."shortcut_contents(
                        shortcut_id,content,creat_time) values (
						:shortcut_id,:content,:creat_time)";
                break;
            case 'edit':
                $sql = "update  ".$tab_suffix."shortcut_contents set 
					shortcut_id = :shortcut_id,
					content = :content
					where id = :id";
                break;
        }
        $command=$connection->createCommand($sql);
        if (strpos($sql,':id')!==false)
            $command->bindParam(':id',$this->id,PDO::PARAM_INT);
        if (strpos($sql,':shortcut_id')!==false)
            $command->bindParam(':shortcut_id',$this->shortcut_id,PDO::PARAM_STR);
        if (strpos($sql,':content')!==false)
            $command->bindParam(':content',$this->content,PDO::PARAM_STR);
        if (strpos($sql,':creat_time')!==false)
            $command->bindParam(':creat_time',date('Y-m-d H:i:s', time()),PDO::PARAM_STR);
        $command->execute();

        if ($this->scenario=='new')
            $this->id = Yii::app()->db->getLastInsertID();
        return true;
    }


    public function deleteAllData()
    {
        $connection = Yii::app()->db;
        $transaction = $connection->beginTransaction();
        try {
            $tab_suffix = Yii::app()->params['table_envSuffix'];
            $city = Yii::app()->user->city();

            // 查询 lbs_service_shortcuts 表中的 id
            $sql_ids = "SELECT GROUP_CONCAT(id) as ids FROM " . $tab_suffix . "shortcuts WHERE city = :city";
            $command = $connection->createCommand($sql_ids);
            $command->bindParam(':city', $city, PDO::PARAM_STR);
            $result = $command->queryRow();
            $ids = $result['ids'];

            // 根据查询到的 id 删除 shortcut_contents 表中的数据
            $sql = "DELETE FROM " . $tab_suffix . "shortcut_contents WHERE shortcut_id IN ($ids)";
            $command = $connection->createCommand($sql);
            $command->execute();

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            throw new CHttpException(404, 'Cannot delete all data. (' . $e->getMessage() . ')');
        }
    }
}
