<br/>
<div class="row expanded">
    <div class="large-12 columns" >
        <?php echo form_open('income/stats') ?>
            <h2>Statistics for the period ( <?php echo floor((strtotime($startAndEndDateforMonth[1]) - strtotime($startAndEndDateforMonth[0])) / (60 * 60 * 24)) + 1; ?> days ) &nbsp;</h2>
    <div class="row expanded">
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
    <div class="row expanded">
        <div class="large-12 columns" >
            <input type="submit" name="filter" value="Filter" id="filter"  class="button"/>
        </div>
    </div>
</form>
<div class="row expanded">
    <div class="large-12 columns" >
        <?php if (!empty($incomesTotal)) { ?>
            <h3>Total Income This Period </h3>
            <p>Total: <?php echo number_format($incomesTotal, 2, ".", ","); ?></p>
            </br>
            <h3>Average Income Per Day</h3>
            <p>Total: <?php echo number_format($incomesTotal / floor((strtotime($startAndEndDateforMonth[1]) - strtotime($startAndEndDateforMonth[0])) / (60 * 60 * 24) + 1), 2, ".", ","); ?></p>
            <br/>
            <h3>Average Income Per Expense </h3>
            <p>Average: <?php echo number_format($averageIncome, 2, ".", ","); ?></p>
            </br>
            <h3>Total Number of Incomes For The Period </h3>
            <p>Number: <?php echo sizeOf($allIncomes); ?></p>
            </br>
        <?php } ?>
    </div>
</div>
<script type="text/javascript">
    var expense_period = <?php echo json_encode($expensePeriods); ?>;
    var default_start_date = "<?php echo $startAndEndDateforMonth[0]; ?>";
    var default_end_date = "<?php echo $startAndEndDateforMonth[1]; ?>";
</script>
<script type="text/javascript" src="/js/incomes/statistics.js"></script>