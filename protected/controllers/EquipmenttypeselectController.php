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

    public function actionIndex($pageNum=0)
    {
        $model = new Equipmenttypeselect();
        if (isset($_POST['Equipmenttypeselect'])) {
            $model->attributes = $_POST['Equipmenttypeselect'];
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
        $model = new Equipmenttypeselect('new');
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
//        var_dump($_POST);die();
        $data = $_POST['Equipmenttypeselect'];
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        if ($data['id']>0){
            $result = Yii::app()->db->createCommand()->update($tab_suffix .'equipment_type_selects', array('check_selects' => $data['check_selects'],'check_targt' => $data['check_targt'],'equipment_type_id' => $data['equipment_type_id']), 'id=:id', array(':id' => $data['id']));
            $id = $data['id'];
        }else{
            $city = Yii::app()->user->city();
            $result = Yii::app()->db->createCommand()->insert($tab_suffix .'equipment_type_selects', array('check_selects' => $data['check_selects'],'check_targt' => $data['check_targt'],'equipment_type_id' => $data['equipment_type_id'],'creat_time'=>date('Y-m-d H:i:s', time())));
            $id = Yii::app()->db->getLastInsertID();
        }
        if ($result) {
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
            $this->redirect(Yii::app()->createUrl('equipmenttypeselect/edit',array('index'=>$id)));
        } else {
            Dialog::message(Yii::t('dialog','Validation Message'), Yii::t('dialog','Save no Done'));
            $this->redirect(Yii::app()->createUrl('equipmenttypeselect/edit',array('index'=>$id)));
        }
    }
    public function actionDelete()
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $de = Yii::app()->db->createCommand()->delete($tab_suffix .'equipment_type_selects', 'id=:id', array(':id' => $_POST['Equipmenttypeselect']['id']));
        if ($de) {
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Submission Done'));
            $this->redirect(Yii::app()->createUrl('equipmenttypeselect/index'));
        } else {
            Dialog::message(Yii::t('dialog','Validation Message'), Yii::t('dialog','Save no Done'));
            $this->redirect(Yii::app()->createUrl('equipmenttypeselect/index'));
        }
    }
    public function actionEdit($index)
    {
        $model = new Equipmenttypeselect('view');
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


}