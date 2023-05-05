<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2023/04/14
 * Time: 10:45
 */
class PestdictController extends Controller
{
    public $function_id = 'PE02';

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
                'expression' => array('PestdictController', 'allowReadWrite'),
            ),
            array('allow',
                'actions' => array('index', 'view','api'),
                'expression' => array('PestdictController', 'allowReadOnly'),
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
    public function encrypt($data, $key) {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }

// 解密数据
    public function decrypt($data, $key) {
        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    }


    public function actionApi(){
        header('Content-Type: text/html; charset=utf-8');
        $authkey = 'TFJTR1JPVVBfd2FpdDk3Mw==';
        $data = array();
        $data = $_POST;
        if (isset($_POST['authkey']) && $data['authkey'] == $authkey ) {
            $city = $_POST['data'];
            $sql = "select type_name,analysis_result,lpd.city,insect_name,measure,suggestion,type_id from lbs_pest_dict as lpd  join  lbs_pest_type as lpt on lpt.id = lpd.type_id  where  lpd.city = \"$city\"";
            $rows = Yii::app()->db->createCommand($sql)->queryAll();
            return exit(json_encode($rows));
        }else{
            exit('no auth');
        }
    }

    public function actionIndex($pageNum = 0)
    {
        $model = new PestDict();
        if (isset($_POST['PestDictList'])) {
            $model->attributes = $_POST['PestDictList'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['pestdict_PE01']) && !empty($session['pestdict_PE01'])) {
                $materiallist = $session['pestdict_PE01'];
                $model->setCriteria($materiallist);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index', array('model' => $model));
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
        $model = new PestDictFrom('delete');
        if (isset($_POST['PestDictFrom'])) {
            $model->attributes = $_POST['PestDictFrom'];
            $model->saveData();
            Dialog::message(Yii::t('dialog', 'Information'), Yii::t('dialog', 'Record Deleted'));
        }
//		$this->actionIndex();
        $this->redirect(Yii::app()->createUrl('pestdict/index'));
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
