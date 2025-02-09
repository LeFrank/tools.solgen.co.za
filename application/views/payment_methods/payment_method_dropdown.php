<?php
if( null == $default_payment_method){ 
?>
<select name="paymentMethod[]">
    <?php
    foreach ($expensePaymentMethod as $k => $v) {
        echo '<option value="' . $v["id"] . '"  '
        . ((strtolower($v["description"]) == "cash") ? 'selected="selected"' : '')
        . '>' . $v["description"] . '</option>';
    }
    ?>
</select>
<?php
    }else{
?>
<select name="paymentMethod[]">
    <?php
    foreach ($expensePaymentMethod as $k => $v) {
        echo '<option value="' . $v["id"] . '"  '
        . (($default_payment_method == $v["id"]) ? "selected" : "" )
        . ((strtolower($v["description"]) == "cash") ? 'selected="selected"' : '')
        . '>' . $v["description"] . '</option>';
    }
    ?>
</select>    

<?php 
    }
?>