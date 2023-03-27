<?php
$this->pageTitle=Yii::app()->name . ' - Equipment_number';
?>

<?php $form=$this->beginWidget('TbActiveForm', array(
    'id'=>'Equipment_number',
    'enableClientValidation'=>true,
    'clientOptions'=>array('validateOnSubmit'=>true,),
    'layout'=>TbHtml::FORM_LAYOUT_INLINE,
)); ?>

<section class="content">
    <div class="box"><div class="box-body">
            <div class="btn-group" role="group">
                <?php
                if (Yii::app()->user->validRWFunction('OS10'))
                    echo TbHtml::button('<span class="fa fa-file-o"></span> '.Yii::t('equipment','Add Equipmentnumber'), array(
                        'submit'=>Yii::app()->createUrl('equipmentnumber/new'),
                    ));
                ?>
            </div>
            <div class="btn-group">
                <?php
                if (Yii::app()->user->validRWFunction('OS10'))
                echo TbHtml::button('<span class="fa fa-upload"></span> '.Yii::t('equipment','Equipmentnumber Down'), array('submit'=>Yii::app()->createUrl('equipmentnumber/down '),
                ));
                ?></div>
        </div></div>
    <?php $this->widget('ext.layout.ListPageWidget', array(
        'title'=>Yii::t('equipment','Equipmentnumber List'),
        'model'=>$model,
        'viewhdr'=>'//equipmentnumber/_listhdr',
        'viewdtl'=>'//equipmentnumber/_listdtl',
        'search'=>array(
            'city',
            'name',
            'equipment_number',
            'downcount',
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
$js = <<<EOF
$(document).ready(function(){
    $("#chkboxAll").on('click',function() {

        $("input[name='EqnumOS11List[id][]']").prop("checked", this.checked);
    });
    $("input[name='EqnumOS11List[id][]']").on('click',function() {
        var subs = $("input[name='EqnumOS11List[id][]']");
        $("#chkboxAll").prop("checked" ,subs.length == subs.filter(":checked").length ? true :false);
    });
});
EOF;
Yii::app()->clientScript->registerScript('starClick',$js,CClientScript::POS_HEAD);

$js = Script::genTableRowClick();
Yii::app()->clientScript->registerScript('rowClick',$js,CClientScript::POS_READY);

$url = Yii::app()->createUrl('Equipmentnumber/down');
$js = "
$('#EquipmentnumberSubmit').on('click', function(){
	$('input[type=checkbox][name*=\"select\"]').each(function() {
		var val = $(this).prop('checked');
		if (val) {
			Loading.show();
			jQuery.yii.submitForm(this,'$url',{});
			return false;
		}
	});
	return false;
});
";
Yii::app()->clientScript->registerScript('EquipmentnumberSubmit',$js,CClientScript::POS_READY);

?>

