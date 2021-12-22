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
    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('new','edit','delete','save','import'),
                'expression'=>array('MateriallistController','allowReadWrite'),
            ),
            array('allow',
                'actions'=>array('index','view','export'),
                'expression'=>array('MateriallistController','allowReadOnly'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionIndex($pageNum=0)
    {
        $model = new MaterialList;
        if (isset($_POST['MaterialList'])) {
            $model->attributes = $_POST['MaterialList'];
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
    public function actionView($index)
    {
        $model = new MaterialFrom('view');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $tab_suffix = Yii::app()->params['table_envSuffix'];
            $city_allow = Yii::app()->user->city_allow();
            $sql = "select id,name from ".$tab_suffix."material_classifys "." where city in(".$city_allow.")";
            $rows = Yii::app()->db->createCommand($sql)->queryAll();
            $maclass = [];
            $this->render('form',array('model'=>$model,'maclass'=> $maclass));
        }
    }

    public function actionNew()
    {
        $model = new MaterialFrom('new');
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
        $sql = "select id,name from ".$tab_suffix."material_classifys "." where city in(".$city_allow.")";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        $maclass = [];
        foreach ($rows as $row) {
            $maclass[$row['id']] = $row['name'];
        }
        $status_lists = ['1'=>'启用','0'=>'未启用'];
        $this->render('form',array('model'=>$model,'maclass'=> $maclass,'status_lists'=>$status_lists));
    }

    public function actionEdit($index)
    {
        $model = new MaterialFrom('edit');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $tab_suffix = Yii::app()->params['table_envSuffix'];
            $city_allow = Yii::app()->user->city_allow();
            $sql = "select id,name from ".$tab_suffix."material_classifys "." where city in(".$city_allow.")";
            $rows = Yii::app()->db->createCommand($sql)->queryAll();
            $maclass = [];
            foreach ($rows as $row) {
                $maclass[$row['id']] = $row['name'];
            }
            $status_lists = ['1'=>'启用','0'=>'未启用'];
            $this->render('form',array('model'=>$model,'maclass'=> $maclass,'status_lists'=>$status_lists));
        }
    }
    public function actionSave()
    {
        if (isset($_POST['MaterialFrom'])) {
            $model = new MaterialFrom($_POST['MaterialFrom']['scenario']);
            $model->attributes = $_POST['MaterialFrom'];
            if ($model->validate()) {
                $model->saveData();
                $model->scenario = 'edit';
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
                $tab_suffix = Yii::app()->params['table_envSuffix'];
                $city_allow = Yii::app()->user->city_allow();
                $sql = "select id,name from ".$tab_suffix."material_classifys "." where city in(".$city_allow.")";
                $rows = Yii::app()->db->createCommand($sql)->queryAll();
                $maclass = [];
                $status_lists = ['1'=>'启用','0'=>'未启用'];
                $this->redirect(Yii::app()->createUrl('materiallist/edit',array('index'=>$model->id,'maclass'=> $maclass,'status_lists'=>$status_lists)));
            } else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog','Validation Message'), $message);
                $tab_suffix = Yii::app()->params['table_envSuffix'];
                $city_allow = Yii::app()->user->city_allow();
                $sql = "select id,name from ".$tab_suffix."material_classifys "." where city in(".$city_allow.")";
                $rows = Yii::app()->db->createCommand($sql)->queryAll();
                $maclass = [];
                foreach ($rows as $row) {
                    $maclass[$row['id']] = $row['name'];
                }
                $status_lists = ['1'=>'启用','0'=>'未启用'];
                $this->render('form',array('model'=>$model,'maclass'=> $maclass,'status_lists'=>$status_lists));
            }
        }
    }
    public function actionDelete()
    {
        $model = new MaterialFrom('delete');
        if (isset($_POST['MaterialFrom'])) {
            $model->attributes = $_POST['MaterialFrom'];
            $model->saveData();
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
        }
//		$this->actionIndex();
        $this->redirect(Yii::app()->createUrl('materiallist/index'));
    }
	
	public function actionImport() {
        $model = new MaterialList;
        if (isset($_POST['MaterialList'])) {
            $model->attributes = $_POST['MaterialList'];
			if ($model->validate()) {
				if ($file = CUploadedFile::getInstance($model,'import_file')) {
					$objImport = new Import;
					$objData = new MaterialData;
				
					$objImport->readerType = $objImport->getReaderTypefromFileExtension($file->extensionName);
					$objImport->fileName = $file->tempName;
					$objImport->dataModel = $objData;
					$message = $objImport->run();
				
					$model->determinePageNum(0);
					$model->retrieveDataByPage($model->pageNum);
					Dialog::message(Yii::t('import','View Log'), $message, -999);
				} else {
					$message = Yii::t('import','Upload file error');
					Dialog::message(Yii::t('dialog','Error Message'), $message);
				}		
			} else {
				$message = CHtml::errorSummary($model);
				Dialog::message(Yii::t('dialog','Validation Message'), $message);
			}
		}
        $this->render('index',array('model'=>$model));
	}
	
	public function actionExport() {
		$model = new MaterialList;
		$session = Yii::app()->session;
		if (isset($session['materiallist_ms01']) && !empty($session['materiallist_ms01'])) {
			$materiallist = $session['materiallist_ms01'];
			$model->setCriteria($materiallist);
		}
		$model->noOfItem = 0;
        $model->determinePageNum(0);
        $model->retrieveDataByPage($model->pageNum);
		
		$objData = new RptMateriallist;
		$objData->data = $model->attr;
		$objExport = new Export;
		$objExport->dataModel = $objData;
		
		$filename = 'material.xlsx';
		$objExport->exportExcel($filename);
	}
	
    public static function allowReadWrite() {
        return Yii::app()->user->validRWFunction('MS01');
    }

    public static function allowReadOnly() {
        return Yii::app()->user->validFunction('MS01');
    }
}
?>