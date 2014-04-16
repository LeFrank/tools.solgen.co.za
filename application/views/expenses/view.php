<?php
?>
<h3>Expense Overview</h3>
<div id="latestExpenses">
    <select id="expenseType" name="expenseType">
    <?php
        foreach($expenseTypes as $k=>$v){
            echo "<option value='".$k . "'>" . $v["description"] ."</option>";
        }
    ?>
    </select>
</div>

