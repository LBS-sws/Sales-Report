<?php
$ftrbtn = [
	TbHtml::button(Yii::t('dialog','OK'), 
		array(
			'id'=>'btnUploadOK',
			'color'=>TbHtml::BUTTON_COLOR_PRIMARY,
			'submit'=>Yii::app()->createUrl('riskpest/import')
		)
	),
	TbHtml::button(Yii::t('dialog','Close'), array('id'=>'btnUploadClose','data-dismiss'=>'modal','color'=>TbHtml::BUTTON_COLOR_PRIMARY)),
];
$this->beginWidget('bootstrap.widgets.TbModal', array(
	'id'=>'fileuploaddialog',
	'header'=>Yii::t('import','Import File'),
	'footer'=>$ftrbtn,
	'show'=>false,
));
?>

<div class="form-group">
	<?php echo $form->labelEx($model,'import_file',array('class'=>"col-sm-4 control-label")); ?>
	<div class="col-sm-4">
		<?php echo $form->fileField($model, 'import_file'); ?>
	</div>
</div>
			
<?php
$this->endWidget(); 
?>