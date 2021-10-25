<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:45
 */

class UseareaController extends Controller
{
    public $function_id='OS05';

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
                'expression'=>array('UseareaController','allowReadWrite'),
            ),
            array('allow',
                'actions'=>array('index','view'),
                'expression'=>array('UseareaController','allowReadOnly'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    public function actionIndex($pageNum=0)
    {
        $model = new UseareaList();
        if (isset($_POST['UseareaList'])) {
            $model->attributes = $_POST['UseareaList'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['usearea_os05']) && !empty($session['usearea_os05'])) {
                $materiallist = $session['usearea_os05'];
                $model->setCriteria($materiallist);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index',array('model'=>$model));
    }
    public function actionNew()
    {
        $model = new UseareaFrom('new');
        $service_type_lists = ['material'=>'物料使用','equipment'=>'设备放置区域'];
        $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists));
    }
    public function actionSave()
    {
        if (isset($_POST['UseareaFrom'])) {
            $model = new UseareaFrom($_POST['UseareaFrom']['scenario']);
            $model->attributes = $_POST['UseareaFrom'];
            if ($model->validate()) {
                $model->saveData();
                $model->scenario = 'edit';
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
                $service_type_lists = ['material'=>'物料使用','equipment'=>'设备放置区域'];
                $this->redirect(Yii::app()->createUrl('usearea/edit',array('index'=>$model->id,'service_type_lists'=>$service_type_lists)));
            } else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog','Validation Message'), $message);
                $service_type_lists = ['material'=>'物料使用','equipment'=>'设备放置区域'];
                $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists));
            }
        }
    }
    public function actionDelete()
    {
        $model = new UseareaFrom('delete');
        if (isset($_POST['UseareaFrom'])) {
            $model->attributes = $_POST['UseareaFrom'];
            $model->saveData();
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
        }
//		$this->actionIndex();
        $this->redirect(Yii::app()->createUrl('usearea/index'));
    }
    public function actionEdit($index)
    {
        $model = new UseareaFrom('edit');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $service_type_lists = ['material'=>'物料使用','equipment'=>'设备放置区域'];
            $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists));
        }
    }
    public static function allowReadWrite() {
        return Yii::app()->user->validRWFunction('OS05');
    }

    public static function allowReadOnly() {
        return Yii::app()->user->validFunction('OS05');
    }
}