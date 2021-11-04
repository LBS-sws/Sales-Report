<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:45
 */

class ReportsectionController extends Controller
{
    public $function_id='OS07';

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
                'expression'=>array('ReportsectionController','allowReadWrite'),
            ),
            array('allow',
                'actions'=>array('index','view'),
                'expression'=>array('ReportsectionController','allowReadOnly'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    public function actionIndex($pageNum=0)
    {
        $model = new ReportsectionList();
        if (isset($_POST['ReportsectionList'])) {
            $model->attributes = $_POST['ReportsectionList'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['reportsection_os07']) && !empty($session['reportsection_os07'])) {
                $materiallist = $session['reportsection_os07'];
                $model->setCriteria($materiallist);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index',array('model'=>$model));
    }
    public function actionNew()
    {
        $model = new ReportsectionFrom('new');
        $sql = "select ServiceType,ServiceName from service where ServiceName is not null";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        $service_type_lists = [];
        foreach ($rows as $row) {
            $service_type_lists[$row['ServiceType']] = $row['ServiceName'];
        }
        $service_sections = ['1'=>'服务简报','2'=>'物料使用','3'=>'设备情况','4'=>'风险跟进','5'=>'现场工作照'];
        $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists,'service_sections'=>$service_sections));
    }
    public function actionSave()
    {
        if (isset($_POST['ReportsectionFrom'])) {
            $model = new ReportsectionFrom($_POST['ReportsectionFrom']['scenario']);
            $model->attributes = $_POST['ReportsectionFrom'];
            if ($model->validate()) {
                $model->saveData();
                $model->scenario = 'edit';
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
                $sql = "select ServiceType,ServiceName from service where ServiceName is not null";
                $rows = Yii::app()->db->createCommand($sql)->queryAll();
                $service_type_lists = [];
                foreach ($rows as $row) {
                    $service_type_lists[$row['ServiceType']] = $row['ServiceName'];
                }
                $service_sections = ['1'=>'服务简报','2'=>'物料使用','3'=>'设备情况','4'=>'风险跟进','5'=>'现场工作照'];
                $this->redirect(Yii::app()->createUrl('reportsection/edit',array('index'=>$model->id,'service_type_lists'=>$service_type_lists,'service_sections'=>$service_sections)));
            } else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog','Validation Message'), $message);
                $sql = "select ServiceType,ServiceName from service where ServiceName is not null";
                $rows = Yii::app()->db->createCommand($sql)->queryAll();
                $service_type_lists = [];
                foreach ($rows as $row) {
                    $service_type_lists[$row['ServiceType']] = $row['ServiceName'];
                }
                $service_sections = ['1'=>'服务简报','2'=>'物料使用','3'=>'设备情况','4'=>'风险跟进','5'=>'现场工作照'];
                $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists,'service_sections'=>$service_sections));
            }
        }
    }
    public function actionDelete()
    {
        $model = new ReportsectionFrom('delete');
        if (isset($_POST['ReportsectionFrom'])) {
            $model->attributes = $_POST['ReportsectionFrom'];
            $model->saveData();
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
        }
//		$this->actionIndex();
        $this->redirect(Yii::app()->createUrl('reportsection/index'));
    }
    public function actionEdit($index)
    {
        $model = new ReportsectionFrom('edit');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $sql = "select ServiceType,ServiceName from service where ServiceName is not null";
            $rows = Yii::app()->db->createCommand($sql)->queryAll();
            $service_type_lists = [];
            foreach ($rows as $row) {
                $service_type_lists[$row['ServiceType']] = $row['ServiceName'];
            }
            $service_sections = ['1'=>'服务简报','2'=>'物料使用','3'=>'设备情况','4'=>'风险跟进','5'=>'现场工作照'];
            $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists,'service_sections'=>$service_sections));
        }
    }
    public static function allowReadWrite() {
        return Yii::app()->user->validRWFunction('OS07');
    }

    public static function allowReadOnly() {
        return Yii::app()->user->validFunction('OS07');
    }
}