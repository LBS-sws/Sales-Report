<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:45
 */

class RiskrankController extends Controller
{
    public $function_id='RS02';

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
                'expression'=>array('RiskrankController','allowReadWrite'),
            ),
            array('allow',
                'actions'=>array('index','view'),
                'expression'=>array('RiskrankController','allowReadOnly'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    public function actionIndex($pageNum=0)
    {
        $model = new RiskrankList();
        if (isset($_POST['RiskrankList'])) {
            $model->attributes = $_POST['RiskrankList'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['riskrank_rs02']) && !empty($session['riskrank_rs02'])) {
                $materiallist = $session['riskrank_rs02'];
                $model->setCriteria($materiallist);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index',array('model'=>$model));
    }
    public function actionNew()
    {
        $model = new RiskrankFrom('new');
        $this->render('form',array('model'=>$model));
    }
    public function actionSave()
    {
        if (isset($_POST['RiskrankFrom'])) {
            $model = new RiskrankFrom($_POST['RiskrankFrom']['scenario']);
            $model->attributes = $_POST['RiskrankFrom'];
            if ($model->validate()) {
                $model->saveData();
                $model->scenario = 'edit';
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
                $this->redirect(Yii::app()->createUrl('riskrank/edit',array('index'=>$model->id)));
            } else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog','Validation Message'), $message);
                $this->render('form',array('model'=>$model));
            }
        }
    }
    public function actionDelete()
    {
        $model = new RiskrankFrom('delete');
        if (isset($_POST['RiskrankFrom'])) {
            $model->attributes = $_POST['RiskrankFrom'];
            $model->saveData();
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
        }
//		$this->actionIndex();
        $this->redirect(Yii::app()->createUrl('riskrank/index'));
    }
    public function actionEdit($index)
    {
        $model = new RiskrankFrom('edit');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $this->render('form',array('model'=>$model));
        }
    }
    public static function allowReadWrite() {
        return Yii::app()->user->validRWFunction('RS02');
    }

    public static function allowReadOnly() {
        return Yii::app()->user->validFunction('RS02');
    }
}