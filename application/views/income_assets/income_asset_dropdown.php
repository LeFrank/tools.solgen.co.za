<?php
if( null == $default_income_asset){ 
?>
<select name="incomeAsset[]">
    <?php
    foreach ($incomeAssets as $k => $v) {
        echo '<option value="' . $v["id"] . '"  '
        . ((strtolower($v["description"]) == "cash") ? 'selected="selected"' : '')
        . '>' . $v["description"] . '</option>';
    }
    ?>
</select>
<?php
    }else{
?>
<select name="incomeAsset[]">
    <?php
    foreach ($incomeAssets as $k => $v) {
        echo '<option value="' . $v["id"] . '"  '
        . (($default_income_asset == $v["id"]) ? "selected" : "" )
        . ((strtolower($v["description"]) == "cash") ? 'selected="selected"' : '')
        . '>' . $v["description"] . '</option>';
    }
    ?>
</select>    

<?php 
    }
?>