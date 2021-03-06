<?php

class ReportfollowController extends Controller
{
	public $function_id='RQ02';

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
				'expression'=>array('ReportfollowController','allowReadWrite'),
			),
			array('allow', 
				'actions'=>array('index','view'),
				'expression'=>array('ReportfollowController','allowReadOnly'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex($pageNum=0) 
	{
		$model = new ReportfollowList;
		if (isset($_POST['ReportfollowList'])) {
			$model->attributes = $_POST['ReportfollowList'];
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

	public function actionEdit($index)
	{
		$model = new ReportfollowForm('edit');
		if (!$model->retrieveData($index,1)) {
			throw new CHttpException(404,'The requested page does not exist.');
		} else {
			$this->render('form',array('model'=>$model,));
		}
	}
    public function actionDown($index)
    {
        $model = new ReportfollowForm;
        if (!$model->retrieveData($index,0)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            Dialog::message(Yii::t('dialog','Warning'), Yii::t('dialog','No Record Found'));
            $this->redirect(Yii::app()->createUrl('reportfollow/index'));
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
        $this->redirect(Yii::app()->createUrl('reportfollow/index'));
    }
    public function actionBatch()
    {
        $model = new ReportfollowForm('batch');
        $this->render('batch',array('model'=>$model,));
    }
    public function actionBatchcreate()
    {
        $model = new ReportfollowForm('batch');
        if(isset($_POST['ReportfollowForm'])){
            $model->batchcreate($_POST['ReportfollowForm']);
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Report Done'));
            $this->redirect(Yii::app()->createUrl('reportfollow/batch'));
        }else{
            Dialog::message(Yii::t('dialog','Warning'), Yii::t('dialog','Save Report no Done'));
            $this->redirect(Yii::app()->createUrl('reportfollow/batch'));
        }
    }
    public function actionBatchdown()
    {
        $model = new ReportfollowForm('batch');
        if(isset($_POST['ReportfollowForm'])){
            $model->batchdown($_POST['ReportfollowForm']);
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Download Report Done'));
            $this->redirect(Yii::app()->createUrl('reportfollow/batch'));
        }else{
            Dialog::message(Yii::t('dialog','Warning'), Yii::t('dialog','Save Download no Done'));
            $this->redirect(Yii::app()->createUrl('reportfollow/batch'));
        }
    }
	public static function allowReadWrite() {
		return Yii::app()->user->validRWFunction('RQ02');
	}
	
	public static function allowReadOnly() {
		return Yii::app()->user->validFunction('RQ02');
	}
}
