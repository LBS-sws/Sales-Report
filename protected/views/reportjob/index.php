<?php
$this->pageTitle=Yii::app()->name . ' - Reportjob';
?>

<?php $form=$this->beginWidget('TbActiveForm', array(
'id'=>'Reportjob-list',
'enableClientValidation'=>true,
'clientOptions'=>array('validateOnSubmit'=>true,),
'layout'=>TbHtml::FORM_LAYOUT_INLINE,
)); ?>

<!--<section class="content-header">-->
<!--	<h1>-->
<!--		<strong>--><?php //echo Yii::t('app','Reportjoblist'); ?><!--</strong>-->
<!--	</h1>-->
<!--
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Layout</a></li>
		<li class="active">Top Navigation</li>
	</ol>
-->
<!--</section>-->

<section class="content">
	<div class="box"><div class="box-body">
	<div class="btn-group" role="group">
        <?php echo TbHtml::button('<span class="fa fa-download"></span> '.Yii::t('misc','Batch'), array('submit'=>Yii::app()->createUrl('reportjob/batch')));
        ?>
        <?php echo TbHtml::button('<span class="fa fa-download"></span> '.Yii::t('reportjob','Download in Batch'), array('id'=>'btnBatchDownload'));?>
	</div>
	</div></div>
	<?php 
/*
		$search = array(
						'JobDate',
						'CustomerID',
						'CustomerName',
						'ServiceType',
						'Staff01',

					);
*/
//		if (!Yii::app()->user->isSingleCity()) $search[] = 'city_name';
		$this->widget('ext.layout.ListPageWidget', array(
			'title'=>Yii::t('app','Reportjoblist'),
			'model'=>$model,
				'viewhdr'=>'//reportjob/_listhdr',
				'viewdtl'=>'//reportjob/_listdtl',
				'advancedSearch'=>true,
				'hasDateButton'=>true,
//				'search'=>$search,
		));
	?>
</section>
<?php $this->renderPartial('//site/removedialog'); ?>
<?php $this->renderPartial('//reportjob/_email'); ?>
<?php
	echo $form->hiddenField($model,'pageNum');
	echo $form->hiddenField($model,'totalRow');
	echo $form->hiddenField($model,'orderField');
	echo $form->hiddenField($model,'orderType');
	echo $form->hiddenField($model,'filter');
?>
<?php $this->endWidget(); ?>
<?php $this->renderPartial('//reportjob/_type'); ?>
<?php
	$js = Script::genTableRowClick();
	Yii::app()->clientScript->registerScript('rowClick',$js,CClientScript::POS_READY);
$js = "
$('.che').on('click', function(e){
e.stopPropagation();
});

$('body').on('click','#all',function() {
	var val = $(this).prop('checked');
	$('input[type=checkbox][name*=\"Reportjob[attr][]\"]').prop('checked',val);
});
";
Yii::app()->clientScript->registerScript('selectAll',$js,CClientScript::POS_READY);
$js = Script::genDeleteData(Yii::app()->createUrl('reportjob/alldelete'));
Yii::app()->clientScript->registerScript('deleteRecordjob',$js,CClientScript::POS_READY);

$url = Yii::app()->createUrl('reportjob/downloadinbatch');
$js = "
$('#btnBatchDownload').on('click', function(){Loading.show();jQuery.yii.submitForm(this,'$url',{});return false;});
";
Yii::app()->clientScript->registerScript('downloadInBatch',$js,CClientScript::POS_READY);

if (isset($zip) && !empty($zip)) {
	$file_url = Yii::app()->createAbsoluteUrl('reportjob/downloadzip',array('fid'=>$zip[0],'fileName'=>$zip[1]));
	$js = "$(location).attr('href','$file_url');";
	Yii::app()->clientScript->registerScript('redirection',$js,CClientScript::POS_READY);
}
?>



