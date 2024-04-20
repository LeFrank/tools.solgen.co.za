<?php
if ($this->session->flashdata("success") !== FALSE) {
    echo $this->session->flashdata("success");
}
?>
<div class="row expanded">
    <div class="large-12 columns">
        <h2>Income Overview</h2>

        <div id="latestIncomes">
            <h3>Five Latest Incomes</h3>
            <?php if (is_array($income) && !empty($income)) {
                ?>
                <table id="incomeSummary" class="tablesorter responsive expanded widget-zebra">
                    <thead>
                    <th/>
                    <th>Date</th>
                    <th>Income Type</th>
                    <th>Payment Method</th>
                    <th>Description</th>
                    <th>Source</th>
                    <th>Amount</th>
                    <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0.0;
                        foreach ($income as $k => $v) {
                            echo "<tr>";
                            echo "<td>" . ++$k . "</td>";
                            echo "<td>" . $v["income_date"] . "</td>";
                            echo "<td>" . $incomeTypes[$v["income_type_id"]]["description"] . "</td>";
                            echo "<td>" . $expensePaymentMethod[$v["payment_method_id"]]["description"] . "</td>";
                            echo "<td>" . $v["description"] . "</td>";
                            echo "<td>" . $v["source"] . "</td>";
                            echo "<td class='align-right'>" . $v["amount"] . "</td>";
                            echo "<td><a href='/income/edit/" . $v["id"] . "'>Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='/income/delete/" . $v["id"] . "' onclick='return confirm_delete()'>Delete</a></td>";
                            echo "</tr>";
                            $total += $v["amount"];
                        }
                        echo "<tr class='td-total'>"
                        . "  <td class='align-left'>Latest income Total</span></td>"
                        . "  <td colspan='6' class='align-right'>" . number_format($total, 2, '.', ',') . "</td>"
                        . "</tr>";
                        ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo "No income captured.";
            }
            ?>
        </div>
        <br/>
    </div>
</div>
<div class="row expanded">
    <div class="large-12 columns">
        <h3>Capture income</h3>
        <?php echo validation_errors(); ?>
        <?php echo form_open_multipart('income/capture') ?>
        <div class="row expanded">
            <div class="large-4 columns">
                <label for="amount">Amount *</label>
                <input type="number" min="0.01" step="0.01" max="9999999999999" name="amount" id="amount" placeholder="0.00"autofocus /><br />
            </div>
            <div class="large-4 columns">
                <label for="incomeType">income Type</label>
                <select name="incomeType" id="incomeType"> 
                    <?php
                    foreach ($incomeTypes as $k => $v) {
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
                <textarea name="description" id="description" cols="40" rows="5" placeholder="What was special about it, or a description of the income."></textarea><br/><br/>
            </div>
        </div>
        <div class="row expanded">
            <div class="large-6 columns">
                <label for="source">Source</label>
                <input  type="text" id="source" name="source" placeholder="Source of income?"/>
            </div>
            <div class="large-6 columns">
                <label for="incomeDate">Income Date</label>
                <input autocomplete="off" type="text" id="incomeDate" name="incomeDate" placeholder="<?php echo date('Y/m/d H:i:s'); ?>" /><br/><br/>
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
<script type="text/javascript" src="/js/income/income_table.js" ></script>
<script type="text/javascript" src="/js/third_party/math.js" ></script>
<script src="/js/third_party/jquery/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    const re = /(?:(?:^|[-+_*/])(?:\s*-?\d+(\.\d+)?(?:[eE][+-]?\d+)?\s*))+$/;
    function test_expr(s) {
        console.log("%s is valid? %s", s, re.test(s));
        return true;
    }
    $(function () {
        $("#incomeDate").datetimepicker();
        var timer = null;
        CKEDITOR.replace('description');
        $("#incomeType").change(function () {
            $.post(
                    "/income-types/type/" + $(this).val(),
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