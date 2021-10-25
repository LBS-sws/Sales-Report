<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:45
 */

class MaterialusepestController extends Controller
{
    public $function_id='MS04';

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
                'expression'=>array('MaterialusepestController','allowReadWrite'),
            ),
            array('allow',
                'actions'=>array('index','view'),
                'expression'=>array('MaterialusepestController','allowReadOnly'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    public function actionIndex($pageNum=0)
    {
        $model = new MaterialusepestList();
        if (isset($_POST['MaterialusepestList'])) {
            $model->attributes = $_POST['MaterialusepestList'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['materialusepest_ms03']) && !empty($session['materialusepest_ms03'])) {
                $materiallist = $session['materialusepest_ms03'];
                $model->setCriteria($materiallist);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index',array('model'=>$model));
    }
    public function actionNew()
    {
        $model = new MaterialusepestFrom('new');
        $sql = "select ServiceType,ServiceName from service where ServiceName is not null";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        $service_type_lists = [];
        foreach ($rows as $row) {
            $service_type_lists[$row['ServiceType']] = $row['ServiceName'];
        }
        $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists));
    }
    public function actionSave()
    {
        if (isset($_POST['MaterialusepestFrom'])) {
            $model = new MaterialusepestFrom($_POST['MaterialusepestFrom']['scenario']);
            $model->attributes = $_POST['MaterialusepestFrom'];
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
                $this->redirect(Yii::app()->createUrl('materialusepest/edit',array('index'=>$model->id,'service_type_lists'=>$service_type_lists)));
            } else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog','Validation Message'), $message);
                $sql = "select ServiceType,ServiceName from service where ServiceName is not null";
                $rows = Yii::app()->db->createCommand($sql)->queryAll();
                $service_type_lists = [];
                foreach ($rows as $row) {
                    $service_type_lists[$row['ServiceType']] = $row['ServiceName'];
                }
                $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists));
            }
        }
    }
    public function actionDelete()
    {
        $model = new MaterialusepestFrom('delete');
        if (isset($_POST['MaterialusepestFrom'])) {
            $model->attributes = $_POST['MaterialusepestFrom'];
            $model->saveData();
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
        }
//		$this->actionIndex();
        $this->redirect(Yii::app()->createUrl('materialusepest/index'));
    }
    public function actionEdit($index)
    {
        $model = new MaterialusepestFrom('edit');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            // print_r($model);exit();
            $sql = "select ServiceType,ServiceName from service where ServiceName is not null";
            $rows = Yii::app()->db->createCommand($sql)->queryAll();
            $service_type_lists = [];
            foreach ($rows as $row) {
                $service_type_lists[$row['ServiceType']] = $row['ServiceName'];
            }
            $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists));
        }
    }
    public static function allowReadWrite() {
        return Yii::app()->user->validRWFunction('MS04');
    }

    public static function allowReadOnly() {
        return Yii::app()->user->validFunction('MS04');
    }
}