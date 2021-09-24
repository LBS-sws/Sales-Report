<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:45
 */

class MaterialusemodeController extends Controller
{
    public $function_id='MS03';

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
        $model = new Materialusemode();
        if (isset($_POST['Materialusemode'])) {
            $model->attributes = $_POST['Materialusemode'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['materialusemode_ms03']) && !empty($session['materialusemode_ms03'])) {
                $materiallist = $session['materialusemode_ms03'];
                $model->setCriteria($materiallist);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index',array('model'=>$model));
    }
    public function actionNew()
    {
        $model = new Materialusemode('new');
        $this->render('form',array('model'=>$model,));
    }
    public function actionSave()
    {
        $data = $_POST['Materialusemode'];
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        if ($data['id']>0){
            $result = Yii::app()->db->createCommand()->update($tab_suffix .'material_use_modes', array('use_mode' => $data['use_mode']), 'id=:id', array(':id' => $data['id']));
            $id = $data['id'];
        }else{
            $city = Yii::app()->user->city();
            $result = Yii::app()->db->createCommand()->insert($tab_suffix .'material_use_modes', array('use_mode' => $data['use_mode'],'city'=>$city,'creat_time'=>date('Y-m-d H:i:s', time())));
            $id = Yii::app()->db->getLastInsertID();
        }
        if ($result) {
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
            $this->redirect(Yii::app()->createUrl('materialusemode/edit',array('index'=>$id)));
        } else {
            Dialog::message(Yii::t('dialog','Validation Message'), Yii::t('dialog','Save no Done'));
            $this->redirect(Yii::app()->createUrl('materialusemode/edit',array('index'=>$id)));
        }
    }
    public function actionDelete()
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $de = Yii::app()->db->createCommand()->delete($tab_suffix .'material_use_modes', 'id=:id', array(':id' => $_POST['Materialusemode']['id']));
        if ($de) {
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Submission Done'));
            $this->redirect(Yii::app()->createUrl('materialusemode/index'));
        } else {
            Dialog::message(Yii::t('dialog','Validation Message'), Yii::t('dialog','Save no Done'));
            $this->redirect(Yii::app()->createUrl('materialusemode/index'));
        }
    }
    public function actionEdit($index)
    {
        $model = new Materialusemode('view');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            // print_r($model);exit();
            $this->render('form',array('model'=>$model));
        }
    }

}