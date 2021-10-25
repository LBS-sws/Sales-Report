<?php
$this->pageTitle=Yii::app()->name . ' - Credits for';
?>
<?php $form=$this->beginWidget('TbActiveForm', array(
'id'=>'Equipmentselect-form',
'enableClientValidation'=>true,
'clientOptions'=>array('validateOnSubmit'=>true,),
'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

<section class="content-header">
	<h1>
		<strong><?php echo Yii::t('equipment','Equipmenttypeselect Form'); ?></strong>
	</h1>
<!--
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Layout</a></li>
		<li class="active">Top Navigation</li>
	</ol>
-->
</section>

<section class="content">
	<div class="box"><div class="box-body">
	<div class="btn-group" role="group">
        <?php
        if ($model->scenario!='new' && $model->scenario!='view') {
            echo TbHtml::button('<span class="fa fa-file-o"></span> '.Yii::t('misc','Add Another'), array(
                'submit'=>Yii::app()->createUrl('equipmenttypeselect/new')));
        }
        ?>
		<?php echo TbHtml::button('<span class="fa fa-reply"></span> '.Yii::t('misc','Back'), array(
				'submit'=>Yii::app()->createUrl('equipmenttypeselect/index')));
		?>
        <?php
        echo TbHtml::button('<span class="fa fa-upload"></span> '.Yii::t('misc','Save'), array(
            'submit'=>Yii::app()->createUrl('equipmenttypeselect/save')));
        ?>
        <?php if($model->id){ echo TbHtml::button('<span class="fa fa-remove"></span> '.Yii::t('misc','Delete'), array( 'submit'=>Yii::app()->createUrl('equipmenttypeselect/delete'))
        );}
        ?>
	</div>
            <div class="btn-group pull-right" role="group">
<!--                --><?php
//                $counter = ($model->no_of_attm['icut'] > 0) ? ' <span id="docicut" class="label label-info">'.$model->no_of_attm['icut'].'</span>' : ' <span id="docicut"></span>';
//                echo TbHtml::button('<span class="fa  fa-file-text-o"></span> '.Yii::t('misc','Attachment').$counter, array(
//                        'name'=>'btnFile','id'=>'btnFile','data-toggle'=>'modal','data-target'=>'#fileuploadicut',)
//                );
//                ?>
            </div>
	</div></div>

    <div class="box box-info" style=" padding-bottom: 10px;">
        <div class="box-body">
            <?php echo $form->hiddenField($model, 'scenario'); ?>
            <?php echo $form->hiddenField($model, 'id',array("id"=>"id")); ?>
            <div class="form-group">
                <?php echo $form->labelEx($model,'equipment_type_id',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-2">
                    <?php
                    if ($model->equipment_type_id>0){  echo $form->dropDownList($model, 'equipment_type_id', $equipment_type_lists, array('disabled' => 'disabled'));}else{
                        echo $form->dropDownList($model, 'equipment_type_id', $equipment_type_lists);
                    }
                    ?>
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model,'check_targt',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-2">
                    <?php
                    if ($model->equipment_type_id>0){ echo $form->dropDownList($model, 'check_targt', $equipment_type_list_selects[$model->equipment_type_id]);}else{
                        echo $form->dropDownList($model, 'check_targt', $equipment_type_list_selects);
                    }
                    ?>
                </div>
                <div class="col-sm-7">
                    <p class="form-control-static" style="color: #c50303;">请注意选择当前设备名称对应的检查项目</p >
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model,'check_selects',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->textField($model, 'check_selects',
                        array('size'=>40,'maxlength'=>250,"id"=>"check_selects",'readonly'=>false)
                    ); ?>
                </div>
                <div class="col-sm-6">
                    <p class="form-control-static" style="color: #c50303;">注：若需要增加多项，请用英文逗号“,”进行隔开</p >
                </div>
            </div>
        </div>
</section>

<?php //$this->renderPartial('//site/fileupload',array('model'=>$model,
//    'form'=>$form,
//    'doctype'=>'ICUT',
//    'header'=>Yii::t('dialog','File Attachment'),
//    'ronly'=>($model->scenario=='view'),
//));
//?>
<?php
$js = '
    $(function () {
        $(".equipment_type").on("click",function () {
            var id = $("#equipment_type_id").val();
           console.log(id);
            return false;
        })
    })
    ';
Yii::app()->clientScript->registerScript('calcFunction',$js,CClientScript::POS_READY);

?>

<?php $this->endWidget(); ?>
<script>
    $("#Equipmenttypeselect_equipment_type_id").click(function(){
        var typeid = $('#Equipmenttypeselect_equipment_type_id').val();
//        <?php //$model['equipment_type_id'] = typeid ?>//;
        $.ajax({
            type:'get',
            url:"./getselects",
            data:{index:typeid},
            success: function(data){
                console.log(data);
            }

        });
        // var v = $('#Equipmenttypeselect_check_targt').val();
        // console.log(typeid);
        // console.log(v);
        // console.log(v['typeid']);
    })

</script>

