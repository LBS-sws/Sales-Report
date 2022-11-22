<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/8/21
 * Time: 10:45
 */

class StatementController extends Controller
{
    public $function_id = 'SR01';

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
                'actions' => array('staff', 'index', 'new', 'edit', 'delete', 'save', 'area', 'jobList', 'StaffInfo', 'test'),
                'expression' => array('StatementController', 'allowReadWrite'),
            ),
            array('allow',
                'actions' => array('staff', 'index', 'new', 'edit', 'delete', 'save', 'area', 'jobList', 'StaffInfo', 'test'),
                'expression' => array('StatementController', 'allowReadOnly'),
            ),
//            array('deny',  // deny all users
//                'users' => array('*'),
//            ),
        );
    }

    public function actionTest($fid, $test)
    {
        var_dump($fid);
        var_dump($test);

    }

    public function actionStaffEx($search, $incity = '')
    {
        $suffix = Yii::app()->params['envSuffix'];
        $suffix = $suffix == 'dev' ? '_w' : $suffix;
        $city = empty($incity) ? Yii::app()->user->city() : $incity;
        $result = array();
        $searchx = str_replace("'", "\'", $search);

        $sql = "select id, concat(name, ' (', code, ')') as value from service$suffix.staff
				where (code like '%$searchx%' or name like '%$searchx%') and city='$city'
				and (leave_dt is null or leave_dt=0 or leave_dt > now()) ";
        $result1 = Yii::app()->db->createCommand($sql)->queryAll();

        $sql = "select id, concat(name, ' (', code, ')',' " . Yii::t('app', '(Resign)') . "') as value from service$suffix.staff
				where (code like '%$searchx%' or name like '%$searchx%') and city='$city'
				and  leave_dt is not null and leave_dt<>0 and leave_dt <= now() ";
        $result2 = Yii::app()->db->createCommand($sql)->queryAll();

        $records = array_merge($result1, $result2);
        if (count($records) > 0) {
            foreach ($records as $k => $record) {
                $result[] = array(
                    'id' => $record['id'],
                    'value' => $record['value'],
                );
            }
        }
        print json_encode($result);
    }


    public function actionIndex($pageNum = 0)
    {
        $model = new JobOrder();
        $model->end_at = '';
        $model->start_at = '';// date("Y", strtotime($model->end_dt)).'/'.date("m", strtotime($model->end_dt)).'/01';
        $this->render('index', array('model' => $model));
    }

    /**
     * 获取区域
     * @return json
     * */
    public function actionArea()
    {
        $model = new JobOrder();
        $res = $model->retrieveData();
        if ($res) {
            $this->json($res);
        }
        $this->json([], 'error', 0);

    }

    /**
     * 获取员工信息
     * @return json
     * */
    public function actionStaff()
    {
        $city = isset($_GET['city']) ? $_GET['city'] : '200';
        $model = new JobOrder();
        $res = $model->getStaff($city);
        if ($res) {
            $this->json($res);
        }
        $this->json([], 'error', 0);
    }

    public function HourMinuteToDecimal($hour_minute) {
        $t = explode(':', $hour_minute);
        return ($t[0] * 60 + $t[1])*60;
    }


    /**
     * 工作报表
     * */
    public function actionjobList()
    {
        $start_time = isset($_GET['start_time']) ? $_GET['start_time'] : date('Y-m-d H:h:s', '-1 day');
        $end_time = isset($_GET['end_time']) ? $_GET['end_time'] : date('Y-m-d H:h:s');
        $staff = isset($_GET['staff']) ? $_GET['staff'] : '';
        $city = isset($_GET['city']) ? $_GET['city'] : '';
        $time_point = isset($_GET['time_point']) ? $_GET['time_point'] : '';
        $service_type = isset($_GET['service_type']) ? $_GET['service_type'] : '';
        $time = $this->HourMinuteToDecimal($time_point);
//        var_dump($_GET['service_type']);exit;
//        if(empty($staff)){
//            $this->json([],'error',0);
//        }
        $model = new JobOrder();
//        var_dump($model);exit;
        try {
            $res = $model->getJob($staff, $city, $start_time, $end_time,$time,$service_type);
            if ($res['data'] && $res['count']) {
                $this->json($res);
            }
        }catch (Exception $exception){
            $this->json([], $exception->getMessage(), 0);
        }
//        var_dump($res);exit();

        $this->json([], '无数据', 0);

    }


    public function actionStaffInfo()
    {
        $start_time = isset($_GET['start_time']) ? $_GET['start_time'] : date('Y-m-d H:h:s', '-1 day');
        $end_time = isset($_GET['end_time']) ? $_GET['end_time'] : date('Y-m-d H:h:s');
        $staff_id = isset($_GET['staff_id']) ? $_GET['staff_id'] : '';
        $time_point = isset($_GET['time_point']) ? $_GET['time_point'] : '';
        $service_type = isset($_GET['service_type']) ? $_GET['service_type'] : '';
        $time = $this->HourMinuteToDecimal($time_point);
        if (empty($staff_id)) {
            $this->json([], 'error', 0);
        }
        $model = new JobOrder();
        $res = $model->getStaffInfo($staff_id,$start_time,$end_time,$time,$service_type);
        if ($res) {
            $this->json($res);
        }
        $this->json([], 'error', 0);


    }


    public static function allowReadWrite()
    {
        return Yii::app()->user->validRWFunction('SR01');
    }

    public static function allowReadOnly()
    {
        return Yii::app()->user->validFunction('SR01');
    }

    protected function json($data = [], $msg = "ok", $code = 1)
    {
        //设置格式
        header('Content-type: application/json');

        //输出json格式的内容
        exit(json_encode([
            "code" => $code,
            "msg" => $msg,
            "data" => $data,
            "request_id" => uniqid()
        ]));
        //结束
//        return Yii::app()->end();exit();
    }
}