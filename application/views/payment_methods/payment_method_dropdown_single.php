<?php ?>
<select name="paymentMethod">
    <?php
    foreach ($expensePaymentMethod as $k => $v) {
        echo '<option value="' . $v["id"] . '"  '
        . ((strtolower($v["description"]) == "cash") ? 'selected="selected"' : '')
        . '>' . $v["description"] . '</option>';
    }
    ?>
</select>
