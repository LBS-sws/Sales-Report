<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:45
 */

class ShortcutcontentController extends Controller
{
    public $function_id='OS02';

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
                'actions'=>array('new','edit','delete','deleteall','save','import'),
                'expression'=>array('ShortcutcontentController','allowReadWrite'),
            ),
            array('allow',
                'actions'=>array('index','deleteall','view','export'),
                'expression'=>array('ShortcutcontentController','allowReadOnly'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    public function actionDeleteall()
    {
        $shortcutContent = new ShortcutcontentFrom();
        try {
            $shortcutContent->deleteAllData();
            $response = ['success' => true, 'message' => '数据删除成功'];
        } catch (Exception $e) {
            $response = ['success' => false, 'message' => 'Failed to delete all data. Error: ' . $e->getMessage()];
        }
        echo json_encode($response);
        Yii::app()->end();
    }

    public function actionIndex($pageNum=0)
    {
        $model = new ShortcutcontentList();
        if (isset($_POST['ShortcutcontentList'])) {
            $model->attributes = $_POST['ShortcutcontentList'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['shortcutcontent_os02']) && !empty($session['shortcutcontent_os02'])) {
                $materiallist = $session['shortcutcontent_os02'];
                $model->setCriteria($materiallist);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index',array('model'=>$model));
    }
    public function actionNew()
    {
        $model = new ShortcutcontentFrom('new');
        $city_allow = Yii::app()->user->city_allow();
        $tab_suffix = Yii::app()->params['table_envSuffix'];
        $sql = "select s.ServiceName,t.* from ".$tab_suffix."shortcuts as t  left join service as s on t.service_type=s.ServiceType where t.city in(".$city_allow.")";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        $service_type_lists = [];
        foreach ($rows as $row) {
            $service_type_lists[$row['id']] = $row['ServiceName']."-".$row['shortcut_name'];
        }
        $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists));
    }
    public function actionSave()
    {
        if (isset($_POST['ShortcutcontentFrom'])) {
            $model = new ShortcutcontentFrom($_POST['ShortcutcontentFrom']['scenario']);
            $model->attributes = $_POST['ShortcutcontentFrom'];
            if ($model->validate()) {
                $model->saveData();
                $model->scenario = 'edit';
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
                $city_allow = Yii::app()->user->city_allow();
                $tab_suffix = Yii::app()->params['table_envSuffix'];
                $sql = "select s.ServiceName,t.* from ".$tab_suffix."shortcuts as t  left join service as s on t.service_type=s.ServiceType where t.city in(".$city_allow.")";
                $rows = Yii::app()->db->createCommand($sql)->queryAll();
                $service_type_lists = [];
                foreach ($rows as $row) {
                    $service_type_lists[$row['id']] = $row['ServiceName']."-".$row['shortcut_name'];
                }
                $this->redirect(Yii::app()->createUrl('shortcutcontent/edit',array('index'=>$model->id,'service_type_lists'=>$service_type_lists)));
            } else {
                $message = CHtml::errorSummary($model);
                Dialog::message(Yii::t('dialog','Validation Message'), $message);
                $city_allow = Yii::app()->user->city_allow();
                $tab_suffix = Yii::app()->params['table_envSuffix'];
                $sql = "select s.ServiceName,t.* from ".$tab_suffix."shortcuts as t  left join service as s on t.service_type=s.ServiceType where t.city in(".$city_allow.")";
                $rows = Yii::app()->db->createCommand($sql)->queryAll();
                $service_type_lists = [];
                foreach ($rows as $row) {
                    $service_type_lists[$row['id']] = $row['ServiceName']."-".$row['shortcut_name'];
                }
                $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists));
            }
        }
    }
    public function actionDelete()
    {
        $model = new ShortcutcontentFrom('delete');
        if (isset($_POST['ShortcutcontentFrom'])) {
            $model->attributes = $_POST['ShortcutcontentFrom'];
            $model->saveData();
            Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Record Deleted'));
        }
//		$this->actionIndex();
        $this->redirect(Yii::app()->createUrl('shortcutcontent/index'));
    }
    public function actionEdit($index)
    {
        $model = new ShortcutcontentFrom('edit');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $tab_suffix = Yii::app()->params['table_envSuffix'];
            $city_allow = Yii::app()->user->city_allow();
            $sql = "select s.ServiceName,t.* from ".$tab_suffix."shortcuts as t  left join service as s on t.service_type=s.ServiceType where t.city in(".$city_allow.")";
            $rows = Yii::app()->db->createCommand($sql)->queryAll();
            $service_type_lists = [];
            foreach ($rows as $row) {
                $service_type_lists[$row['id']] = $row['ServiceName']."-".$row['shortcut_name'];
            }
            $this->render('form',array('model'=>$model,'service_type_lists'=>$service_type_lists));
        }
    }
 	public function actionImport() {
        $model = new ShortcutcontentList;
        if (isset($_POST['ShortcutcontentList'])) {
            $model->attributes = $_POST['ShortcutcontentList'];
			if ($model->validate()) {
				if ($file = CUploadedFile::getInstance($model,'import_file')) {
					$objImport = new Import;
					$objData = new ShortcutcontentData;

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
		$model = new ShortcutcontentList;
		$session = Yii::app()->session;
		if (isset($session['shortcutcontent_os02']) && !empty($session['shortcutcontent_os02'])) {
			$Shortcutcontentlist = $session['shortcutcontent_os02'];
			$model->setCriteria($Shortcutcontentlist);
		}
		$model->noOfItem = 0;
        $model->determinePageNum(0);
        $model->retrieveDataByPage($model->pageNum);

		$objData = new RptShortcutcontentlist;
		$objData->data = $model->attr;
		$objExport = new Export;
		$objExport->dataModel = $objData;

		$filename = 'shortcutcontent.xlsx';
		$objExport->exportExcel($filename);
	}

   public static function allowReadWrite() {
        return Yii::app()->user->validRWFunction('OS02');
    }

    public static function allowReadOnly() {
        return Yii::app()->user->validFunction('OS02');
    }
}
