<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:45
 */

class RisktypeController extends Controller
{
    public $function_id='RS03';

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
                'expression'=>array('RisktypeController','allowReadWrite'),
            ),
            array('allow',
                'actions'=>array('index','view'),
                'expression'=>array('RisktypeController','allowReadOnly'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    public function actionIndex($pageNum=0)
    {
        $model = new RisktypeList();
        if (isset($_POST['RisktypeList'])) {
            $model->attributes = $_POST['RisktypeList'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['risktype_rs03']) && !empty($session['risktype_rs03'])) {
                $materiallist = $session['risktype_rs03'];
                $model->setCriteria($materiallist);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index',array('model'=>$model));
    }
    public function actionNew()
    {
        $model = new RisktypeFrom('new');
        $this->render('form',array('model'=>$model));
    }
    public function actionSave()
    {
        if (isset($_POST['RisktypeFrom'])) {
            $model = new RisktypeFrom($_POST['RisktypeFrom']['scenario']);
            $model->attributes = $_POST['RisktypeFrom'];
            if ($model->validate()) {
                $model->saveData();
                $model->scenario = 'edit';
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
                $this->redirect(Yii::app()->createUrl('risktype/edit',array('index'=>$model->id)));
            } else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog','Validation Message'), $message);
                $this->render('form',array('model'=>$model));
            }
        }
    }
    public function actionDelete()
    {
        $model = new RisktypeFrom('delete');
        if (isset($_POST['RisktypeFrom'])) {
            $model->attributes = $_POST['RisktypeFrom'];
            $model->saveData();
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
        }
//		$this->actionIndex();
        $this->redirect(Yii::app()->createUrl('risktype/index'));
    }
    public function actionEdit($index)
    {
        $model = new RisktypeFrom('edit');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $this->render('form',array('model'=>$model));
        }
    }
    public static function allowReadWrite() {
        return Yii::app()->user->validRWFunction('RS03');
    }

    public static function allowReadOnly() {
        return Yii::app()->user->validFunction('RS03');
    }
}