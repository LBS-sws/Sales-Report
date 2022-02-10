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
				'actions'=>array('new','edit','delete','save','add','down','AllDelete'),
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
			if (isset($session['report_rq01']) && !empty($session['report_rq01'])) {
				$criteria = $session['report_rq01'];
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
	

	public static function allowReadWrite() {
		return Yii::app()->user->validRWFunction('RQ01');
	}
	
	public static function allowReadOnly() {
		return Yii::app()->user->validFunction('RQ01');
	}
}
