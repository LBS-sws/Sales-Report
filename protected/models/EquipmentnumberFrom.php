<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/10/22
 * Time: 17:51
 */

class EquipmentnumberFrom extends CFormModel
{
    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public $id = 0;
    public $city;
    public $city_name;
    public $name;
    public $eq_type_id;
    public $equipment_number;
    public $status;
    public $downcount;
    public $creat_time;
    public $number;

    public function attributeLabels()
    {
        return array(
            'id'=>Yii::t('equipment','id'),
            'city_name'=>Yii::t('equipment','City_name'),
            'city'=>Yii::t('equipment','City'),
            'eq_type_id'=>Yii::t('equipment','Eq_type_id'),
            'equipment_number'=>Yii::t('equipment','Equipment_number'),
            'name'=>Yii::t('equipment','Name'),
            'status'=>Yii::t('equipment','Status'),
            'downcount'=>Yii::t('equipment','Downcount'),
            'creat_time'=>Yii::t('equipment','Creat_time'),
            'number'=>Yii::t('equipment','Number'),
        );
    }
    public function rules()
    {
        return array(
            array('id,city,city_name,creat_time','safe'),
            array('eq_type_id,number','required'),
        );
    }
    public function saveData()
    {
        $connection = Yii::app()->db;
        $transaction=$connection->beginTransaction();
        try {
            if($this->scenario=='new'){
                $this->Addlist($connection);
            }else{
                $this->Equipmentnumber($connection);
            }

            $transaction->commit();
        }
        catch(Exception $e) {
            $transaction->rollback();
            throw new CHttpException(404,'Cannot update. ('.$e->getMessage().')');
        }
    }
    protected function Addlist(&$connection){
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $num_max = Yii::app()->db->createCommand()
            ->select('e.name,e.id,e.number_code,n.equipment_number')
            ->from($tab_suffix.'equipment_type e')
            ->leftjoin($tab_suffix.'equipment_numbers n', 'e.id=n.eq_type_id')
            ->where('e.id=:id', array(':id'=>$this->eq_type_id))
            ->order('n.equipment_number desc')
            ->queryRow();
        $st_num = str_replace($num_max['number_code'],'',$num_max['equipment_number']);
        $add['eq_type_id'] = $num_max['id'];
        $add['name'] = $num_max['name'];
        for($i=0 ;$i<$this->number;$i++){
            $num = $st_num+$i+1;
            $str_num = $num<10?str_pad($num,2,"0",STR_PAD_LEFT):$num;
            $add['equipment_number'] = $num_max['number_code'].$str_num;
            $add['creat_time'] = date('Y-m-d H:i:s', time());
            Yii::app()->db->createCommand()->insert($tab_suffix.'equipment_numbers',$add);
        }
    }

    protected function Equipmentnumber(&$connection)
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $sql = '';
        switch ($this->scenario) {
            case 'delete':
                $sql = "delete from ".$tab_suffix."equipment_type where id = :id";
                break;
            case 'new':
                $sql = "insert into ".$tab_suffix."equipment_type(
                        type,city,name,check_targt,check_handles,creat_time) values (
						:type,:city,:name,:check_targt,:check_handles,:creat_time)";
                break;
            case 'edit':
                $sql = "update  ".$tab_suffix."equipment_type set 
					type = :type,
					name = :name,
					check_targt = :check_targt,
					check_handles = :check_handles
					where id = :id";
                break;
        }
        $command=$connection->createCommand($sql);
        if (strpos($sql,':id')!==false)
            $command->bindParam(':id',$this->id,PDO::PARAM_INT);
        if (strpos($sql,':type')!==false)
            $command->bindParam(':type',$this->type,PDO::PARAM_STR);
        if (strpos($sql,':city')!==false)
            $command->bindParam(':city',Yii::app()->user->city(),PDO::PARAM_STR);
        if (strpos($sql,':name')!==false)
            $command->bindParam(':name',$this->name,PDO::PARAM_STR);
        if (strpos($sql,':check_targt')!==false)
            $command->bindParam(':check_targt',$this->check_targt,PDO::PARAM_STR);
        if (strpos($sql,':check_handles')!==false)
            $command->bindParam(':check_handles',$this->check_handles,PDO::PARAM_STR);
        if (strpos($sql,':creat_time')!==false)
            $command->bindParam(':creat_time',date('Y-m-d H:i:s', time()),PDO::PARAM_STR);
        $command->execute();

        if ($this->scenario=='new')
            $this->id = Yii::app()->db->getLastInsertID();
        return true;
    }
    public function retrieveDown($ids){
        $connection = Yii::app()->db;
        $transaction=$connection->beginTransaction();
        try {
            $tab_suffix = Yii::app()->params['table_envSuffix'];
            $lists = Yii::app()->db->createCommand()
                ->select('name,equipment_number')
                ->from($tab_suffix.'equipment_numbers e')
                ->Where(['in','id',$ids['id']])
                ->queryAll();
//            $update_sql="update ".$tab_suffix."equipment_numbers set downcount=1 where id=91";
            $update_sql="update ".$tab_suffix."equipment_numbers set downcount=downcount+1 where id in (".implode(',',$ids['id']).")";
            $update_lists = Yii::app()->db->createCommand($update_sql);

//            var_dump($update_sql,$update_lists);die();
            Yii::$enableIncludePath = false;
            $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel');
            spl_autoload_unregister(array('YiiBase','autoload'));
            include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
            $objPHPExcel = new PHPExcel;
            $objReader  = PHPExcel_IOFactory::createReader('Excel2007');
            $path = Yii::app()->basePath.'/commands/template/equipment.xlsx';
            $objPHPExcel = $objReader->load($path);
            $i=1;
            $objActSheet=$objPHPExcel->setActiveSheetIndex(0);
            foreach ($lists as $value){
                $i=$i+1;
                $objActSheet->setCellValue('A'.$i, $value['name']) ;
                $objActSheet->setCellValue('B'.$i, $value['equipment_number']) ;

            }
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            ob_start();
            $objWriter->save('php://output');
            $output = ob_get_clean();
            spl_autoload_register(array('YiiBase','autoload'));
            $time=time();
            $str="templates/EquipmentExcel_".$time.".xlsx";
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
            header("Content-Type:application/force-download");
            header("Content-Type:application/vnd.ms-execl");
            header("Content-Type:application/octet-stream");
            header("Content-Type:application/download");;
            header('Content-Disposition:attachment;filename="'.$str.'"');
            header("Content-Transfer-Encoding:binary");
            echo $output;

            $transaction->commit();
        }
        catch(Exception $e) {
            $transaction->rollback();
            throw new CHttpException(404,'Cannot update. ('.$e->getMessage().')');
        }
    }
}