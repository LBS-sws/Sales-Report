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
				'actions'=>array('new','edit','delete','save','add','down','AllDelete','delcache','batch','batchcreate','batchdown','emaildetail','resentemail','downloadinbatch','downloadzip'),
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

	public function actionIndex($pageNum=0,$fid='') 
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

		$this->render('index',array('model'=>$model,'fid'=>$fid));
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
	
	public function actionEmaildetail($jobid) {
		$rtn = '';
		$data = ReportEmail::getData($jobid, 1);
        if (key_exists("message",$data) && $data["message"]=="Success" && isset($data['data'])) {
			foreach ($data['data'] as $row) {
				$status = $row['status'];
				$status_desc = $status=='C' ? '成功' : ($status=='F' ? '失败' : ($status=='P' ? '待发送' : '进行中'));
				$send_dt = $row['send_dt'];
				$message = $row['message'];
				$mesgrow = $status=='F' ? "<tr><td width=15%><b>错误信息</b></td><td colspan=3>$message</td></tr>" : '';
//				$to_addr = json_decode($row['to_addr'], true);
//				$to_addr_text = is_array($to_addr) ? implode(';', $to_addr) : (empty($row['to_addr']) && $status=='P' ? '数据读取中' : $row['to_addr']);
				$to_addr_text = empty($row['to_addr']) && $status=='P' ? '数据读取中' : $row['to_addr'];
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
		$data = ReportEmail::addData($job_id, 1);
		if ($data['code']==0) {
            Dialog::message(Yii::t('dialog','Information'), '成功. 电邮待重发.');
		} else {
            Dialog::message(Yii::t('dialog','Warning'), '电邮未能重发.');
		}	
		$this->redirect(Yii::app()->createUrl('reportjob/index'));
	}

	public function actionDownloadinbatch() 
	{
		$count = ReportJobBatch::countJobReport();
		if ($count == 0) {
            Dialog::message(Yii::t('dialog','Warning'), '未能下载. 原因: 沒有相關下载项目.');
			$this->redirect(Yii::app()->createUrl('reportjob/index'));
		} elseif ($count > 50) {
            Dialog::message(Yii::t('dialog','Warning'), '未能下载. 原因: 下载项目超过50个.');
			$this->redirect(Yii::app()->createUrl('reportjob/index'));
		} else {
			$zip = ReportJobBatch::downloadJobReport();
            Dialog::message(Yii::t('dialog','Information'), '下载完成');
			$this->redirect(Yii::app()->createUrl('reportjob/index',array('fid'=>$zip[0],'fileName'=>$zip[1])));
		}
	}

	public function actionDownloadzip($fid,$fileName) {
		$zipname = sys_get_temp_dir().'/'.$fid.'.zip';
        var_dump($zipname);exit;
		header('Content-Type: application/zip');
        $filename=iconv("UTF-8","GB2312",$fileName);
		header("Content-disposition: attachment; filename=$fid.zip");
		header('Content-Length: ' . filesize($zipname));
		readfile($zipname);
		unlink($zipname);
		Yii::app()->end();
	}
	
	public static function allowReadWrite() {
		return Yii::app()->user->validRWFunction('RQ01');
	}
	
	public static function allowReadOnly() {
		return Yii::app()->user->validFunction('RQ01');
	}
}
