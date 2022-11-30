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
        //接收参数
        $data['start_date'] = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d H:h:s', '-1 day');
        $data['end_date'] = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d H:h:s');
        $data['staff'] = isset($_GET['staff']) ? $_GET['staff'] : '';
        $data['city'] = isset($_GET['city']) ? $_GET['city'] : '';
        $time_point = isset($_GET['time_point']) ? $_GET['time_point'] : '00:10';
        $data['service_type'] = isset($_GET['service_type']) ? $_GET['service_type'] : 1;
//        $data['switch_type'] = isset($_GET['switch_type']) ? $_GET['switch_type'] : 1;
        $data['is_mark'] = isset($_GET['is_mark']) ? $_GET['is_mark'] : 1;
//        if(isset($data['is_mark']) && $data['is_mark'] == 1){
//            $start_time = isset($_GET['start_time']) ? $_GET['start_time'] : '';
//            $end_time = isset($_GET['end_time']) ? $_GET['end_time'] : '';
////            $data['start_time'] = $this->HourMinuteToDecimal($start_time);
////            $data['end_time'] = $this->HourMinuteToDecimal($end_time);
//        }
        //特殊处理三个时间
        $data['time_point'] = $this->HourMinuteToDecimal($time_point);

        $model = new JobOrder();
        try {
            $res = $model->getJob($data);
            if ($res['data'] && $res['count']) {
                $this->json($res);
            }
        }catch (Exception $exception){
            $this->json([], $exception->getMessage(), 0);
        }
        $this->json([], '无数据', 0);

    }


    public function actionStaffInfo()
    {
        $data['start_date'] = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d H:h:s', '-1 day');
        $data['end_date'] = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d H:h:s');
        $data['staff_id'] = isset($_GET['staff_id']) ? $_GET['staff_id'] : '';
        $data['time_point'] = isset($_GET['time_point']) ? $_GET['time_point'] : '';
        $data['service_type'] = isset($_GET['service_type']) ? $_GET['service_type'] : '';
        $data['city'] = isset($_GET['city']) ? $_GET['city'] : '';
        $data['is_mark'] = isset($_GET['is_mark']) ? $_GET['is_mark'] : '';
        $data['time'] = $this->HourMinuteToDecimal($data['time_point']);
        if (!isset($data['staff_id']) && empty($data['staff_id'])) {
            $this->json([], 'error', 0);
        }
        $model = new JobOrder();
        $res = $model->getStaffInfo($data);
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