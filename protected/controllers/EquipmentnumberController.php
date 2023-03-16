<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:45
 */

class EquipmentnumberController extends Controller
{
    public $function_id='OS10';

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
                'actions'=>array('new','edit','delete','save','down'),
                'expression'=>array('EquipmentnumberController','allowReadWrite'),
            ),
            array('allow',
                'actions'=>array('index','view'),
                'expression'=>array('EquipmentnumberController','allowReadOnly'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    public function actionIndex($pageNum=0)
    {
        $model = new EquipmentnumberList();
        if (isset($_POST['EquipmentnumberList'])) {
            $model->attributes = $_POST['EquipmentnumberList'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['equipmentnumber_os10']) && !empty($session['equipmentnumber_os10'])) {
                $materiallist = $session['equipmentnumbertype_os10'];
                $model->setCriteria($materiallist);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index',array('model'=>$model));
    }
    public function actionNew()
    {
        $model = new EquipmentnumberFrom('new');
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $city = Yii::app()->user->city();
        $sql1 = "select * from ".$tab_suffix."equipment_type where  city='".$city."'";
        $rows1 = Yii::app()->db->createCommand($sql1)->queryAll();
        $equipment_types = [];
        foreach ($rows1 as $row1) {
            $equipment_types[$row1['id']] = $row1['name'];
        }
        $this->render('form',array('model'=>$model,'equipment_types'=>$equipment_types));
    }
    public function actionSave()
    {
        if (isset($_POST['EquipmentnumberFrom'])) {
            $model = new EquipmentnumberFrom($_POST['EquipmentnumberFrom']['scenario']);
            $model->attributes = $_POST['EquipmentnumberFrom'];
            if ($model->validate()) {
                $model->saveData();
                $model->scenario = 'edit';
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
            } else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog','Validation Message'), $message);
            }
            $this->redirect(Yii::app()->createUrl('equipmentnumber/index'));
        }
    }

    public function actionDown()
    {
        $model = new EquipmentnumberFrom();
        if (!$model->retrieveDown($_POST['EqnumOS11List'])) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $model->retrieveDown($_POST['EqnumOS11List']);
            //$this->render('form',array('model'=>$model,));
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
        return Yii::app()->user->validRWFunction('OS10');
    }

    public static function allowReadOnly() {
        return Yii::app()->user->validFunction('OS10');
    }
}