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
				'actions'=>array('new','edit','delete','save','add','down','AllDelete'),
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
			if (isset($session['report_rq02']) && !empty($session['report_rq02'])) {
				$criteria = $session['report_rq02'];
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
		if (!$model->retrieveData($index)) {
			throw new CHttpException(404,'The requested page does not exist.');
		} else {
			$this->render('form',array('model'=>$model,));
		}
	}

	public static function allowReadWrite() {
		return Yii::app()->user->validRWFunction('RQ02');
	}
	
	public static function allowReadOnly() {
		return Yii::app()->user->validFunction('RQ02');
	}
}
