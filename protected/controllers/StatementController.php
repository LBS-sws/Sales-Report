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
                'actions' => array('staff', 'index', 'new', 'edit', 'delete', 'save', 'area', 'jobList', 'StaffInfo', 'export'),
                'expression' => array('StatementController', 'allowReadWrite'),
            ),
            array('allow',
                'actions' => array('staff', 'index', 'new', 'edit', 'delete', 'save', 'area', 'jobList', 'StaffInfo', 'export'),
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

    public function HourMinuteToDecimal($hour_minute)
    {
        $t = explode(':', $hour_minute);
        return ($t[0] * 60 + $t[1]) * 60;
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
        } catch (Exception $exception) {
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

    public function actionExport()
    {
        if(empty($_GET)){
            $this->json([], '参数错误', 0);
        }
        $objectPHPExcel = new PHPExcel();
        $objectPHPExcel->setActiveSheetIndex(0);
        $data['start_date'] = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d H:h:s', '-1 day');
        $data['end_date'] = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d H:h:s');
//        $data['staff_id'] = isset($_GET['staff_id']) ? $_GET['staff_id'] : '';
        $data['time_point'] = isset($_GET['time_point']) ? $_GET['time_point'] : '';
        $data['service_type'] = isset($_GET['service_type']) ? $_GET['service_type'] : '';
        $data['city'] = isset($_GET['city']) ? $_GET['city'] : '';
        $data['is_mark'] = isset($_GET['is_mark']) ? $_GET['is_mark'] : '';
        $data['time'] = $this->HourMinuteToDecimal($data['time_point']);
        if (isset($data['staff_id']) && !empty($data['staff_id'])) {
            $this->json([], 'error', 0);
        }
        $model = new JobOrder();
        $page_size = 5000;
        $result = $model->getExport($data);
        if(isset($result['count']['row_count']) && $result['count']['row_count'] >= $page_size){
            $this->json([], '筛选的时间段过大', 0);
        }
        if ($result['count']['row_count'] <= 0) {
            $this->json([], '导出错误', 0);
        }

//        $count = 10000;
        //总页数的算出 [暂不使用]
        $page_count = (int)($result['count']['row_count']/$page_size) +1;
        $current_page = 0;
        $n = 0;
        foreach ( $result['data'] as $k => $product )
        {
            if ( $n % $page_size === 0 )
            {
                $current_page = $current_page +1;
                //报表头的输出
                $objectPHPExcel->getActiveSheet()->mergeCells('A1:I1');
                $objectPHPExcel->getActiveSheet()->setCellValue('A1','区域明细');

                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('A2','区域明细');
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('A2','区域明细');
                $objectPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getFont()->setSize(24);
                $objectPHPExcel->setActiveSheetIndex(0)->getStyle('A1')
                    ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('A2','日期：'.date("Y年m月j日"));
//                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('G2','第'.$current_page.'/'.$page_count.'页');
                $objectPHPExcel->setActiveSheetIndex(0)->getStyle('I2')
                    ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                //表格头的输出
                $objectPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('A3','日期');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B3','客户名称');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('C3','员工姓名');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(22);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('D3','城市');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('E3','开始时间');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('F3','结束时间');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);

                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('G3','服务类型');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);

                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('H3','工作时长');
                $objectPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);

//                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('J3','second');
//                $objectPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);

                $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('I3','状态');
//                $objectPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);

                //设置居中
                $objectPHPExcel->getActiveSheet()->getStyle('A3:I3')
                    ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                //设置边框
                $objectPHPExcel->getActiveSheet()->getStyle('A3:I3' )
                    ->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objectPHPExcel->getActiveSheet()->getStyle('A3:I3' )
                    ->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objectPHPExcel->getActiveSheet()->getStyle('A3:I3' )
                    ->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objectPHPExcel->getActiveSheet()->getStyle('A3:I3' )
                    ->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objectPHPExcel->getActiveSheet()->getStyle('A3:I3' )
                    ->getBorders()->getVertical()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                //设置颜色
                $objectPHPExcel->getActiveSheet()->getStyle('A3:I3')->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF66CCCC');
            }
            //明细的输出
            $objectPHPExcel->getActiveSheet()->setCellValue('A'.($n+4) ,$product['job_date']);
            $objectPHPExcel->getActiveSheet()->setCellValue('B'.($n+4) ,$product['customer_name']);
            $objectPHPExcel->getActiveSheet()->setCellValue('C'.($n+4) ,$product['staff_name']);
            $objectPHPExcel->getActiveSheet()->setCellValue('D'.($n+4) ,$product['city_name']);
            $objectPHPExcel->getActiveSheet()->setCellValue('E'.($n+4) ,$product['start_time']);
            $objectPHPExcel->getActiveSheet()->setCellValue('F'.($n+4) ,$product['end_time']);

            $objectPHPExcel->getActiveSheet()->setCellValue('G'.($n+4) ,$product['service_type']);
            $objectPHPExcel->getActiveSheet()->setCellValue('H'.($n+4) ,$product['job_time']);
//            $objectPHPExcel->getActiveSheet()->setCellValue('J'.($n+4) ,$product['second']);
            $objectPHPExcel->getActiveSheet()->setCellValue('I'.($n+4) ,$product['status']);
            if($product['flag'] == 0){
                $objectPHPExcel->getActiveSheet()->getStyle('I'.($k+4).':I'.($k+4).'')->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FF66CC88');
            }else{
                $objectPHPExcel->getActiveSheet()->getStyle('I'.($k+4).':I'.($k+4).'')->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00FF6699');
            }

            //设置边框
            $currentRowNum = $n+4;
            $objectPHPExcel->getActiveSheet()->getStyle('A'.($n+4).':I'.$currentRowNum )
                ->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('A'.($n+4).':I'.$currentRowNum )
                ->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('A'.($n+4).':I'.$currentRowNum )
                ->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('A'.($n+4).':I'.$currentRowNum )
                ->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('A'.($n+4).':I'.$currentRowNum )
                ->getBorders()->getVertical()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $objectPHPExcel->getActiveSheet()->getStyle('A'.($n+4).':I'.$currentRowNum )
                ->getBorders()->getVertical()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('A'.($n+4).':I'.$currentRowNum )
                ->getBorders()->getVertical()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objectPHPExcel->getActiveSheet()->getStyle('A'.($n+4).':I'.$currentRowNum )
                ->getBorders()->getVertical()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//            $objectPHPExcel->getActiveSheet()->getStyle('B'.($n+4).':K'.$currentRowNum )
//                ->getBorders()->getVertical()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $n = $n +1;
        }
        //设置分页显示
        //$objectPHPExcel->getActiveSheet()->setBreak( 'I55' , PHPExcel_Worksheet::BREAK_ROW );
        //$objectPHPExcel->getActiveSheet()->setBreak( 'I10' , PHPExcel_Worksheet::BREAK_COLUMN );
        $objectPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $objectPHPExcel->getActiveSheet()->getPageSetup()->setVerticalCentered(false);


        @ob_end_clean();
        @ob_start();
        header('Content-Type : application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="'.'区域明细-'.date("Y年m月j日").'.xls"');
        $objWriter= PHPExcel_IOFactory::createWriter($objectPHPExcel,'Excel5');
        $objWriter->save('php://output');
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