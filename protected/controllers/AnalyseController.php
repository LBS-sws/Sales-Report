<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2023/04/27
 * Time: 10:45
 */
class AnalyseController extends Controller
{
    public $function_id = 'PE03';

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
                'actions' => array('new', 'edit', 'delete', 'save'),
                'expression' => array('AnalyseController', 'allowReadWrite'),
            ),
            array('allow',
                'actions' => array('index', 'view','api'),
                'expression' => array('AnalyseController', 'allowReadOnly'),
            ),
            array('allow',
                'actions' => array('api'),
                'users' => array('*'),
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }


    public function actionIndex($pageNum = 0)
    {
        $city = Yii::app()->user->city();

        $this->render('index', array('city' => $city,'api_url'=>Yii::app()->params['baseUrl_imgs']));
    }

    public function actionNew()
    {
        $model = new PestDictFrom('new');
        $city = Yii::app()->user->city();
        $sql = "select id as type_id,type_name from lbs_pest_type where  city = \"$city\"";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        $pest_type_list = array();
        foreach ($rows as $row) {
            $pest_type_list[$row['type_id']] = $row['type_name'];
        }
        $this->render('form', array('model' => $model, 'pest_type_list' => $pest_type_list));
    }

    public function actionSave()
    {
        if (isset($_POST['PestDictFrom'])) {
            $model = new PestDictFrom($_POST['PestDictFrom']['scenario']);
            $model->attributes = $_POST['PestDictFrom'];
            if ($model->validate()) {
                $model->saveData();
                $model->scenario = 'edit';
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
                $city = Yii::app()->user->city();
                $sql = "select id as type_id,type_name from lbs_pest_type where  city = \"$city\"";
                $rows = Yii::app()->db->createCommand($sql)->queryAll();
                $pest_type_list = array();
                foreach ($rows as $row) {
                    $pest_type_list[$row['type_id']] = $row['type_name'];
                }
                $this->redirect(Yii::app()->createUrl('pestdict/edit',array('index'=>$model->id,'pest_type_list'=>$pest_type_list)));
            } else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog', 'Validation Message'), $message);
                $city = Yii::app()->user->city();
                $sql = "select id as type_id,type_name from lbs_pest_type where  city = \"$city\"";
                $rows = Yii::app()->db->createCommand($sql)->queryAll();
                $pest_type_list = array();
                foreach ($rows as $row) {
                    $pest_type_list[$row['type_id']] = $row['type_name'];
                }
                $this->render('form', array('model' => $model, 'pest_type_list' => $pest_type_list));
            }
        }
    }

    public function actionDelete()
    {
        $model = new ShortcutFrom('delete');
        if (isset($_POST['ShortcutFrom'])) {
            $model->attributes = $_POST['ShortcutFrom'];
            $model->saveData();
            Dialog::message(Yii::t('dialog', 'Information'), Yii::t('dialog', 'Record Deleted'));
        }
//		$this->actionIndex();
        $this->redirect(Yii::app()->createUrl('shortcut/index'));
    }

    public function actionEdit($index)
    {
        $model = new PestDictFrom('edit');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404, 'The requested page does not exist.');
        } else {
            $city = Yii::app()->user->city();
            $sql = "select id as type_id,type_name from lbs_pest_type where  city = \"$city\"";
            $rows = Yii::app()->db->createCommand($sql)->queryAll();
            $pest_type_list = array();
            foreach ($rows as $row) {
                $pest_type_list[$row['type_id']] = $row['type_name'];
            }
            $this->render('form',array('model'=>$model,'pest_type_list'=>$pest_type_list));
        }

//
//        $model = new PestType('edit');
//        if (!$model->retrieveData($index)) {
//            throw new CHttpException(404, 'The requested page does not exist.');
//        } else {
//            $this->render('form', array('model' => $model));
//        }
    }

    public static function allowReadWrite()
    {
        return Yii::app()->user->validRWFunction('OS01');
    }

    public static function allowReadOnly()
    {
        return Yii::app()->user->validFunction('OS01');
    }
}
