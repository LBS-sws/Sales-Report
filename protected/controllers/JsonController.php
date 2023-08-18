<?php

class JsonController extends Controller
{
    /**
     *	sales-report
     */
    public function actionIndex()
    {
        $se_suffix = Yii::app()->params['envSuffix'];

        if(@$_GET['user']!='admin'){
            exit;
        }

        // 员工证件数据
        if(@$_GET['ac']=='xcx'){

            // http://dms.lbsapps.cn/sv-uat/
            $url='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
            $host = substr($url,0,strrpos($url,"index.php"));

            $se_suffix = Yii::app()->params['envSuffix'];

            /* 员工证件列表 */
            $sql1 = "select * from service".$se_suffix.".papersstaff order by id desc ";
            $list = Yii::app()->db->createCommand($sql1)->queryAll();

            /* 证件信息 */
            $sql2 = "select * from service".$se_suffix.".papersstaff_info order by id desc ";
            $rows = Yii::app()->db->createCommand($sql2)->queryAll();

            /* 分割图片数组，在数组前面加上域名 */
//            foreach ($rows as $key=>$val){
//                $rows[$key]['imgArr'] = [];
//                if($val['imgUrl']){
//                    $arr = explode(",", $val['imgUrl']);
//                    if(count($arr)==1){
//                        $arr[0];
//                    }else{
//                        foreach ($arr as $k=>$v){
//                            $arr[$k] = $host.$v;
//                        }
//                    }
//                }
//                $rows[$key]['imgArr'] = $arr;
//            }

            $data['host'] = $host;
            $data['data'] = $list;
            $data['list'] = $rows;

            echo json_encode($data);
        }

        // 公司资质数据
        if(@$_GET['ac']=='xcx_company'){

            $sql = "select id,name,city,tacitly from hr".$se_suffix.".hr_company order by id desc ";

            $list = Yii::app()->db->createCommand($sql)->queryAll();

            foreach ($list as $key=>$val){

                $sql1 = "SELECT a.phy_file_name,a.phy_path_name,a.lcd,a.lud FROM docman".$se_suffix.".dm_file a LEFT JOIN docman".$se_suffix.".dm_master b ON a.mast_id = b.id WHERE b.doc_id='".$val['id']."' and b.doc_type_code='COMPANY2'";

                $rows = Yii::app()->db->createCommand($sql1)->queryAll();

                foreach ($rows as $k=>$v){
                    $image_path = "/data/part1".$v['phy_path_name']."/".$v['phy_file_name'];
                    $rows[$k]['img'] = $image_path;
//                    $rows[$k]['img'] = $image_path;
                    //$image_path = "/data/part1/docman/uat/75/5a/262dad057c20357c340fb41579c6a744.jpg";
                    /*$image_data = file_get_contents($image_path);

                    $image_base64 = base64_encode($image_data);

                    $img_url = 'data:image/jpeg;base64,'.$image_base64;

                    $rows[$k]['img'] = $img_url;*/

                }
                $list[$key]['list'] = $rows;
            }

            $data['list'] = $list;
            echo json_encode($data);
        }
		// 公司资质详情
		if(@$_GET['ac']=='xcx_company_item'){
			$str = @$_GET['text'];
			
			$rows = explode(',',$str);
			
			foreach ($rows as $k=>$v){
                
//                    $rows[$k]['img'] = $image_path;
                    //$image_path = "/data/part1/docman/uat/75/5a/262dad057c20357c340fb41579c6a744.jpg";
                    $image_path = $v;
					$image_data = @file_get_contents($image_path);

                    $image_base64 = base64_encode($image_data);
					
                    $rows[$k] = $image_base64;
            }
           
			//print_r($rows);exit;

			echo json_encode($rows);	
		}
    }

}
