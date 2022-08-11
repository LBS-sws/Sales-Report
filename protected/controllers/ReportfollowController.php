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
				'actions'=>array('new','edit','delete','save','add','down','AllDelete','delcache','batch','batchcreate','batchdown','emaildetail','resentemail'),
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

	public function actionEmaildetail($jobid) {
		$rtn = '';
		$data = ReportEmail::getData($jobid, 2);
        if (key_exists("message",$data) && $data["message"]=="Success" && isset($data['data'])) {
			foreach ($data['data'] as $row) {
				$status = $row['status'];
				$status_desc = $status=='C' ? '成功' : ($status=='F' ? '失败' : ($status='P' ? '待发送' : '进行中'));
				$send_dt = $row['send_dt'];
				$message = $row['message'];
				$mesgrow = $status=='F' ? "<tr><td width=15%><b>错误信息</b></td><td colspan=3>$message</td></tr>" : '';
				$to_addr = json_decode($row['to_addr'], true);
				$to_addr_text = is_array($to_addr) ? implode(';', $to_addr) : (empty($row['to_addr']) ? '待定' : $row['to_addr']);
				$rtn .= <<<EOF
<table class="table table-bordered">
	<tr><td width=15%><b>收件者:</b></td><td colspan=3>$to_addr_text</td></tr>
	<tr><td width=15%><b>发送时间:</b></td><td>$send_dt</td><td width=10%><b>状态:</b></td><td>$status_desc</td></tr>
	$mesgrow
</table>
<br>
EOF;
			}
		}
		if ($rtn=='') $rtn = <<<EOF
<table class="table table-bordered">
	<tr><td>没有发送记录</td></tr>
</table>
<br>
EOF;
		echo $rtn;
	}
	
	public function actionResentemail($job_id) {
		$data = ReportEmail::addData($job_id, 2);
		if ($data['code']==0) {
            Dialog::message(Yii::t('dialog','Information'), '成功. 电邮待重发.');
		} else {
            Dialog::message(Yii::t('dialog','Warning'), '电邮未能重发.');
		}	
		$this->redirect(Yii::app()->createUrl('reportfollow/index'));
	}
	
	public static function allowReadWrite() {
		return Yii::app()->user->validRWFunction('RQ02');
	}
	
	public static function allowReadOnly() {
		return Yii::app()->user->validFunction('RQ02');
	}
}
