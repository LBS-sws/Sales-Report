<?php

class JobOrder extends CListPageModel
{
    // For manually adjust the label content
    protected $rpt_labels = array(
        'city' => array('label' => 'City', 'width' => 20, 'align' => 'C'),
        'start_at' => array('label' => 'Start Date', 'width' => 25, 'align' => 'C'),
        'end_dt' => array('label' => 'End Date', 'width' => 25, 'align' => 'C'),
//        'week_1'=>array('label'=>'Week 1','width'=>25,'align'=>'C'),
//        'week_2'=>array('label'=>'Week 2','width'=>25,'align'=>'C'),
//        'week_3'=>array('label'=>'Week 3','width'=>25,'align'=>'C'),
//        'week_4'=>array('label'=>'Week 4','width'=>25,'align'=>'C'),
    );
    protected $ret = null;
    public $id;
    public $name;
    public $start_at;
    public $end_at;
    public $format;
    public $uid;
    public $city;
    public $target_at;
    public $fields;
    public $email;
    public $emailcc;
    public $touser;
    public $ccuser;
    public $year;
    public $follow_staff;
    public $type;
    public $form;
    public $staffs_desc;
    public $se_suffix = '';

    public function __construct()
    {

        $this->se_suffix = Yii::app()->params['envSuffix'];
//        $this->tab_suffix = Yii::app()->params['table_envSuffix'];
    }

