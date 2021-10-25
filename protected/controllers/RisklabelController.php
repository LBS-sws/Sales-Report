<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:45
 */

class RisklabelController extends Controller
{
    public $function_id='RS04';

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
                'expression'=>array('RisklabelController','allowReadWrite'),
            ),
            array('allow',
                'actions'=>array('index','view'),
                'expression'=>array('RisklabelController','allowReadOnly'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    public function actionIndex($pageNum=0)
    {
        $model = new RisklabelList();
        if (isset($_POST['RisklabelList'])) {
            $model->attributes = $_POST['RisklabelList'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['risklabel_rs04']) && !empty($session['risklabel_rs04'])) {
                $materiallist = $session['risklabel_rs04'];
                $model->setCriteria($materiallist);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
//        var_dump($model);die();
        $this->render('index',array('model'=>$model));
    }
    public function actionNew()
    {
        $model = new RisklabelFrom('new');
        $this->render('form',array('model'=>$model));
    }
    public function actionSave()
    {
        if (isset($_POST['RisklabelFrom'])) {
            $model = new RisklabelFrom($_POST['RisklabelFrom']['scenario']);
            $model->attributes = $_POST['RisklabelFrom'];
            if ($model->validate()) {
                $model->saveData();
                $model->scenario = 'edit';
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
                $this->redirect(Yii::app()->createUrl('risklabel/edit',array('index'=>$model->id)));
            } else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog','Validation Message'), $message);
                $this->render('form',array('model'=>$model));
            }
        }
    }
    public function actionDelete()
    {
        $model = new RisklabelFrom('delete');
        if (isset($_POST['RisklabelFrom'])) {
            $model->attributes = $_POST['RisklabelFrom'];
            $model->saveData();
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
        }
//		$this->actionIndex();
        $this->redirect(Yii::app()->createUrl('risklabel/index'));
    }
    public function actionEdit($index)
    {
        $model = new RisklabelFrom('edit');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $this->render('form',array('model'=>$model));
        }
    }
    public static function allowReadWrite() {
        return Yii::app()->user->validRWFunction('RS04');
    }

    public static function allowReadOnly() {
        return Yii::app()->user->validFunction('RS04');
    }
}