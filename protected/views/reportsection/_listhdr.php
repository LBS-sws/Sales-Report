<tr>
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <th>
            <?php echo TbHtml::link($this->getLabelName('city_name').$this->drawOrderArrow('city_name'),'#',$this->createOrderLink('reportsection','city_name'))
            ;
            ?>
        </th>
    <?php endif ?>
    <th>
        <?php echo TbHtml::link($this->getLabelName('service_name').$this->drawOrderArrow('service_name'),'#',$this->createOrderLink('reportsection','reportsection'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('section_ids').$this->drawOrderArrow('section_ids'),'#',$this->createOrderLink('reportsection','reportsection'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('creat_time').$this->drawOrderArrow('creat_time'),'#',$this->createOrderLink('reportsection','reportsection'))
        ;
        ?>
    </th>
    <th width="10%"></th>
</tr>