    public function attributeLabels()
    {
        return array(
            'start_at' => Yii::t('statement', 'Start Date'),
            'end_at' => Yii::t('statement', 'End Date'),
            'city' => Yii::t('statement', 'City'),
        );
    }

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
//            array('id'),
            array('start_at, end_at, target_at', 'date', 'allowEmpty' => true,
                'format' => array('yyyy/MM/dd', 'yyyy-MM-dd', 'yyyy/M/d', 'yyyy-M-d',),
            ),
//            array('email','validateEmail'),
//            array('emailcc','validateEmailList'),
        );
    }



    public function fields()
    {
        return $this->rpt_labels;
    }

    public function getSelectString()
    {
        return Yii::t('returneport', 'Date') . ': ' . $this->criteria->year . '/' . $this->criteria->month;
    }

    public function retrieveData()
    {
        $year = empty($this->criteria->year) ? date('Y') : $this->criteria->year;
        $month = empty($this->criteria->month) ? date('m') : $this->criteria->month;
        $first_date = $year . '-' . $month . '-01';
//        $last_date = date('Y-m-d',strtotime(date('Y-m-d',strtotime($first_date.' +1 month')).' -1 day'));
//        $first_date2 = date('Y-m-d',strtotime($first_date.' -1 day'));
        $sql = "select * from officecity a left join enums b on b.EnumID=a.City AND b.EnumType = 1";
        $ret = Yii::app()->db->createCommand($sql)->queryAll();
        return $ret;
    }


    public function getStaff($city = '')
    {
        $sql = "select * from staff a left join enums b on b.EnumID=a.City AND b.EnumType = 1 where City = {$city} ";
        $ret = Yii::app()->db->createCommand($sql)->queryAll();
        return $ret;
    }

    public function getJob($staff_id = '', $city = '', $start_time, $end_time,$time_point,$service_type = 1)
    {

        $sql_mode = "set sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'; ";
        Yii::app()->db->createCommand($sql_mode)->queryAll();

        $start_time = date('Y-m-d',strtotime($start_time));
        $end_time = date('Y-m-d',strtotime($end_time));
//                var_dump($start_time);
        /*$sql = "(SELECT COUNT(1) AS count, (FinishTime - StartTime)/3600 AS service_time, b.Text as city_name,c.StaffName as staff_name
	, '1' AS 'type', FinishDate
FROM joborder a LEFT JOIN enums b ON b.EnumID= a.City LEFT JOIN staff c ON c.StaffID = a.Staff01   WHERE (a.Staff01 = {$staff_id} OR a.Staff02 = {$staff_id} OR a.Staff03 = {$staff_id}) AND JobDate BETWEEN '{$start_time}' AND '{$end_time}'
AND FinishTime - StartTime <= 1800 AND b.EnumID = '{$city}'
GROUP BY a.City, FinishDate)
UNION
(SELECT COUNT(1) AS count, (FinishTime - StartTime)/3600 AS service_time, b.Text as city_name,c.StaffName as staff_name
	, '2' AS 'type', FinishDate
FROM joborder a LEFT JOIN enums b ON b.EnumID= a.City LEFT JOIN staff c ON c.StaffID = a.Staff01   WHERE (a.Staff01 = {$staff_id} OR a.Staff02 = {$staff_id} OR a.Staff03 = {$staff_id}) AND JobDate BETWEEN '{$start_time}' AND '{$end_time}'
AND FinishTime - StartTime > 1800 AND b.EnumID = '{$city}'
GROUP BY a.City, FinishDate)";*/
        $staff_sql = "";
        if (!empty($staff_id)) {
            $staff_sql = "and (a.Staff01 = {$staff_id} OR a.Staff02 = {$staff_id} OR a.Staff03 = {$staff_id})";
        }
        switch ($service_type){
            case '1':
                $table = "joborder";
                $rangDate = 'FinishDate';

                break;
            case '2':
                $table = "followuporder";
                $rangDate = 'jobDate';

                break;
            default:
                $table = "joborder";
                $rangDate = 'FinishDate';

        }
//        var_dump($table);




        $sql = "SELECT 
    COUNT(1) AS total,
    COUNT(IF((FinishTime-StartTime)>={$time_point}, (FinishTime-StartTime)>={$time_point}, NULL
    )) normal,
    COUNT(IF((FinishTime-StartTime)<{$time_point}, (FinishTime-StartTime)<{$time_point}, NULL
    )) unusual,
	b.Text AS city_name,
	ANY_VALUE(IFNULL(c.StaffName ,''))  AS staff_name, 
	IFNULL(c.StaffId ,'')  AS staff_id, 
	{$rangDate} 
FROM
	{$table} a
	LEFT JOIN enums b ON b.EnumID = a.City
	 JOIN staff c ON c.StaffID = a.Staff01
WHERE
	JobDate BETWEEN '{$start_time}' AND '{$end_time}'" . $staff_sql . "
	AND b.EnumID = '{$city}' AND a.Staff01 !=''
GROUP BY staff_id ORDER BY {$rangDate} DESC";
        $ret['data'] = Yii::app()->db->createCommand($sql)->queryAll();

        $sql_count = "SELECT COUNT(1) AS value , FinishTime - StartTime AS service_time
	, ANY_VALUE(if(FinishTime - StartTime >= {$time_point}, '1', '0')) AS 'scene',	if((FinishTime-StartTime)>={$time_point},'正常单','异常单') AS 'name'

	, b.Text AS city_name, c.StaffName AS staff_name, {$rangDate},CustomerName
FROM {$table} a
	LEFT JOIN enums b ON b.EnumID = a.City
	 JOIN staff c ON c.StaffID = a.Staff01
WHERE JobDate BETWEEN '{$start_time}' AND '{$end_time}'" . $staff_sql . "
	AND b.EnumID = '{$city}' AND a.Staff01 !=''
GROUP BY scene";
        $ret['count'] = Yii::app()->db->createCommand($sql_count)->queryAll();
        return $ret;
    }

    public function getStaffInfo($staff_id = '')
    {
        if (empty($staff_id)) {
            return false;
        }
        $sql = "SELECT 
	a.CustomerName AS customer_name,
	d.StaffName AS staff_name,
	b.Text AS service_type,
	c.Text AS city_name,
	a.StartTime AS start_time,
	a.FinishTime AS end_time,
	a.JobDate AS job_date,
	TIMEDIFF(a.FinishTime,a.StartTime) AS job_time,	TIME_TO_SEC(TIMEDIFF(a.FinishTime,a.StartTime)) as second,IF(TIME_TO_SEC(TIMEDIFF(a.FinishTime,a.StartTime))>1800,'正常','异常') as 'status'

FROM
	joborder a
	LEFT JOIN enums b ON b.EnumType = a.ServiceType
	LEFT JOIN enums c ON c.EnumID = a.City 
	LEFT JOIN staff d ON d.StaffID = a.Staff01
WHERE
	a.Staff01 = '$staff_id'
	AND a.`Status` = 3";
        $ret = Yii::app()->db->createCommand($sql)->queryAll();
        return $ret;
    }

    public function showField($name)
    {
        $a = explode(',', $this->fields);
        return empty($this->fields) || in_array($name, $a);
    }
}

?>