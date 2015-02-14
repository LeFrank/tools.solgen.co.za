<?php ?>
<div class="row full-width">
    <div class="large-12 columns">
        <h2>Expense Overview</h2>

        <div id="latestExpenses">
            <h3>Five Latest Expenses</h3>
            <?php if (is_array($expense) && !empty($expense)) {
                ?>
                <table id="expenseSummary" class="tablesorter full-width">
                    <thead>
                    <th/>
                    <th>Date</th>
                    <th>Expense Type</th>
                    <th>Payment Method</th>
                    <th>Description</th>
                    <th>Location</th>
                    <th>Amount</th>
                    <th>Actions</th>
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
                            echo "<td class='align-right'>" . $v["amount"] . "</td>";
                            echo "<td><a href='/expenses/edit/" . $v["id"] . "'>Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='/expenses/delete/" . $v["id"] . "'>Delete</a></td>";
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
    </div>
</div>
<div class="row">
    <div class="large-12 columns">
        <div id="captureExpenses">
            <h3>Capture Expense</h3>
            <?php echo validation_errors(); ?>

            <?php echo form_open('expenses/capture') ?>
            <div class="row">
                <div class="large-4 columns">
                    <label for="amount">Amount *</label>
                    <input type="number" min="0.01" step="0.01" max="9999999999999" name="amount" placeholder="0.0"/><br />
                </div>
                <div class="large-4 columns">
                    <label for="expenseType">Expense Type</label>
                    <select name="expenseType">
                        <?php
                        foreach ($expenseTypes as $k => $v) {
                            echo '<option value="' . $v["id"] . '">' . $v["description"] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="large-4 columns">
                    <label for="paymentMethod">Payment Method</label>
                    <select name="paymentMethod">
                        <?php
                        foreach ($expensePaymentMethod as $k => $v) {
                            echo '<option value="' . $v["id"] . '"  '
                            . ((strtolower($v["description"]) == "cash") ? 'selected="selected"' : '')
                            . '>' . $v["description"] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <label for="description">Description</label>
                    <textarea name="description" cols="40" rows="5" placeholder="What was special about it, or a description of the expense."></textarea><br/><br/>
                </div>
            </div>
            <div class="row">
                <div class="large-6 columns">
                    <label for="location">Location</label>
                    <input  type="text" name="location" placeholder="Where was the expense made?"/><br/><br/>
                </div>
                <div class="large-6 columns">
                    <label for="expenseDate">Expense Date</label>
                    <input  type="text" id="expenseDate" name="expenseDate" placeholder="<?php echo date('Y/m/d H:i:s'); ?>" /><br/><br/>
                </div>
            </div>
            <span>* Required Field</span><br/><br/>

            <input type="submit" name="submit" value="Record" class="button"/>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $("#expenseDate").datetimepicker();
    });
</script>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
<script src="/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/js/third_party/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="/js/expenses/expense_table.js" ></script>


