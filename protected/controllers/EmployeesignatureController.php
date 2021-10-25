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
    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('new','edit','delete','save'),
                'expression'=>array('EmployeesignatureController','allowReadWrite'),
            ),
            array('allow',
                'actions'=>array('index','view'),
                'expression'=>array('EmployeesignatureController','allowReadOnly'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionIndex($pageNum=0)
    {
        $model = new EmployeesignatureList();
        if (isset($_POST['EmployeesignatureList'])) {
            $model->attributes = $_POST['EmployeesignatureList'];
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
    public function actionView($index)
    {
        $model = new EmployeesignatureList('view');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $this->render('form',array('model'=>$model));
        }
    }
    public function actionNew()
    {
        $model = new EmployeesignatureFrom('new');
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
        if (isset($_POST['EmployeesignatureFrom'])) {
            $model = new EmployeesignatureFrom($_POST['EmployeesignatureFrom']['scenario']);
            $model->attributes = $_POST['EmployeesignatureFrom'];
            $file = CUploadedFile::getInstance($model,'signaturefile');
            if ($file) {
                $model->signature_file_type = $file->type;
                $content = file_get_contents($file->tempName);
                $model->signature = "data:image/jpg;base64,".base64_encode($content);
            }
            if ($model->validate()) {
                $model->saveData();
                $model->scenario = 'edit';
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
                //当前城市员工列表
                $se_suffix = Yii::app()->params['envSuffix'];
                $city_allow = Yii::app()->user->city_allow();
                $sql = "select s.StaffID,s.StaffName,b.name city_name from staff  as s left join officecity as o on o.City = s.City left join enums as e on e.EnumID = o.Office left join security".$se_suffix.".sec_city as b on e.Text=b.code where  e.EnumType=8 and s.Status in('1,2,5') and e.Text in(".$city_allow.")";
                $rows = Yii::app()->db->createCommand($sql)->queryAll();
                $employee_lists = [];
                foreach ($rows as $row) {
                    $employee_lists[$row['StaffID']] = $row['StaffName']."(".$row['city_name'].")";
                }
                $this->redirect(Yii::app()->createUrl('employeesignature/edit',array('index'=>$model->id,'employee_lists'=>$employee_lists)));
            } else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog','Validation Message'), $message);
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
        }
    }
    public function actionDelete()
    {
        $model = new EmployeesignatureFrom('delete');
        if (isset($_POST['EmployeesignatureFrom'])) {
            $model->attributes = $_POST['EmployeesignatureFrom'];
            $model->saveData();
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
        }
//		$this->actionIndex();
        $this->redirect(Yii::app()->createUrl('employeesignature/index'));
    }
    public function actionEdit($index)
    {
        $model = new EmployeesignatureFrom('edit');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
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
    }
    public static function allowReadWrite() {
        return Yii::app()->user->validRWFunction('SS01');
    }

    public static function allowReadOnly() {
        return Yii::app()->user->validFunction('SS01');
    }
}