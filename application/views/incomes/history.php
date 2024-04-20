
<?php ?>
<div class="row expanded">
    <div class="large-3 columns" >
        <div class="row expanded">
            <div class="large-12 columns" >
                <div id="incomeHistoryFilter" class="incomeHistoryFilter">
                    <h3>Filter incomes History</h3>
                    <div id="validation_errors" ></div>
                    <form accept-charset="utf-8" method="post" action="/incomes/export" id="filterIncomeForm" >
                        <div class="row">
                            <div class="large-6 columns">
                                <label> Filter by Period
                                </label>
                            </div>
                            <div class="large-6 columns">
                                <select id="incomePeriod" name="incomePeriod">
                                    <option value="0">Current Month</option>
                                    <?php
                                    foreach ($incomePeriods as $k => $v) {
                                        echo "<option value='" . $v["id"] . "'>" . $v["name"] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-6 columns">
                                <label> Date From
                                    <input type="text" autocomplete="off" name="fromDate" id="fromDate" value="<?php echo $startAndEndDateforMonth[0]; ?>"/>
                                </label>
                            </div>
                            <div class="large-6 columns">
                                <label>
                                    Date To<input type="text" autocomplete="off" name="toDate" id="toDate" value="<?php echo $startAndEndDateforMonth[1]; ?>"/>
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
                                <input type="button" name="filter" value="Filter" id="filter" class="button" />
                                <input type="button" name="export" value="Export To CSV" id="export" class="button secondary" onClick="submit()"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-12 columns">
                                <label>Income Types</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-12 columns">
                                <div class="row">
                                    <div class="large-6 columns">
                                        <input type="checkbox" checked="checked" value="all" name="incomeType[]" />
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
                                <input type="button" name="export" value="Export To CSV" id="export" class="button secondary" onClick="submit()"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="large-9 columns" >
        <div class="row expanded">
            <div class="large-12 columns" >
                <?php echo $history_table; ?>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
<script type="text/javascript" src="/js/jquery.datetimepicker.js" ></script>
<script type="text/javascript" src="/js/third_party/handlebars-v1.3.0.js" ></script>
<script type="text/javascript" src="/js/third_party/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="/js/incomes/history.js" ></script>
<script type="text/javascript">
    var expense_types = <?php echo json_encode($expenseTypes); ?>;
    var payment_methods = <?php echo json_encode($expensePaymentMethod); ?>;
    var expense_period = <?php echo json_encode($expensePeriods); ?>;
    var default_start_date = "<?php echo $startAndEndDateforMonth[0]; ?>";
    var default_end_date = "<?php echo $startAndEndDateforMonth[1]; ?>";
</script>