<?php
	$ftrbtn = array();
	$ftrbtn[] = TbHtml::button(Yii::t('reportjob','Resent'), array('id'=>'btnDtlResent','color'=>TbHtml::BUTTON_COLOR_PRIMARY));
	$ftrbtn[] = TbHtml::button(Yii::t('dialog','Close'), array('id'=>'btnDtlClose','data-dismiss'=>'modal','color'=>TbHtml::BUTTON_COLOR_PRIMARY));
	$this->beginWidget('bootstrap.widgets.TbModal', array(
					'id'=>'dtlviewdialog',
					'header'=>Yii::t('reportjob','Report Email'),
					'footer'=>$ftrbtn,
					'show'=>false,
				));
?>
<div class="box box-info" style="max-height: 350px; overflow-y: auto;">
	<?php echo TbHtml::hiddenField('dtlJobId',0,array('id'=>'dtlJobId')); ?>
	<div id="dtl-list">
	</div>
</div>
<?php
	$this->endWidget(); 
?>

<?php
	$content = "<p>确定重发电邮?</p>";
	$this->widget('bootstrap.widgets.TbModal', array(
					'id'=>'resentdialog',
					'header'=>'重发电邮',
					'content'=>$content,
					'footer'=>array(
						TbHtml::button(Yii::t('dialog','OK'), array('id'=>'btnResentEmail','data-dismiss'=>'modal','color'=>TbHtml::BUTTON_COLOR_PRIMARY)),
						TbHtml::button(Yii::t('dialog','Cancel'), array('data-dismiss'=>'modal','color'=>TbHtml::BUTTON_COLOR_PRIMARY)),
					),
					'show'=>false,
				));
?>

<?php
$link = Yii::app()->createAbsoluteUrl("reportjob");
$js = <<<EOF
function showEmail(e, jobid) {
	var data = "jobid="+jobid;
	var link = "$link"+"/emaildetail";
	$.ajax({
		type: 'GET',
		url: link,
		data: data,
		success: function(data) {
			$('#dtlJobId').val(jobid);
			$("#dtl-list").html(data);
			$('#dtlviewdialog').modal('show');
		},
		error: function(data) { // if error occured
			var x = 1;
			alert("Error occured.please try again");
		},
		dataType:'html'
	});
	e.stopPropagation();
}
EOF;
Yii::app()->clientScript->registerScript('dtlview',$js,CClientScript::POS_HEAD);

$link1 = Yii::app()->createAbsoluteUrl("reportjob").'/resentemail?job_id=';
$js = <<<EOF
$('#btnDtlResent').on('click',function() {
	$('#dtlviewdialog').modal('hide');
	$('#resentdialog').modal('show');
});

$('#btnResentEmail').on('click',function() {
	$('#resentdialog').modal('hide');
	resentEmail();
});

function resentEmail() {
	var elm=$('#btnResentEmail');
	var jobid = $('#dtlJobId').val();
	jQuery.yii.submitForm(elm,'$link1'+jobid,{});
}
EOF;
Yii::app()->clientScript->registerScript('resentEmail',$js,CClientScript::POS_READY);
?>
