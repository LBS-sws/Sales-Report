<?php

class JsonMateriallistController extends Controller
{
    /**
     *	sales-report
     */
    public function actionIndex()
    {
		$tab_suffix = Yii::app()->params['table_envSuffix'];
        $se_suffix = Yii::app()->params['envSuffix'];

        if(@$_GET['user']!='admin'){
            exit;
        }
        if(@$_GET['ac']=='xcx_list'){
			
			
			$text = @$_GET['text'];
			$city = @$_GET['city'];
//            echo "<pre>";
            //$sql = "select name,img_arr from service".$se_suffix.".lbs_service_material_lists where name='$text' and img_arr is not null limit 0,1 ";
			$sql = "select m.*,c.name as classify,c.city,b.name as city_name from ".$tab_suffix."material_lists as m left join ".$tab_suffix."material_classifys as c on m.classify_id=c.id left join security".$se_suffix.".sec_city as b on c.city=b.code where m.name='$text' and c.city='$city'";
			
			//echo $sql;exit;
            $list = Yii::app()->db->createCommand($sql)->queryRow();
			
            $data['item'] = $list;

            echo json_encode($data);
        }
		
	}
}