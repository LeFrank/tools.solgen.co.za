<?php
if ($this->session->flashdata("success") !== FALSE) {
    echo $this->session->flashdata("success");
}
?>
<div class="row expanded">
    <div class="large-12 columns">
        <h2>Expense Overview</h2>

        <div id="latestExpenses">
            <h3>Five Latest Expenses</h3>
            <?php if (is_array($expense) && !empty($expense)) {
                ?>
                <table id="expenseSummary" class="tablesorter responsive expanded widget-zebra">
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
                            echo "<td><a href='/expenses/edit/" . $v["id"] . "'>Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='/expenses/delete/" . $v["id"] . "' onclick='return confirm_delete()'>Delete</a></td>";
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
<div class="row expanded">
    <div class="large-12 columns">
        <h3>Capture Expense</h3>
        <?php echo validation_errors(); ?>
        <?php echo form_open_multipart('expenses/capture') ?>
        <div class="row expanded">
            <div class="large-4 columns">
                <label for="amount">Amount *</label>
                <input type="number" min="0.01" step="0.01" max="9999999999999" name="amount" id="amount" placeholder="0.00"autofocus /><br />
            </div>
            <div class="large-4 columns">
                <label for="expenseType">Expense Type</label>
                <select name="expenseType" id="expenseType"> 
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
        <div class="row expanded">
            <div class="large-12 columns">
                <label for="description">Description</label>
                <textarea name="description" id="description" cols="40" rows="5" placeholder="What was special about it, or a description of the expense."></textarea><br/><br/>
            </div>
        </div>
        <div class="row expanded">
            <div class="large-6 columns">
                <label for="location">Location</label>
                <input  type="text" id="location" name="location" placeholder="Where was the expense made?"/>
                <input  type="hidden" id="locationId" name="locationId" value="0"/><br/><br/>
            </div>
            <div class="large-6 columns">
                <label for="expenseDate">Expense Date</label>
                <input autocomplete="off" type="text" id="expenseDate" name="expenseDate" placeholder="<?php echo date('Y/m/d H:i:s'); ?>" /><br/><br/>
            </div>
        </div>
        <div class="row expanded">
            <div class="large-6 columns">
                <input name="userfile" id="userfile" type="file" />
            </div>
            <div class="large-6 columns">
                <div id="commandline">
                    <div class="cle">
                        <div class="top-panel">
                            <div class="results">
                                <pre class="res">8</pre>
                            </div>
                            <button class="fullscreen" title="Toggle full screen display (Ctrl+F11)" style="top: 8px; right: 8px;"></button>
                        </div>
                        <div class="bottom-panel">
                            <div class="input-left">
                                <input class="input" title="Enter an expression">
                            </div>
                            <div class="input-right">
                                <button class="eval" title="Evaluate the expression (Enter)">Evaluate</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <span>* Required Field</span><br/><br/>
    <input type="submit" name="submit" value="Record" class="button"/>
</form>
</div>
</div>
<script src="/js/third_party/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
<script src="/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/js/third_party/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="/js/expenses/expense_table.js" ></script>
<script src="/js/third_party/jquery/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/location/autocomplete.js"></script>
<script type="text/javascript">
    $(function () {
        $("#expenseDate").datetimepicker();
        CKEDITOR.replace('description');
        $("#expenseType").change(function () {
            $.post(
                    "/expense-types/type/" + $(this).val(),
                    null
                    ).done(function (resp) {
                obj = JSON.parse(resp);
                if (null != obj.template && obj.template != "") {
                    CKEDITOR.instances.description.setData(CKEDITOR.instances.description.getData() + obj.template);
                }
            });
        });
    });
</script>