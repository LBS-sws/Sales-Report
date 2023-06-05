<?php
class ReportJobBatch {
	public static function countJobReport() {
		$model = new ReportjobList;
		$session = Yii::app()->session;
		if (isset($session[$model->criteriaName()]) && !empty($session[$model->criteriaName()])) {
			$criteria = $session[$model->criteriaName()];
			$model->setCriteria($criteria);
		}
		$sql = $model->getCountSQL();
		$total = Yii::app()->db->createCommand($sql)->queryScalar();
		return $total;
	}

	public static function downloadJobReport() {
		$model = new ReportjobList;
		$session = Yii::app()->session;
		if (isset($session[$model->criteriaName()]) && !empty($session[$model->criteriaName()])) {
			$criteria = $session[$model->criteriaName()];
			$model->setCriteria($criteria);
		}
		$sql = $model->getDataSQL();

		$file_list = array();
		$data = Yii::app()->db->createCommand($sql)->queryAll();
//        $job_ids = [];
		foreach ($data as $row) {
			$city = $row['code'];
			$job_dt = $row['JobDate'];
			$job_id = $row['JobID'];
			$servicename = $row['ServiceName'];
			$custname = $row['CustomerName'];
			$reportfile = Yii::app()->basePath."/images/report/$city/$job_dt/$job_id.pdf";
			if (!file_exists($reportfile)) {
				self::generateJobReport($row, $city, $reportfile);
			}
			if (file_exists($reportfile))
				$file_list[$reportfile] = mb_convert_encoding("$custname-($servicename)$job_dt-$job_id.pdf",($city=='MO'?'BIG5':'GB2312'),'UTF-8');
		}
//        $sqlCust = "select CustomerName,CustomerID,JobID from joborder where Status=3 and City in({$jobids}) GROUP BY CustomerID";
//        $custResult = Yii::app()->db->createCommand($sqlCust)->queryAll();
        if(count($data)){
            if(count($data)>10){
                $arr = array_slice($data, 0, 10);
                $zipFileNameArr = [];
                foreach ($arr as $key => $val){
                    $zipFileNameArr[] = $val['CustomerName'];
                }
                $zipNew = array_unique($zipFileNameArr);
                $zipFileName = implode("、",$zipNew);
                $zipFileName = $zipFileName."等".count($data)."个服务报告";
            }else{
                $zipFileNameArr = [];
                foreach ($data as $key => $val){
//                    $zipFileName.=$val['CustomerName']."、";
                    $zipFileNameArr[] = $val['CustomerName'];
                }
                $zipNew = array_unique($zipFileNameArr);
                $zipFileName = implode("、",$zipNew);
                $zipFileName = $zipFileName."等".count($data)."个服务报告";
            }
        }
        $zipNewName = date('Y-m-d').'_'.$zipFileName;
		$fid = 'j'.md5(microtime());
		$zip = new ZipArchive;
		$zipname = sys_get_temp_dir().'/'.$fid.'.zip';
		$zip->open($zipname, ZipArchive::CREATE);
		foreach ($file_list as $pdf=>$result) {
			$zip->addFile($pdf, $result);
		}
        $zip->close();
		return [$fid,$zipNewName];
/*
		header('Content-Type: application/zip');
		header('Content-disposition: attachment; filename=服务报告.zip');
		header('Content-Length: ' . filesize($zipname));
		readfile($zipname);
		unlink($zipname);
*/
	}

