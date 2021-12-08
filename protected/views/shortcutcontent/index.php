<?php
$this->pageTitle=Yii::app()->name . ' - Shortcutcontent';
?>

<?php $form=$this->beginWidget('TbActiveForm', array(
    'id'=>'Shortcut-content',
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
                if (Yii::app()->user->validRWFunction('OS02'))
                    echo TbHtml::button('<span class="fa fa-file-o"></span> '.Yii::t('shortcut','Add Shortcutcontent'), array(
                        'submit'=>Yii::app()->createUrl('shortcutcontent/new'),
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
						'submit'=>Yii::app()->createUrl('shortcutcontent/export'),
                    ));
                ?>
			</div>
        </div>
	</div>
    <?php $this->widget('ext.layout.ListPageWidget', array(
        'title'=>Yii::t('shortcut','Shortcutcontent List'),
        'model'=>$model,
        'viewhdr'=>'//shortcutcontent/_listhdr',
        'viewdtl'=>'//shortcutcontent/_listdtl',
        'search'=>array(
            'city',
            'service_name',
            'shortcut_name',
            'content',
        ),
    ));
    ?>
</section>
<?php
echo $form->hiddenField($model,'pageNum');
echo $form->hiddenField($model,'totalRow');
echo $form->hiddenField($model,'orderField');
echo $form->hiddenField($model,'orderType');

$this->renderPartial('//shortcutcontent/logview');
$this->renderPartial('//shortcutcontent/fileupload', array('model'=>$model, 'form'=>$form));
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

