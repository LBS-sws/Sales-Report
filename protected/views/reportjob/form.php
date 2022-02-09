<?php
$this->pageTitle=Yii::app()->name . ' - Invoice Form';
?>

<?php $form=$this->beginWidget('TbActiveForm', array(
'id'=>'invoice-form',
'enableClientValidation'=>true,
'clientOptions'=>array('validateOnSubmit'=>true,),
'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
)); ?>

<section class="content-header">
	<h1>
		<strong><?php echo Yii::t('staff','Invoice Form'); ?></strong>
	</h1>
<!--
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="#">Layout</a></li>
		<li class="active">Top Navigation</li>
	</ol>
-->
</section>

<section class="content">
	<div class="box"><div class="box-body">
	<div class="btn-group" role="group">
		<?php echo TbHtml::button('<span class="fa fa-reply"></span> '.Yii::t('misc','Back'), array(
				'submit'=>Yii::app()->createUrl('invoice/index')));
		?>
			<?php echo TbHtml::button('<span class="fa fa-upload"></span> '.Yii::t('misc','Save'), array(
				'submit'=>Yii::app()->createUrl('invoice/save')));
			?>
        <?php echo TbHtml::button('<span class="fa fa-remove"></span> '.Yii::t('misc','Delete'), array(
                'name'=>'btnDelete','id'=>'btnDelete','data-toggle'=>'modal','data-target'=>'#removedialog',)
            );
        ?>
	</div>
	</div></div>

	<div class="box box-info">
		<div class="box-body">
			<?php echo $form->hiddenField($model, 'scenario'); ?>
			<?php echo $form->hiddenField($model, 'id'); ?>
            <?php echo $form->hiddenField($model, 'city'); ?>

			<div class="form-group">
				<?php echo $form->labelEx($model,'number',array('class'=>"col-sm-2 control-label")); ?>
				<div class="col-sm-2">
					<?php echo $form->textField($model, 'number',
						array('size'=>10,'maxlength'=>10,'readonly'=>'readonly')
					); ?>
				</div>

                <?php echo $form->labelEx($model,'dates',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-2">
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <?php echo $form->textField($model, 'dates',
                            array('class'=>'form-control pull-right','readonly'=>'readonly',));
                        ?>
                    </div>
                </div>
			</div>

            <div class="form-group">
                <?php echo $form->labelEx($model,'customer_account',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-2">
                    <?php echo $form->textField($model, 'customer_account',
                        array('size'=>40,'maxlength'=>250,'readonly'=>'readonly')
                    ); ?>
                </div>
                <?php echo $form->labelEx($model,'payment_term',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-2">
                    <?php echo $form->textField($model, 'payment_term',
                        array('size'=>40,'maxlength'=>250,'readonly'=>'')
                    ); ?>
                </div>
            </div>



			<div class="form-group">
				<?php echo $form->labelEx($model,'customer_po_no',array('class'=>"col-sm-2 control-label")); ?>
				<div class="col-sm-2">
					<?php echo $form->textField($model, 'customer_po_no',
						array('size'=>40,'maxlength'=>250,'readonly'=>'')
					); ?>
				</div>

                <?php echo $form->labelEx($model,'sales_order_no',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-2">
                    <?php echo $form->textField($model, 'sales_order_no',
                        array('size'=>40,'maxlength'=>250,'readonly'=>'')
                    ); ?>
                </div>
			</div>

            <div class="form-group">
                <?php echo $form->labelEx($model,'sales_order_date',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-2">
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <?php echo $form->textField($model, 'sales_order_date',
                            array('class'=>'form-control pull-right','readonly'=>'',));
                        ?>
                    </div>
                </div>

                <?php echo $form->labelEx($model,'ship_via',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-2">
                    <?php echo $form->textField($model, 'ship_via',
                        array('size'=>40,'maxlength'=>250,'readonly'=>'')
                    ); ?>
                </div>
            </div>

			<div class="form-group">
				<?php echo $form->labelEx($model,'salesperson',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-7">
                    <?php echo $form->textField($model, 'salesperson',
                        array('size'=>40,'maxlength'=>250,'readonly'=>'')
                    ); ?>
                </div>
			</div>

            <div class="form-group">
                <?php echo $form->labelEx($model,'invoice_company',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-7">
                    <?php echo $form->textField($model, 'invoice_company',
                        array('size'=>40,'maxlength'=>250,'readonly'=>'')
                    ); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model,'invoice_address',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-7">
                    <?php echo $form->textField($model, 'invoice_address',
                        array('size'=>40,'maxlength'=>250,'readonly'=>'')
                    ); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model,'invoice_tel',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-7">
                    <?php echo $form->textField($model, 'invoice_tel',
                        array('size'=>40,'maxlength'=>250,'readonly'=>'')
                    ); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model,'delivery_company',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-7">
                    <?php echo $form->textField($model, 'delivery_company',
                        array('size'=>40,'maxlength'=>250,'readonly'=>'')
                    ); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model,'delivery_address',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-7">
                    <?php echo $form->textField($model, 'delivery_address',
                        array('size'=>40,'maxlength'=>250,'readonly'=>'')
                    ); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model,'delivery_tel',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-7">
                    <?php echo $form->textField($model, 'delivery_tel',
                        array('size'=>40,'maxlength'=>250,'readonly'=>'')
                    ); ?>
                </div>
            </div>

           <?php $i=1;foreach ($model['type'] as $value){ ?>
               <div class="form-group">
                   <label class="col-sm-2 control-label" for="InvoiceForm_disc"><?php echo Yii::t('invoice','Description').$i;?></label>
                   <div class="col-sm-3">
                       <input min="0" name="InvoiceForm[type][<?php echo $i;?>][description]" id="InvoiceForm_description<?php echo $i;?>" class="input-40 form-control" type="text" value="<?php echo $value['description'];?>">
                   </div>
                   <label class="col-sm-1 control-label" for="InvoiceForm_disc"><?php echo Yii::t('invoice','Quantity');?></label>
                   <div class="col-sm-3">
                       <input min="0" name="InvoiceForm[type][<?php echo $i;?>][quantity]" id="InvoiceForm_quantity<?php echo $i;?>" class="input-40 form-control" type="number" value="<?php echo $value['quantity'];?>">
                   </div>
               </div>
               <div class="form-group">
                   <label class="col-sm-2 control-label" for="InvoiceForm_disc"><?php echo Yii::t('invoice','Unit Price');?></label>
                   <div class="col-sm-3">
                       <input min="0" name="InvoiceForm[type][<?php echo $i;?>][unit_price]" id="InvoiceForm_unit_price<?php echo $i;?>" class="input-40 form-control" type="number" value="<?php echo $value['unit_price'];?>">
                   </div>
                   <label class="col-sm-1 control-label" for="InvoiceForm_disc"><?php echo Yii::t('invoice','Amount');?></label>
                   <div class="col-sm-3">
                       <input min="0" name="InvoiceForm[type][<?php echo $i;?>][amount]" id="InvoiceForm_amount<?php echo $i;?>" class="input-40 form-control" type="number" value="<?php echo $value['amount'];?>">
                   </div>
               </div>
               <input min="0" name="InvoiceForm[type][<?php echo $i;?>][id]" id="InvoiceForm_amount" class="input-40 form-control" type="number" style="display:none" value="<?php echo $value['id'];?>">
            <?php $i=$i+1;}?>

            <div class="form-group">
                <?php echo $form->labelEx($model,'disc',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'disc',
                        array('size'=>40,'maxlength'=>250,'readonly'=>'readonly')
                    ); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model,'sub_total',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">
                    <?php echo $form->numberField($model, 'sub_total',
                        array('size'=>40,'min'=>0,'readonly'=>'')
                    ); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model,'gst',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">
                    <?php echo $form->numberField($model, 'gst',
                        array('size'=>40,'min'=>0,'readonly'=>'readonly')
                    ); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model,'total_amount',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">
                    <?php echo $form->numberField($model, 'total_amount',
                        array('size'=>40,'min'=>0,'readonly'=>'readonly')
                    ); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model,'generated_by',array('class'=>"col-sm-2 control-label")); ?>
                <div class="col-sm-3">
                    <?php echo $form->textField($model, 'generated_by',
                        array('size'=>40,'maxlength'=>250,'readonly'=>'readonly')
                    ); ?>
                </div>
            </div>
		</div>
	</div>
</section>

<?php $this->renderPartial('//site/removedialog'); ?>

<?php
$js = "
function IsNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}
";
Yii::app()->clientScript->registerScript('calcFunction',$js,CClientScript::POS_READY);

$js = Script::genDeleteData(Yii::app()->createUrl('invoice/delete'));
Yii::app()->clientScript->registerScript('deleteRecord',$js,CClientScript::POS_READY);

if ($model->scenario!='view') {
	$js = Script::genDatePicker(array(
			'InvoiceForm_sales_order_date',

		));
	Yii::app()->clientScript->registerScript('datePick',$js,CClientScript::POS_READY);
}

$js = Script::genReadonlyField();
Yii::app()->clientScript->registerScript('readonlyClass',$js,CClientScript::POS_READY);
?>

<?php $this->endWidget(); ?>

</div><!-- form -->

