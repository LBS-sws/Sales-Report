<?php
$this->pageTitle=Yii::app()->name . ' - Material';
?>

<?php $form=$this->beginWidget('TbActiveForm', array(
    'id'=>'Material-list',
    'enableClientValidation'=>true,
    'clientOptions'=>array('validateOnSubmit'=>true,),
    'layout'=>TbHtml::FORM_LAYOUT_INLINE,
)); ?>

<section class="content">
    <div class="box"><div class="box-body">
            <div class="btn-group" role="group">
                <?php
                if (Yii::app()->user->validRWFunction('MS01'))
                    echo TbHtml::button('<span class="fa fa-file-o"></span> '.Yii::t('material','Add Material'), array(
                        'submit'=>Yii::app()->createUrl('materiallist/new'),
                    ));
                ?>
            </div>
        </div></div>

    <?php $this->widget('ext.layout.ListPageWidget', array(
        'title'=>Yii::t('material','Material List'),
        'model'=>$model,
        'viewhdr'=>'//materiallist/_listhdr',
        'viewdtl'=>'//materiallist/_listdtl',
        'search'=>array(
            'city',
            'classify',
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
?>

