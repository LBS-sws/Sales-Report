<?php

/**
 * UserForm class.
 * UserForm is the data structure for keeping
 * user form data. It is used by the 'user' action of 'SiteController'.
 */
class ReportjobForm extends CFormModel
{
	/* User Fields */
    public $city = [];
    public $job = [];
	public $basic = [];////基础信息
	public $briefing = [];//服务简报
	public $material = [];//物料使用
	public $equipment = [];//设备巡查
    public $risk = [];//风险跟进
    public $photo = [];//现场工作照
    public $autograph = [];//签名点评
    public $service_sections = [];//服务板块
    public $start_dt;
    public $end_dt;
	public $fields;
	public $customer_name;
	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'customer_name'=>Yii::t('reportjob','CustomerName'),
			'start_dt'=>Yii::t('reportjob','Start_dt'),
			'end_dt'=>Yii::t('reportjob','End_dt'),
		);
	}

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('id,number,type,dates,payment_term,customer_po_no,customer_account,salesperson,sales_order_no,sales_order_date,
			ship_via,invoice_company,invoice_address,invoice_tel,delivery_company,delivery_address,delivery_tel,
			disc,sub_total,gst,total_amount,city,generated_by,start_dt,end_dt,customer_name','safe'),
			array('','required'),
			//array('code','validateCode'),
//			array('code','safe','on'=>'edit'),

		);
	}
    function array_to_object($arr) {
        if (gettype($arr) != 'array') {
            return;
        }
        foreach ($arr as $k => $v) {
            if (gettype($v) == 'array' || getType($v) == 'object') {
                $arr[$k] = (object)array_to_object($v);
            }
        }

        return (object)$arr;
    }
    function pic_rotating($degrees,$url){
        $srcImg = imagecreatefrompng($url);     //获取图片资源
        $rotate = imagerotate($srcImg, $degrees, 0);        //原图旋转

        //获取旋转后的宽高
        $srcWidth = imagesx($rotate);
        $srcHeight = imagesy($rotate);

        //创建新图
        $newImg = imagecreatetruecolor($srcWidth, $srcHeight);

        //分配颜色 + alpha，将颜色填充到新图上
        $alpha = imagecolorallocatealpha($newImg, 0, 0, 0, 127);
        imagefill($newImg, 0, 0, $alpha);

        //将源图拷贝到新图上，并设置在保存 PNG 图像时保存完整的 alpha 通道信息
        imagecopyresampled($newImg, $rotate, 0, 0, 0, 0, $srcWidth, $srcHeight, $srcWidth, $srcHeight);
        imagesavealpha($newImg, true);

        //生成新图
        imagepng($newImg, $url);
    }
    public function batchdown($dates)
    {
        $city = Yii::app()->user->city();
        $sql_city = "select GROUP_CONCAT(DISTINCT o.City) as citys from enums as e left join officecity as o on o.Office=e.EnumID where e.Text='" . $city . "' and e.EnumType=8";
        $city_off = Yii::app()->db->createCommand($sql_city)->queryRow();
        $jobids = "select JobID from joborder where Status=3 and FinishDate>='" . $dates['start_dt'] . "' and FinishDate<='" . $dates['end_dt'] . "' and City in(" . $city_off['citys'] . ")";

		if (!empty($dates['customer_name'])) $jobids .= " and CustomerName like '%".$dates['customer_name']."%'";
        $jobids_data = Yii::app()->db->createCommand($jobids)->queryAll();
        if ($jobids_data) {
            $zipname = sys_get_temp_dir() . '/' . 'zipped_file.zip';
            $zip = new ZipArchive;
            $zip->open($zipname, ZipArchive::CREATE);
            for ($fj = 0; $fj < count($jobids_data); $fj++) {
                $index = $jobids_data[$fj]['JobID'];
                $sql_basic = "select j.JobID,j.CustomerName,j.Addr,j.ContactName,j.Mobile,j.JobDate,j.StartTime,j.FinishTime,u.StaffName as Staff01,uo.StaffName as Staff02,ut.StaffName as Staff03,s.ServiceName,j.Status,j.City,j.ServiceType,j.FirstJob,j.FinishDate  from joborder as j left join service as s on s.ServiceType=j.ServiceType left join staff as u on u.StaffID=j.Staff01 left join staff as uo on uo.StaffID=j.Staff02 left join staff as ut on ut.StaffID=j.Staff03 where j.JobID=" . $index;
                $this->basic = Yii::app()->db->createCommand($sql_basic)->queryRow();
                $sql_job = "select * from joborder where JobID=" . $index;
                $this->job = Yii::app()->db->createCommand($sql_job)->queryRow();

                $sql_city = "select * from enums as e left join officecity as o on o.Office=e.EnumID where o.City=" . $this->basic['City'] . " and e.EnumType=8";
                $this->city = Yii::app()->db->createCommand($sql_city)->queryRow();
                $city = $this->city['Text'];
                //判断是否存在PDF
                $reportfile = Yii::app()->basePath . "/images/report/" . $city . "/" . $this->basic['JobDate'] . "/" . $index . '.pdf';
                if (file_exists($reportfile)) {

                    $filename = $this->basic['CustomerName'] . "-(" . $this->basic['ServiceName'] . ")" . $this->basic['JobDate'] . ".pdf";
                    header('Content-Type: application-x/force-download');
                    header('Content-Disposition: attachment; filename=' . $filename);
                    header("Content-Length: " . filesize($reportfile));
                    // 将文件发送到浏览器。
                    $result = basename($reportfile);
                    $zip->addFile(sys_get_temp_dir() . $reportfile, $result);
                }
            }
            $zip->close();
            header('Content-Type: application/zip');
            header('Content-disposition: attachment; filename=' . $zipname);
            header('Content-Length: ' . filesize($zipname));
            readfile($zipname);
            unlink($zipname);
        }
    }

    public function batchcreate($dates)
    {
        $city = Yii::app()->user->city();
        $sql_city = "select GROUP_CONCAT(DISTINCT o.City) as citys from enums as e left join officecity as o on o.Office=e.EnumID where e.Text='".$city."' and e.EnumType=8";
        $city_off = Yii::app()->db->createCommand($sql_city)->queryRow();
        $jobids = "select JobID from joborder where Status=3 and FinishDate>='".$dates['start_dt']."' and FinishDate<='".$dates['end_dt']."' and City in(".$city_off['citys'].")";
		if (!empty($dates['customer_name'])) $jobids .= " and CustomerName like '%".$dates['customer_name']."%'";
        $jobids_data =  Yii::app()->db->createCommand($jobids)->queryAll();
        if ($jobids_data){
            for ($fj =0;$fj<count($jobids_data);$fj++) {
                $index = $jobids_data[$fj]['JobID'];
                $sql_basic = "select j.JobID,j.CustomerName,j.Addr,j.ContactName,j.Mobile,j.JobDate,j.StartTime,j.FinishTime,u.StaffName as Staff01,uo.StaffName as Staff02,ut.StaffName as Staff03,s.ServiceName,j.Status,j.City,j.ServiceType,j.FirstJob,j.FinishDate  from joborder as j left join service as s on s.ServiceType=j.ServiceType left join staff as u on u.StaffID=j.Staff01 left join staff as uo on uo.StaffID=j.Staff02 left join staff as ut on ut.StaffID=j.Staff03 where j.JobID=" . $index;
                $this->basic = Yii::app()->db->createCommand($sql_basic)->queryRow();
                //判断是否存在PDF
                $reportfile = Yii::app()->basePath . "/images/report/" . $city . "/" . $this->basic['JobDate'] . "/" . $index . '.pdf';
                if (!file_exists($reportfile)) {
                    $sql_job = "select * from joborder where JobID=" . $index;
                    $this->job = Yii::app()->db->createCommand($sql_job)->queryRow();

                    $sql_city = "select * from enums as e left join officecity as o on o.Office=e.EnumID where o.City=" . $this->basic['City'] . " and e.EnumType=8";
                    $this->city = Yii::app()->db->createCommand($sql_city)->queryRow();
                    $city = $this->city['Text'];
                    $service_type = $this->basic['ServiceType'];
                    $this->basic['equipments'] = '';
                    $sql_basic_equipments = "select distinct equipment_type_id from lbs_service_equipments where job_type=1 and job_id=" . $index;
                    $basic_equipments = Yii::app()->db->createCommand($sql_basic_equipments)->queryAll();
                    if (count($basic_equipments) > 0) {
                        foreach ($basic_equipments as $k => $equipment) {
                            $sql_name = "select name from lbs_service_equipment_type where id=" . $equipment['equipment_type_id'];
                            $basic_name = Yii::app()->db->createCommand($sql_name)->queryRow();
                            $sql_number = "select count(id) from lbs_service_equipments where job_type=1 and job_id=" . $index . " and equipment_type_id=" . $equipment['equipment_type_id'];
                            $number = Yii::app()->db->createCommand($sql_number)->queryScalar();
                            if ($this->basic['equipments'] == '') {
                                $this->basic['equipments'] = $basic_name['name'] . '-' . $number;
                            } else {
                                $this->basic['equipments'] = $this->basic['equipments'] . ',' . $basic_name['name'] . '-' . $number;
                            }
                        }
                    }
                    $this->basic['Staffall'] = $this->basic['Staff01'] . ($this->basic['Staff02'] ? ',' . $this->basic['Staff02'] : '') . ($this->basic['Staff03'] ? ',' . $this->basic['Staff03'] : '');
                    if ($this->basic['FirstJob'] == 1) {
                        $this->basic['task_type'] = "首次服务";
                    } else {
                        $this->basic['task_type'] = "常规服务";
                    }
                    //服务项目
                    $service_projects = '';
                    $job_datas = $this->job;
                    if ($service_type == 1) {//洁净
                        if ($job_datas["Item01"] > 0) $service_projects .= "坐厕：" . $job_datas["Item01"] . ",";
                        if ($job_datas["Item02"] > 0) $service_projects .= "尿缸：" . $job_datas["Item02"] . ",";
                        if ($job_datas["Item03"] > 0) $service_projects .= "洗手盆：" . $job_datas["Item03"] . ",";
                        if ($job_datas["Item11"] > 0) $service_projects .= "洗手间：" . $job_datas["Item11"] . " " . $job_datas["Item11Rmk"] . ",";
                        if ($job_datas["Item04"] > 0) $service_projects .= "电动清新机：" . $job_datas["Item04"] . " " . $job_datas["Item04Rmk"] . ",";
                        if ($job_datas["Item05"] > 0) $service_projects .= "皂液机：" . $job_datas["Item05"] . " " . $job_datas["Item05Rmk"] . ",";
                        if ($job_datas["Item06"] > 0) $service_projects .= "水剂喷机：" . $job_datas["Item06"] . " " . $job_datas["Item06Rmk"] . ",";
                        if ($job_datas["Item07"] > 0) $service_projects .= "压缩罐喷机：" . $job_datas["Item07"] . " " . $job_datas["Item07Rmk"] . ",";
                        if ($job_datas["Item08"] > 0) $service_projects .= "尿缸自动消毒器：" . $job_datas["Item08"] . " " . $job_datas["Item08Rmk"] . ",";
                        if ($job_datas["Item09"] > 0) $service_projects .= "厕纸机：" . $job_datas["Item09"] . " " . $job_datas["Item09Rmk"] . ",";
                        if ($job_datas["Item10"] > 0) $service_projects .= "抹手纸：" . $job_datas["Item10"] . " " . $job_datas["Item10Rmk"] . ",";
                        if ($job_datas["Item13"] > 0) $service_projects .= "GOJO机：" . $job_datas["Item13"] . " " . $job_datas["Item13Rmk"] . ",";
                        if ($job_datas["Item12"] > 0) $service_projects .= "其他：" . $job_datas["Item12"] . " " . $job_datas["Item12Rmk"] . ",";
                    } else if ($service_type == 2) {//灭虫
                        if ($job_datas["Item01"] > 0) $service_projects .= "老鼠,";
                        if ($job_datas["Item02"] > 0) $service_projects .= "蟑螂,";
                        if ($job_datas["Item03"] > 0) $service_projects .= "蚁,";
                        if ($job_datas["Item04"] > 0) $service_projects .= "果蝇,";
                        if ($job_datas["Item09"] > 0) $service_projects .= "苍蝇,";
                        if ($job_datas["Item06"] > 0) $service_projects .= "水剂喷机：" . $job_datas["Item06"] . " " . $job_datas["Item06Rmk"] . ",";
                        if ($job_datas["Item07"] > 0) $service_projects .= "罐装灭虫喷机：" . $job_datas["Item07"] . " " . $job_datas["Item07Rmk"] . ",";
                        if ($job_datas["Item10"] > 0) $service_projects .= "灭蝇灯：" . $job_datas["Item10"] . " " . $job_datas["Item10Rmk"] . ",";
                        if ($job_datas["Item08"] > 0) $service_projects .= "其他：" . $job_datas["Item08"] . " " . $job_datas["Item08Rmk"] . ",";
                    } else if ($service_type == 3) {//灭虫喷焗
                        if ($job_datas["Item01"] > 0) $service_projects .= "蚊子,";
                        if ($job_datas["Item02"] > 0) $service_projects .= "苍蝇,";
                        if ($job_datas["Item03"] > 0) $service_projects .= "蟑螂,";
                        if ($job_datas["Item04"] > 0) $service_projects .= "跳蚤,";
                        if ($job_datas["Item05"] > 0) $service_projects .= "蛀虫,";
                        if ($job_datas["Item06"] > 0) $service_projects .= "白蚁,";
                        if ($job_datas["Item07"] > 0) $service_projects .= "其他：" . $job_datas["Item07Rmk"] . ",";
                    } else if ($service_type == 4) {//租机服务
                        if ($job_datas["Item01"] > 0) $service_projects .= "白蚁,";
                        if ($job_datas["Item02"] > 0) $service_projects .= "跳蚤,";
                        if ($job_datas["Item03"] > 0) $service_projects .= "螨虫,";
                        if ($job_datas["Item04"] > 0) $service_projects .= "臭虫,";
                        if ($job_datas["Item05"] > 0) $service_projects .= "滞留,";
                        if ($job_datas["Item06"] > 0) $service_projects .= "焗雾,";
                        if ($job_datas["Item07"] > 0) $service_projects .= "勾枪,";
                        if ($job_datas["Item08"] > 0) $service_projects .= "空间消毒,";
                        if ($job_datas["Item09"] > 0) $service_projects .= "其他：" . $job_datas["Item09Rmk"] . ",";
                    }
                    $this->basic['service_projects'] = $service_projects;

                    $sql_briefing = "select * from lbs_service_briefings where job_type=1 and job_id=" . $index;
                    $this->briefing = Yii::app()->db->createCommand($sql_briefing)->queryRow();

                    $sql_material = "select * from lbs_service_materials where job_type=1 and job_id=" . $index;
                    $this->material = Yii::app()->db->createCommand($sql_material)->queryAll();

                    $sql_risk = "select * from lbs_service_risks where job_type=1 and job_id=" . $index;
                    $this->risk = Yii::app()->db->createCommand($sql_risk)->queryAll();

                    $equipmenthz_datas = [];
                    $sql_equipment_type_ids = "select distinct equipment_type_id from lbs_service_equipments where job_type=1 and job_id=" . $index;
                    $equipment_type_ids = Yii::app()->db->createCommand($sql_equipment_type_ids)->queryAll();
                    if (count($equipment_type_ids) > 0) {
                        foreach ($equipment_type_ids as $i => $type_id) {
                            $sql_equipmenthz_allcount = "select count(id) from lbs_service_equipments where job_type=1 and job_id=" . $index . " and equipment_type_id=" . $type_id['equipment_type_id'];
                            $equipmenthz_allcount = Yii::app()->db->createCommand($sql_equipmenthz_allcount)->queryScalar();
                            $sql_equipmenthz_count = "select count(id) from lbs_service_equipments where job_type=1 and job_id=" . $index . " and equipment_type_id=" . $type_id['equipment_type_id'] . " and equipment_area is not null and equipment_area!='' and check_datas is not null and check_datas!=''";
                            $equipmenthz_count = Yii::app()->db->createCommand($sql_equipmenthz_count)->queryScalar();
                            $sql_equipment_type = "select name from lbs_service_equipment_type where id=" . $type_id['equipment_type_id'];
                            $equipment_type = Yii::app()->db->createCommand($sql_equipment_type)->queryRow();
                            $equipmenthz_datas[$i]['title'] = $equipment_type['name'] . "(" . $equipmenthz_count . "/" . $equipmenthz_allcount . ")";

                            $sql_check_datas = "select * from lbs_service_equipments where job_type=1 and job_id=" . $index . " and equipment_type_id=" . $type_id['equipment_type_id'] . " and equipment_area is not null and equipment_area!='' and check_datas is not null and check_datas!='' order by id asc";
                            $check_datas = Yii::app()->db->createCommand($sql_check_datas)->queryAll();
                            if (count($check_datas) > 0) {
                                for ($j = 0; $j < count($check_datas); $j++) {
                                    $check_data = json_decode($check_datas[$j]['check_datas'], true);
                                    $equipmenthz_datas[$i]['table_title'][0] = '编号';
                                    $equipmenthz_datas[$i]['content'][$j][0] = sprintf('%02s', $j + 1);
                                    $equipmenthz_datas[$i]['table_title'][1] = '区域';
                                    $equipmenthz_datas[$i]['content'][$j][1] = $check_datas[$j]['equipment_area'];
                                    for ($m = 0; $m < count($check_data); $m++) {
                                        $equipmenthz_datas[$i]['table_title'][$m + 2] = $check_data[$m]['label'];
                                        $equipmenthz_datas[$i]['content'][$j][$m + 2] = $check_data[$m]['value'];
                                    }
                                    $equipmenthz_datas[$i]['table_title'][$m + 2] = '检查与处理';
                                    $equipmenthz_datas[$i]['content'][$j][$m + 2] = $check_datas[$j]['check_handle'];
                                    $equipmenthz_datas[$i]['table_title'][$m + 3] = '补充说明';
                                    $equipmenthz_datas[$i]['content'][$j][$m + 3] = $check_datas[$j]['more_info'];
                                    $equipmenthz_datas[$i]['site_photos'][$j] = $check_datas[$j]['site_photos'];
                                }
                            }
                        }
                    }
                    $this->equipment = $equipmenthz_datas;

                    $sql_photo = "select * from lbs_service_photos where job_type=1 and job_id=" . $index . " limit 4";
                    $this->photo = Yii::app()->db->createCommand($sql_photo)->queryAll();



                    //        在这里 首先去获取 新的数据表中是存在相关数据 使用curl_get去获取

                    /**
                     * ###########################################################
                     *                            签名更改开始
                     * ##########################################################
                     * */
                    $params = [
                        'job_type' => 1,
                        'job_id' => $index,
                    ];
                    include_once Yii::app()->basePath . '/common/Utils.php';//引入类文件
                    $utils = new Utils();
                    $params_str = http_build_query($params);
                    $res = $utils->httpCurl($utils->url.$params_str);
                    $res_de = json_decode($res, true);
                    if (isset($res_de) && $res_de['code'] == 0) {
                        $autograph_new = $res_de;
                        //有图片进行处理
                    } else {
                        $autograph_new = $res_de;
                        //继续查询lbs的数据库
                        $sql_autograph = "select * from lbs_report_autograph where job_type='1' and job_id='" . $index."'";
                        $this->autograph = Yii::app()->db->createCommand($sql_autograph)->queryRow();
                    }

                    /**
                     * ###########################################################
                     *                            签名更改结束
                     * ##########################################################
                     * */

                    //查询服务板块
                    $sql_service_sections = "select * from lbs_service_reportsections where city='" . $city . "' and service_type=" . $service_type;
                    $service_sections = Yii::app()->db->createCommand($sql_service_sections)->queryRow();
                    if ($service_sections) {
                        $this->service_sections = explode(',', $service_sections['section_ids']);
                    } else {
                        $this->service_sections = '';
                    }
                    $basic = $this->array_to_object($this->basic);
                    $briefing = $this->briefing ? $this->array_to_object($this->briefing) : '';
                    $material = $this->material;
                    $risk = $this->risk;
                    $equipment = $this->equipment;
                    $photo = $this->photo;
                    $autograph = $this->autograph;
                    $baseUrl_imgs = Yii::app()->params['baseUrl_imgs'];

                    $company_img = $baseUrl_imgs . "pdf/company/" . $city . ".jpg";
                    $logo_img = $baseUrl_imgs . "pdf/logo.png";
                    include_once Yii::app()->basePath . '/extensions/tcpdf/tcpdf.php';//引入库
                    include_once Yii::app()->basePath . '/extensions/tcpdf/config/tcpdf_config.php';//引入库
                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                    //pdf生成
                    $html = <<<EOD
            <style>
            body{
                padding: 0;
                font-family: STFangsong;
            }
            .myTable {
                height: 300px;
                width: 100%;
                font-family:STFangsong;
            }
            .myTitle {
                background-color: #eeeeee;
                font-size: 17px;
                font-weight: bold;
            }
            tr:hover {
                background: #edffcf;
            }
            th {
                font-size: 17px;
                font-weight: bold;
            }
            td {
                font-size: 16px;
            }
            th,td {
                border: solid 1px #eeeeee;
                text-align: center;
            }
            p{
                font-size: 18px;
                line-height:10px;
            }
            </style>
            <body>
            <table class="myTable" cellpadding="5">
                <tr style="border: none;border-top: none;border-right:none;border-left:none;">
                    <td width="25%" style="float:left;border: none;border-top: none;">
                        <img src="$logo_img" width="60" height="70">
                    </td>
                    <td  align="center" width="50%" style="float:left;border: none;border-top: none;">
                        <p style="font-size: 20px;line-height:15px;">史伟莎服务现场管理报告</p>
                    </td>
                </tr>
                <tr class="myTitle">
                    <th  width="100%"  style="text-align:left" align="left">基础信息</th>
                </tr>
                <tr>
                    <td width="15%">客户名称</td>
                    <td width="35%" align="left">$basic->CustomerName</td>
                    <td width="15%">服务日期</td>
                    <td width="35%" align="left">$basic->JobDate</td>
                </tr>
                <tr>
                    <td width="15%">客户地址</td>
                    <td width="85%" align="left">$basic->Addr</td>
                   
                </tr>
                <tr>
                    <td width="15%">服务类型</td>
                    <td width="35%" align="left">$basic->ServiceName</td>
                    <td width="15%">服务项目</td>
                    <td width="35%" align="left">$basic->service_projects</td>
                </tr>
                <tr>
                    <td width="15%">联系人员</td>
                    <td width="35%" align="left">$basic->ContactName</td>
                    <td width="15%">联系电话</td>
                    <td width="35%" align="left">$basic->Mobile</td>
                </tr>
                <tr>
                    <td width="15%">任务类型</td>
                    <td width="35%" align="left">$basic->task_type</td>
                    <td width="15%">服务人员</td>
                    <td width="35%" align="left">$basic->Staffall</td>
                </tr>
                <tr>
                    <td width="15%">监测设备</td>
                    <td width="85%" align="left">$basic->equipments</td>
                </tr>
EOD;
                    if ($briefing != '') {
                        if (($this->service_sections != '' && in_array('1', $this->service_sections)) || $this->service_sections == '') {
							$bc = $city=='MO' ? $briefing->content : mb_convert_encoding(mb_convert_encoding($briefing->content, 'GB2312', 'UTF-8'), 'UTF-8', 'GB2312');
							$bp = $city=='MO' ? $briefing->proposal : mb_convert_encoding(mb_convert_encoding($briefing->proposal, 'GB2312', 'UTF-8'), 'UTF-8', 'GB2312');
                           $html .= <<<EOD
                    <tr class="myTitle">
                        <th width="100%" align="left">服务简报</th>
                    </tr>
                    <tr>
                        <td width="15%">服务内容</td>
                        <td width="85%" align="left">$bc</td>
                    </tr>
                    <tr v-if="report_datas.briefing.proposal!=''">
                        <td width="15%">跟进与建议</td>
                        <td width="85%" align="left">$bp</td>
                    </tr>
EOD;
                        }
                    }

                    if (count($photo) > 0) {
                        if (($this->service_sections != '' && in_array('5', $this->service_sections)) || $this->service_sections == '') {
                            $html .= <<<EOD
                        <tr class="myTitle">
                            <th width="100%" align="left">现场工作照</th>
                        </tr>
EOD;
                            for ($p = 0; $p < count($photo); $p++) {
                                $photox = $this->array_to_object($photo[$p]);
                                $html .= <<<EOD
                        <tr>
                        <td width="20%" align="left">$photox->remarks</td>
EOD;
                                $site_photos = explode(',', $photox->site_photos);
                                for ($sp = 0; $sp < count($site_photos); $sp++) {
                                    $spa = $baseUrl_imgs . str_replace("\/", '/', trim($site_photos[$sp], '"'));
									if (!General::isWebImageValid($spa)) $spa = '/images/spacer.gif';
                                    $html .= <<<EOD
                            <td width="20%" align="center">
                            <img src="$spa" width="80" height="100" style="padding:20px 50px;">
                            </td>
EOD;
                                }
                                $sy_unm = 4 - count($site_photos);
                                for ($j = 0; $j < $sy_unm; $j++) {
                                    $html .= <<<EOD
                            <td width="20%" align="center"></td>
EOD;
                                }
                                $html .= <<<EOD
                                </tr>
EOD;
                            }
                        }
                    }
                    if (count($material) > 0) {
                        if (($this->service_sections != '' && in_array('2', $this->service_sections)) || $this->service_sections == '') {
                            $html .= <<<EOD
                            <tr class="myTitle">
                                <th width="100%" align="left">物料使用</th>
                            </tr>  
                            <tr>
                            <td width="15%">名称</td>
                            <td width="12%">处理面积</td>
                            <td width="7%">配比</td>
                            <td width="8%">用量</td>
                            <td width="12%">使用方式</td>
                            <td width="12%">靶标</td>
                            <td width="12%">使用区域</td>
                            <td width="22%">备注</td>
                            </tr>
EOD;
                            for ($m = 0; $m < count($material); $m++) {
                                $materialx = $this->array_to_object($material[$m]);
                                $degrees = $materialx->dosage . $materialx->unit;
                                $html .= <<<EOD
                        <tr>
                        <td width="15%">$materialx->material_name</td>
                        <td width="12%">$materialx->processing_space</td>
                        <td width="7%">$materialx->material_ratio</td>
                        <td width="8%">$degrees</td>
                        <td width="12%" align="left">$materialx->use_mode</td>
                        <td width="12%" align="left">$materialx->targets</td>
                        <td width="12%" align="left">$materialx->use_area</td>
                        <td width="22%" align="left">$materialx->matters_needing_attention</td>
                        </tr>  
EOD;
                            }
                        }
                    }
                    if(count($risk)>0){
                        if(($this->service_sections!='' && in_array('4',$this->service_sections)) || $this->service_sections==''){
                            $html .= <<<EOD
                            <tr class="myTitle">
                                <th width="100%"align="left">现场风险评估与建议</th>
                            </tr>  
                            <tr>
                            <td width="16%">风险类别</td>
                            <td width="19%">风险描述</td>
                            <td width="13%">靶标</td>
                            <td width="7%">级别</td>
                            <td width="15%">整改建议</td>
                            <td width="15%">采取措施</td>
                            <td width="15%">跟进日期</td>
                            </tr>
EOD;
                            for ($r=0; $r < count($risk); $r++) {
                                $riskx = $this->array_to_object($risk[$r]);
                                $c_t =  date('Y-m-d',strtotime($riskx->creat_time));

                                $html .= <<<EOD
                        <tr>
                        <td width="16%">$riskx->risk_types</td>
                        <td width="19%" align="left">$riskx->risk_description</td>
                        <td width="13%" align="left">$riskx->risk_targets</td>
                        <td width="7%">$riskx->risk_rank</td>
                        <td width="15%" align="left">$riskx->risk_proposal</td>
                        <td width="15%" align="left">$riskx->take_steps</td>
                        <td width="15%">$c_t</td>
                        </tr>
                        <tr>
                        <td width="16%">风险图片</td>
EOD;
                                $site_photos = explode(',',$riskx->site_photos);
                                for ($sp=0; $sp < count($site_photos); $sp++) {
                                    $spa = $baseUrl_imgs.str_replace("\/",'/',trim($site_photos[$sp],'"'));
									if (!General::isWebImageValid($spa)) $spa = '/images/spacer.gif';
                                    $html .= <<<EOD
                        <td width="21%" align="center">
                            <img src="${spa}" width="80" height="100" style="padding:20px 50px;">
                        </td>
EOD;
                    }
                    $sy_unm = 4-count($site_photos);
                        for($j=0;$j<$sy_unm;$j++){
                            $html .= <<<EOD
                            <td width="21%" align="center"></td>
EOD;
                                }
                                $html .= <<<EOD
                        </tr>  
EOD;
                            }
                        }}
                    if (count($equipment) > 0) {
                        if (($this->service_sections != '' && in_array('3', $this->service_sections)) || $this->service_sections == '') {
                            //设备巡查
                            $total = count($equipment);
                            $html .= <<<EOD
                            <tr class="myTitle">
                                <th  width="100%" align="left">设备巡查</th>
                            </tr>
EOD;
                            for ($e = 0; $e < count($equipment); $e++) {
                                $titlex = json_encode($equipment[$e]['title'], JSON_UNESCAPED_UNICODE);
                                $titlex = str_replace("\/", '/', trim($titlex, '"'));
                                if (count($equipment[$e]) > 1) {
                                    $total01 = count($equipment[$e]['table_title']);
                                    $html .= <<<EOD
                            <tr>
                                <th width="100%" align="left">$titlex</th>
                            </tr>
                            <tr>
EOD;
                                    $targs = (31 / ($total01 - 4)) . "%";
                                    $table_titlex = $equipment[$e]['table_title'];
                                    foreach ($table_titlex as $ti => $record) {
                                        if ($ti == 0) {
                                            $wi01 = '8%';
                                        } else if ($ti == 1) {
                                            $wi01 = "11%";
                                        } else if ($ti > 1 && $ti < count($table_titlex) - 2) {
                                            $wi01 = $targs;
                                        } else if ((($ti + 1) == count($table_titlex)) || (($ti + 2) == count($table_titlex))) {
                                            $wi01 = "25%";
                                        }
                                        $html .= <<<EOD
                                        <td width="{$wi01}">$record</td>
EOD;
                                    }
                                    $html .= <<<EOD
                                    </tr>
EOD;

                                    $contentx = $equipment[$e]['content'];
                                    foreach ($contentx as $c => $record1) {
                                        $html .= <<<EOD
                                    <tr>
EOD;
                                        for ($cd = 0; $cd < count($record1); $cd++) {
                                            if ($cd == 0) {
                                                $wi02 = '8%';
                                            } else if ($cd == 1) {
                                                $wi02 = "11%";
                                            } else if ($cd > 1 && $cd < count($record1) - 2) {
                                                $wi02 = $targs;
                                            } else if ((($cd + 1) == count($record1)) || (($cd + 2) == count($record1))) {
                                                $wi02 = "25%";
                                            }

                                            $html .= <<<EOD
                                            <td width="{$wi02}">$record1[$cd]</td>
EOD;
                                        }
                                        $html .= <<<EOD
                                    </tr>
EOD;

                                    }
                                } else {
                                    $html .= <<<EOD
                                    <tr>
                                        <th width="100%" align="left">$titlex</th>
                                    </tr>
                                    <tr>
                                    <td width="100%">设备正常，无处理数据！</td>
                                    </tr>
EOD;
                                }
                            }
                        }
                    }
                    //签名点评



                    /**
                     * ###########################################################
                     *                            签名点评开始
                     * ##########################################################
                     * */
                    //签名点评
                    //设置图片保存路径
                    $path = Yii::app()->basePath . "/images/pdf/" . date("Ymd", time());
                    //判断目录是否存在 不存在就创建
                    if (!is_dir($path)) {
                        mkdir($path, 0777, true);
                    }
                    if ($res_de['code'] == 0) {
//            这里是请求成功的情况
                        $img_data = $autograph_new['data'];
                        $eimageSrc01 = !empty($img_data['staff_id01_url']) ? $utils->sign_url . $img_data['staff_id01_url'] : '';
                        $eimageSrc02 = !empty($img_data['staff_id02_url']) ? $utils->sign_url . $img_data['staff_id02_url'] : '';
                        $eimageSrc03 = !empty($img_data['staff_id03_url']) ? $utils->sign_url . $img_data['staff_id03_url'] : '';
                        $cimageSrcOrg = !empty($img_data['customer_signature_url']) ? $utils->sign_url . $img_data['customer_signature_url'] : '';
                        $customer_grade = !empty($img_data['customer_grade']) ? $img_data['customer_grade'] : '';
                        $employee02_signature = '';
                        $employee03_signature = '';

                        if ($cimageSrcOrg != '' && $img_data['customer_signature_url'] != 'undefined') {
                            $file = @file_get_contents($cimageSrcOrg);
                            $cimageSrc = $path . $img_data['customer_signature_url'];
                            file_put_contents($path . $img_data['customer_signature_url'], $file);
                            $degrees = 90;      //旋转角度
                            $utils->pic_rotating($degrees, $cimageSrc);
                        } else {
                            $cimageSrc = '';
                        }

                    } else {
//            没有查询到图片
                        $eimageName01 = "lbs_" . date("His", time()) . "_" . rand(111, 999) . '.png';
                        $eimageName02 = "lbs_" . date("His", time()) . "_" . rand(111, 999) . '.png';
                        $eimageName03 = "lbs_" . date("His", time()) . "_" . rand(111, 999) . '.png';
                        //设置图片保存路径
                        $path = Yii::app()->basePath . "/images/pdf/" . date("Ymd", time());
                        //判断目录是否存在 不存在就创建
                        if (!is_dir($path)) {
                            mkdir($path, 0777, true);
                        }
                        $employee01_signature = str_replace("data:image/jpg;base64,", "", $autograph['employee01_signature']);
                        $employee02_signature = str_replace("data:image/jpg;base64,", "", $autograph['employee02_signature']);
                        $employee03_signature = str_replace("data:image/jpg;base64,", "", $autograph['employee03_signature']);
                        //图片路径
                        $eimageSrc01 = $path . "/" . $eimageName01;
                        if ($employee01_signature != '') file_put_contents($eimageSrc01, base64_decode($employee01_signature));
                        $eimageSrc02 = $path . "/" . $eimageName02;
                        if ($employee02_signature != '') file_put_contents($eimageSrc02, base64_decode($employee02_signature));
                        $eimageSrc03 = $path . "/" . $eimageName03;
                        if ($employee03_signature != '') file_put_contents($eimageSrc03, base64_decode($employee03_signature));

                        if ($autograph['customer_signature'] != '' && $autograph['customer_signature'] != 'undefined') {
                            $cimageName = "lbs_" . date("His", time()) . "_" . rand(111, 999) . '.png';
                            $cimageSrc = $path . "/" . $cimageName;
                            $customer_signature = str_replace("data:image/png;base64,", "", $autograph['customer_signature']);
                            file_put_contents($cimageSrc, base64_decode($customer_signature));

                            $degrees = 90;      //旋转角度
                            $url = $cimageSrc;  //图片存放位置
                            $utils->pic_rotating($degrees, $url);
                        } else {
                            $cimageSrc = '';
                        }
                        $customer_grade = $autograph['customer_grade'];
                    }
                    if (count($autograph) > 0 || $res_de['code'] == 0) {
                        $sign_datas = $res_de['data'];
                        $html .= <<<EOD
                        <tr class="myTitle">
                            <th width="100%" align="left">客户点评</th>
                        </tr>
                        <tr>
							<td width="100%" align="left">{$customer_grade}星(1~5)</td>
                        </tr>
                        <tr class="myTitle">
                            <th  width="100%" align="left">报告签名</th>
                        </tr>                                         
                        <tr>
							<td width="50%" align="left">服务人员签字</td>
							<td width="50%" align="left">客户签字</td>
                        </tr>
                        <tr>
							<td width="50%" align="left">
								<img src="{$eimageSrc01}" width="130" height="80" style="magin:20px 50px;">
EOD;
                        if ($employee02_signature != '' || isset($sign_datas['staff_id02_url']) && $sign_datas['staff_id02_url'] != '') {
                            $html .= <<<EOD
								<img src="{$eimageSrc02}" width="130" height="80" style="magin:20px 50px;">
EOD;
                        }
                        if ($employee03_signature != '' || isset($sign_datas['staff_id03_url']) && $sign_datas['staff_id03_url'] != '') {
                            $html .= <<<EOD
								<img src="{$eimageSrc03}" width="130" height="80" style="magin:20px 50px;">
EOD;
                        }
                        $html .= <<<EOD
							</td>
							<td width="50%" align="left"><img src="{$cimageSrc}" width="130" height="80" style="magin:20px 50px; transform:rotate(-90deg)"></td>
                        </tr>
EOD;
                    }


                    /**
                     * ###########################################################
                     *                            签名点评结束
                     * ##########################################################
                     * */




                    $html .= <<<EOD
            </table>
            <img src="$company_img">
            </body>
EOD;
                    if (@file_exists(dirname(__FILE__) . '/lang/chi.php')) {
                        require_once(dirname(__FILE__) . '/lang/chi.php');
                    }
                    $pdf->SetPrintHeader(false);
                    $pdf->SetPrintFooter(false);
                    $pdf->AddPage();
                    $pdf->WriteHTML($html, 1);
                    //Close and output PDF document

                    $filename = $basic->CustomerName . "-(" . $basic->ServiceName . ")" . $basic->JobDate . ".pdf";

                    //设置pdf保存路径
                    $reportpath = Yii::app()->basePath . "/images/report/" . $city . "/" . $basic->JobDate;
                    //判断目录是否存在 不存在就创建
                    if (!is_dir($reportpath)) {
                        mkdir($reportpath, 0777, true);
                    }
                    ob_clean();
                    $pdf->Output($reportpath . "/" . $index . '.pdf', 'F');
                }
            }
            return true;
        }else{
            return false;
        }

    }

	public function retrieveData($index,$status)
	{
        $suffix = Yii::app()->params['envSuffix'];
		$city = Yii::app()->user->city_allow();
		$sql_basic = "select j.JobID,j.CustomerName,j.Addr,j.ContactName,j.Mobile,j.JobDate,j.StartTime,j.FinishTime,u.StaffName as Staff01,uo.StaffName as Staff02,ut.StaffName as Staff03,s.ServiceName,j.Status,j.City,j.ServiceType,j.FirstJob,j.FinishDate  from joborder as j left join service as s on s.ServiceType=j.ServiceType left join staff as u on u.StaffID=j.Staff01 left join staff as uo on uo.StaffID=j.Staff02 left join staff as ut on ut.StaffID=j.Staff03 where j.JobID=".$index;
        $this->basic = Yii::app()->db->createCommand($sql_basic)->queryRow();

		$sql_job = "select * from joborder where JobID=".$index;
        $this->job = Yii::app()->db->createCommand($sql_job)->queryRow();

        $sql_city = "select * from enums as e left join officecity as o on o.Office=e.EnumID where o.City=".$this->basic['City']." and e.EnumType=8";
        $this->city = Yii::app()->db->createCommand($sql_city)->queryRow();
        $city = $this->city['Text'];

        //判断是否存在PDF
        $reportfile = Yii::app()->basePath."/images/report/".$city."/".$this->basic['JobDate']."/".$index.'.pdf';
        if(file_exists($reportfile)){
            if ($status>0){
                header("Content-type: application/pdf");
            }else{
                $filename = $this->basic['CustomerName']."-(".$this->basic['ServiceName'].")".$this->basic['JobDate'].".pdf";
                header('Content-Type: application-x/force-download');
                header('Content-Disposition: attachment; filename='.$filename );
            }
            header("Content-Length: " . filesize($reportfile));
            // 将文件发送到浏览器。
            return readfile($reportfile);
        }

        $service_type = $this->basic['ServiceType'];
        $this->basic['equipments'] = '';
        $sql_basic_equipments = "select distinct equipment_type_id from lbs_service_equipments where job_type=1 and job_id=".$index;
        $basic_equipments =  Yii::app()->db->createCommand($sql_basic_equipments)->queryAll();
        if (count($basic_equipments) > 0) {
            foreach ($basic_equipments as $k=>$equipment) {
                $sql_name = "select name from lbs_service_equipment_type where id=".$equipment['equipment_type_id'];
                $basic_name =  Yii::app()->db->createCommand($sql_name)->queryRow();
                $sql_number = "select count(id) from lbs_service_equipments where job_type=1 and job_id=".$index." and equipment_type_id=".$equipment['equipment_type_id'];
                $number = Yii::app()->db->createCommand($sql_number)->queryScalar();
                if ($this->basic['equipments'] == '') {
                    $this->basic['equipments'] = $basic_name['name'].'-'.$number;
                }else{
                    $this->basic['equipments'] =$this->basic['equipments'].','.$basic_name['name'].'-'.$number;
                }
            }
        }
        $this->basic['Staffall'] = $this->basic['Staff01'].($this->basic['Staff02']?','.$this->basic['Staff02']:'').($this->basic['Staff03']?','.$this->basic['Staff03']:'');
        if($this->basic['FirstJob']==1){
            $this->basic['task_type'] = "首次服务";
        }else{
            $this->basic['task_type'] = "常规服务";
        }
        //服务项目
        $service_projects = '';
        $job_datas = $this->job;
        if($service_type==1){//洁净
            if ($job_datas["Item01"] > 0) $service_projects .= "坐厕：".$job_datas["Item01"].",";
            if ($job_datas["Item02"] > 0) $service_projects .= "尿缸：".$job_datas["Item02"].",";
            if ($job_datas["Item03"] > 0) $service_projects .= "洗手盆：".$job_datas["Item03"].",";
            if ($job_datas["Item11"] > 0) $service_projects .= "洗手间：".$job_datas["Item11"]." ".$job_datas["Item11Rmk"] . ",";
            if ($job_datas["Item04"] > 0) $service_projects .= "电动清新机：".$job_datas["Item04"]. " ".$job_datas["Item04Rmk"] . ",";
            if ($job_datas["Item05"] > 0) $service_projects .= "皂液机：".$job_datas["Item05"]." ".$job_datas["Item05Rmk"] . ",";
            if ($job_datas["Item06"] > 0) $service_projects .= "水剂喷机：".$job_datas["Item06"]." ".$job_datas["Item06Rmk"] . ",";
            if ($job_datas["Item07"] > 0) $service_projects .= "压缩罐喷机：".$job_datas["Item07"]." ".$job_datas["Item07Rmk"] . ",";
            if ($job_datas["Item08"] > 0) $service_projects .= "尿缸自动消毒器：".$job_datas["Item08"]." ".$job_datas["Item08Rmk"] . ",";
            if ($job_datas["Item09"] > 0) $service_projects .= "厕纸机：".$job_datas["Item09"]." ".$job_datas["Item09Rmk"] . ",";
            if ($job_datas["Item10"] > 0) $service_projects .= "抹手纸：".$job_datas["Item10"]." ".$job_datas["Item10Rmk"] . ",";
            if ($job_datas["Item13"] > 0) $service_projects .= "GOJO机：".$job_datas["Item13"]." ".$job_datas["Item13Rmk"] . ",";
            if ($job_datas["Item12"] > 0) $service_projects .= "其他：".$job_datas["Item12"]." ".$job_datas["Item12Rmk"] . ",";
        }else if($service_type==2){//灭虫
            if ($job_datas["Item01"] > 0) $service_projects .= "老鼠,";
            if ($job_datas["Item02"] > 0) $service_projects .= "蟑螂,";
            if ($job_datas["Item03"] > 0) $service_projects .= "蚁,";
            if ($job_datas["Item04"] > 0) $service_projects .= "果蝇,";
            if ($job_datas["Item09"] > 0) $service_projects .= "苍蝇,";
            if ($job_datas["Item06"] > 0) $service_projects .= "水剂喷机：".$job_datas["Item06"]." ".$job_datas["Item06Rmk"] . ",";
            if ($job_datas["Item07"] > 0) $service_projects .= "罐装灭虫喷机：".$job_datas["Item07"]." ".$job_datas["Item07Rmk"] . ",";
            if ($job_datas["Item10"] > 0) $service_projects .= "灭蝇灯：".$job_datas["Item10"]." ".$job_datas["Item10Rmk"] . ",";
            if ($job_datas["Item08"] > 0) $service_projects .= "其他：".$job_datas["Item08"]." ".$job_datas["Item08Rmk"] . ",";
        }else if($service_type==3){//灭虫喷焗
            if ($job_datas["Item01"] > 0) $service_projects .= "蚊子,";
            if ($job_datas["Item02"] > 0) $service_projects .= "苍蝇,";
            if ($job_datas["Item03"] > 0) $service_projects .= "蟑螂,";
            if ($job_datas["Item04"] > 0) $service_projects .= "跳蚤,";
            if ($job_datas["Item05"] > 0) $service_projects .= "蛀虫,";
            if ($job_datas["Item06"] > 0) $service_projects .= "白蚁,";
            if ($job_datas["Item07"] > 0) $service_projects .= "其他：".$job_datas["Item07Rmk"] . ",";
        }else if($service_type==4){//租机服务
            if ($job_datas["Item01"] > 0) $service_projects .= "白蚁,";
            if ($job_datas["Item02"] > 0) $service_projects .= "跳蚤,";
            if ($job_datas["Item03"] > 0) $service_projects .= "螨虫,";
            if ($job_datas["Item04"] > 0) $service_projects .= "臭虫,";
            if ($job_datas["Item05"] > 0) $service_projects .= "滞留,";
            if ($job_datas["Item06"] > 0) $service_projects .= "焗雾,";
            if ($job_datas["Item07"] > 0) $service_projects .= "勾枪,";
            if ($job_datas["Item08"] > 0) $service_projects .= "空间消毒,";
            if ($job_datas["Item09"] > 0) $service_projects .= "其他：".$job_datas["Item09Rmk"] . ",";
        }
        $this->basic['service_projects'] = $service_projects;

        $sql_briefing = "select * from lbs_service_briefings where job_type=1 and job_id=".$index;
        $this->briefing = Yii::app()->db->createCommand($sql_briefing)->queryRow();

        $sql_material = "select * from lbs_service_materials where job_type=1 and job_id=".$index;
        $this->material = Yii::app()->db->createCommand($sql_material)->queryAll();

        $sql_risk = "select * from lbs_service_risks where job_type=1 and job_id=".$index;
        $this->risk = Yii::app()->db->createCommand($sql_risk)->queryAll();

        $equipmenthz_datas = [];
        $sql_equipment_type_ids = "select distinct equipment_type_id from lbs_service_equipments where job_type=1 and job_id=".$index;
        $equipment_type_ids =  Yii::app()->db->createCommand($sql_equipment_type_ids)->queryAll();
        if (count($equipment_type_ids) > 0) {
            foreach ($equipment_type_ids as $i=>$type_id) {
                $sql_equipmenthz_allcount = "select count(id) from lbs_service_equipments where job_type=1 and job_id=".$index." and equipment_type_id=".$type_id['equipment_type_id'];
                $equipmenthz_allcount = Yii::app()->db->createCommand($sql_equipmenthz_allcount)->queryScalar();
                $sql_equipmenthz_count = "select count(id) from lbs_service_equipments where job_type=1 and job_id=".$index." and equipment_type_id=".$type_id['equipment_type_id']." and equipment_area is not null and equipment_area!='' and check_datas is not null and check_datas!=''";
                $equipmenthz_count = Yii::app()->db->createCommand($sql_equipmenthz_count)->queryScalar();
                $sql_equipment_type = "select name from lbs_service_equipment_type where id=".$type_id['equipment_type_id'];
                $equipment_type= Yii::app()->db->createCommand($sql_equipment_type)->queryRow();
                $equipmenthz_datas[$i]['title'] = $equipment_type['name']."(".$equipmenthz_count."/".$equipmenthz_allcount.")";

                $sql_check_datas = "select * from lbs_service_equipments where job_type=1 and job_id=".$index." and equipment_type_id=".$type_id['equipment_type_id']." and equipment_area is not null and equipment_area!='' and check_datas is not null and check_datas!='' order by id asc";
                $check_datas= Yii::app()->db->createCommand($sql_check_datas)->queryAll();
                if (count($check_datas) > 0) {
                    for($j=0; $j < count($check_datas); $j++){
                        $check_data = json_decode($check_datas[$j]['check_datas'],true);
                        $equipmenthz_datas[$i]['table_title'][0] = '编号';
                        $equipmenthz_datas[$i]['content'][$j][0] = sprintf('%02s', $j+1);
                        $equipmenthz_datas[$i]['table_title'][1] = '区域';
                        $equipmenthz_datas[$i]['content'][$j][1] = $check_datas[$j]['equipment_area'];
                        for ($m=0; $m < count($check_data); $m++) {
                            $equipmenthz_datas[$i]['table_title'][$m+2] = $check_data[$m]['label'];
                            $equipmenthz_datas[$i]['content'][$j][$m+2] = $check_data[$m]['value'];
                        }
                        $equipmenthz_datas[$i]['table_title'][$m+2] = '检查与处理';
                        $equipmenthz_datas[$i]['content'][$j][$m+2] = $check_datas[$j]['check_handle'];
                        $equipmenthz_datas[$i]['table_title'][$m+3] = '补充说明';
                        $equipmenthz_datas[$i]['content'][$j][$m+3] = $check_datas[$j]['more_info'];
                        $equipmenthz_datas[$i]['site_photos'][$j] = $check_datas[$j]['site_photos'];
                    }
                }
            }
        }
        $this->equipment = $equipmenthz_datas;

        $sql_photo = "select * from lbs_service_photos where job_type=1 and job_id=".$index." limit 8";
        $this->photo = Yii::app()->db->createCommand($sql_photo)->queryAll();

        /**
         * ###########################################################
         *                            签名更改开始
         * ##########################################################
         * */
        $params = [
            'job_type' => 1,
            'job_id' => $index,
        ];
        include_once Yii::app()->basePath . '/common/Utils.php';//引入类文件
        $utils = new Utils();
        $params_str = http_build_query($params);
        $res = $utils->httpCurl($utils->url.$params_str);
        $res_de = json_decode($res, true);
        if (isset($res_de) && $res_de['code'] == 0) {
            $autograph_new = $res_de;
            //有图片进行处理
        } else {
            $autograph_new = $res_de;
            //继续查询lbs的数据库
            $sql_autograph = "select * from lbs_report_autograph where job_type='1' and job_id='" . $index."'";
            $this->autograph = Yii::app()->db->createCommand($sql_autograph)->queryRow();
        }

        /**
         * ###########################################################
         *                            签名更改结束
         * ##########################################################
         * */




        //查询服务板块
        $sql_service_sections = "select * from lbs_service_reportsections where city='".$city."' and service_type=".$service_type;
        $service_sections = Yii::app()->db->createCommand($sql_service_sections)->queryRow();
        if($service_sections){
            $this->service_sections = explode(',',$service_sections['section_ids']);
        }else{
            $this->service_sections = '';
        }

        $basic = $this->array_to_object ($this->basic);
        $briefing = $this->briefing?$this->array_to_object ($this->briefing):'';
        $material = $this->material;
        $risk = $this->risk;
        $equipment = $this->equipment;
        $photo = $this->photo;
        $autograph = $this->autograph;
        $baseUrl_imgs = Yii::app()->params['baseUrl_imgs'];
        $company_img = $baseUrl_imgs."pdf/company/".$city.".jpg";
        $logo_img = $baseUrl_imgs."pdf/logo.png";
        include_once Yii::app()->basePath . '/extensions/tcpdf/tcpdf.php';//引入库
        include_once Yii::app()->basePath . '/extensions/tcpdf/config/tcpdf_config.php';//引入库
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        //pdf生成
        $html = <<<EOD
            <style>
            body{
                padding: 0;
                font-family: STFangsong;
            }
            .myTable {
                height: 300px;
                width: 100%;
                font-family:STFangsong;
            }
            .myTitle {
                background-color: #eeeeee;
                font-size: 17px;
                font-weight: bold;
            }
            tr:hover {
                background: #edffcf;
            }
            th {
                font-size: 17px;
                font-weight: bold;
            }
            td {
                font-size: 16px;
            }
            th,td {
                border: solid 1px #eeeeee;
                text-align: center;
            }
            p{
                font-size: 18px;
                line-height:10px;
            }
            </style>
            <body>
            <table class="myTable" cellpadding="5">
                <tr style="border: none;border-top: none;border-right:none;border-left:none;">
                    <td width="25%" style="float:left;border: none;border-top: none;">
                        <img src="$logo_img" width="60" height="70">
                    </td>
                    <td  align="center" width="50%" style="float:left;border: none;border-top: none;">
                        <p style="font-size: 20px;line-height:15px;">史伟莎服务现场管理报告</p>
                    </td>
                </tr>
                <tr class="myTitle">
                    <th  width="100%"  style="text-align:left" align="left">基础信息</th>
                </tr>
                <tr>
                    <td width="15%">客户名称</td>
                    <td width="35%" align="left">$basic->CustomerName</td>
                    <td width="15%">服务日期</td>
                    <td width="35%" align="left">$basic->JobDate</td>
                </tr>
                <tr>
                    <td width="15%">客户地址</td>
                    <td width="85%" align="left">$basic->Addr</td>
                   
                </tr>
                <tr>
                    <td width="15%">服务类型</td>
                    <td width="35%" align="left">$basic->ServiceName</td>
                    <td width="15%">服务项目</td>
                    <td width="35%" align="left">$basic->service_projects</td>
                </tr>
                <tr>
                    <td width="15%">联系人员</td>
                    <td width="35%" align="left">$basic->ContactName</td>
                    <td width="15%">联系电话</td>
                    <td width="35%" align="left">$basic->Mobile</td>
                </tr>
                <tr>
                    <td width="15%">任务类型</td>
                    <td width="35%" align="left">$basic->task_type</td>
                    <td width="15%">服务人员</td>
                    <td width="35%" align="left">$basic->Staffall</td>
                </tr>
                <tr>
                    <td width="15%">监测设备</td>
                    <td width="85%" align="left">$basic->equipments</td>
                </tr>
EOD;
        if($briefing!=''){
        if(($this->service_sections!='' && in_array('1',$this->service_sections)) || $this->service_sections==''){
			$bc = $city=='MO' ? $briefing->content : mb_convert_encoding(mb_convert_encoding($briefing->content, 'GB2312', 'UTF-8'), 'UTF-8', 'GB2312');
			$bp = $city=='MO' ? $briefing->proposal : mb_convert_encoding(mb_convert_encoding($briefing->proposal, 'GB2312', 'UTF-8'), 'UTF-8', 'GB2312');
            $html .= <<<EOD
                    <tr class="myTitle">
                        <th width="100%" align="left">服务简报</th>
                    </tr>
                    <tr>
                        <td width="15%">服务内容</td>
                        <td width="85%" align="left">$bc</td>
                    </tr>
                    <tr v-if="report_datas.briefing.proposal!=''">
                        <td width="15%">跟进与建议</td>
                        <td width="85%" align="left">$bp</td>
                    </tr>
EOD;
            }}

        if(count($photo)>0){
        if(($this->service_sections!='' && in_array('5',$this->service_sections)) || $this->service_sections==''){
            $html .= <<<EOD
                        <tr class="myTitle">
                            <th width="100%" align="left">现场工作照</th>
                        </tr>
EOD;
                for ($p=0; $p < count($photo); $p++) {
                    $photox = $this->array_to_object($photo[$p]);
                    $html .= <<<EOD
                        <tr>
                        <td width="20%" align="left">$photox->remarks</td>
EOD;
                        $site_photos = explode(',',$photox->site_photos);
                        for ($sp=0; $sp < count($site_photos); $sp++) {
                            $spa = $baseUrl_imgs.str_replace("\/",'/',trim($site_photos[$sp],'"'));
							if (!General::isWebImageValid($spa)) $spa = '/images/spacer.gif';
                            $html .= <<<EOD
                            <td width="20%" align="center">
                            <img src="$spa" width="80" height="100" style="padding:20px 50px;">
                            </td>
EOD;
                        }
                        $sy_unm = 4-count($site_photos);
                        for($j=0;$j<$sy_unm;$j++){
                            $html .= <<<EOD
                            <td width="20%" align="center"></td>
EOD;
                        }
                    $html .= <<<EOD
                                </tr>
EOD;
                }
            }}
        if(count($material)>0){
        if(($this->service_sections!='' && in_array('2',$this->service_sections)) || $this->service_sections==''){
            $html .= <<<EOD
                            <tr class="myTitle">
                                <th width="100%" align="left">物料使用</th>
                            </tr>  
                            <tr>
                            <td width="15%">名称</td>
                            <td width="12%">处理面积</td>
                            <td width="7%">配比</td>
                            <td width="8%">用量</td>
                            <td width="12%">使用方式</td>
                            <td width="12%">靶标</td>
                            <td width="12%">使用区域</td>
                            <td width="22%">备注</td>
                            </tr>
EOD;
                for ($m=0; $m < count($material); $m++) {
                    $materialx = $this->array_to_object($material[$m]);
                    $degrees = $materialx->dosage.$materialx->unit;
                    $html .= <<<EOD
                        <tr>
                        <td width="15%">$materialx->material_name</td>
                        <td width="12%">$materialx->processing_space</td>
                        <td width="7%">$materialx->material_ratio</td>
                        <td width="8%">$degrees</td>
                        <td width="12%" align="left">$materialx->use_mode</td>
                        <td width="12%" align="left">$materialx->targets</td>
                        <td width="12%" align="left">$materialx->use_area</td>
                        <td width="22%" align="left">$materialx->matters_needing_attention</td>
                        </tr>  
EOD;
                }
            }}
        if(count($risk)>0){
            if(($this->service_sections!='' && in_array('4',$this->service_sections)) || $this->service_sections==''){
                $html .= <<<EOD
                            <tr class="myTitle">
                                <th width="100%"align="left">现场风险评估与建议</th>
                            </tr>  
                            <tr>
                            <td width="16%">风险类别</td>
                            <td width="19%">风险描述</td>
                            <td width="13%">靶标</td>
                            <td width="7%">级别</td>
                            <td width="15%">整改建议</td>
                            <td width="15%">采取措施</td>
                            <td width="15%">跟进日期</td>
                            </tr>
EOD;
                for ($r=0; $r < count($risk); $r++) {
                    $riskx = $this->array_to_object($risk[$r]);
                    $c_t =  date('Y-m-d',strtotime($riskx->creat_time));

                    $html .= <<<EOD
                        <tr>
                        <td width="16%">$riskx->risk_types</td>
                        <td width="19%" align="left">$riskx->risk_description</td>
                        <td width="13%" align="left">$riskx->risk_targets</td>
                        <td width="7%">$riskx->risk_rank</td>
                        <td width="15%" align="left">$riskx->risk_proposal</td>
                        <td width="15%" align="left">$riskx->take_steps</td>
                        <td width="15%">$c_t</td>
                        </tr>
                        <tr>
                        <td width="16%">风险图片</td>
EOD;
                    $site_photos = explode(',',$riskx->site_photos);
                    for ($sp=0; $sp < count($site_photos); $sp++) {
                        $spa = $baseUrl_imgs.str_replace("\/",'/',trim($site_photos[$sp],'"'));
						if (!General::isWebImageValid($spa)) $spa = '/images/spacer.gif';
                        $html .= <<<EOD
                        <td width="21%" align="center">
                            <img src="${spa}" width="80" height="100" style="padding:20px 50px;">
                        </td>
EOD;
                    }
                    $sy_unm = 4-count($site_photos);
                        for($j=0;$j<$sy_unm;$j++){
                            $html .= <<<EOD
                            <td width="21%" align="center"></td>
EOD;
                    }
                    $html .= <<<EOD
                        </tr>  
EOD;
                }
            }}
        if(count($equipment)>0){
        if(($this->service_sections!='' && in_array('3',$this->service_sections)) || $this->service_sections==''){
            //设备巡查
            $total = count($equipment);
            $html .= <<<EOD
                            <tr class="myTitle">
                                <th  width="100%" align="left">设备巡查</th>
                            </tr>
EOD;
                for ($e=0; $e < count($equipment); $e++) {
                    $titlex = json_encode($equipment[$e]['title'], JSON_UNESCAPED_UNICODE);
                    $titlex = str_replace("\/",'/',trim($titlex,'"'));
                    if(count($equipment[$e])>1){
                        $total01 = count($equipment[$e]['table_title']);
                        $html .= <<<EOD
                            <tr>
                                <th width="100%" align="left">$titlex</th>
                            </tr>
                            <tr>
EOD;
                        $targs = (31/($total01-4))."%";
                        $table_titlex = $equipment[$e]['table_title'];
                        foreach ($table_titlex as $ti=>$record) {
                            if ($ti==0) {
                                $wi01 = '8%';
                            }else if ($ti==1) {
                               $wi01 = "11%";
                            }else if($ti>1 && $ti<count($table_titlex)-2){
                                $wi01 = $targs;
                            }else if ((($ti+1)==count($table_titlex)) || (($ti+2)==count($table_titlex))) {
                               $wi01 = "25%";
                            }
                            $html .= <<<EOD
                                        <td width="{$wi01}">$record</td>
EOD;
                        }
                        $html .= <<<EOD
                                    </tr>
EOD;

                        $contentx= $equipment[$e]['content'];
                        foreach ($contentx as $c=>$record1) {
                            $html .= <<<EOD
                                    <tr>
EOD;
                            for ($cd=0; $cd < count($record1); $cd++) {
                                if ($cd==0) {
                                    $wi02 = '8%';
                                }else if ($cd==1) {
                                   $wi02 = "11%";
                                }else if($cd>1 && $cd<count($record1)-2){
                                    $wi02 = $targs;
                                }else if ((($cd+1)==count($record1)) || (($cd+2)==count($record1))) {
                                   $wi02 = "25%";
                                }

                                $html .= <<<EOD
                                            <td width="{$wi02}">$record1[$cd]</td>
EOD;
                            }
                            $html .= <<<EOD
                                    </tr>
EOD;

                        }
                    }else{
                        $html .= <<<EOD
                                    <tr>
                                        <th width="100%" align="left">$titlex</th>
                                    </tr>
                                    <tr>
                                    <td width="100%">设备正常，无处理数据！</td>
                                    </tr>
EOD;
                    }
                }
            }}
        //签名点评

        /**
         * ###########################################################
         *                            签名点评开始
         * ##########################################################
         * */
        //签名点评

        //设置图片保存路径
        $path = Yii::app()->basePath . "/images/pdf/" . date("Ymd", time());
        //判断目录是否存在 不存在就创建
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        if ($res_de['code'] == 0) {
//            这里是请求成功的情况
            $img_data = $autograph_new['data'];
            $eimageSrc01 = !empty($img_data['staff_id01_url']) ? $utils->sign_url . $img_data['staff_id01_url'] : '';
            $eimageSrc02 = !empty($img_data['staff_id02_url']) ? $utils->sign_url . $img_data['staff_id02_url'] : '';
            $eimageSrc03 = !empty($img_data['staff_id03_url']) ? $utils->sign_url . $img_data['staff_id03_url'] : '';
            $cimageSrcOrg = !empty($img_data['customer_signature_url']) ? $utils->sign_url . $img_data['customer_signature_url'] : '';
            $customer_grade = !empty($img_data['customer_grade']) ? $img_data['customer_grade'] : '';
            $employee02_signature = '';
            $employee03_signature = '';

            if ($cimageSrcOrg != '' && $img_data['customer_signature_url'] != 'undefined') {
                $file = @file_get_contents($cimageSrcOrg);
                $cimageSrc = $path . $img_data['customer_signature_url'];
                file_put_contents($path . $img_data['customer_signature_url'], $file);
                $degrees = 90;      //旋转角度
                $utils->pic_rotating($degrees, $cimageSrc);
            } else {
                $cimageSrc = '';
            }
//            var_dump($cimageSrc);


        } else {
//            没有查询到图片
            $eimageName01 = "lbs_" . date("His", time()) . "_" . rand(111, 999) . '.png';
            $eimageName02 = "lbs_" . date("His", time()) . "_" . rand(111, 999) . '.png';
            $eimageName03 = "lbs_" . date("His", time()) . "_" . rand(111, 999) . '.png';

            $employee01_signature = str_replace("data:image/jpg;base64,", "", $autograph['employee01_signature']);
            $employee02_signature = str_replace("data:image/jpg;base64,", "", $autograph['employee02_signature']);
            $employee03_signature = str_replace("data:image/jpg;base64,", "", $autograph['employee03_signature']);
            //图片路径
            $eimageSrc01 = $path . "/" . $eimageName01;
            if ($employee01_signature != '') file_put_contents($eimageSrc01, base64_decode($employee01_signature));
            $eimageSrc02 = $path . "/" . $eimageName02;
            if ($employee02_signature != '') file_put_contents($eimageSrc02, base64_decode($employee02_signature));
            $eimageSrc03 = $path . "/" . $eimageName03;
            if ($employee03_signature != '') file_put_contents($eimageSrc03, base64_decode($employee03_signature));

            if ($autograph['customer_signature'] != '' && $autograph['customer_signature'] != 'undefined') {
                $cimageName = "lbs_" . date("His", time()) . "_" . rand(111, 999) . '.png';
                $cimageSrc = $path . "/" . $cimageName;
                $customer_signature = str_replace("data:image/png;base64,", "", $autograph['customer_signature']);
                file_put_contents($cimageSrc, base64_decode($customer_signature));
                //直接使用css样式旋转即可，无需特殊处理。

                $degrees = 90;      //旋转角度
                $url = $cimageSrc;  //图片存放位置
                $utils->pic_rotating($degrees, $url);
            } else {
                $cimageSrc = '';
            }
            $customer_grade = $autograph['customer_grade'];
           
        }
        if (count($autograph) > 0 || $res_de['code'] == 0) {
            $sign_datas = $res_de['data'];
            $html .= <<<EOD
                        <tr class="myTitle">
                            <th width="100%" align="left">客户点评</th>
                        </tr>
                        <tr>
							<td width="100%" align="left">{$customer_grade}星(1~5)</td>
                        </tr>
                        <tr class="myTitle">
                            <th  width="100%" align="left">报告签名</th>
                        </tr>                                         
                        <tr>
							<td width="50%" align="left">服务人员签字</td>
							<td width="50%" align="left">客户签字</td>
                        </tr>
                        <tr>
							<td width="50%" align="left">
								<img src="{$eimageSrc01}" width="130" height="80" style="magin:20px 50px;">
EOD;
            if ($employee02_signature != '' || isset($sign_datas['staff_id02_url']) && $sign_datas['staff_id02_url'] != '') {
                $html .= <<<EOD
								<img src="{$eimageSrc02}" width="130" height="80" style="magin:20px 50px;">
EOD;
            }
            if ($employee03_signature != '' || isset($sign_datas['staff_id03_url']) && $sign_datas['staff_id03_url'] != '') {
                $html .= <<<EOD
								<img src="{$eimageSrc03}" width="130" height="80" style="magin:20px 50px;">
EOD;
            }
            $html .= <<<EOD
							</td>
							<td width="50%" align="left"><img src="{$cimageSrc}" width="130" height="80" style="magin:20px 50px; transform:rotate(-90deg)"></td>
                        </tr>
EOD;
        }


        /**
         * ###########################################################
         *                            签名点评结束
         * ##########################################################
         * */

            $html .= <<<EOD
            </table>
            <img src="$company_img">
            </body>
EOD;
        if (@file_exists(dirname(__FILE__).'/lang/chi.php')) {
            require_once(dirname(__FILE__).'/lang/chi.php');
        }
//        var_dump($html);exit();
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->AddPage();
        $pdf->WriteHTML($html, 1);
        $filename = $basic->CustomerName."-(".$basic->ServiceName.")".$basic->JobDate.".pdf";

        //设置pdf保存路径
        $reportpath = Yii::app()->basePath."/images/report/".$city."/".$basic->JobDate;
        //判断目录是否存在 不存在就创建
        if (!is_dir($reportpath)){
            mkdir($reportpath,0777,true);
        }
        ob_clean();
        $pdf->Output($reportpath."/".$index.'.pdf', 'F');
        if ($status>0){
            $pdf->Output($filename, 'I');
        }else{
            $pdf->Output($filename, 'D');
        }
	}
    public function showField($name) {
        $a = explode(',',$this->fields);
        return empty($this->fields) || in_array($name, $a);
    }
}