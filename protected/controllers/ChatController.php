<?php


/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2023/04/27
 * Time: 10:45
 */
class ChatController extends Controller
{
    public $function_id = 'CT01';

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
                'actions' => array('new', 'edit', 'delete', 'save'),
                'expression' => array('ChatController', 'allowReadWrite'),
            ),
            array('allow',
                'actions' => array('index', 'view', 'api'),
                'expression' => array('ChatController', 'allowReadOnly'),
            ),
            array('allow',
                'actions' => array('api'),
                'users' => array('*'),
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }


    public function actionIndex($pageNum = 0)
    {
        $city = Yii::app()->user->city();
        $wss = Yii::app()->params['wss'];
        $uid = Yii::app()->user->id;
        $api_url = Yii::app()->params['baseUrl_imgs'];
        $this->render('index', array('city' => $city,'wss' => $wss, 'uid' => $uid, 'api_url' => $api_url));
    }
    public static function allowReadWrite()
    {
        return Yii::app()->user->validRWFunction('CT01');
    }

    public static function allowReadOnly()
    {
        return Yii::app()->user->validFunction('CT01');
    }
}
