<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:45
 */

class ServiceequipmentController extends Controller
{
    public $function_id='OS06';

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
                'expression'=>array('ServiceequipmentController','allowReadWrite'),
            ),
            array('allow',
                'actions'=>array('index','view'),
                'expression'=>array('ServiceequipmentController','allowReadOnly'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    public function actionIndex($pageNum=0)
    {
        $model = new ServiceequipmentList();
        if (isset($_POST['ServiceequipmentList'])) {
            $model->attributes = $_POST['ServiceequipmentList'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['serviceequipment_os06']) && !empty($session['serviceequipment_os06'])) {
                $materiallist = $session['serviceequipment_os06'];
                $model->setCriteria($materiallist);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index',array('model'=>$model));
    }
    public function actionNew()
    {
        $model = new ServiceequipmentFrom('new');
        $sql = "select ServiceType,ServiceName from service where ServiceName is not null";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        $service_type_lists = [];
        foreach ($rows as $row) {
            $service_type_lists[$row['ServiceType']] = $row['ServiceName'];
        }
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $city = Yii::app()->user->city();
        $sql1 = "select * from ".$tab_suffix."equipment_type where  city='".$city."'";
        $rows1 = Yii::app()->db->createCommand($sql1)->queryAll();
        $service_equipments = [];
        foreach ($rows1 as $row1) {
            $service_equipments[$row1['id']] = $row1['name'];
        }
        $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists,'service_equipments'=>$service_equipments));
    }
    public function actionSave()
    {
        if (isset($_POST['ServiceequipmentFrom'])) {
            $model = new ServiceequipmentFrom($_POST['ServiceequipmentFrom']['scenario']);
            $model->attributes = $_POST['ServiceequipmentFrom'];
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
                $tab_suffix = Yii::app()->params['table_envSuffix'];
                $city = Yii::app()->user->city();
                $sql1 = "select * from ".$tab_suffix."equipment_type where city='".$city."'";
                $rows1 = Yii::app()->db->createCommand($sql1)->queryAll();
                $service_equipments = [];
                foreach ($rows1 as $row1) {
                    $service_equipments[$row1['id']] = $row1['name'];
                }
                $this->redirect(Yii::app()->createUrl('serviceequipment/edit',array('index'=>$model->id,'service_type_lists'=>$service_type_lists,'service_equipments'=>$service_equipments)));
            } else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog','Validation Message'), $message);
                $sql = "select ServiceType,ServiceName from service where ServiceName is not null";
                $rows = Yii::app()->db->createCommand($sql)->queryAll();
                $service_type_lists = [];
                foreach ($rows as $row) {
                    $service_type_lists[$row['ServiceType']] = $row['ServiceName'];
                }
                $tab_suffix = Yii::app()->params['table_envSuffix'];
                $city = Yii::app()->user->city();
                $sql1 = "select * from ".$tab_suffix."equipment_type where city='".$city."'";
                $rows1 = Yii::app()->db->createCommand($sql1)->queryAll();
                $service_equipments = [];
                foreach ($rows1 as $row1) {
                    $service_equipments[$row1['id']] = $row1['name'];
                }
                $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists,'service_equipments'=>$service_equipments));
            }
        }
    }
    public function actionDelete()
    {
        $model = new ServiceequipmentFrom('delete');
        if (isset($_POST['ServiceequipmentFrom'])) {
            $model->attributes = $_POST['ServiceequipmentFrom'];
            $model->saveData();
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
        }
//		$this->actionIndex();
        $this->redirect(Yii::app()->createUrl('serviceequipment/index'));
    }
    public function actionEdit($index)
    {
        $model = new ServiceequipmentFrom('edit');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $sql = "select ServiceType,ServiceName from service where ServiceName is not null";
            $rows = Yii::app()->db->createCommand($sql)->queryAll();
            $service_type_lists = [];
            foreach ($rows as $row) {
                $service_type_lists[$row['ServiceType']] = $row['ServiceName'];
            }
            $tab_suffix = Yii::app()->params['table_envSuffix'];
            $city = Yii::app()->user->city();
            $sql1 = "select * from ".$tab_suffix."equipment_type where city='".$city."'";
            $rows1 = Yii::app()->db->createCommand($sql1)->queryAll();
            $service_equipments = [];
            foreach ($rows1 as $row1) {
                $service_equipments[$row1['id']] = $row1['name'];
            }
            $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists,'service_equipments'=>$service_equipments));
        }
    }
    public static function allowReadWrite() {
        return Yii::app()->user->validRWFunction('OS06');
    }

    public static function allowReadOnly() {
        return Yii::app()->user->validFunction('OS06');
    }
}