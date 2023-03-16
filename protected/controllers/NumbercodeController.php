<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:45
 */

class NumbercodeController extends Controller
{
    public $function_id='OS11';

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
                'expression'=>array('NumbercodeController','allowReadWrite'),
            ),
            array('allow',
                'actions'=>array('index','view'),
                'expression'=>array('NumbercodeController','allowReadOnly'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    public function actionIndex($pageNum=0)
    {
        $model = new NumbercodeList();
        if (isset($_POST['NumbercodeList'])) {
            $model->attributes = $_POST['NumbercodeList'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['numbercode_os11']) && !empty($session['numbercode_os11'])) {
                $numbercode = $session['numbercode_os11'];
                $model->setCriteria($numbercode);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index',array('model'=>$model));
    }

    public function actionSave()
    {
        if (isset($_POST['NumbercodeFrom'])) {
            $model = new NumbercodeFrom($_POST['NumbercodeFrom']['scenario']);
            $model->attributes = $_POST['NumbercodeFrom'];
            if ($model->validate()) {
                $model->saveData();
                $model->scenario = 'edit';
                $this->redirect(Yii::app()->createUrl('numbercode/edit',array('index'=>$model->id)));
            } else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog','Validation Message'), $message);
                $this->render('form',array('model'=>$model));
            }
        }
    }
    public function actionEdit($index)
    {
        $model = new NumbercodeFrom('edit');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $this->render('form',array('model'=>$model));
        }
    }
    public static function allowReadWrite() {
        return Yii::app()->user->validRWFunction('OS11');
    }

    public static function allowReadOnly() {
        return Yii::app()->user->validFunction('OS11');
    }
}