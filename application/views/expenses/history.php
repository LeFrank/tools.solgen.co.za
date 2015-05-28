
<?php ?>
<div class="row">
    <div class="large-3 columns" >
        <div class="row">
            <div class="large-12 columns" >
                <div id="expenseHistoryFilter" class="expenseHistoryFilter">
                    <h3>Filter Expenses History</h3>
                    <div id="validation_errors" ></div>
                    <form accept-charset="utf-8" method="post" action="/expenses/export" id="filterExpenseForm" >
                        <div class="row">
                            <div class="large-6 columns">
                                <label> Filter by Period
                                </label>
                            </div>
                            <div class="large-6 columns">
                                <select id="expensePeriod" name="expensePeriod">
                                    <option value="0">Current Month</option>
                                    <?php
                                    foreach ($expensePeriods as $k => $v) {
                                        echo "<option value='" . $v["id"] . "'>" . $v["name"] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-6 columns">
                                <label> Date From
                                    <input type="text" name="fromDate" id="fromDate" value="<?php echo $startAndEndDateforMonth[0]; ?>"/>
                                </label>
                            </div>
                            <div class="large-6 columns">
                                <label>
                                    Date To<input type="text" name="toDate" id="toDate" value="<?php echo $startAndEndDateforMonth[1]; ?>"/>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-6 columns">
                                <label>Amount From
                                    <input type="text" name="fromAmount" id="fromAmount" value="0" />
                                </label>
                            </div>
                            <div class="large-6 columns">
                                <label>To
                                    <input type="text" name="toAmount" id="toAmount" value="0" />
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-12 columns">
                                <label>Keywords
                                    <input type="text" name="keyword" id="keyword" value="" />
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-12 columns">
                                <label>Expense Types</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-12 columns">
                                <div class="row">
                                    <div class="large-6 columns">
                                        <input type="checkbox" checked="checked" value="all" name="expenseType[]" />
                                        <label>all</label>
                                    </div>
                                    <?php
                                    $count = 1;
                                    $breakCount = 2;
                                    foreach ($expenseTypes as $k => $v) {
                                        echo "<div class='large-6 columns'><input type='checkbox' value='" . $v["id"] . "' name='expenseType[]' /><label>" . $v["description"] . "</label></div>";
                                        $count++;
                                        if ($count % $breakCount === 0) {
                                            echo "</div><div class='row'>";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-12 columns">
                                Payment Method
                                <div class="row">
                                    <div class="large-6 columns">                        
                                        <input type="checkbox" checked="checked" value="all" name="paymentMethod[]" /><label>all</label>
                                    </div>
                                    <?php
                                    $pmCount = 1;
                                    $bpmBeakCount = 2;
                                    foreach ($expensePaymentMethod as $k => $v) {
                                        echo "<div class='large-6 columns'><input type='checkbox' value='" . $v["id"] . "' name='paymentMethod[]' /><label>" . $v["description"] . "</label></div>";
                                        $pmCount++;
                                        if ($pmCount % $bpmBeakCount === 0) {
                                            echo "</div><div class='row'>";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-12 columns">
                                <input type="button" name="filter" value="Filter" id="filter" class="button" />
                                <input type="submit" name="export" value="Export To CSV" id="export" class="button secondary"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="large-9 columns" >
        <div class="row">
            <div class="large-12 columns" >
                <div id="expenseHistoryContent" class="expenseHistoryContent" >
                    <h2>Expense History</h2>
                    <div id="historyGraph">
                        Table of full data from <?php echo $startAndEndDateforMonth[0]; ?> to <?php echo $startAndEndDateforMonth[1]; ?><br/><br/>
                        <?php if (is_array($expensesForPeriod) && !empty($expensesForPeriod)) {
                            ?>
                            <table id="expense_history" class="tablesorter">
                                <thead>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <th>Date</th>
                                        <th>Expense Type</th>
                                        <th>Payment Method</th>
                                        <th>Description</th>
                                        <th>Location</th>
                                        <th>Amount</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total = 0.0;
                                    foreach ($expensesForPeriod as $k => $v) {
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
                                    ?>
                                </tbody>
                            </table>
                            <table style="width:100%;">
                                <?php
                                echo "<tr class='td-total'>"
                                . "  <td class='align-left'>Period Expenses Total</td>"
                                . "  <td colspan='6' class='align-right'>" . number_format($total, 2, '.', ',') . "</td>"
                                . "</tr>";
                                ?>
                            </table>
                            <?php
                        } else {
                            echo "No expenses captured.";
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Handlebars test --> 
<script id="some-template" type="text/x-handlebars-template">
    <table id="expense_history" class="tablesorter">
    <thead>
    <tr>
    <th></th>
    <th>Date</th>
    <th>Expense Type</th>
    <th>Payment Method</th>
    <th>Description</th>
    <th>Location</th>
    <th>Amount</th>
    <th>Actions</th>
    <tr/>
    </thead>
    <tbody>
    {{#expenses}}
    <tr>
    <td> {{@index}}</td>
    <td>{{expense_date}}</td>
    <td>{{expense_type_id}}</td>
    <td>{{payment_method_id}}</td>
    <td>{{description}}</td>
    <td>{{location}}</td>
    <td>{{amount}}</td>
    <td><a href="/expenses/edit/{{id}}">Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/expenses/delete/{{id}}">Delete</a></td>
    </tr>
    {{/expenses}}
    </tbody>
    </table>
    <table style="width:100%;">
    <tr class='td-total'>
    <td class='align-left'>Period Expenses Total</td>
    <td colspan='6' class='align-right'>{{total}}</td>
    </tr>
    </table>
</script>


<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
<script type="text/javascript" src="/js/jquery.datetimepicker.js" ></script>
<script type="text/javascript" src="/js/third_party/handlebars-v1.3.0.js" ></script>
<script type="text/javascript" src="/js/third_party/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="/js/expenses/history.js" ></script>
<script type="text/javascript">
    var expense_types = <?php echo json_encode($expenseTypes); ?>;
    var payment_methods = <?php echo json_encode($expensePaymentMethod); ?>;
    var expense_period = <?php echo json_encode($expensePeriods);?>;
    console.log(expense_period);
    var default_start_date = "<?php echo $startAndEndDateforMonth[0]; ?>";
    var default_end_date = "<?php echo $startAndEndDateforMonth[1]; ?>";
</script>