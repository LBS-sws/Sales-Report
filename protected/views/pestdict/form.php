<?php
$this->pageTitle=Yii::app()->name . ' - Credits for pestdict';
?>
<?php $form=$this->beginWidget('TbActiveForm', array(
'id'=>'pestdict-form',
'enableClientValidation'=>true,
'clientOptions'=>array('validateOnSubmit'=>true,),
'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

<section class="content-header">
	<h1>
		<strong><?php echo Yii::t('pestdict','pestdict Form'); ?></strong>
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
                'submit'=>Yii::app()->createUrl('pestdict/new')));
        }
        ?>
		<?php echo TbHtml::button('<span class="fa fa-reply"></span> '.Yii::t('misc','Back'), array(
				'submit'=>Yii::app()->createUrl('pestdict/index')));
		?>
        <?php
        echo TbHtml::button('<span class="fa fa-upload"></span> '.Yii::t('misc','Save'), array(
            'submit'=>Yii::app()->createUrl('pestdict/save')));
        ?>
        <?php if($model->id){ echo TbHtml::button('<span class="fa fa-remove"></span> '.Yii::t('misc','Delete'), array( 'submit'=>Yii::app()->createUrl('pestdict/delete'))
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
                <?php echo $form->labelEx($model,'type_id',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">
                    <?php
                    echo $form->dropDownList($model, 'type_id', $pest_type_list);
                    ?>
                </div>
            </div>
            <div class="form-group">
<!--                --><?php //echo $form->labelEx($model,'insect_name',array('class'=>"col-sm-2 control-label")); ?>
<!--                <div class="col-sm-3">-->
<!--                    --><?php //echo $form->textField($model, 'insect_name',
//                        array('size'=>40,'maxlength'=>250,"id"=>"insect_name",'readonly'=>false)
//                    ); ?>
<!--                </div>-->
                <?php echo $form->labelEx($model,'analysis_result',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">
                    <?php
                    echo $form->textArea($model, 'analysis_result', array(
                        'rows' => 6,
                        'cols' => 50,
                    ));
                    ?>
                </div>

                <?php echo $form->labelEx($model,'suggestion',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">

                    <?php
                    echo $form->textArea($model, 'suggestion', array(
                        'rows' => 6,
                        'cols' => 50,
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model,'measure',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">
                    <?php
                    echo $form->textArea($model, 'measure', array(
                        'rows' => 6,
                        'cols' => 50,
                    ));
                    ?>
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


<?php $this->endWidget(); ?>
