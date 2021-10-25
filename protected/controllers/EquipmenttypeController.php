<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:45
 */

class EquipmenttypeController extends Controller
{
    public $function_id='OS03';

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
                'expression'=>array('EquipmenttypeController','allowReadWrite'),
            ),
            array('allow',
                'actions'=>array('index','view'),
                'expression'=>array('EquipmenttypeController','allowReadOnly'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    public function actionIndex($pageNum=0)
    {
        $model = new EquipmenttypeList();
        if (isset($_POST['EquipmenttypeList'])) {
            $model->attributes = $_POST['EquipmenttypeList'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['equipmenttype_os03']) && !empty($session['equipmenttype_os03'])) {
                $materiallist = $session['equipmenttype_os03'];
                $model->setCriteria($materiallist);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index',array('model'=>$model));
    }
    public function actionNew()
    {
        $model = new EquipmenttypeFrom('new');
        $service_type_lists = ['1'=>'数量输入','2'=>'数据输入'];
        $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists));
    }
    public function actionSave()
    {
        if (isset($_POST['EquipmenttypeFrom'])) {
            $model = new EquipmenttypeFrom($_POST['EquipmenttypeFrom']['scenario']);
            $model->attributes = $_POST['EquipmenttypeFrom'];
            if ($model->validate()) {
                $model->saveData();
                $model->scenario = 'edit';
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
                $service_type_lists = ['1'=>'数量输入','2'=>'数据输入'];
                $this->redirect(Yii::app()->createUrl('equipmenttype/edit',array('index'=>$model->id,'service_type_lists'=>$service_type_lists)));
            } else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog','Validation Message'), $message);
                $service_type_lists = ['1'=>'数量输入','2'=>'数据输入'];
                $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists));
            }
        }
    }
    public function actionDelete()
    {
        $model = new EquipmenttypeFrom('delete');
        if (isset($_POST['EquipmenttypeFrom'])) {
            $model->attributes = $_POST['EquipmenttypeFrom'];
            $model->saveData();
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
        }
//		$this->actionIndex();
        $this->redirect(Yii::app()->createUrl('equipmenttype/index'));
    }
    public function actionEdit($index)
    {
        $model = new EquipmenttypeFrom('edit');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $service_type_lists = ['1'=>'数量输入','2'=>'数据输入'];
            $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists));
        }
    }
    public static function allowReadWrite() {
        return Yii::app()->user->validRWFunction('OS03');
    }

    public static function allowReadOnly() {
        return Yii::app()->user->validFunction('OS03');
    }
}