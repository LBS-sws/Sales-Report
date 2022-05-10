<?php
$this->pageTitle=Yii::app()->name . ' - Report';
?>

<?php $form=$this->beginWidget('TbActiveForm', array(
    'id'=>'report-form',
    'action'=>Yii::app()->createUrl('report/generate'),
    'enableClientValidation'=>true,
    'clientOptions'=>array('validateOnSubmit'=>true,),
    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

<section class="content-header">
    <h1>
        <strong><?php echo Yii::t('reportjob','Batch Form'); ?></strong>
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
                <?php  echo TbHtml::button('<span class="fa fa-check"></span> '.Yii::t('misc','Batch Create'), array(
                    'submit'=>Yii::app()->createUrl('reportjob/batchcreate')));
                ?>
            </div>
<!--            <div class="btn-group" role="group">-->
<!--                --><?php // echo TbHtml::button('<span class="fa fa-download"></span> '.Yii::t('misc','Batch Down'), array(
//                    'submit'=>Yii::app()->createUrl('reportjob/batchdown')));
//                ?>
<!--            </div>-->
        </div></div>

    <div class="box box-info">
        <div class="box-body">

            <div class="form-group">
                <?php echo $form->labelEx($model,'start_dt',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">
                    <div class="input-group date">
                        <?php echo $form->textField($model, 'start_dt', array('class'=>'form-control pull-right',)); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model,'end_dt',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">
                    <div class="input-group date">
                        <?php echo $form->textField($model, 'end_dt', array('class'=>'form-control pull-right',)); ?>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>



<?php $this->endWidget(); ?>

</div><!-- form -->

