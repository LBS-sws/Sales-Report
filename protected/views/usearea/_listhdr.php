<tr>
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <th>
            <?php echo TbHtml::link($this->getLabelName('city_name').$this->drawOrderArrow('city_name'),'#',$this->createOrderLink('material','city_name'))
            ;
            ?>
        </th>
    <?php endif ?>
    <th>
        <?php echo TbHtml::link($this->getLabelName('area_type').$this->drawOrderArrow('area_type'),'#',$this->createOrderLink('usearea','usearea'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('use_area').$this->drawOrderArrow('use_area'),'#',$this->createOrderLink('usearea','usearea'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('creat_time').$this->drawOrderArrow('creat_time'),'#',$this->createOrderLink('usearea','usearea'))
        ;
        ?>
    </th>
    <th width="10%"></th>
</tr>
