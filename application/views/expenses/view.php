<?php ?>

<div id="expenseContent" class="expenseContent" >
    <h2>Expense Overview</h2>

    <div id="latestExpenses">
        <h3>Five Latest Expenses</h3>
        <?php if (is_array($expense) && !empty($expense)) {
            ?>
            <table>
                <thead>
                <th/>
                <th>Date</th>
                <th>Expense Type</th>
                <th>Payment Method</th>
                <th>Description</th>
                <th>Location</th>
                <th>Amount</th>
                </thead>
                <tbody>
                    <?php
                    $total = 0.0;
                    foreach ($expense as $k => $v) {
                        echo "<tr>";
                        echo "<td>" . ++$k . "</td>";
                        echo "<td>" . $v["expense_date"] . "</td>";
                        echo "<td>" . $expenseTypes[$v["expense_type_id"]]["description"] . "</td>";
                        echo "<td>" . $expensePaymentMethod[$v["payment_method_id"]]["description"] . "</td>";
                        echo "<td>" . $v["description"] . "</td>";
                        echo "<td>" . $v["location"] . "</td>";
                        echo "<td>" . $v["amount"] . "</td>";
                        echo "</tr>";
                        $total += $v["amount"];
                    }
                    echo "<tr class='td-total'>"
                    . "  <td class='align-left'>Latest Expenses Total</span></td>"
                    . "  <td colspan='6' class='align-right'>" . number_format($total, 2, '.', ',') . "</td>"
                    . "</tr>";
                    ?>
                </tbody>
            </table>
            <?php
        } else {
            echo "No expenses captured.";
        }
        ?>
    </div>
    <br/>
    <div id="captureExpenses">
        <h3>Capture Expense</h3>
        <?php echo validation_errors(); ?>

        <?php echo form_open('expenses/capture') ?>

        <label for="amount">Amount *</label>
        <input type="number" min="0.01" step="0.01" max="9999999999999" name="amount" /><br />

        <label for="expenseType">Expense Type</label>
        <select name="expenseType">
            <option value="0">miscellaneous</option>
            <?php
            foreach ($expenseTypes as $k => $v) {
                echo '<option value="' . $v["id"] . '">' . $v["description"] . '</option>';
            }
            ?>
        </select><br />

        <label for="paymentMethod">Payment Method</label>
        <select name="paymentMethod">
            <?php
            foreach ($expensePaymentMethod as $k => $v) {
                echo '<option value="' . $v["id"] . '"  '
                . ((strtolower($v["description"]) == "cash") ? 'selected="selected"' : '')
                . '>' . $v["description"] . '</option>';
            }
            ?>
        </select><br />

        <label for="description">Description</label>
        <textarea name="description" cols="40" rows="5" ></textarea><br/><br/>

        <label for="location">Location</label>
        <input  type="text" name="location" /><br/><br/>

        <label for="expenseDate">Expense Date</label>
        <input  type="text" id="expenseDate" name="expenseDate" /><br/><br/>

        <span>* Required Field</span><br/><br/>

        <input type="submit" name="submit" value="Record" />
        </form>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $("#expenseDate").datetimepicker();
    });
</script>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css"/ >
<script src="/js/jquery.datetimepicker.js"></script>


