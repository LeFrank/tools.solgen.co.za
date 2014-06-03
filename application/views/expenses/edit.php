<?php ?>
<div id="captureExpenses">
    <h3>Capture Expense</h3>
    <?php echo validation_errors(); ?>

    <?php echo form_open('expenses/update') ?>
    <input type="hidden" name="id" value="<?php echo $expense->id;?>"
    <label for="amount">Amount *</label>
    <input type="number" min="0.01" step="0.01" max="9999999999999" name="amount" value="<?php echo $expense->amount; ?>"/><br />

    <label for="expenseType">Expense Type</label>
    <select name="expenseType">
        <?php
        foreach ($expenseTypes as $k => $v) {
            echo '<option value="' . $v["id"] . '" ' . (($expense->expense_type_id == $v["id"]) ? "selected" : "" ). '>' . $v["description"] . '</option>';
        }
        ?>
    </select><br />

    <label for="paymentMethod">Payment Method</label>
    <select name="paymentMethod">
        <?php
        foreach ($expensePaymentMethod as $k => $v) {
            echo '<option value="' . $v["id"] . '"  '
            . (($expense->payment_method_id == $v["id"]) ? 'selected' : '')
                    . '>' . $v["description"] . '</option>';
        }
        ?>
    </select><br />

    <label for="description">Description</label>
    <textarea name="description" cols="40" rows="5" ><?php echo $expense->description; ?></textarea><br/><br/>

    <label for="location">Location</label>
    <input  type="text" name="location" value="<?php echo $expense->location; ?>"/><br/><br/>

    <label for="expenseDate">Expense Date</label>
    <input  type="text" id="expenseDate" name="expenseDate" value="<?php echo $expense->expense_date; ?>" /><br/><br/>

    <span>* Required Field</span><br/><br/>

    <input type="submit" name="submit" value="Record" /> <a href="/expenses" >Cancel</a>
</form>
</div>
<script type="text/javascript">
    $(function() {
        $("#expenseDate").datetimepicker();
    });
</script>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css"/ >
<script src="/js/jquery.datetimepicker.js"></script>