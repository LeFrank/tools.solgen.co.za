<?php ?>
<select name="incomeType">
    <?php
    foreach ($incomeTypes as $k => $v) {
        echo '<option value="' . $v["id"] . '"  '
        . ((strtolower($v["description"]) == "cash") ? 'selected="selected"' : '')
        . '>' . $v["description"] . '</option>';
    }
    ?>
</select>
