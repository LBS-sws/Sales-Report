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

    public function actionIndex($pageNum=0)
    {
        $model = new Equipmenttype();
        if (isset($_POST['Equipmenttype'])) {
            $model->attributes = $_POST['Equipmenttype'];
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
        $model = new Equipmenttype('new');
        $service_type_lists = ['1'=>'数量输入','2'=>'数据输入'];
        $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists));
    }
    public function actionSave()
    {
        $data = $_POST['Equipmenttype'];
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        if ($data['id']>0){
            $result = Yii::app()->db->createCommand()->update($tab_suffix .'equipment_type', array('name' => $data['name'],'type' => $data['type'],'check_targt' => $data['check_targt'],'check_handles' => $data['check_handles']), 'id=:id', array(':id' => $data['id']));
            $id = $data['id'];
        }else{
            $city = Yii::app()->user->city();
            $result = Yii::app()->db->createCommand()->insert($tab_suffix .'equipment_type', array('name' => $data['name'],'type' => $data['type'],'check_targt' => $data['check_targt'],'check_handles' => $data['check_handles'],'city'=>$city,'creat_time'=>date('Y-m-d H:i:s', time())));
            $id = Yii::app()->db->getLastInsertID();
        }
        if ($result) {
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
            $this->redirect(Yii::app()->createUrl('equipmenttype/edit',array('index'=>$id)));
        } else {
            Dialog::message(Yii::t('dialog','Validation Message'), Yii::t('dialog','Save no Done'));
            $this->redirect(Yii::app()->createUrl('equipmenttype/edit',array('index'=>$id)));
        }
    }
    public function actionDelete()
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $de = Yii::app()->db->createCommand()->delete($tab_suffix .'equipment_type', 'id=:id', array(':id' => $_POST['Equipmenttype']['id']));
        if ($de) {
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Submission Done'));
            $this->redirect(Yii::app()->createUrl('equipmenttype/index'));
        } else {
            Dialog::message(Yii::t('dialog','Validation Message'), Yii::t('dialog','Save no Done'));
            $this->redirect(Yii::app()->createUrl('equipmenttype/index'));
        }
    }
    public function actionEdit($index)
    {
        $model = new Equipmenttype('view');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $service_type_lists = ['1'=>'数量输入','2'=>'数据输入'];
            $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists));
        }
    }

}