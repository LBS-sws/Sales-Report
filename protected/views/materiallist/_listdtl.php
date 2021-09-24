
<tr class='clickable-row' data-href='<?php echo $this->getLink('MS01', 'materiallist/edit', 'materiallist/edit', array('index'=>$this->record['id']));?>'>
    <?php if (!Yii::app()->user->isSingleCity()) : ?>
        <td class="name"><?php echo $this->record['city_name']; ?></td>
    <?php endif ?>
    <td class="name"><?php echo $this->record['sort']; ?></td>
    <td class="name"><?php echo $this->record['name']; ?></td>
    <td class="name"><?php echo $this->record['classify']; ?></td>
    <td class="name"><?php echo $this->record['registration_no']; ?></td>
    <td class="name"><?php echo $this->record['active_ingredient']; ?></td>
    <td class="name"><?php echo $this->record['ratio']; ?></td>
    <td class="name"><?php echo $this->record['unit']; ?></td>
    <td class="name"><?php echo $this->record['validity']; ?></td>
    <td class="name"><?php echo $this->record['creat_time']; ?></td>
</tr>


<script>
    $(function () {
        $(".btnIntegralApply").on("click",function () {
            var $tr = $(this).parents("tr:first");
            $("#gift_type").val($(this).data("id"));
            $("#gift_name").val($tr.find(".integral_name:first").text());
            $("#bonus_point").val($tr.find(".integral_num:first").text());
            $('#integralApply').modal('show');
            return false;
        })
    })
</script>