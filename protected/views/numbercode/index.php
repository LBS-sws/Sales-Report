<?php
$this->pageTitle=Yii::app()->name . ' - numbercode';
?>

<?php $form=$this->beginWidget('TbActiveForm', array(
    'id'=>'numbercode',
    'enableClientValidation'=>true,
    'clientOptions'=>array('validateOnSubmit'=>true,),
    'layout'=>TbHtml::FORM_LAYOUT_INLINE,
)); ?>

<section class="content">
    <div class="box"><div class="box-body">

        </div></div>
    <?php $this->widget('ext.layout.ListPageWidget', array(
        'title'=>Yii::t('equipment','Equipmenttype List'),
        'model'=>$model,
        'viewhdr'=>'//numbercode/_listhdr',
        'viewdtl'=>'//numbercode/_listdtl',
        'search'=>array(
            'city',
            'name',
        ),
    ));
    ?>
</section>
<?php
echo $form->hiddenField($model,'pageNum');
echo $form->hiddenField($model,'totalRow');
echo $form->hiddenField($model,'orderField');
echo $form->hiddenField($model,'orderType');
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

$js = "
$('body').on('click','#chkboxAll',function() {
	var val = $(this).prop('checked');
	$('input[type=checkbox][name*=\"select\"]').prop('checked',val);
});
";
Yii::app()->clientScript->registerScript('selectAll',$js,CClientScript::POS_READY);

$js = "
$('input[type=checkbox][name*=\"select\"]').on('click', function() {
	var val = $(this).prop('checked');
});
";
Yii::app()->clientScript->registerScript('enableButton',$js,CClientScript::POS_READY);

$link = Yii::app()->createAbsoluteUrl("realize");

?>

