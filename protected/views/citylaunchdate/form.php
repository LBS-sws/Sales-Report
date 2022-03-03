<?php
$this->pageTitle=Yii::app()->name . ' - Credits for';
?>
<?php $form=$this->beginWidget('TbActiveForm', array(
'id'=>'Citylaunchdate-form',
'enableClientValidation'=>true,
'clientOptions'=>array('validateOnSubmit'=>true,),
'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>


<section class="content-header">
	<h1>
		<strong><?php echo Yii::t('citylaunchdate','Citylaunchdate Form'); ?></strong>
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
                'submit'=>Yii::app()->createUrl('citylaunchdate/new')));
        }
        ?>
		<?php echo TbHtml::button('<span class="fa fa-reply"></span> '.Yii::t('misc','Back'), array(
				'submit'=>Yii::app()->createUrl('citylaunchdate/index')));
		?>
        <?php
        echo TbHtml::button('<span class="fa fa-upload"></span> '.Yii::t('misc','Save'), array(
            'submit'=>Yii::app()->createUrl('citylaunchdate/save')));
        ?>
        <?php if($model->id){ echo TbHtml::button('<span class="fa fa-remove"></span> '.Yii::t('misc','Delete'), array( 'submit'=>Yii::app()->createUrl('citylaunchdate/delete'))
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
            <?php echo $form->hiddenField($model, 'signature',array("id"=>"signature")); ?>

            <div class="form-group">
                <?php echo $form->labelEx($model,'city',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-2">
                    <?php
                    echo $form->dropDownList($model, 'city', $city_lists);
                    ?>
                </div>
            </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model,'launch_date',array('class'=>"col-sm-2 control-label")); ?>
                    <div class="col-sm-2">
                        <div class="input-group date" type="date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <?php echo $form->textField($model, 'launch_date',
                                array('class'=>'form-control pull-right'));
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <p class="form-control-static" style="color: #c50303;">填写格式例如：2022-03-03</p >
                    </div>
                </div>

</section>

<?php
$js = "
showEmailField();

$('#ReportForm_format').on('change',function() {
	showEmailField();
});

function showEmailField() {
	$('#email_div').css('display','none');
	if ($('#ReportForm_format').val()=='EMAIL') $('#email_div').css('display','');
}
";
Yii::app()->clientScript->registerScript('changestyle',$js,CClientScript::POS_READY);

$datefields = array();
//if ($model->showField('launch_date')) $datefields[] = 'CitylaunchdateForm_launch_date';
if (!empty($datefields)) {
    $js = Script::genDatePicker($datefields);
    Yii::app()->clientScript->registerScript('datePick',$js,CClientScript::POS_READY);
}
$js = Script::genDatePicker($datefields);
Yii::app()->clientScript->registerScript('datePick',$js,CClientScript::POS_READY);
$this->endWidget(); ?>
