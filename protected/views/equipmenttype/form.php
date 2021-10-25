<?php
$this->pageTitle=Yii::app()->name . ' - Credits for';
?>
<?php $form=$this->beginWidget('TbActiveForm', array(
'id'=>'Equipment-form',
'enableClientValidation'=>true,
'clientOptions'=>array('validateOnSubmit'=>true,),
'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

<section class="content-header">
	<h1>
		<strong><?php echo Yii::t('equipment','Equipmenttype Form'); ?></strong>
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
                'submit'=>Yii::app()->createUrl('equipmenttype/new')));
        }
        ?>
		<?php echo TbHtml::button('<span class="fa fa-reply"></span> '.Yii::t('misc','Back'), array(
				'submit'=>Yii::app()->createUrl('equipmenttype/index')));
		?>
        <?php
        echo TbHtml::button('<span class="fa fa-upload"></span> '.Yii::t('misc','Save'), array(
            'submit'=>Yii::app()->createUrl('equipmenttype/save')));
        ?>
        <?php if($model->id){ echo TbHtml::button('<span class="fa fa-remove"></span> '.Yii::t('misc','Delete'), array( 'submit'=>Yii::app()->createUrl('equipmenttype/delete'))
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
                <?php echo $form->labelEx($model,'name',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->textField($model, 'name',
                        array('size'=>40,'maxlength'=>250,"id"=>"name",'readonly'=>false)
                    ); ?>
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model,'type',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-2">
                    <?php
                    echo $form->dropDownList($model, 'type', $service_type_lists);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model,'check_targt',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->textField($model, 'check_targt',
                        array('size'=>40,'maxlength'=>250,"id"=>"check_targt",'readonly'=>false)
                    ); ?>
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model,'check_handles',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-4">
                    <?php echo $form->textField($model, 'check_handles',
                        array('size'=>40,'maxlength'=>250,"id"=>"check_handles",'readonly'=>false)
                    ); ?>
                </div>

                <div class="col-sm-6">
                    <p class="form-control-static" style="color: #c50303;">注：检查项目及检查与处理，若都需要增加多项，请用英文逗号“,”进行隔开</p >
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
        $(".btnIntegralApply").on("click",function () {
            $("#gift_type").val($("#rq_gift_id").val());
            $("#gift_name").val($("#rq_gift_name").val());
            $("#bonus_point").val($("#rq_bonus_point").val());
            $("#integralApply").modal("show");
            return false;
        })
    })
    ';
Yii::app()->clientScript->registerScript('calcFunction',$js,CClientScript::POS_READY);
Script::genFileUpload($model,$form->id,'ICUT');
$js = Script::genReadonlyField();
Yii::app()->clientScript->registerScript('readonlyClass',$js,CClientScript::POS_READY);
?>

<?php $this->endWidget(); ?>
