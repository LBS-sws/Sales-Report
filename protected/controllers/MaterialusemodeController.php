<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:45
 */

class MaterialusemodeController extends Controller
{
    public $function_id='MS03';

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
                'expression'=>array('MaterialusemodeController','allowReadWrite'),
            ),
            array('allow',
                'actions'=>array('index','view'),
                'expression'=>array('MaterialusemodeController','allowReadOnly'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    public function actionIndex($pageNum=0)
    {
        $model = new MaterialusemodeList();
        if (isset($_POST['MaterialusemodeList'])) {
            $model->attributes = $_POST['MaterialusemodeList'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['materialusemode_ms03']) && !empty($session['materialusemode_ms03'])) {
                $materiallist = $session['materialusemode_ms03'];
                $model->setCriteria($materiallist);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index',array('model'=>$model));
    }
    public function actionNew()
    {
        $model = new MaterialusemodeFrom('new');
        $this->render('form',array('model'=>$model,));
    }
    public function actionSave()
    {
        if (isset($_POST['MaterialusemodeFrom'])) {
            $model = new MaterialusemodeFrom($_POST['MaterialusemodeFrom']['scenario']);
            $model->attributes = $_POST['MaterialusemodeFrom'];
            if ($model->validate()) {
                $model->saveData();
                $model->scenario = 'edit';
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
                $this->redirect(Yii::app()->createUrl('materialusemode/edit',array('index'=>$model->id)));
            } else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog','Validation Message'), $message);
                $this->render('form',array('model'=>$model));
            }
        }
    }
    public function actionDelete()
    {
        $model = new MaterialusemodeFrom('delete');
        if (isset($_POST['MaterialusemodeFrom'])) {
            $model->attributes = $_POST['MaterialusemodeFrom'];
            $model->saveData();
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
        }
//		$this->actionIndex();
        $this->redirect(Yii::app()->createUrl('materialusemode/index'));
    }
    public function actionEdit($index)
    {
        $model = new MaterialusemodeFrom('edit');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $this->render('form',array('model'=>$model));
        }
    }
    public static function allowReadWrite() {
        return Yii::app()->user->validRWFunction('MS03');
    }

    public static function allowReadOnly() {
        return Yii::app()->user->validFunction('MS03');
    }
}