<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:45
 */

class MaterialclassController extends Controller
{
    public $function_id='MS02';

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
                'expression'=>array('MaterialclassController','allowReadWrite'),
            ),
            array('allow',
                'actions'=>array('index','view'),
                'expression'=>array('MaterialclassController','allowReadOnly'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    public function actionIndex($pageNum=0)
    {
        $model = new MaterialclassList();
        if (isset($_POST['MaterialclassList'])) {
            $model->attributes = $_POST['MaterialclassList'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['materialclass_ms02']) && !empty($session['materialclass_ms02'])) {
                $materiallist = $session['materialclass_ms02'];
                $model->setCriteria($materiallist);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index',array('model'=>$model));
    }
    public function actionNew()
    {
        $model = new MaterialclassFrom('new');
        $this->render('form',array('model'=>$model,));
    }
    public function actionSave()
    {
        if (isset($_POST['MaterialclassFrom'])) {
            $model = new MaterialclassFrom($_POST['MaterialclassFrom']['scenario']);
            $model->attributes = $_POST['MaterialclassFrom'];
            if ($model->validate()) {
                $model->saveData();
                $model->scenario = 'edit';
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
                $this->redirect(Yii::app()->createUrl('materialclass/edit',array('index'=>$model->id)));
            } else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog','Validation Message'), $message);
                $this->render('form',array('model'=>$model));
            }
        }
    }
    public function actionDelete()
    {
        $model = new MaterialclassFrom('delete');
        if (isset($_POST['MaterialclassFrom'])) {
            $model->attributes = $_POST['MaterialclassFrom'];
            $model->saveData();
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
        }
//		$this->actionIndex();
        $this->redirect(Yii::app()->createUrl('materialclass/index'));
    }
    public function actionEdit($index)
    {
        $model = new MaterialclassFrom('edit');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $this->render('form',array('model'=>$model));
        }
    }
    public static function allowReadWrite() {
        return Yii::app()->user->validRWFunction('MS02');
    }

    public static function allowReadOnly() {
        return Yii::app()->user->validFunction('MS02');
    }
}