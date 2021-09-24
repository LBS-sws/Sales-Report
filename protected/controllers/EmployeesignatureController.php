<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/9/18
 * Time: 10:35
 */

class EmployeesignatureController extends Controller
{
    public $function_id='SS01';

    public function filters()
    {
        return array(
            'enforceRegisteredStation',
            'enforceSessionExpiration',
            'enforceNoConcurrentLogin',
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function actionIndex($pageNum=0)
    {
        $model = new Employeesignature();
        if (isset($_POST['Employeesignature'])) {
            $model->attributes = $_POST['Employeesignature'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['employeesignature_ss01']) && !empty($session['employeesignature_ss01'])) {
                $materiallist = $session['employeesignature_ss01'];
                $model->setCriteria($materiallist);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index',array('model'=>$model));
    }
    public function actionNew()
    {
        $model = new Employeesignature('new');
        //当前城市员工列表
        $se_suffix = Yii::app()->params['envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
        $sql = "select s.StaffID,s.StaffName,b.name city_name from staff  as s left join officecity as o on o.City = s.City left join enums as e on e.EnumID = o.Office left join security".$se_suffix.".sec_city as b on e.Text=b.code where  e.EnumType=8 and s.Status in('1,2,5') and e.Text in(".$city_allow.")";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        $employee_lists = [];
        foreach ($rows as $row) {
            $employee_lists[$row['StaffID']] = $row['StaffName']."(".$row['city_name'].")";
        }
        $this->render('form',array('model'=>$model,'employee_lists'=>$employee_lists));
    }

    public function actionSave()
    {
        if (isset($_POST['Employeesignature'])) {
            $model = new Employeesignature($_POST['Employeesignature']['scenario']);
            $model->attributes = $_POST['Employeesignature'];
            if ($model->validate()) {
                $file = CUploadedFile::getInstance($model,'signature');
                if ($file) {
                    $model->signature_file_type = $file->type;
                    $content = file_get_contents($file->tempName);
                    $model->signature = "data:image/jpg;base64,".base64_encode($content);
                } else {
                    $model->signature_file_type = '';
                    $model->signature = '';
                }
                //查询是否存在
                $sql = "select e.Text from staff  as s left join officecity as o on o.City = s.City left join enums as e on e.EnumID = o.Office where  e.EnumType=8 and s.StaffID =".$model->staffid;
                $row = Yii::app()->db->createCommand($sql)->queryRow();
                $city = $row['Text'];
                $tab_suffix = Yii::app()->params['table_envSuffix'];
                $sql_e = "select * from ".$tab_suffix."employee_signature where city='".$city."' and staffid=".$model->staffid;
                $row_e = Yii::app()->db->createCommand($sql_e)->queryRow();
                if ($row_e){
                    $result = Yii::app()->db->createCommand()->update($tab_suffix .'employee_signature', array('signature' => $model->signature), 'id=:id', array(':id' => $row_e['id']));
                    $id = $model->id;
                }else{

                    $result = Yii::app()->db->createCommand()->insert($tab_suffix .'employee_signature', array('city' => $city,'staffid' => $model->staffid,'signature'=>$model->signature,'creat_time'=>date('Y-m-d H:i:s', time())));
                    $id = Yii::app()->db->getLastInsertID();
                }
                if ($result) {
                    Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
                    $this->redirect(Yii::app()->createUrl('employeesignature/edit',array('index'=>$id)));
                } else {
                    Dialog::message(Yii::t('dialog','Validation Message'), Yii::t('dialog','Save no Done'));
                    $this->redirect(Yii::app()->createUrl('employeesignature/edit',array('index'=>$id)));
                }
            } else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog','Validation Message'), $message);
                $this->render('form',array('model'=>$model,));
            }
        }
    }
    public function actionDelete()
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $de = Yii::app()->db->createCommand()->delete($tab_suffix .'employee_signature', 'id=:id', array(':id' => $_POST['Employeesignature']['id']));
        if ($de) {
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Submission Done'));
            $this->redirect(Yii::app()->createUrl('employeesignature/index'));
        } else {
            Dialog::message(Yii::t('dialog','Validation Message'), Yii::t('dialog','Save no Done'));
            $this->redirect(Yii::app()->createUrl('employeesignature/index'));
        }
    }
    public function actionEdit($index)
    {
        $model = new Employeesignature('edit');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $se_suffix = Yii::app()->params['envSuffix'];
            $city_allow = Yii::app()->user->city_allow();
            $sql = "select s.StaffID,s.StaffName,b.name city_name from staff  as s left join officecity as o on o.City = s.City left join enums as e on e.EnumID = o.Office left join security".$se_suffix.".sec_city as b on e.Text=b.code where  e.EnumType=8 and s.Status in('1,2,5') and e.Text in(".$city_allow.")";
            $rows = Yii::app()->db->createCommand($sql)->queryAll();
            $employee_lists = [];
            foreach ($rows as $row) {
                $employee_lists[$row['StaffID']] = $row['StaffName']."(".$row['city_name'].")";
            }
            $this->render('form',array('model'=>$model,'employee_lists'=>$employee_lists));
        }
    }
}