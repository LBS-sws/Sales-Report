<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/9/18
 * Time: 10:35
 */
use yii\web\UploadedFile;
class PapersstaffController extends Controller
{
    public $function_id='PQ01';

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
            /* request */
            array('allow',
                'actions'=>array('new','edit','delete','deletex','save','list','item','UpdateData','Upload'),
                'expression'=>array('PapersstaffController','allowReadWrite'),
            ),
            array('allow',
                'actions'=>array('index','view'),
                'expression'=>array('PapersstaffController','allowReadOnly'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    // 列表
    public function actionIndex($pageNum=0)
    {
        $model = new PapersstaffList();
        if (isset($_POST['PapersstaffList'])) {
            $model->attributes = $_POST['PapersstaffList'];
        } else {
            $session = Yii::app()->session;
            if (isset($session['papersstaff_pq01']) && !empty($session['papersstaff_pq01'])) {
                $materiallist = $session['papersstaff_pq01'];
                $model->setCriteria($materiallist);
            }
        }
        $model->determinePageNum($pageNum);
        $model->retrieveDataByPage($model->pageNum);
        $this->render('index',array('model'=>$model));
    }
    public function actionView($index)
    {
        $model = new EmployeesignatureList('view');
        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {
            $this->render('form',array('model'=>$model));
        }
    }
    public function actionNew()
    {
        $model = new PapersstaffForm('new');
        //当前城市员工列表
        $se_suffix = Yii::app()->params['envSuffix'];
        $city_allow = Yii::app()->user->city_allow();
        $sql = "select s.StaffID,s.StaffName,b.name city_name from staff  as s left join officecity as o on o.City = s.City left join enums as e on e.EnumID = o.Office left join security".$se_suffix.".sec_city as b on e.Text=b.code where  e.EnumType=8 and s.Status in(1,2,5) and e.Text in(".$city_allow.")";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        $employee_lists = [];

        foreach ($rows as $row) {
            $StaffID = $row['StaffID'];
            $sql = "select * from papersstaff where code= '$StaffID'";
            $item = Yii::app()->db->createCommand($sql)->queryRow();
            if(!$item){
                $employee_lists[$row['StaffID']] = $row['StaffName']."(".$row['city_name'].")";
            }
        }
        $item['id'] = '';
        $item['code'] = '';
        $this->render('form',array('model'=>$model,'employee_lists'=>$employee_lists,'item'=>$item));
    }
    // 新增提交
    public function actionSave()
    {
        if (isset($_POST['PapersstaffForm'])) {
            $model = new PapersstaffForm($_POST['PapersstaffForm']['scenario']);
            $model->attributes = $_POST['PapersstaffForm'];

            if ($model->validate()) {
                //新增
                $model->saveData();
                $model->scenario = 'edit';
                Dialog::message(Yii::t('dialog','Information'), Yii::t('dialog','Save Done'));
                $this->redirect(Yii::app()->createUrl('papersstaff/edit',array('index'=>$model->id)));
            } else {
                echo "0";
            }
        }
    }
    public function actionDelete()
    {
        $se_suffix = Yii::app()->params['envSuffix'];

        $id = $_GET['index'];
        $item = Yii::app()->db->createCommand("select * from service".$se_suffix.".papersstaff where id=$id")->queryRow();

        if ($item){
            $p_id = $item['id'];
            Yii::app()->db->createCommand("DELETE FROM service".$se_suffix.".papersstaff_info WHERE `papersstaff_id` = $p_id")->query();

            Yii::app()->db->createCommand("DELETE FROM service".$se_suffix.".papersstaff WHERE `id` = $p_id")->query();
        }
        $this->redirect(Yii::app()->createUrl('papersstaff/index'));
    }
    public function actionDeletex(){
        $se_suffix = Yii::app()->params['envSuffix'];
        $id = $_GET['id'];
        Yii::app()->db->createCommand("DELETE FROM service".$se_suffix.".papersstaff_info WHERE `id` = $id")->query();

        $data['id'] = $id;
        echo json_encode($data);
    }
    public function actionEdit($index)
    {
        $model = new PapersstaffForm('edit');


        if (!$model->retrieveData($index)) {
            throw new CHttpException(404,'The requested page does not exist.');
        } else {

            //当前城市员工列表
            $se_suffix = Yii::app()->params['envSuffix'];
            $city_allow = Yii::app()->user->city_allow();

            $sql = "select * from papersstaff where id=".$index;

            $item = Yii::app()->db->createCommand($sql)->queryRow();
            $employee_lists = [];
            $this->render('form',array('model'=>$model,'employee_lists'=>$employee_lists,'item'=>$item));
        }
    }
    public function actionList(){
        $id = $_GET['id'];
        $sql = "select * from papersstaff_info where papersstaff_id = ".$id;

        $records = Yii::app()->db->createCommand($sql)->queryAll();

        $data['data'] = $records;
        echo json_encode($data);
    }
    // 获取证件详情
    public function actionItem(){
        $id = $_GET['id'];

        $sql = "select * from papersstaff_info where id = ".$id;

        $records = Yii::app()->db->createCommand($sql)->queryRow();

        $data['data'] = $records;
        echo json_encode($data);
    }
    public function actionUpdateData(){
        // add
        if(trim($_POST['id']) ==''){
            $name = $_POST['name'];
            $code = $_POST['code'];
            $papersstaff_id = $_POST['papersstaff_id'];
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];
            $imgUrl = $_POST['imgUrl'];

            $sql = "INSERT INTO `papersstaff_info` (`id`, `papersstaff_id`, `StaffCode`, `PapersName`, `StartDate`, `EndDate`, `imgUrl`) 
VALUES (NULL, '$papersstaff_id', '$code', '$name', '$startDate', '$endDate', '$imgUrl')";
            Yii::app()->db->createCommand($sql)->query();

            $id = Yii::app()->db->getLastInsertID();
            $data['id'] = $id;
            echo json_encode($data);
        }
        if(trim($_POST['id']) !=''){
            $name = $_POST['name'];
            $code = $_POST['code'];
            $papersstaff_id = $_POST['papersstaff_id'];
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];
            $imgUrl = $_POST['imgUrl'];

            $id = $_POST['id'];
            $sql = $sql = "update papersstaff_info set 
					PapersName='$name',StartDate='$startDate',EndDate='$endDate',imgUrl='$imgUrl'
					where id = ".$id;

            Yii::app()->db->createCommand($sql)->query();

            $id = Yii::app()->db->getLastInsertID();
            $data['id'] = $id;
            echo json_encode($data);
        }
    }
    /* 上传图片 */
    public function actionUpload(){
        $se_suffix = Yii::app()->params['envSuffix'];

        $file = $_FILES["img"];
        $date = date('Ymdhis');
        $fileName = $file["name"];
        $name = explode('.', $fileName); // 上传文件后缀
        $newPath = time() . '.' . $name[1];
        // 本地
        if($se_suffix == 'dev'){

            $dir = str_replace('\\','/',dirname(dirname(__DIR__)).'/upload/papers');    // D:\phpstudy_pro\WWW\10003\LBS\Sales-Report
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
                //echo "目录 $dir 创建成功！";
            } else {
                //echo "目录 $dir 已存在！";
            }
            echo $dir;exit;
            move_uploaded_file($_FILES["img"]["tmp_name"],$dir."/".$_FILES["img"]["name"]);
            rename($dir."/".$fileName, $dir."/".$newPath);
        }
        // 测试
        if($se_suffix == 'uat'){
            chmod($_FILES["img"]["tmp_name"],0755);
            $dir = str_replace('\\','/',dirname(dirname(__DIR__)).'/upload/papers');
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
            $dir = str_replace('\\','/',dirname(dirname(__DIR__)).'/upload/papers');
            if (!file_exists($dir)) {
                mkdir($dir,0776);
                //echo "目录 $dir 创建成功！";
            } else {
                //echo "目录 $dir 已存在！";
            }
            move_uploaded_file($_FILES["img"]["tmp_name"],$dir."/".$_FILES["img"]["name"]);
            rename($dir."/".$fileName, $dir."/".$newPath);
        }

        $img_url = "upload/papers/".$newPath;
        $data['img'] = $img_url;
        echo json_encode($data);
    }

    public static function allowReadWrite() {
        return Yii::app()->user->validRWFunction('PQ01');
    }

    public static function allowReadOnly() {
        return Yii::app()->user->validFunction('PQ01');
    }
}