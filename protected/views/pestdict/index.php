<?php
$this->pageTitle=Yii::app()->name . ' - pestdict';
?>

<?php $form=$this->beginWidget('TbActiveForm', array(
    'id'=>'pestdict',
    'enableClientValidation'=>true,
    'clientOptions'=>array('validateOnSubmit'=>true,),
    'layout'=>TbHtml::FORM_LAYOUT_INLINE,
)); ?>

<section class="content">
    <div class="box"><div class="box-body">
            <div class="btn-group" role="group">
                <?php
                if (Yii::app()->user->validRWFunction('PE02'))
                    echo TbHtml::button('<span class="fa fa-file-o"></span> '.Yii::t('pestdict','Add pestdict'), array(
                        'submit'=>Yii::app()->createUrl('pestdict/new'),
                    ));
                ?>
            </div>
        </div></div>
    <?php $this->widget('ext.layout.ListPageWidget', array(
        'title'=>Yii::t('pestdict','pestdict List'),
        'model'=>$model,
        'viewhdr'=>'//pestdict/_listhdr',
        'viewdtl'=>'//pestdict/_listdtl',
        'search'=>array(
            'city',
            'type_name',
            'create_at',
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
?>

