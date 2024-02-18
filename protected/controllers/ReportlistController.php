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

        // 获取数据表所有城市
        $city_all = General::getCityList();

        $city_alls = [];
        foreach ($city_all as $key=>$val){
            array_push($city_alls,array('label'=>$val,'value'=>$key));
        }

        // 当前用户所拥有的城市权限
        $city = Yii::app()->user->city_allow();

        $strArray = explode(',',$city);
        $select_ck = 1;
        if(count($strArray) == 1){
            $select_ck = 0;
            $city_val = str_replace("'", '', $city);

        }else{
            $city_val = '';
        }


        $this->render('index',array('city' => $city,'city_all'=>$city_alls, 'select_ck'=>$select_ck, 'city_val'=>$city_val, 'api_url'=>Yii::app()->params['baseUrl_imgs']));
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

    }

    public function actionEdit($index)
    {

    }
    public function actionSave()
    {

    }
    public function actionDelete()
    {

    }

    public function actionImport() {

    }

    public function actionExport() {

    }
    public function actionUpload(){

    }
    public static function allowReadWrite() {
        return Yii::app()->user->validRWFunction('RE01');
    }

    public static function allowReadOnly() {
        return Yii::app()->user->validFunction('RE01');
    }
}
?>
