<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:45
 */

class UseareaController extends Controller
{
    public $function_id='OS05';

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
        $model = new Usearea();
        if (isset($_POST['Usearea'])) {
            $model->attributes = $_POST['Usearea'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['usearea_os05']) && !empty($session['usearea_os05'])) {
                $materiallist = $session['usearea_os05'];
                $model->setCriteria($materiallist);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index',array('model'=>$model));
    }
    public function actionNew()
    {
        $model = new Usearea('new');
        $service_type_lists = ['material'=>'物料使用','equipment'=>'设备放置区域'];
        $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists));
    }
    public function actionSave()
    {
        $data = $_POST['Usearea'];
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        if ($data['id']>0){
            $result = Yii::app()->db->createCommand()->update($tab_suffix .'use_areas', array('area_type' => $data['area_type'],'use_area' => $data['use_area']), 'id=:id', array(':id' => $data['id']));
            $id = $data['id'];
        }else{
            $city = Yii::app()->user->city();
            $result = Yii::app()->db->createCommand()->insert($tab_suffix .'use_areas', array('area_type' => $data['area_type'],'use_area' => $data['use_area'],'city'=>$city,'creat_time'=>date('Y-m-d H:i:s', time())));
            $id = Yii::app()->db->getLastInsertID();
        }
        if ($result) {
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
            $this->redirect(Yii::app()->createUrl('usearea/edit',array('index'=>$id)));
        } else {
            Dialog::message(Yii::t('dialog','Validation Message'), Yii::t('dialog','Save no Done'));
            $this->redirect(Yii::app()->createUrl('usearea/edit',array('index'=>$id)));
        }
    }
    public function actionDelete()
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $de = Yii::app()->db->createCommand()->delete($tab_suffix .'use_areas', 'id=:id', array(':id' => $_POST['Usearea']['id']));
        if ($de) {
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Submission Done'));
            $this->redirect(Yii::app()->createUrl('usearea/index'));
        } else {
            Dialog::message(Yii::t('dialog','Validation Message'), Yii::t('dialog','Save no Done'));
            $this->redirect(Yii::app()->createUrl('usearea/index'));
        }
    }
    public function actionEdit($index)
    {
        $model = new Usearea('view');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $service_type_lists = ['material'=>'物料使用','equipment'=>'设备放置区域'];
            $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists));
        }
    }

}