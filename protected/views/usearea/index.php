<?php
$this->pageTitle=Yii::app()->name . ' - Usearea';
?>

<?php $form=$this->beginWidget('TbActiveForm', array(
    'id'=>'Usearea-type',
    'enableClientValidation'=>true,
    'clientOptions'=>array('validateOnSubmit'=>true,),
    'layout'=>TbHtml::FORM_LAYOUT_INLINE,
)); ?>

<section class="content">
    <div class="box"><div class="box-body">
            <div class="btn-group" role="group">
                <?php
                if (Yii::app()->user->validRWFunction('OS05'))
                    echo TbHtml::button('<span class="fa fa-file-o"></span> '.Yii::t('usearea','Add Usearea'), array(
                        'submit'=>Yii::app()->createUrl('usearea/new'),
                    ));
                ?>
            </div>
        </div></div>
    <?php $this->widget('ext.layout.ListPageWidget', array(
        'title'=>Yii::t('usearea','Usearea List'),
        'model'=>$model,
        'viewhdr'=>'//usearea/_listhdr',
        'viewdtl'=>'//usearea/_listdtl',
        'search'=>array(
            'city',
            'use_area',
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

