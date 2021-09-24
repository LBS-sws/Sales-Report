<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:45
 */

class MaterialusepestController extends Controller
{
    public $function_id='MS04';

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

    public function actionIndex($pageNum=0)
    {
        $model = new Materialusepest();
        if (isset($_POST['Materialusepest'])) {
            $model->attributes = $_POST['Materialusepest'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['materialusepest_ms03']) && !empty($session['materialusepest_ms03'])) {
                $materiallist = $session['materialusepest_ms03'];
                $model->setCriteria($materiallist);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index',array('model'=>$model));
    }
    public function actionNew()
    {
        $model = new Materialusepest('new');
        $city_allow = Yii::app()->user->city_allow();
        $sql = "select ServiceType,ServiceName from service where ServiceName is not null";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($rows as $row) {
            $service_type_lists[$row['ServiceType']] = $row['ServiceName'];
        }
        $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists));
    }
    public function actionSave()
    {
        $data = $_POST['Materialusepest'];
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        if ($data['id']>0){
            $result = Yii::app()->db->createCommand()->update($tab_suffix .'material_target_lists', array('service_type' => $data['service_type'],'targets' => $data['targets']), 'id=:id', array(':id' => $data['id']));
            $id = $data['id'];
        }else{
            $city = Yii::app()->user->city();
            $result = Yii::app()->db->createCommand()->insert($tab_suffix .'material_target_lists', array('service_type' => $data['service_type'],'targets' => $data['targets'],'city'=>$city,'creat_time'=>date('Y-m-d H:i:s', time())));
            $id = Yii::app()->db->getLastInsertID();
        }
        if ($result) {
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
            $this->redirect(Yii::app()->createUrl('materialusepest/edit',array('index'=>$id)));
        } else {
            Dialog::message(Yii::t('dialog','Validation Message'), Yii::t('dialog','Save no Done'));
            $this->redirect(Yii::app()->createUrl('materialusepest/edit',array('index'=>$id)));
        }
    }
    public function actionDelete()
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $de = Yii::app()->db->createCommand()->delete($tab_suffix .'material_target_lists', 'id=:id', array(':id' => $_POST['Materialusepest']['id']));
        if ($de) {
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Submission Done'));
            $this->redirect(Yii::app()->createUrl('materialusepest/index'));
        } else {
            Dialog::message(Yii::t('dialog','Validation Message'), Yii::t('dialog','Save no Done'));
            $this->redirect(Yii::app()->createUrl('materialusepest/index'));
        }
    }
    public function actionEdit($index)
    {
        $model = new Materialusepest('view');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            // print_r($model);exit();
            $sql = "select ServiceType,ServiceName from service where ServiceName is not null";
            $rows = Yii::app()->db->createCommand($sql)->queryAll();
            foreach ($rows as $row) {
                $service_type_lists[$row['ServiceType']] = $row['ServiceName'];
            }
            $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists));
        }
    }

}