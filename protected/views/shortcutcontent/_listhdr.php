<tr>
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <th>
            <?php echo TbHtml::link($this->getLabelName('city_name').$this->drawOrderArrow('city_name'),'#',$this->createOrderLink('material','city_name'))
            ;
            ?>
        </th>
    <?php endif ?>
    <th>
        <?php echo TbHtml::link($this->getLabelName('shortcut_name').$this->drawOrderArrow('shortcut_name'),'#',$this->createOrderLink('shortcut','shortcutcontent'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('content').$this->drawOrderArrow('content'),'#',$this->createOrderLink('shortcut','shortcutcontent'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('creat_time').$this->drawOrderArrow('creat_time'),'#',$this->createOrderLink('shortcut','shortcutcontent'))
        ;
        ?>
    </th>
    <th width="10%"></th>
</tr>
