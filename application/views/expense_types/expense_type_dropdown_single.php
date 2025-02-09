<?php ?>
<select name = "expenseType" id = "expenseType">
    <?php
    foreach ($expenseTypes as $k => $v) {
        echo '<option value="' . $v["id"] . '">' . $v["description"] . '</option>';
    }
    ?>
</select>