	public static function generateJobReport($data, $city, $reportfile) {
		$data['Staffall'] = $data['Staff01Name'] . ($data['Staff02Name'] ? ',' . $data['Staff02Name'] : '') . ($data['Staff03Name'] ? ',' . $data['Staff03Name'] : '');

		$data['task_type'] = $data['FirstJob'] == 1 ? "首次服务" : "常规服务";

		//服务项目
		$service_projects = '';
		$service_type = $data['ServiceType'];
		if ($service_type == 1) {//洁净
			if ($data["Item01"] > 0) $service_projects .= "坐厕：" . $data["Item01"] . ",";
			if ($data["Item02"] > 0) $service_projects .= "尿缸：" . $data["Item02"] . ",";
			if ($data["Item03"] > 0) $service_projects .= "洗手盆：" . $data["Item03"] . ",";
			if ($data["Item11"] > 0) $service_projects .= "洗手间：" . $data["Item11"] . " " . $data["Item11Rmk"] . ",";
			if ($data["Item04"] > 0) $service_projects .= "电动清新机：" . $data["Item04"] . " " . $data["Item04Rmk"] . ",";
			if ($data["Item05"] > 0) $service_projects .= "皂液机：" . $data["Item05"] . " " . $data["Item05Rmk"] . ",";
			if ($data["Item06"] > 0) $service_projects .= "水剂喷机：" . $data["Item06"] . " " . $data["Item06Rmk"] . ",";
			if ($data["Item07"] > 0) $service_projects .= "压缩罐喷机：" . $data["Item07"] . " " . $data["Item07Rmk"] . ",";
			if ($data["Item08"] > 0) $service_projects .= "尿缸自动消毒器：" . $data["Item08"] . " " . $data["Item08Rmk"] . ",";
			if ($data["Item09"] > 0) $service_projects .= "厕纸机：" . $data["Item09"] . " " . $data["Item09Rmk"] . ",";
			if ($data["Item10"] > 0) $service_projects .= "抹手纸：" . $data["Item10"] . " " . $data["Item10Rmk"] . ",";
			if ($data["Item13"] > 0) $service_projects .= "GOJO机：" . $data["Item13"] . " " . $data["Item13Rmk"] . ",";
			if ($data["Item12"] > 0) $service_projects .= "其他：" . $data["Item12"] . " " . $data["Item12Rmk"] . ",";
		} else if ($service_type == 2) {//灭虫
			if ($data["Item01"] > 0) $service_projects .= "老鼠,";
			if ($data["Item02"] > 0) $service_projects .= "蟑螂,";
			if ($data["Item03"] > 0) $service_projects .= "蚁,";
			if ($data["Item04"] > 0) $service_projects .= "果蝇,";
			if ($data["Item09"] > 0) $service_projects .= "苍蝇,";
			if ($data["Item06"] > 0) $service_projects .= "水剂喷机：" . $data["Item06"] . " " . $data["Item06Rmk"] . ",";
			if ($data["Item07"] > 0) $service_projects .= "罐装灭虫喷机：" . $data["Item07"] . " " . $data["Item07Rmk"] . ",";
			if ($data["Item10"] > 0) $service_projects .= "灭蝇灯：" . $data["Item10"] . " " . $data["Item10Rmk"] . ",";
			if ($data["Item08"] > 0) $service_projects .= "其他：" . $data["Item08"] . " " . $data["Item08Rmk"] . ",";
		} else if ($service_type == 3) {//灭虫喷焗
			if ($data["Item01"] > 0) $service_projects .= "蚊子,";
			if ($data["Item02"] > 0) $service_projects .= "苍蝇,";
			if ($data["Item03"] > 0) $service_projects .= "蟑螂,";
			if ($data["Item04"] > 0) $service_projects .= "跳蚤,";
			if ($data["Item05"] > 0) $service_projects .= "蛀虫,";
			if ($data["Item06"] > 0) $service_projects .= "白蚁,";
			if ($data["Item07"] > 0) $service_projects .= "其他：" . $data["Item07Rmk"] . ",";
		} else if ($service_type == 4) {//租机服务
			if ($data["Item01"] > 0) $service_projects .= "白蚁,";
			if ($data["Item02"] > 0) $service_projects .= "跳蚤,";
			if ($data["Item03"] > 0) $service_projects .= "螨虫,";
			if ($data["Item04"] > 0) $service_projects .= "臭虫,";
			if ($data["Item05"] > 0) $service_projects .= "滞留,";
			if ($data["Item06"] > 0) $service_projects .= "焗雾,";
			if ($data["Item07"] > 0) $service_projects .= "勾枪,";
			if ($data["Item08"] > 0) $service_projects .= "空间消毒,";
			if ($data["Item09"] > 0) $service_projects .= "其他：" . $data["Item09Rmk"] . ",";
		}
		$data['service_projects'] = $service_projects;

		$sql_briefing = "select * from lbs_service_briefings where job_type=1 and job_id=" . $data['JobID'];
		$briefing = Yii::app()->db->createCommand($sql_briefing)->queryRow();

		$sql_material = "select * from lbs_service_materials where job_type=1 and job_id=" . $data['JobID'];
		$material = Yii::app()->db->createCommand($sql_material)->queryAll();

		$sql_risk = "select * from lbs_service_risks where job_type=1 and job_id=" . $data['JobID'];
		$risk = Yii::app()->db->createCommand($sql_risk)->queryAll();

		$data['equipments'] = '';
		$sql_basic_equipments = "
			select a.equipment_type_id, b.name, count(a.id) as counter from lbs_service_equipments a, lbs_service_equipment_type b
			where b.id=a.equipment_type_id and a.job_type=1 and a.job_id=".$data['JobID']."
			group by a.equipment_type_id, b.name
		";
		$basic_equipments = Yii::app()->db->createCommand($sql_basic_equipments)->queryAll();
		if (count($basic_equipments) > 0) {
			foreach ($basic_equipments as $k => $equipment) {
				$data['equipments'] .= ($data['equipments']=='' ? '' : ',').$equipment['name'].'-'.$equipment['counter'];
			}
		}

		$equipmenthz_datas = [];
		if (count($basic_equipments) > 0) {
			foreach ($basic_equipments as $i => $type) {
				$sql_check_datas = "select * from lbs_service_equipments where job_type=1 and job_id=" . $data['JobID'] . " and equipment_type_id=" . $type['equipment_type_id'] . " and equipment_area is not null and equipment_area!='' and check_datas is not null and check_datas!='' order by id asc";
				$check_datas = Yii::app()->db->createCommand($sql_check_datas)->queryAll();

				$equipmenthz_count = count($check_datas);
				$equipmenthz_datas[$i]['title'] = $type['name'] . "(" . $equipmenthz_count . "/" . $type['counter'] . ")";

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
		$equipment = $equipmenthz_datas;

		$sql_photo = "select * from lbs_service_photos where job_type=1 and job_id=" . $data['JobID'] . " limit 4";
		$photo = Yii::app()->db->createCommand($sql_photo)->queryAll();

//		$sql_autograph = "select * from lbs_report_autograph where job_type='1' and job_id='" . $data['JobID']."'";
//		$autograph = Yii::app()->db->createCommand($sql_autograph)->queryRow();

        //        在这里 首先去获取 新的数据表中是存在相关数据 使用curl_get去获取

        /**
         * ###########################################################
         *                            签名更改开始
         * ##########################################################
         * */
        $params = [
            'job_type' => 1,
            'job_id' => $data['JobID'],
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
            $sql_autograph = "select * from lbs_report_autograph where job_type='1' and job_id='" . $data['JobID'] . "'";
            $autograph = Yii::app()->db->createCommand($sql_autograph)->queryRow();
        }

        /**
         * ###########################################################
         *                            签名更改结束
         * ##########################################################
         * */




		 //查询服务板块
		$sql_service_sections = "select * from lbs_service_reportsections where city='" . $city . "' and service_type=" . $service_type;
		$service_sections_q = Yii::app()->db->createCommand($sql_service_sections)->queryRow();
		if ($service_sections_q) {
			$service_sections = explode(',', $service_sections_q['section_ids']);
		} else {
			$service_sections = '';
		}

		$basic = $data;
//		$briefing = $briefing_q ? self::array_to_object($briefing_q) : '';
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
                        <img src="{$logo_img}" width="60" height="70">
                    </td>
                    <td  align="center" width="50%" style="float:left;border: none;border-top: none;">
                        <p>史伟莎环保科技有限公司</p>
                        <p style="font-size: 14px;line-height:1px;">服务现场管理报告</p>
                    </td>
                </tr>
                <tr class="myTitle">
                    <th  width="100%"  style="text-align:left" align="left">基础信息</th>
                </tr>
                <tr>
                    <td width="15%">客户名称</td>
                    <td width="35%" align="left">{$basic['CustomerName']}</td>
                    <td width="15%">服务日期</td>
                    <td width="35%" align="left">{$basic['JobDate']}</td>
                </tr>
                <tr>
                    <td width="15%">客户地址</td>
                    <td width="85%" align="left">{$basic['Addr']}</td>
                   
                </tr>
                <tr>
                    <td width="15%">服务类型</td>
                    <td width="35%" align="left">{$basic['ServiceName']}</td>
                    <td width="15%">服务项目</td>
                    <td width="35%" align="left">{$basic['service_projects']}</td>
                </tr>
                <tr>
                    <td width="15%">联系人员</td>
                    <td width="35%" align="left">{$basic['ContactName']}</td>
                    <td width="15%">联系电话</td>
                    <td width="35%" align="left">{$basic['Mobile']}</td>
                </tr>
                <tr>
                    <td width="15%">任务类型</td>
                    <td width="35%" align="left">{$basic['task_type']}</td>
                    <td width="15%">服务人员</td>
                    <td width="35%" align="left">{$basic['Staffall']}</td>
                </tr>
                <tr>
                    <td width="15%">监测设备</td>
                    <td width="85%" align="left">{$basic['equipments']}</td>
                </tr>
EOD;
		if ($briefing !== false) {
			if (($service_sections != '' && in_array('1', $service_sections)) || $service_sections == '') {
				$html .= <<<EOD
                    <tr class="myTitle">
                        <th width="100%" align="left">服务简报</th>
                    </tr>
                    <tr>
                        <td width="15%">服务内容</td>
                        <td width="85%" align="left">{$briefing['content']}</td>
                    </tr>
                    <tr v-if="report_datas.briefing.proposal!=''">
                        <td width="15%">跟进与建议</td>
                        <td width="85%" align="left">{$briefing['proposal']}</td>
                    </tr>
EOD;
			}
		}

		if (count($photo) > 0) {
			if (($service_sections != '' && in_array('5', $service_sections)) || $service_sections == '') {
				$html .= <<<EOD
                        <tr class="myTitle">
                            <th width="100%" align="left">现场工作照</th>
                        </tr>
EOD;
//				for ($p = 0; $p < count($photo); $p++) {
				foreach ($photo as $photox) {
//					$photox = $this->array_to_object($photo[$p]);
					$html .= <<<EOD
                        <tr>
							<td width="20%" align="left">{$photox['remarks']}</td>
EOD;
					$site_photos = explode(',', $photox['site_photos']);
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
			if (($service_sections != '' && in_array('2', $service_sections)) || $service_sections == '') {
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
//				for ($m = 0; $m < count($material); $m++) {
//					$materialx = self::array_to_object($material[$m]);
				foreach ($material as $materialx) {
					$degrees = $materialx['dosage'].$materialx['unit'];
					$html .= <<<EOD
						<tr>
							<td width="15%">{$materialx['material_name']}</td>
							<td width="12%">{$materialx['processing_space']}</td>
							<td width="7%">{$materialx['material_ratio']}</td>
							<td width="8%">{$degrees}</td>
							<td width="12%" align="left">{$materialx['use_mode']}</td>
							<td width="12%" align="left">{$materialx['targets']}</td>
							<td width="12%" align="left">{$materialx['use_area']}</td>
							<td width="22%" align="left">{$materialx['matters_needing_attention']}</td>
                        </tr>  
EOD;
				}
			}
		}

		if(count($risk)>0){
			if(($service_sections!='' && in_array('4',$service_sections)) || $service_sections==''){
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
//				for ($r=0; $r < count($risk); $r++) {
//					$riskx = self::array_to_object($risk[$r]);
				foreach ($risk as $riskx) {
					$c_t =  date('Y-m-d',strtotime($riskx['creat_time']));

					$html .= <<<EOD
						<tr>
							<td width="16%">{$riskx['risk_types']}</td>
							<td width="19%" align="left">{$riskx['risk_description']}</td>
							<td width="13%" align="left">{$riskx['risk_targets']}</td>
							<td width="7%">{$riskx['risk_rank']}</td>
							<td width="15%" align="left">{$riskx['risk_proposal']}</td>
							<td width="15%" align="left">{$riskx['take_steps']}</td>
							<td width="15%">{$c_t}</td>
						</tr>
						<tr>
							<td width="16%">风险图片</td>
EOD;
					$site_photos = explode(',',$riskx['site_photos']);
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
			}
		}

		if (count($equipment) > 0) {
			if (($service_sections != '' && in_array('3', $service_sections)) || $service_sections == '') {
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
							<th width="100%" align="left">{$titlex}</th>
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
							<td width="{$wi01}">{$record}</td>
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
							<th width="100%" align="left">{$titlex}</th>
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
            $cimageSrc = !empty($img_data['customer_signature_url']) ? $utils->sign_url . $img_data['customer_signature_url'] : '';
			$cimageSrc_add = !empty($img_data['customer_signature_url_add']) ? $utils->sign_url . $img_data['customer_signature_url_add'] : '';
			$customer_grade = !empty($img_data['customer_grade']) ? $img_data['customer_grade'] : '';
            $employee02_signature = '';
            $employee03_signature = '';

            // conversion_flag = 1 图片未旋转 需要先下载
            if($img_data['conversion_flag'] == 1){
                if ($cimageSrc != '' && $img_data['customer_signature_url'] != 'undefined') {
                    $cimageName = "lbs_" . date("His", time()) . "_" . rand(111, 999) . '.png';
                    $cimageSrc = $path . "/" . $cimageName;
                    file_put_contents($cimageSrc, $file);
                    $degrees = 90;      //旋转角度
                    $utils->pic_rotating($degrees, $cimageSrc);
                } else {
                    $cimageSrc = '';
                }

				if ($cimageSrc_add != '' && $img_data['customer_signature_url_add'] != 'undefined') {
					$file = @file_get_contents($cimageSrc_add);
					$cimageName = "lbs_" . date("His", time()) . "_" . rand(111, 999) . '.png';
					$cimageSrc_add = $path . "/" . $cimageName;
					file_put_contents($cimageSrc_add, $file);
					$degrees = 90;      //旋转角度
					$utils->pic_rotating($degrees, $cimageSrc_add);
				} else {
					$cimageSrc_add = '';
				}

            }

        } else {
//            没有查询到图片
            $eimageSrc01 = '';
            $eimageSrc02 = '';
            $eimageSrc03 = '';
//            没有查询到图片
            $cimageSrc = '';
            $cimageSrc_add = '';
            $customer_grade = $autograph['customer_grade']??'';
        }
        if ($res_de['code'] == 0) {
            $sign_datas = $autograph_new['data'];
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
			if ($cimageSrc_add != '') {
				$html .= <<<EOD
                            <img src="{$cimageSrc_add}" width="130" height="80" style="magin:20px 50px; transform:rotate(-90deg)">
EOD;
			}
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

		//设置pdf保存路径
		$path_parts = pathinfo($reportfile);
		$reportpath = $path_parts['dirname'];
		//判断目录是否存在 不存在就创建
		if (!is_dir($reportpath)) {
			mkdir($reportpath, 0777, true);
		}
		ob_clean();
		$pdf->Output($reportfile, 'F');
	}
	
	public static function array_to_object($arr) {
        if (gettype($arr) != 'array') {
            return;
        }
        foreach ($arr as $k => $v) {
            if (gettype($v) == 'array' || getType($v) == 'object') {
                $arr[$k] = (object)self::array_to_object($v);
            }
        }

        return (object)$arr;
    }

    public static function pic_rotating($degrees,$url){
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
}
?>