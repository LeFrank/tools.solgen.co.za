<?php
if( null == $default_expense_type){ ?>
    <select name = "expenseType[]" id = "expenseType[]">
    <?php

    foreach ($expenseTypes as $k => $v) {
        echo '<option value="' . $v["id"] . '">' . $v["description"] . '</option>';
    }
    ?>
</select>

<?php
}else{
?>
<select name = "expenseType[]" id = "expenseType[]">
    <?php

    foreach ($expenseTypes as $k => $v) {
        echo '<option value="' . $v["id"] . '"'. (($default_expense_type == $v["id"]) ? "selected" : "" ) .' .>' . $v["description"] . '</option>';
    }
    ?>
</select>
<?php
}
?>