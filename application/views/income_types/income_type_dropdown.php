<?php
if( null == $default_income_type){ ?>
    <select name = "incomeType[]" id = "incomeType[]">
    <?php

    foreach ($incomeTypes as $k => $v) {
        echo '<option value="' . $v["id"] . '">' . $v["description"] . '</option>';
    }
    ?>
</select>

<?php
}else{
?>
<select name = "incomeType[]" id = "incomeType[]">
    <?php

    foreach ($incomeTypes as $k => $v) {
        echo '<option value="' . $v["id"] . '"'. (($default_income_type == $v["id"]) ? "selected" : "" ) .' .>' . $v["description"] . '</option>';
    }
    ?>
</select>
<?php
}
?>