<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:45
 */

class ShortcutcontentController extends Controller
{
    public $function_id='OS02';

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
        $model = new Shortcutcontent();
        if (isset($_POST['Shortcutcontent'])) {
            $model->attributes = $_POST['Shortcutcontent'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['shortcutcontent_os02']) && !empty($session['shortcutcontent_os02'])) {
                $materiallist = $session['shortcutcontent_os02'];
                $model->setCriteria($materiallist);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index',array('model'=>$model));
    }
    public function actionNew()
    {
        $model = new Shortcutcontent('new');
        $city_allow = Yii::app()->user->city_allow();
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $sql = "select s.ServiceName,t.* from ".$tab_suffix."shortcuts as t  left join service as s on t.service_type=s.ServiceType where t.city in(".$city_allow.")";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        $service_type_lists = [];
        foreach ($rows as $row) {
            $service_type_lists[$row['id']] = $row['ServiceName']."-".$row['shortcut_name'];
        }
        $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists));
    }
    public function actionSave()
    {
        $data = $_POST['Shortcutcontent'];
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        if ($data['id']>0){
            $result = Yii::app()->db->createCommand()->update($tab_suffix .'shortcut_contents', array('shortcut_id' => $data['shortcut_id'],'content' => $data['content']), 'id=:id', array(':id' => $data['id']));
            $id = $data['id'];
        }else{
            $city = Yii::app()->user->city();
            $result = Yii::app()->db->createCommand()->insert($tab_suffix .'shortcut_contents', array('shortcut_id' => $data['shortcut_id'],'content' => $data['content'],'creat_time'=>date('Y-m-d H:i:s', time())));
            $id = Yii::app()->db->getLastInsertID();
        }
        if ($result) {
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
            $this->redirect(Yii::app()->createUrl('shortcutcontent/edit',array('index'=>$id)));
        } else {
            Dialog::message(Yii::t('dialog','Validation Message'), Yii::t('dialog','Save no Done'));
            $this->redirect(Yii::app()->createUrl('shortcutcontent/edit',array('index'=>$id)));
        }
    }
    public function actionDelete()
    {
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $de = Yii::app()->db->createCommand()->delete($tab_suffix .'shortcut_contents', 'id=:id', array(':id' => $_POST['Shortcutcontent']['id']));
        if ($de) {
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Submission Done'));
            $this->redirect(Yii::app()->createUrl('shortcutcontent/index'));
        } else {
            Dialog::message(Yii::t('dialog','Validation Message'), Yii::t('dialog','Save no Done'));
            $this->redirect(Yii::app()->createUrl('shortcutcontent/index'));
        }
    }
    public function actionEdit($index)
    {
        $model = new Shortcutcontent('view');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            // print_r($model);exit();
            $city_allow = Yii::app()->user->city_allow();
            $tab_suffix = Yii::app()->params['table_envSuffix'];
            $sql = "select s.ServiceName,t.* from ".$tab_suffix."shortcuts as t  left join service as s on t.service_type=s.ServiceType where t.city in(".$city_allow.")";
            $rows = Yii::app()->db->createCommand($sql)->queryAll();
            $service_type_lists = [];
            foreach ($rows as $row) {
                $service_type_lists[$row['id']] = $row['ServiceName']."-".$row['shortcut_name'];
            }
            $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists));
        }
    }

}