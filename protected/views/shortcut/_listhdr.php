<tr>
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <th>
            <?php echo TbHtml::link($this->getLabelName('city_name').$this->drawOrderArrow('city_name'),'#',$this->createOrderLink('material','city_name'))
            ;
            ?>
        </th>
    <?php endif ?>
    <th>
        <?php echo TbHtml::link($this->getLabelName('service_name').$this->drawOrderArrow('service_name'),'#',$this->createOrderLink('shortcut','shortcut'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('shortcut_type').$this->drawOrderArrow('shortcut_type'),'#',$this->createOrderLink('shortcut','shortcut'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('shortcut_name').$this->drawOrderArrow('shortcut_name'),'#',$this->createOrderLink('shortcut','shortcut'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('creat_time').$this->drawOrderArrow('creat_time'),'#',$this->createOrderLink('shortcut','shortcut'))
        ;
        ?>
    </th>
    <th width="10%"></th>
</tr>
