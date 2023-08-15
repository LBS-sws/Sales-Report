<?php

return array(
    'Material settings'=>array(
        'access'=>'MS',
        'icon'=>'fa-edit',
        'items'=>array(
            'Material List'=>array(
                'access'=>'MS01',
                'url'=>'/materiallist/index',
            ),
            'Material Class'=>array(
                'access'=>'MS02',
                'url'=>'/materialclass/index',
            ),
            'Material Usemode'=>array(
                'access'=>'MS03',
                'url'=>'/materialusemode/index',
            ),
            'Material Usepest'=>array(
                'access'=>'MS04',
                'url'=>'/materialusepest/index',
            ),
        ),
    ),
    'Risk settings'=>array(
        'access'=>'RS',
        'icon'=>'fa-edit',
        'items'=>array(
            'Risk Pest'=>array(
                'access'=>'RS01',
                'url'=>'/riskpest/index',
            ),
            'Risk Grade'=>array(
                'access'=>'RS02',
                'url'=>'/riskrank/index',
            ),
            'Risk Category'=>array(
                'access'=>'RS03',
                'url'=>'/risktype/index',
            ),
            'Risk Label'=>array(
                'access'=>'RS04',
                'url'=>'/risklabel/index',
            ),
        ),
    ),
    'Other settings'=>array(
        'access'=>'OS',
        'icon'=>'fa-edit',
        'items'=>array(
            'Shortcuts'=>array(
                'access'=>'OS01',
                'url'=>'/shortcut/index',
            ),
            'Shortcut Content'=>array(
                'access'=>'OS02',
                'url'=>'/shortcutcontent/index',
            ),
            'Equipment Type'=>array(
                'access'=>'OS03',
                'url'=>'/equipmenttype/index',
            ),
            'Number Code'=>array(
                'access'=>'OS11',
                'url'=>'/numbercode/index',
            ),
            'Equipment Number'=>array(
                'access'=>'OS10',
                'url'=>'/equipmentnumber/index',
            ),
            'Equipment Type Select'=>array(
                'access'=>'OS04',
                'url'=>'/equipmenttypeselect/index',
            ),
            'Equipment and material use area'=>array(
                'access'=>'OS05',
                'url'=>'/usearea/index',
            ),
            'Service equipment'=>array(
                'access'=>'OS06',
                'url'=>'/serviceequipment/index',
            ),
            'Service material'=>array(
                'access'=>'OS09',
                'url'=>'/servicematerial/index',
            ),
            'Report section'=>array(
                'access'=>'OS07',
                'url'=>'/reportsection/index',
            ),
            'City Launch Date'=>array(
                'access'=>'OS08',
                'url'=>'/citylaunchdate/index',
            ),
        ),
    ),
    'Signature settings'=>array(
        'access'=>'SS',
        'icon'=>'fa-edit',
        'items'=>array(
            'Employeesignature'=>array(
                'access'=>'SS01',
                'url'=>'/employeesignature/index',
            ),
        ),
    ),
    'Report query'=>array(
        'access'=>'RQ',
        'icon'=>'fa-edit',
        'items'=>array(
            'Reportjoblist'=>array(
                'access'=>'RQ01',
                'url'=>'/reportjob/index',
            ),
            'Reportfollowlist'=>array(
                'access'=>'RQ02',
                'url'=>'/reportfollow/index',
            ),
        ),
    ),
    'Papers query'=>array(
        'access'=>'PQ',
        'icon'=>'fa-edit',
        'items'=>array(
            'Papersstafflist'=>array(
                'access'=>'PQ01',
                'url'=>'/Papersstaff/index',
            ),
        ),
    ),
    'WorkOrder'=>array(
        'access'=>'WO',
        'icon'=>'fa fa-industry',
        'items'=>array(
            'LBS WorkOrder'=>array(
                'access'=>'WO01',
                'url'=>'/WorkList/index',
            )
        ),
    ),
   //数据分析词设置
   'Analyse Settings'=>array(
    'access'=>'PE',
    'icon'=>'fa fa-industry',
    'items'=>array(

        'Pest Type'=>array(
            'access'=>'PE01',
            'url'=>'/pesttype/index',
        ),
        'Pest Dict'=>array(
            'access'=>'PE02',
            'url'=>'/pestdict/index',
        ),
        // 分析报告
        'Analyse Report'=>array(
            'access'=>'PE03',
            'url'=>'/analyse/index',
        ),
    ),
),

    //数据分析词设置
    'Chat'=>array( //聊天客服
        'access'=>'CT',
        'icon'=>'fa fa-volume-up',
        'items'=>array(
            'Chat List'=>array( //聊天列表
                'access'=>'CT01',
                'url'=>'/chat/index',
            ),
        )
    ),
);
