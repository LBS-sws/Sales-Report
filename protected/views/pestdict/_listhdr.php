<tr>
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <th>
            <?php echo TbHtml::link($this->getLabelName('city_name').$this->drawOrderArrow('city'),'#',$this->createOrderLink('pestdict','city'))
            ;
            ?>
        </th>
    <?php endif ?>
    <th>
        <?php echo TbHtml::link($this->getLabelName('id').$this->drawOrderArrow('id'),'#',$this->createOrderLink('pestdict','id'))
        ;
        ?>
    </th>

    <th>
        <?php echo TbHtml::link($this->getLabelName('type_name').$this->drawOrderArrow('type_name'),'#',$this->createOrderLink('pestdict','type_name'))
        ;
        ?>
    <th>
        <?php echo TbHtml::link($this->getLabelName('insect_name').$this->drawOrderArrow('insect_name'),'#',$this->createOrderLink('pestdict','insect_name'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('analysis_result').$this->drawOrderArrow('analysis_result'),'#',$this->createOrderLink('pestdict','analysis_result'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('suggestion').$this->drawOrderArrow('suggestion'),'#',$this->createOrderLink('pestdict','suggestion'))
        ;
        ?>
    </th>
    <th>
        <?php echo TbHtml::link($this->getLabelName('measure').$this->drawOrderArrow('measure'),'#',$this->createOrderLink('pestdict','measure'))
        ;
        ?>
    </th>

    <th>
        <?php echo TbHtml::link($this->getLabelName('created_at').$this->drawOrderArrow('created_at'),'#',$this->createOrderLink('pestdict','created_at'))
        ;
        ?>
    </th>

    <th width="10%"></th>
</tr>
