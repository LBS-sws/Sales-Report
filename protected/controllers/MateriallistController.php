<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:45
 */

class MateriallistController extends Controller
{
    public $function_id='MS01';

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
        $model = new Material;
        if (isset($_POST['Material'])) {
            $model->attributes = $_POST['Material'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['materiallist_ms01']) && !empty($session['materiallist_ms01'])) {
                $materiallist = $session['materiallist_ms01'];
                $model->setCriteria($materiallist);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index',array('model'=>$model));
    }
    public function actionNew()
    {
        $model = new Material('new');
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
        $sql = "select id,name from ".$tab_suffix."material_classifys "." where city in(".$city_allow.")";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($rows as $row) {
            $maclass[$row['id']] = $row['name'];
        }
        $this->render('form',array('model'=>$model,'maclass'=> $maclass));
    }
    public function actionSave()
    {
        $data = $_POST['Material'];
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        if ($data['id']>0){
            $result = Yii::app()->db->createCommand()->update($tab_suffix .'material_lists', array('name' => $data['name'],'classify_id' => $data['classify_id'],'registration_no' => $data['registration_no'],'validity'=>$data['validity'],'active_ingredient' => $data['active_ingredient'],'ratio' => $data['ratio'],'brief'=>$data['brief'],'unit' => $data['unit'],'sort' => $data['sort']), 'id=:id', array(':id' => $data['id']));
            $id = $data['id'];
        }else{
            $city = Yii::app()->user->city();
            $result = Yii::app()->db->createCommand()->insert($tab_suffix .'material_lists', array('name' => $data['name'],'classify_id' => $data['classify_id'],'registration_no' => $data['registration_no'],'validity'=>$data['validity'],'active_ingredient' => $data['active_ingredient'],'ratio' => $data['ratio'],'brief'=>$data['brief'],'unit' => $data['unit'],'sort' => $data['sort'],'creat_time'=>date('Y-m-d h:i:s', time())));
            $id = Yii::app()->db->getLastInsertID();
        }
        if ($result) {
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
            $this->redirect(Yii::app()->createUrl('materiallist/edit',array('index'=>$id)));
        } else {
            Dialog::message(Yii::t('dialog','Validation Message'), Yii::t('dialog','Save no Done'));
            $this->redirect(Yii::app()->createUrl('materiallist/edit',array('index'=>$id)));
        }
    }
    public function actionDelete()
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $de = Yii::app()->db->createCommand()->delete($tab_suffix .'material_lists', 'id=:id', array(':id' => $_POST['Material']['id']));
        if ($de) {
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Submission Done'));
            $this->redirect(Yii::app()->createUrl('materiallist/index'));
        } else {
            Dialog::message(Yii::t('dialog','Validation Message'), Yii::t('dialog','Save no Done'));
            $this->redirect(Yii::app()->createUrl('materiallist/index'));
        }
    }
    public function actionEdit($index)
    {
        $model = new Material('view');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            // print_r($model);exit();
            $tab_suffix = Yii::app()->params['table_envSuffix'];
            $city_allow = Yii::app()->user->city_allow();
            $sql = "select id,name from ".$tab_suffix."material_classifys "." where city in(".$city_allow.")";
            $rows = Yii::app()->db->createCommand($sql)->queryAll();
            foreach ($rows as $row) {
                $maclass[$row['id']] = $row['name'];
            }
            $this->render('form',array('model'=>$model,'maclass'=> $maclass));
        }
    }

}