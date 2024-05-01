<?php ?>
<select name="incomeAsset[]">
    <?php
    foreach ($incomeAssets as $k => $v) {
        echo '<option value="' . $v["id"] . '"  '
        . ((strtolower($v["description"]) == "cash") ? 'selected="selected"' : '')
        . '>' . $v["description"] . '</option>';
    }
    ?>
</select>
