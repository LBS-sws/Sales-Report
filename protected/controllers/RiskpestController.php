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
    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('new','edit','delete','save','import'),
                'expression'=>array('RiskpestController','allowReadWrite'),
            ),
            array('allow',
                'actions'=>array('index','view','export'),
                'expression'=>array('RiskpestController','allowReadOnly'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    public function actionIndex($pageNum=0)
    {
        $model = new RiskpestList();
        if (isset($_POST['RiskpestList'])) {
            $model->attributes = $_POST['RiskpestList'];
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
        $model = new RiskpestFrom('new');
        $this->render('form',array('model'=>$model));
    }
    public function actionSave()
    {
        if (isset($_POST['RiskpestFrom'])) {
            $model = new RiskpestFrom($_POST['RiskpestFrom']['scenario']);
            $model->attributes = $_POST['RiskpestFrom'];
            if ($model->validate()) {
                $model->saveData();
                $model->scenario = 'edit';
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
                $this->redirect(Yii::app()->createUrl('riskpest/edit',array('index'=>$model->id)));
            } else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog','Validation Message'), $message);
                $this->render('form',array('model'=>$model));
            }
        }
    }
    public function actionDelete()
    {
        $model = new RiskpestFrom('delete');
        if (isset($_POST['RiskpestFrom'])) {
            $model->attributes = $_POST['RiskpestFrom'];
            $model->saveData();
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
        }
//		$this->actionIndex();
        $this->redirect(Yii::app()->createUrl('riskpest/index'));
    }
    public function actionEdit($index)
    {
        $model = new RiskpestFrom('edit');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $this->render('form',array('model'=>$model));
        }
    }

	public function actionImport() {
        $model = new RiskpestList;
        if (isset($_POST['RiskpestList'])) {
            $model->attributes = $_POST['RiskpestList'];
			if ($model->validate()) {
				if ($file = CUploadedFile::getInstance($model,'import_file')) {
					$objImport = new Import;
					$objData = new RiskpestData;
				
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
		$model = new RiskpestList;
		$session = Yii::app()->session;
		if (isset($session['riskpest_rs01']) && !empty($session['riskpest_rs01'])) {
			$riskpestlist = $session['riskpest_rs01'];
			$model->setCriteria($riskpestlist);
		}
		$model->noOfItem = 0;
        $model->determinePageNum(0);
        $model->retrieveDataByPage($model->pageNum);
		
		$objData = new RptRiskpestlist;
		$objData->data = $model->attr;
		$objExport = new Export;
		$objExport->dataModel = $objData;
		
		$filename = 'riskpest.xlsx';
		$objExport->exportExcel($filename);
	}

    public static function allowReadWrite() {
        return Yii::app()->user->validRWFunction('RS01');
    }

    public static function allowReadOnly() {
        return Yii::app()->user->validFunction('RS01');
    }
}