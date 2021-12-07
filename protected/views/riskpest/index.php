<?php
$this->pageTitle=Yii::app()->name . ' - Materialclass';
?>

<?php $form=$this->beginWidget('TbActiveForm', array(
    'id'=>'Risk-pest',
    'enableClientValidation'=>true,
    'clientOptions'=>array('validateOnSubmit'=>true,),
    'layout'=>TbHtml::FORM_LAYOUT_INLINE,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

<section class="content">
    <div class="box">
		<div class="box-body">
            <div class="btn-group" role="group">
                <?php
                if (Yii::app()->user->validRWFunction('RS01'))
                    echo TbHtml::button('<span class="fa fa-file-o"></span> '.Yii::t('risk','Add Riskpest'), array(
                        'submit'=>Yii::app()->createUrl('riskpest/new'),
                    ));
                ?>
            </div>

			<div class="btn-group pull-right" role="group">
                <?php
                    echo TbHtml::button('<span class="fa fa-file-o"></span> '.Yii::t('import','Import'), array(
                        'id'=>'btnImportData',
                    ));
                ?>
                <?php
                    echo TbHtml::button('<span class="fa fa-file-o"></span> '.Yii::t('import','Export'), array(
                        'id'=>'btnExportData',
						'submit'=>Yii::app()->createUrl('riskpest/export'),
                    ));
                ?>
			</div>
		</div>
	</div>
    <?php $this->widget('ext.layout.ListPageWidget', array(
        'title'=>Yii::t('risk','Riskpest'),
        'model'=>$model,
        'viewhdr'=>'//riskpest/_listhdr',
        'viewdtl'=>'//riskpest/_listdtl',
        'search'=>array(
            'city',
            'target',
        ),
    ));
    ?>
</section>
<?php
echo $form->hiddenField($model,'pageNum');
echo $form->hiddenField($model,'totalRow');
echo $form->hiddenField($model,'orderField');
echo $form->hiddenField($model,'orderType');

$this->renderPartial('//riskpest/logview');
$this->renderPartial('//riskpest/fileupload', array('model'=>$model, 'form'=>$form));
?>
<?php $this->endWidget(); ?>


<form class="form-horizontal MultiFile-intercepted" action="" method="post">
<!--    --><?php //$this->renderPartial('//materiallist/redeemApply',array(
//        'submit'=> Yii::app()->createUrl('materiallist/apply'),
//    ));
//    ?>
</form>
<?php
$js = Script::genTableRowClick();
Yii::app()->clientScript->registerScript('rowClick',$js,CClientScript::POS_READY);

$js = <<<EOF
$('#btnImportData').on('click', function() {
	$("#fileuploaddialog").modal("show");
});
EOF;
Yii::app()->clientScript->registerScript('dataImportClick',$js,CClientScript::POS_READY);
?>

