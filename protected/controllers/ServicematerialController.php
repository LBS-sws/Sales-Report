<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:45
 */

class ServicematerialController extends Controller
{
    public $function_id='OS09';

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
                'expression'=>array('ServicematerialController','allowReadWrite'),
            ),
            array('allow',
                'actions'=>array('index','view'),
                'expression'=>array('ServicematerialController','allowReadOnly'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    public function actionIndex($pageNum=0)
    {
        $model = new ServicematerialList();
        if (isset($_POST['ServicematerialList'])) {
            $model->attributes = $_POST['ServicematerialList'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['servicematerial_os09']) && !empty($session['servicematerial_os09'])) {
                $materiallist = $session['servicematerial_os09'];
                $model->setCriteria($materiallist);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index',array('model'=>$model));
    }
    public function actionNew()
    {
        $model = new ServicematerialFrom('new');
        $sql = "select ServiceType,ServiceName from service where ServiceName is not null";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        $service_type_lists = [];
        foreach ($rows as $row) {
            $service_type_lists[$row['ServiceType']] = $row['ServiceName'];
        }
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $city = Yii::app()->user->city();
        $sql1 = "select m.* from ".$tab_suffix."material_lists as m left join ".$tab_suffix."material_classifys as c on m.classify_id=c.id where c.city='".$city."'";
        $rows1 = Yii::app()->db->createCommand($sql1)->queryAll();
        $service_materials = [];
        foreach ($rows1 as $row1) {
            $service_materials[$row1['id']] = $row1['name'];
        }
        $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists,'service_materials'=>$service_materials));
    }
    public function actionSave()
    {
        if (isset($_POST['ServicematerialFrom'])) {
            $model = new ServicematerialFrom($_POST['ServicematerialFrom']['scenario']);
            $model->attributes = $_POST['ServicematerialFrom'];
            if ($model->validate()) {
                $model->saveData();
                $model->scenario = 'edit';
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
                $this->redirect(Yii::app()->createUrl('servicematerial/edit',array('index'=>$model->id)));
            } else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog','Validation Message'), $message);
                $this->redirect(Yii::app()->createUrl('servicematerial/edit',array('index'=>$model->id)));
            }
        }
    }
    public function actionDelete()
    {
        $model = new ServicematerialFrom('delete');
        if (isset($_POST['ServicematerialFrom'])) {
            $model->attributes = $_POST['ServicematerialFrom'];
            $model->saveData();
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
        }
        $this->redirect(Yii::app()->createUrl('servicematerial/index'));
    }
    public function actionEdit($index)
    {
        $model = new ServicematerialFrom('edit');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $sql = "select ServiceType,ServiceName from service where ServiceName is not null";
            $rows = Yii::app()->db->createCommand($sql)->queryAll();
            $service_type_lists = [];
            foreach ($rows as $row) {
                $service_type_lists[$row['ServiceType']] = $row['ServiceName'];
            }
            $tab_suffix = Yii::app()->params['table_envSuffix'];
            $city = Yii::app()->user->city();
            $sql1 = "select m.* from ".$tab_suffix."material_lists as m left join ".$tab_suffix."material_classifys as c on m.classify_id=c.id where c.city='".$city."'";
            $rows1 = Yii::app()->db->createCommand($sql1)->queryAll();
            $service_materials = [];
            foreach ($rows1 as $row1) {
                $service_materials[$row1['id']] = $row1['name'];
            }
            $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists,'service_materials'=>$service_materials));
        }
    }
    public static function allowReadWrite() {
        return Yii::app()->user->validRWFunction('OS09');
    }

    public static function allowReadOnly() {
        return Yii::app()->user->validFunction('OS09');
    }
}