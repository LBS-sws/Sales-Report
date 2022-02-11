<?php
$this->pageTitle=Yii::app()->name . ' - Reportfollow';
?>

<?php $form=$this->beginWidget('TbActiveForm', array(
'id'=>'Reportfollow-list',
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
<!--	<div class="box"><div class="box-body">-->
<!--	<div class="btn-group" role="group">-->
<!--        --><?php //echo TbHtml::button('<span class="fa fa-download"></span> '.Yii::t('misc','Down'), array(
//            'submit'=>Yii::app()->createUrl('reportfollow/down')));
//        ?>
<!--	</div>-->
<!--	</div></div>-->
	<?php 
		$search = array(
            'JobDate',
            'CustomerID',
            'CustomerName',
            'ServiceType',
            'Staff01',

					);
		if (!Yii::app()->user->isSingleCity()) $search[] = 'city_name';
		$this->widget('ext.layout.ListPageWidget', array(
			'title'=>Yii::t('app','Reportjoblist'),
			'model'=>$model,
				'viewhdr'=>'//reportfollow/_listhdr',
				'viewdtl'=>'//reportfollow/_listdtl',
				'gridsize'=>'24',
				'height'=>'600',
				'search'=>$search,
		));
	?>
</section>
<?php $this->renderPartial('//site/removedialog'); ?>
<?php
	echo $form->hiddenField($model,'pageNum');
	echo $form->hiddenField($model,'totalRow');
	echo $form->hiddenField($model,'orderField');
	echo $form->hiddenField($model,'orderType');
?>
<?php $this->endWidget(); ?>
<?php $this->renderPartial('//reportfollow/_type'); ?>
<?php
	$js = Script::genTableRowClick();
	Yii::app()->clientScript->registerScript('rowClick',$js,CClientScript::POS_READY);
$js = "
$('.che').on('click', function(e){
e.stopPropagation();
});

$('body').on('click','#all',function() {
	var val = $(this).prop('checked');
	$('input[type=checkbox][name*=\"Reportfollow[attr][]\"]').prop('checked',val);
});
";
Yii::app()->clientScript->registerScript('selectAll',$js,CClientScript::POS_READY);
$js = Script::genDeleteData(Yii::app()->createUrl('reportfollow/alldelete'));
Yii::app()->clientScript->registerScript('deleteRecordfollow',$js,CClientScript::POS_READY);
?>



