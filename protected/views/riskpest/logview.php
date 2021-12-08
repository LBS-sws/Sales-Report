<?php
if($flashes = Yii::app()->user->getFlashes(false)) {
    foreach($flashes as $key => $message) {
        if($key == -999) {
			$ftrbtn = array();
			$ftrbtn[] = TbHtml::button(Yii::t('dialog','Close'), array('id'=>'btnLogClose','data-dismiss'=>'modal','color'=>TbHtml::BUTTON_COLOR_PRIMARY));
			$this->beginWidget('bootstrap.widgets.TbModal', array(
					'id'=>'logviewdialog',
					'header'=>Yii::t('import','View Log'),
					'footer'=>$ftrbtn,
					'show'=>true,
				));

			echo '<div class="form-group">';
			echo '<div class="col-sm-11">';
			echo TbHtml::textArea('log_content', $message['content'], 
				array(
					'rows'=>10,
					'cols'=>70,
					'readonly'=>true,
					'style'=>'resize: both; display: inline-block;',
				));
			echo '</div>';
			echo '</div>';
			
			$this->endWidget(); 
		}
	}
}
?>
