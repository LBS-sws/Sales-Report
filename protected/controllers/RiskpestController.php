<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:45
 */

class RiskpestController extends Controller
{
    public $function_id='RS01';

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
        $model = new Riskpest();
        if (isset($_POST['Riskpest'])) {
            $model->attributes = $_POST['Riskpest'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['riskpest_rs01']) && !empty($session['riskpest_rs01'])) {
                $materiallist = $session['riskpest_rs01'];
                $model->setCriteria($materiallist);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index',array('model'=>$model));
    }
    public function actionNew()
    {
        $model = new Riskpest('new');
        $this->render('form',array('model'=>$model));
    }
    public function actionSave()
    {
        $data = $_POST['Riskpest'];
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        if ($data['id']>0){
            $result = Yii::app()->db->createCommand()->update($tab_suffix .'risk_target_lists', array('target' => $data['target']), 'id=:id', array(':id' => $data['id']));
            $id = $data['id'];
        }else{
            $city = Yii::app()->user->city();
            $result = Yii::app()->db->createCommand()->insert($tab_suffix .'risk_target_lists', array('target' => $data['target'],'city'=>$city,'creat_time'=>date('Y-m-d H:i:s', time())));
            $id = Yii::app()->db->getLastInsertID();
        }
        if ($result) {
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
            $this->redirect(Yii::app()->createUrl('riskpest/edit',array('index'=>$id)));
        } else {
            Dialog::message(Yii::t('dialog','Validation Message'), Yii::t('dialog','Save no Done'));
            $this->redirect(Yii::app()->createUrl('riskpest/edit',array('index'=>$id)));
        }
    }
    public function actionDelete()
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $de = Yii::app()->db->createCommand()->delete($tab_suffix .'risk_target_lists', 'id=:id', array(':id' => $_POST['Riskpest']['id']));
        if ($de) {
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Submission Done'));
            $this->redirect(Yii::app()->createUrl('riskpest/index'));
        } else {
            Dialog::message(Yii::t('dialog','Validation Message'), Yii::t('dialog','Save no Done'));
            $this->redirect(Yii::app()->createUrl('riskpest/index'));
        }
    }
    public function actionEdit($index)
    {
        $model = new Riskpest('view');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $this->render('form',array('model'=>$model));
        }
    }

}