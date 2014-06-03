
<?php ?>
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
<div id="expenseHistoryFilter" class="expenseHistoryFilter">
    <h3>Filter Expenses History</h3>
    <div id="validation_errors" ></div>
    <form action="/" id="filterExpenseForm">
        <div>
            <label>Date</label>
            From &nbsp;
            <input type="text" name="fromDate" id="fromDate" value="<?php echo $startAndEndDateforMonth[0]; ?>"/>
            &nbsp;&nbsp;
            To&nbsp;<input type="text" name="toDate" id="toDate" value="<?php echo $startAndEndDateforMonth[1]; ?>"/>
        </div>
        <div>
            <label>Amount</label>
            From &nbsp;
            <input type="text" name="fromAmount" id="fromAmount" value="0" />
            &nbsp;&nbsp;
            To&nbsp;<input type="text" name="toAmount" id="toAmount" value="0" />
        </div>
        <div >
            <label>Keyword</label>
            <input type="text" name="keyword" id="keyword" value="" />
        </div>
        <div>
            <div class="inline-block div-label" style="vertical-align: top;padding-top: 10px;">Expense Types</label></div>
            <div class="inline-block three-col" style="vertical-align: top;padding-top: 10px;">
                <div class='checkbox-col'><input type="checkbox" checked="checked" value="all" name="expenseType[]" />all</div>
                <?php
                $count = 1;
                $breakCount = 3;
                foreach ($expenseTypes as $k => $v) {
                    echo "<div class='checkbox-col'><input type='checkbox' value='" . $v["id"] . "' name='expenseType[]' />" . $v["description"] . "</div>";
                    $count++;
                    if ($count % $breakCount === 0) {
                        echo "<br/>";
                    }
                }
                ?>
            </div>
        </div>
        <div>
            <div class="inline-block div-label" style="vertical-align: top;padding-top: 10px;">Payment Method</label></div>
            <div class="inline-block three-col" style="vertical-align: top;padding-top: 10px;">
                <div class='checkbox-col'><input type="checkbox" checked="checked" value="all" name="paymentMethod[]" />all</div>
                <?php
                $pmCount = 1;
                $bpmBeakCount = 3;
                foreach ($expensePaymentMethod as $k => $v) {
                    echo "<div class='checkbox-col'><input type='checkbox' value='" . $v["id"] . "' name='paymentMethod[]' />" . $v["description"] . "</div>";
                    $pmCount++;
                    if ($pmCount % $bpmBeakCount === 0) {
                        echo "<br/>";
                    }
                }
                ?>
            </div>
        </div>
        <input type="button" name="filter" value="Filter" id="filter" />
    </form>
</div>

<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
<script type="text/javascript" src="/js/jquery.datetimepicker.js" ></script>
<script type="text/javascript" src="/js/third_party/handlebars-v1.3.0.js" ></script>
<script type="text/javascript" src="/js/third_party/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="/js/expenses/history.js" ></script>
<script type="text/javascript">
    var expense_types = <?php echo json_encode($expenseTypes); ?>;
    var payment_methods = <?php echo json_encode($expensePaymentMethod); ?>;
</script>