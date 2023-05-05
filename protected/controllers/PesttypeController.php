<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2023/04/14
 * Time: 10:45
 */
class PesttypeController extends Controller
{
    public $function_id = 'PE01';

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
                'expression' => array('PesttypeController', 'allowReadWrite'),
            ),
            array('allow',
                'actions' => array('index', 'view'),
                'expression' => array('PesttypeController', 'allowReadOnly'),
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex($pageNum = 0)
    {
        $model = new PestType();
        if (isset($_POST['PestTypeList'])) {
            $model->attributes = $_POST['PestTypeList'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['pest_type_PE01']) && !empty($session['pest_type_PE01'])) {
                $materiallist = $session['pest_type_PE01'];
                $model->setCriteria($materiallist);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index', array('model' => $model));
    }

    public function actionNew()
    {
        $model = new PestTypeFrom('new');
        $sql = "select ServiceType,ServiceName from service where ServiceName is not null";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        // $service_type_lists = [];
        foreach ($rows as $row) {
            $service_type_lists[$row['ServiceType']] = $row['ServiceName'];
        }
        $this->render('form', array('model' => $model, 'service_type_lists' => $service_type_lists));
    }

    public function actionSave()
    {
        if (isset($_POST['PestTypeFrom'])) {
            $model = new PestTypeFrom($_POST['PestTypeFrom']['scenario']);
            $model->attributes = $_POST['PestTypeFrom'];
            if ($model->validate()) {
                $res = $model->saveData();
                $model->scenario = 'edit';
                Dialog::message(Yii::t('dialog', 'Information'), Yii::t('dialog', 'Save Done'));
                $this->redirect(Yii::app()->createUrl('PestType/edit', array('index' => $model->id)));
            } else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog', 'Validation Message'), $message);
                $this->render('form', array('model' => $model));
            }
        }
    }

    public function actionDelete()
    {
        $model = new PestTypeFrom('delete');
        if (isset($_POST['PestTypeFrom'])) {
            $model->attributes = $_POST['PestTypeFrom'];
            $model->saveData();
            Dialog::message(Yii::t('dialog', 'Information'), Yii::t('dialog', 'Record Deleted'));
        }
//		$this->actionIndex();
        $this->redirect(Yii::app()->createUrl('pesttype/index'));
    }

    public function actionEdit($index)
    {
        $model = new PestTypeFrom('edit');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404, 'The requested page does not exist.');
        } else {
            $this->render('form', array('model' => $model));
        }
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
