<tr>
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <th>
            <?php echo TbHtml::link($this->getLabelName('city_name').$this->drawOrderArrow('city_name'),'#',$this->createOrderLink('material','city_name'))
            ;
            ?>
        </th>
    <?php endif ?>
    <th>
        <?php echo TbHtml::link($this->getLabelName('sort').$this->drawOrderArrow('sort'),'#',$this->createOrderLink('material','sort'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('name').$this->drawOrderArrow('name'),'#',$this->createOrderLink('material','name'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('classify').$this->drawOrderArrow('classify'),'#',$this->createOrderLink('material','classify'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('registration_no').$this->drawOrderArrow('registration_no'),'#',$this->createOrderLink('material','registration_no'))
        ;
        ?>
    </th>

    <th>
        <?php echo TbHtml::link($this->getLabelName('active_ingredient').$this->drawOrderArrow('active_ingredient'),'#',$this->createOrderLink('material','active_ingredient'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('ratio').$this->drawOrderArrow('ratio'),'#',$this->createOrderLink('material','ratio'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('unit').$this->drawOrderArrow('unit'),'#',$this->createOrderLink('material','unit'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('validity').$this->drawOrderArrow('validity'),'#',$this->createOrderLink('material','validity'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('creat_time').$this->drawOrderArrow('creat_time'),'#',$this->createOrderLink('material','creat_time'))
        ;
        ?>
    </th>
    <th width="10%"></th>
</tr>
