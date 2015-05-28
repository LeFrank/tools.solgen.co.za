<div class="row">
    <div class="large-12 columns" >
        <?php echo form_open('expenses/statistics') ?>

        <h2>Statistics for the period ( <?php echo floor((strtotime($startAndEndDateforMonth[1]) - strtotime($startAndEndDateforMonth[0])) / (60 * 60 * 24)) + 1; ?> days ) &nbsp;</h2>
    </div>
</div>
<div class="row">
    <div class="large-4 columns" >
        <label> Filter by Period
            <select id="expensePeriod" name="expensePeriod">
                <option value="0">Current Month</option>
                <?php
                foreach ($expensePeriods as $k => $v) {
                    echo "<option value='" . $v["id"] . "'>" . $v["name"] . "</option>";
                }
                ?>
            </select>
        </label>
    </div>
    <div class="large-4 columns" >
        <label>
            from<input type="text" name="fromDate" id="fromDate" value="<?php echo $startAndEndDateforMonth[0]; ?>"/>
        </label>
    </div>
    <div class="large-4 columns" >
        <label>
            To<input type="text" name="toDate" id="toDate" value="<?php echo $startAndEndDateforMonth[1]; ?>"/> 
        </label>
    </div>
</div>
<div class="row">
    <div class="large-12 columns" >
        <input type="submit" name="filter" value="Filter" id="filter"  class="button"/>
    </div>
