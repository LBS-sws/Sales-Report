<tr>
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <th>
            <?php echo TbHtml::link($this->getLabelName('city_name').$this->drawOrderArrow('city_name'),'#',$this->createOrderLink('material','city_name'))
            ;
            ?>
        </th>
    <?php endif ?>
    <th>
        <?php echo TbHtml::link($this->getLabelName('name').$this->drawOrderArrow('name'),'#',$this->createOrderLink('material','materialclass'))
        ;
        ?>
    </th>

    <th>
        <?php echo TbHtml::link($this->getLabelName('creat_time').$this->drawOrderArrow('creat_time'),'#',$this->createOrderLink('material','materialclass'))
        ;
        ?>
    </th>
    <th width="10%"></th>
</tr>