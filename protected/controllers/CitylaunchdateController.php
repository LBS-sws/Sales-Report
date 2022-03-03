<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/9/18
 * Time: 10:35
 */

class CitylaunchdateController extends Controller
{
    public $function_id='OS08';

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
                'actions'=>array('new','edit','delete','save'),
                'expression'=>array('CitylaunchdateController','allowReadWrite'),
            ),
            array('allow',
                'actions'=>array('index','view'),
                'expression'=>array('CitylaunchdateController','allowReadOnly'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionIndex($pageNum=0)
    {
        $model = new CitylaunchdateList();
        if (isset($_POST['CitylaunchdateList'])) {
            $model->attributes = $_POST['CitylaunchdateList'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['citylaunchdate_ss01']) && !empty($session['citylaunchdate_ss01'])) {
                $citylaunchdatelist = $session['citylaunchdate_ss01'];
                $model->setCriteria($citylaunchdatelist);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index',array('model'=>$model));
    }
    public function actionView($index)
    {
        $model = new CitylaunchdateList('view');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $this->render('form',array('model'=>$model));
        }
    }
    public function actionNew()
    {
        $model = new CitylaunchdateFrom('new');
        //当前城市列表
        $se_suffix = Yii::app()->params['envSuffix'];
        $sql = "select code as city,name as city_name from security".$se_suffix.".sec_city";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        $city_lists = [];
        foreach ($rows as $row) {
            $city_lists[$row['city']] = $row['city']."(".$row['city_name'].")";
        }
        $this->render('form',array('model'=>$model,'city_lists'=>$city_lists));
    }

    public function actionSave()
    {
        if (isset($_POST['CitylaunchdateFrom'])) {
            $model = new CitylaunchdateFrom($_POST['CitylaunchdateFrom']['scenario']);
            $model->attributes = $_POST['CitylaunchdateFrom'];
            if ($model->validate()) {
                $model->saveData();
                $model->scenario = 'edit';
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
                //当前城市列表
                $se_suffix = Yii::app()->params['envSuffix'];
                $sql = "select code as city,name as city_name from security".$se_suffix.".sec_city";
                $rows = Yii::app()->db->createCommand($sql)->queryAll();
                $city_lists = [];
                foreach ($rows as $row) {
                    $city_lists[$row['city']] = $row['city']."(".$row['city_name'].")";
                }
                $this->redirect(Yii::app()->createUrl('citylaunchdate/edit',array('index'=>$model->id,'city_lists'=>$city_lists)));
            } else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog','Validation Message'), $message);
                //当前城市列表
                $se_suffix = Yii::app()->params['envSuffix'];
                $sql = "select code as city,name as city_name from security".$se_suffix.".sec_city";
                $rows = Yii::app()->db->createCommand($sql)->queryAll();
                $city_lists = [];
                foreach ($rows as $row) {
                    $city_lists[$row['city']] = $row['city']."(".$row['city_name'].")";
                }
                $this->render('form',array('model'=>$model,'city_lists'=>$city_lists));
            }
        }
    }
    public function actionDelete()
    {
        $model = new CitylaunchdateFrom('delete');
        if (isset($_POST['CitylaunchdateFrom'])) {
            $model->attributes = $_POST['CitylaunchdateFrom'];
            $model->saveData();
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
        }
//		$this->actionIndex();
        $this->redirect(Yii::app()->createUrl('citylaunchdate/index'));
    }
    public function actionEdit($index)
    {
        $model = new CitylaunchdateFrom('edit');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            //当前城市列表
            $se_suffix = Yii::app()->params['envSuffix'];
            $sql = "select code as city,name as city_name from security".$se_suffix.".sec_city";
            $rows = Yii::app()->db->createCommand($sql)->queryAll();
            $city_lists = [];
            foreach ($rows as $row) {
                $city_lists[$row['city']] = $row['city']."(".$row['city_name'].")";
            }
            $this->render('form',array('model'=>$model,'city_lists'=>$city_lists));
        }
    }
    public static function allowReadWrite() {
        return Yii::app()->user->validRWFunction('OS08');
    }

    public static function allowReadOnly() {
        return Yii::app()->user->validFunction('OS08');
    }
}