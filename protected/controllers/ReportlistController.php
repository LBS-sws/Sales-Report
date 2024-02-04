<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:45
 */

class ReportlistController extends Controller
{
    public $function_id='RE01';

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
                'actions'=>array('new','edit','delete','save','import','upload'),
                'expression'=>array('ReportlistController','allowReadWrite'),
            ),
            array('allow',
                'actions'=>array('index','view','export'),
                'expression'=>array('ReportlistController','allowReadOnly'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionIndex($pageNum=0)
    {

        $se_suffix = Yii::app()->params['envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
//        echo $se_suffix;
//
//        echo $city_allow;

        $city_all = General::getCityList();
        

        $city = Yii::app()->user->city_allow();
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
        $this->render('index',array('model'=>$model,'city' => $city,'api_url'=>Yii::app()->params['baseUrl_imgs']));
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
    // 自定义上传
    public function actionUpload(){
        //print_r($_FILES);
        $se_suffix = Yii::app()->params['envSuffix'];

        $file = $_FILES["img"];
        $date = date('Ymdhis');
        $fileName = $file["name"];
        $name = explode('.', $fileName); // 上传文件后缀
        $newPath = time() . '.' . $name[1];
        // 本地
        if($se_suffix == 'dev'){

            $dir = str_replace('\\','/',dirname(dirname(__DIR__)).'/upload/materiel');    // D:\phpstudy_pro\WWW\10003\LBS\Sales-Report
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
                //echo "目录 $dir 创建成功！";
            } else {
                //echo "目录 $dir 已存在！";
            }
            move_uploaded_file($_FILES["img"]["tmp_name"],$dir."/".$_FILES["img"]["name"]);
            rename($dir."/".$fileName, $dir."/".$newPath);
        }
        // 测试
        if($se_suffix == 'uat'){
            chmod($_FILES["img"]["tmp_name"],0755);
            $dir = str_replace('\\','/',dirname(dirname(__DIR__)).'/upload/materiel');
            if (!file_exists($dir)) {
                mkdir($dir,0776);
                //echo "目录 $dir 创建成功！";
            } else {
                //echo "目录 $dir 已存在！";
            }
            move_uploaded_file($_FILES["img"]["tmp_name"],$dir."/".$_FILES["img"]["name"]);
            rename($dir."/".$fileName, $dir."/".$newPath);
        }
        // 正式
        if($se_suffix == ''){
            chmod($_FILES["img"]["tmp_name"],0755);
            $dir = str_replace('\\','/',dirname(dirname(__DIR__)).'/upload/materiel');
            if (!file_exists($dir)) {
                mkdir($dir,0776);
                //echo "目录 $dir 创建成功！";
            } else {
                //echo "目录 $dir 已存在！";
            }
            move_uploaded_file($_FILES["img"]["tmp_name"],$dir."/".$_FILES["img"]["name"]);
            rename($dir."/".$fileName, $dir."/".$newPath);
        }
        $img_url = "upload/materiel/".$newPath;
        $data['img'] = $img_url;
        $data['msg'] = 'success';
        echo json_encode($data);

    }
    public static function allowReadWrite() {
        return Yii::app()->user->validRWFunction('MS01');
    }

    public static function allowReadOnly() {
        return Yii::app()->user->validFunction('MS01');
    }
}
?>