</div>
<div class="row">
    <div class="large-12 columns" >
        <?php if (!empty($expensesTotal)) { ?>
            <h3>Total Spent This Period </h3>
            <p>Total: <?php echo number_format($expensesTotal, 2, ".", ","); ?></p>
            </br>
            <h3>Average Spent Per Day</h3>
            <p>Total: <?php echo number_format($expensesTotal / floor((strtotime($startAndEndDateforMonth[1]) - strtotime($startAndEndDateforMonth[0])) / (60 * 60 * 24) + 1), 2, ".", ","); ?></p>
            <br/>
            <h3>Average Cost Per Expense </h3>
            <p>Average: <?php echo number_format($averageExpense, 2, ".", ","); ?></p>
            </br>
            <h3>Total Number of Expenses For The Period </h3>
            <p>Number: <?php echo sizeOf($allExpenses); ?></p>
            </br>
            <h3>Top 5 Individual Expenses </h3>
            <div id="top-five-expense-types" >
                <table class="full-width">
                    <thead>
                    <th>Position</th>
                    <th>Expense Type</th>
                    <th>Payment Method</th>
                    <th>Value</th>
                    <th>Expense Date</th>
                    <th>Description</th>
                    </thead>
                    <tbody>
                        <?php
                        $top5Expenses = 1;
                        foreach ($topFiveExpenses as $k => $v) {
                            echo "<tr>";
                            echo "<td>" . $top5Expenses . "</td>";
                            echo "<td>" . $expenseTypes[$v["expense_type_id"]]["description"] . "</td>";
                            echo "<td>" . $expensePaymentMethod[$v["payment_method_id"]]["description"] . "</td>";
                            echo "<td>" . number_format($v["amount"], 2, ".", ",") . "</td>";
                            echo "<td>" . $v["expense_date"] . "</td>";
                            echo "<td>" . $v["description"] . "</td>";
                            echo "</tr>";
                            $top5Expenses++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            </br>
            <h3>Top 5 Expense Types</h3>
            <div id="top-five-expense-types" >
                <table class="full-width">
                    <thead>
                    <th>Position</th>
                    <th>Expense Type</th>
                    <th>Value</th>
                    <th>Number of Expenses</th>
                    <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php
                        $top5ExpenseTypes = 1;
                        foreach ($topFiveExpenseTypes as $k => $v) {
                            echo "<tr>";
                            echo "<td>" . $top5ExpenseTypes . "</td>";
                            echo "<td>" . $expenseTypes[$k]["description"] . "</td>";
                            echo "<td>" . number_format($v["value"], 2, ".", ",") . "</td>";
                            echo "<td>" . $v["expenseCount"] . "</td>";
                            echo "<td><a href='/expenses/getExpenses/" . implode("-", explode(",", $v["expenseIds"])) . "?keepThis=true&TB_iframe=true&width=850&height=500' title='Expenses' class='thickbox'>View Expense(s)</a>&nbsp;&nbsp;</td>";
                            echo "</tr>";
                            $top5ExpenseTypes++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <br/>
            <h3>Expenses Type Totals</h3>
            <div id="expense-type-totals">    
            </div>
            </br>
            <h3>Top 5 Payment Methods</h3>
            <?php if (!empty($topFivePaymentMethods) && !array_key_exists("0", $topFivePaymentMethods)) { ?>
                <div id="top-five-payment-methods" >
                    <table class="full-width">
                        <thead>
                        <th>Position</th>
                        <th>Payment Method</th>
                        <th>Value</th>
                        <th>Number of Expenses</th>
                        <th>Actions</th>
                        </thead>
                        <tbody>
                            <?php
                            $top5PaymentMethods = 1;
                            foreach ($topFivePaymentMethods as $k => $v) {
                                echo "<tr>";
                                echo "<td>" . $top5PaymentMethods . "</td>";
                                echo "<td>" . $expensePaymentMethod[$k]["description"] . "</td>";
                                echo "<td>" . number_format($v["value"], 2, ".", ",") . "</td>";
                                echo "<td>" . $v["expenseCount"] . "</td>";
                                echo "<td><a href='/expenses/getExpenses/" . implode("-", explode(",", $v["expenseIds"])) . "?keepThis=true&TB_iframe=true&width=850&height=500' title='Expenses' class='thickbox'>View Expense(s)</a>&nbsp;&nbsp;</td>";
                                echo "</tr>";
                                $top5PaymentMethods++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
            <br/>
            <h3>Payment Method Totals</h3>
            <div id="payment-method-totals">    
            </div>
            </br>
            </br>
            <h3>Top 5 Locations</h3>
            <div id="top-five-locations" >
                <table class="full-width">
                    <thead>
                    <th>Position</th>
                    <th>Location</th>
                    <th>Value</th>
                    <th>Number of Expenses</th>
                    <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php
                        $top5Location = 1;
                        foreach ($topFiveLocations as $k => $v) {
                            echo "<tr>";
                            echo "<td>" . $top5Location . "</td>";
                            echo "<td>" . $k . "</td>";
                            echo "<td>" . number_format($v["value"], 2, ".", ",") . "</td>";
                            echo "<td>" . $v["expenseCount"] . "</td>";
                            echo "<td><a href='/expenses/getExpenses/" . implode("-", explode(",", $v["expenseIds"])) . "?keepThis=true&TB_iframe=true&width=850&height=500' title='Expenses' class='thickbox'>View Expense(s)</a>&nbsp;&nbsp;</td>";
                            echo "</tr>";
                            $top5Location++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            </br>
            <h3>Expenses over time period</h3>
            <div id="expenses-over-time-period" ></div>
            </br>
            <h3>Day of week on which expenses occurred over the selected period.</h3>
            <div id="days-on-which-expenses-were-made" ></div>
            </br>
            <br/>
            <h3>Hour of the day when expenses occurred over the selected period</h3>
            <div id="expenses-per-hour-over-period" ></div>
            </br>
        </div>
    </div>
    <script type="text/javascript">

        /**
         * Expense Type Total Graph data start
         */
        var expenseTotals = [
    <?php
    $expenseTotalCount = 1;
    foreach ($expenseTypesTotals as $k => $v) {
        if ($expenseTotalCount == 1) {
            $max = round($v["value"], 0);
        }
        echo '"' . round($v["value"], 0) . '"' . ((sizeOf($expenseTypesTotals) != $expenseTotalCount) ? ',' : '');
        $expenseTotalCount++;
    }
    ?>
        ];

        var max = <?php echo round($max + 500, -3); ?>;
        var expenseTotalNames = [
    <?php
    $expenseTotalNameCount = 1;
    foreach ($expenseTypesTotals as $k => $v) {
        echo '"' . $expenseTypes[$k]["description"] . '"' . ((sizeOf($expenseTypesTotals) != $expenseTotalNameCount) ? ',' : '');
        $expenseTotalCount++;
    }
    ?>
        ];

        var expenseTypeIdsForTotals = [<?php
    $expenseTotalIdCounts = 1;
    foreach ($expenseTypesTotals as $k => $v) {
        $expenseIdArr = explode(",", $v["expenseIds"]);
        $expenseIdArr = array_filter($expenseIdArr);
        $expenseIds = implode("-", $expenseIdArr);
        echo '["' . $expenseIds . '"]' . ((sizeOf($expenseTypesTotals) != $expenseTotalIdCounts) ? ',' : '');
        $expenseTotalIdCounts++;
    }
    ?>
        ];
        /**
         * Expense Type Total Graph Data end
         */


        /**
         * Payment Method Total Graph data start
         */
        var line1 = <?php echo $expensesOverPeriod; ?>;
        var allExpenses = <?php echo json_encode($allExpenses); ?>;
        // for the days-on-which-expenses-were-made graph
        var dayOfWeekData = [
    <?php
    $countWeek = 1;
    foreach ($expensesByDayOfWeek as $k => $v) {
        echo '["' . $daysOfWeek[$k] . ' - ' . $v["value"] . '",  ' . $v["value"] . ']' . ((sizeOf($expensesByDayOfWeek) != $countWeek) ? ',' : '');
        $countWeek++;
    }
    ?>
        ];

        var paymentMethodTotals = [
    <?php
    $paymentMethodsTotalCount = 1;
    foreach ($paymentMethodsTotal as $k => $v) {
        if ($paymentMethodsTotalCount == 1) {
            $paymentMethodTotalMax = round($v["value"], 0);
        }
        echo '"' . round($v["value"], 0) . '"' . ((sizeOf($paymentMethodsTotal) != $paymentMethodsTotalCount) ? ',' : '');
        $paymentMethodsTotalCount++;
    }
    ?>
        ];
        var paymentMethodTotalMax = <?php echo round($paymentMethodTotalMax + 500, -3); ?>;
        var paymentMethodTotalsNames = [
    <?php
    $paymentMethodNamesCount = 1;
    foreach ($paymentMethodsTotal as $k => $v) {
        echo '"' . $expensePaymentMethod[$k]["description"] . '"' . ((sizeOf($paymentMethodsTotal) != $paymentMethodNamesCount) ? ',' : '');
        $paymentMethodNamesCount++;
    }
    ?>
        ];

        var paymentMethodIdsForTotals = [<?php
    $paymentTotalIdCounts = 1;
    foreach ($paymentMethodsTotal as $k => $v) {
        $expenseIdArr = explode(",", $v["expenseIds"]);
        $expenseIdArr = array_filter($expenseIdArr);
        $expenseIds = implode("-", $expenseIdArr);
        echo '["' . $expenseIds . '"]' . ((sizeOf($paymentMethodsTotal) != $paymentTotalIdCounts) ? ',' : '');
        $paymentTotalIdCounts++;
    }
    ?>
        ];
        /**
         * Payment Method Total Graph data end
         */

        var expenseIdsForDayOfWeek = [<?php
    $countWeekIds = 1;
    foreach ($expensesByDayOfWeek as $k => $v) {
        $expenseIdArr = explode(",", $v["expenseIds"]);
        $expenseIdArr = array_filter($expenseIdArr);
        $expenseIds = implode("-", $expenseIdArr);
        echo '["' . $expenseIds . '"]' . ((sizeOf($expensesByDayOfWeek) != $countWeekIds) ? ',' : '');
        $countWeekIds++;
    }
    ?>
        ];
        // for the hour of day graph
        hours = ['00h', '01h', '02h', '03h', '04h', '05h',
            '06h', '07h', '08h', '09h', '10h', '11h',
            '12h', '13h', '14h', '15h', '16h', '17h',
            '18h', '19h', '20h', '21h', '22h', '23h'];
        var amount = [
    <?php
    $countHourAmount = 0;
    foreach ($expensesByHourOfDay as $k => $v) {
        echo $v["value"] . ((sizeOf($expensesByHourOfDay) != $countHourAmount) ? ',' : '');
        $countHourAmount++;
    }
    ?>
        ];

        var expenseCount = [<?php
    $countHourCount = 0;
    foreach ($expensesByHourOfDay as $k => $v) {
        echo $v["expenseCount"] . ((sizeOf($expensesByHourOfDay) != $countHourCount) ? ',' : '');
        $countHourCount++;
    }
    ?>
        ];
        var expense_period = <?php echo json_encode($expensePeriods); ?>;
        var default_start_date = "<?php echo $startAndEndDateforMonth[0]; ?>";
        var default_end_date = "<?php echo $startAndEndDateforMonth[1]; ?>";
    </script>
    <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
    <link rel="stylesheet" href="/css/third_party/thickbox/thickbox.css" type="text/css" media="screen" />
    <script type="text/javascript" src="/js/jquery.datetimepicker.js" ></script>
    <script type="text/javascript" src="/js/third_party/jqplot/jquery.jqplot.min.js"></script>
    <script type="text/javascript" src="/js/third_party/jqplot/plugins/jqplot.barRenderer.min.js"></script>
    <script type="text/javascript" src="/js/third_party/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
    <script type="text/javascript" src="/js/third_party/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
    <script type="text/javascript" src="/js/third_party/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
    <script type="text/javascript" src="/js/third_party/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
    <script type="text/javascript" src="/js/third_party/jqplot/plugins/jqplot.logAxisRenderer.min.js"></script>
    <script type="text/javascript" src="/js/third_party/jqplot/plugins/jqplot.highlighter.min.js"></script>
    <script type="text/javascript" src="/js/third_party/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/third_party/jqplot/jquery.jqplot.min.css" />
    <script type="text/javascript" src="/js/third_party/thickbox-compressed.js"></script>
    <script type="text/javascript" src="/js/expenses/statistics.js"></script>
    <?php
} else {
    echo "<h3>No Expenses Have Been Captured This Period </h3>";
}?>