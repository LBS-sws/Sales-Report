<!-- 列表数据 -->

<tr class='clickable-row' data-href='<?php echo $this->getLink('PQ01', 'papersstaff/edit', 'papersstaff/edit', array('index'=>$this->record['id']));?>'>
    <!--    --><?php //if (!Yii::app()->user->isSingleCity()) : ?>
    <!--        <td class="name">--><?php //echo $this->record['city']; ?><!--</td>-->
    <!--    --><?php //endif ?>

    <td class="city"><?php //echo $this->record['city_name']; ?><?php echo $this->record['city']; ?></td>
    <td class="code"><?php echo $this->record['code']; ?></td>
    <td class="staffname"><?php echo $this->record['staffname']; ?></td>
    <td class="create_time"><?php echo $this->record['create_time']; ?></td>

    <td class="update_time"><?php echo $this->record['update_time']; ?>
        <div style="display:none;"><?php echo $this->record['id'];?></div>
    </td>
    <td>
        <?php
        $dlnk = Yii::app()->createUrl('papersstaff/delete',array('index'=>$this->record['id']));
        echo TbHtml::Button('<span class="fa fa-remove"></span> '."删除", array('submit'=>$dlnk,'size' => TbHtml::BUTTON_SIZE_SMALL));
        ?>
    </td>
</tr>
