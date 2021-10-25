<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:45
 */

class ShortcutController extends Controller
{
    public $function_id='OS01';

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
                'expression'=>array('ShortcutController','allowReadWrite'),
            ),
            array('allow',
                'actions'=>array('index','view'),
                'expression'=>array('ShortcutController','allowReadOnly'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    public function actionIndex($pageNum=0)
    {
        $model = new ShortcutList();
        if (isset($_POST['ShortcutList'])) {
            $model->attributes = $_POST['ShortcutList'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['shortcut_OS01']) && !empty($session['shortcut_OS01'])) {
                $materiallist = $session['shortcut_OS01'];
                $model->setCriteria($materiallist);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index',array('model'=>$model));
    }
    public function actionNew()
    {
        $model = new ShortcutFrom('new');
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
        if (isset($_POST['ShortcutFrom'])) {
            $model = new ShortcutFrom($_POST['ShortcutFrom']['scenario']);
            $model->attributes = $_POST['ShortcutFrom'];
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
                $this->redirect(Yii::app()->createUrl('shortcut/edit',array('index'=>$model->id,'service_type_lists'=>$service_type_lists)));
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
        $model = new ShortcutFrom('delete');
        if (isset($_POST['ShortcutFrom'])) {
            $model->attributes = $_POST['ShortcutFrom'];
            $model->saveData();
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
        }
//		$this->actionIndex();
        $this->redirect(Yii::app()->createUrl('shortcut/index'));
    }
    public function actionEdit($index)
    {
        $model = new ShortcutFrom('edit');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
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
        return Yii::app()->user->validRWFunction('OS01');
    }

    public static function allowReadOnly() {
        return Yii::app()->user->validFunction('OS01');
    }
}