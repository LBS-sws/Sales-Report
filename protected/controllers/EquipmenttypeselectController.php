<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:45
 */

class EquipmenttypeselectController extends Controller
{
    public $function_id='OS04';

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
                'expression'=>array('EquipmenttypeselectController','allowReadWrite'),
            ),
            array('allow',
                'actions'=>array('index','view'),
                'expression'=>array('EquipmenttypeselectController','allowReadOnly'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    public function actionIndex($pageNum=0)
    {
        $model = new EquipmenttypeselectList();
        if (isset($_POST['EquipmenttypeselectList'])) {
            $model->attributes = $_POST['EquipmenttypeselectList'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['equipmenttypeselect_os04']) && !empty($session['equipmenttypeselect_os04'])) {
                $materiallist = $session['equipmenttypeselect_os04'];
                $model->setCriteria($materiallist);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index',array('model'=>$model));
    }
    public function actionNew()
    {
        $model = new EquipmenttypeselectFrom('new');
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
        $sql = "select * from ".$tab_suffix."equipment_type where  type=2 and city in(".$city_allow.")";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        $equipment_type_lists = [];
        $equipment_type_list_selects = [];
        foreach ($rows as $row) {
            $equipment_type_lists[$row['id']] = $row['name'];
            $equipment_type_list_selects[$row['id']]= explode(',',$row['check_targt']);
        }
        $this->render('form',array('model'=>$model,'equipment_type_lists'=>$equipment_type_lists,'equipment_type_list_selects'=>$equipment_type_list_selects));
    }
    public function actionSave()
    {
        if (isset($_POST['EquipmenttypeselectFrom'])) {
            $model = new EquipmenttypeselectFrom($_POST['EquipmenttypeselectFrom']['scenario']);
            $model->attributes = $_POST['EquipmenttypeselectFrom'];
            if ($model->validate()) {
                $model->saveData();
                $model->scenario = 'edit';
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
                $tab_suffix = Yii::app()->params['table_envSuffix'];
                $city_allow = Yii::app()->user->city_allow();
                $sql = "select * from ".$tab_suffix."equipment_type where  type=2 and city in(".$city_allow.")";
                $rows = Yii::app()->db->createCommand($sql)->queryAll();
                $equipment_type_lists = [];
                $equipment_type_list_selects = [];
                foreach ($rows as $row) {
                    $equipment_type_lists[$row['id']] = $row['name'];
                    $equipment_type_list_selects[$row['id']]= explode(',',$row['check_targt']);
                }
                $this->redirect(Yii::app()->createUrl('equipmenttypeselect/edit',array('index'=>$model->id,'equipment_type_lists'=>$equipment_type_lists,'equipment_type_list_selects'=>$equipment_type_list_selects)));
            } else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog','Validation Message'), $message);
                $tab_suffix = Yii::app()->params['table_envSuffix'];
                $city_allow = Yii::app()->user->city_allow();
                $sql = "select * from ".$tab_suffix."equipment_type where  type=2 and city in(".$city_allow.")";
                $rows = Yii::app()->db->createCommand($sql)->queryAll();
                $equipment_type_lists = [];
                $equipment_type_list_selects = [];
                foreach ($rows as $row) {
                    $equipment_type_lists[$row['id']] = $row['name'];
                    $equipment_type_list_selects[$row['id']]= explode(',',$row['check_targt']);
                }
                $this->render('form',array('model'=>$model,'equipment_type_lists'=>$equipment_type_lists,'equipment_type_list_selects'=>$equipment_type_list_selects));
            }
        }
    }
    public function actionDelete()
    {
        $model = new EquipmenttypeselectFrom('delete');
        if (isset($_POST['EquipmenttypeselectFrom'])) {
            $model->attributes = $_POST['EquipmenttypeselectFrom'];
            $model->saveData();
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
        }
//		$this->actionIndex();
        $this->redirect(Yii::app()->createUrl('equipmenttypeselect/index'));
    }
    public function actionEdit($index)
    {
        $model = new EquipmenttypeselectFrom('edit');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $tab_suffix = Yii::app()->params['table_envSuffix'];
            $city_allow = Yii::app()->user->city_allow();
            $sql = "select * from ".$tab_suffix."equipment_type where  type=2 and city in(".$city_allow.")";
            $rows = Yii::app()->db->createCommand($sql)->queryAll();
            $equipment_type_lists = [];
            $equipment_type_list_selects = [];
            foreach ($rows as $row) {
                $equipment_type_lists[$row['id']] = $row['name'];
                $equipment_type_list_selects[$row['id']]= explode(',',$row['check_targt']);
            }
            $this->render('form',array('model'=>$model,'equipment_type_lists'=>$equipment_type_lists,'equipment_type_list_selects'=>$equipment_type_list_selects));
        }
    }
    public static function allowReadWrite() {
        return Yii::app()->user->validRWFunction('OS04');
    }

    public static function allowReadOnly() {
        return Yii::app()->user->validFunction('OS04');
    }

}