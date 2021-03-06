<?php

class ReportjobController extends Controller
{
	public $function_id='RQ01';

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

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
/*		
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','new','edit','delete','save'),
				'users'=>array('@'),
			),
*/
			array('allow', 
				'actions'=>array('new','edit','delete','save','add','down','AllDelete','delcache','batch','batchcreate','batchdown'),
				'expression'=>array('ReportjobController','allowReadWrite'),
			),
			array('allow', 
				'actions'=>array('index','view'),
				'expression'=>array('ReportjobController','allowReadOnly'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex($pageNum=0) 
	{
		$model = new ReportjobList;
		if (isset($_POST['ReportjobList'])) {
			$model->attributes = $_POST['ReportjobList'];
		} else {
			$session = Yii::app()->session;
			if (isset($session[$model->criteriaName()]) && !empty($session[$model->criteriaName()])) {
				$criteria = $session[$model->criteriaName()];
				$model->setCriteria($criteria);
			}
		}
		$model->determinePageNum($pageNum);
		$model->retrieveDataByPage($model->pageNum);

		$this->render('index',array('model'=>$model));
	}

    public function actionAdd(){
        if (isset($_GET)) {
            $model = new ReportjobForm;
            $model->newData($_GET);
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
            $this->redirect(Yii::app()->createUrl('reportjob/index'));
        }
    }

	public function actionSave()
	{
		if (isset($_POST['ReportjobForm'])) {
			$model = new ReportjobForm($_POST['ReportjobForm']['scenario']);
			$model->attributes = $_POST['ReportjobForm'];
			if ($model->validate()) {
				$model->saveData();
				$model->scenario = 'edit';
				Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
				$this->redirect(Yii::app()->createUrl('reportjob/edit',array('index'=>$model->id)));
			} else {
				$message = CHtml::errorSummary($model);
				Dialog::message(Yii::t('dialog','Validation Message'), $message);
				$this->render('form',array('model'=>$model,));
			}
		}
	}

	public function actionView($index)
	{
		$model = new ReportjobForm('view');
		if (!$model->retrieveData($index)) {
			throw new CHttpException(404,'The requested page does not exist.');
		} else {
			$this->render('form',array('model'=>$model,));
		}
	}
	
	public function actionNew()
	{
		$model = new ReportjobForm('new');
		$this->render('form',array('model'=>$model,));
	}
	public function actionEdit($index)
	{
		$model = new ReportjobForm('edit');
		if (!$model->retrieveData($index,1)) {
			throw new CHttpException(404,'The requested page does not exist.');
		} else {
			$this->render('form',array('model'=>$model,));
		}
	}
	
	public function actionDelete()
	{
		$model = new ReportjobForm('delete');
		if (isset($_POST['ReportjobForm'])) {
			$model->attributes = $_POST['ReportjobForm'];
			$model->saveData();
			Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
		}
		$this->redirect(Yii::app()->createUrl('reportjob/index'));
	}

	public function actionAllDelete()
    {
        $model = new ReportjobForm;
        if(isset($_POST['ReportjobList']['attr'])){
            foreach ($_POST['ReportjobList']['attr'] as $a){
                $model->deleteData($a);
            }
            $this->redirect(Yii::app()->createUrl('reportjob/index'));
        }else{
            Dialog::message(Yii::t('dialog','Warning'), Yii::t('dialog','No Record Found'));
            $this->redirect(Yii::app()->createUrl('reportjob/index'));
        }

    }

    public function actionDown($index)
    {
        $model = new ReportjobForm;
        if (!$model->retrieveData($index,0)) {

            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            Dialog::message(Yii::t('dialog','Warning'), Yii::t('dialog','No Record Found'));
            $this->redirect(Yii::app()->createUrl('reportjob/index'));
        }
    }
    public function actionDelcache($index,$jobdate,$city)
    {
        $reportfile = Yii::app()->basePath."/images/report/".$city."/".$jobdate."/".$index.'.pdf';
        $isc = file_exists($reportfile);
        if ($isc){
            unlink ($reportfile);
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
        }else {
            Dialog::message(Yii::t('dialog','Warning'), Yii::t('dialog','No Record Found'));
        }
        $this->redirect(Yii::app()->createUrl('reportjob/index'));
    }

    public function actionBatch()
    {
        $model = new ReportjobForm('batch');
        $this->render('batch',array('model'=>$model,));
    }
    public function actionBatchcreate()
    {
        $model = new ReportjobForm('batch');
        if(isset($_POST['ReportjobForm'])){
            $model->batchcreate($_POST['ReportjobForm']);
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Report Done'));
            $this->redirect(Yii::app()->createUrl('reportjob/batch'));
        }else{
            Dialog::message(Yii::t('dialog','Warning'), Yii::t('dialog','Save Report no Done'));
            $this->redirect(Yii::app()->createUrl('reportjob/batch'));
        }
    }
    public function actionBatchdown()
    {
        $model = new ReportjobForm('batch');
        if(isset($_POST['ReportjobForm'])){
            $model->batchdown($_POST['ReportjobForm']);
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Download Report Done'));
            $this->redirect(Yii::app()->createUrl('reportjob/batch'));
        }else{
            Dialog::message(Yii::t('dialog','Warning'), Yii::t('dialog','Save Download no Done'));
            $this->redirect(Yii::app()->createUrl('reportjob/batch'));
        }
    }
	public static function allowReadWrite() {
		return Yii::app()->user->validRWFunction('RQ01');
	}
	
	public static function allowReadOnly() {
		return Yii::app()->user->validFunction('RQ01');
	}
}
