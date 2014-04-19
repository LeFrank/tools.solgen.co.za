<?php ?>
<div id="expenseHistoryContent" class="expenseHistoryContent" >
    <h2>Expense History</h2>
    <div id="historyGraph">
        Graph of the full data for the last week?
        <pre>
            <?php print_r($expensesForWeek); ?>
        </pre>
    </div>
</div>
<div id="expenseHistoryFilter" class="expenseHistoryFilter">
    <h3>Filter Expenses History</h3>
    <div id="validation_errors" ></div>
    <div>
        <label>Date</label>
        From &nbsp;
        <input type="text" id="fromDate" value="<?php echo $startAndEndDateOfWeek[0]; ?>"/>
        &nbsp;&nbsp;
        To&nbsp;<input type="text" id="toDate" value="<?php echo $startAndEndDateOfWeek[1]; ?>"/>
    </div>
    <div>
        <label>Amount</label>
        From &nbsp;
        <input type="text" id="fromAmount" value="0" />
        &nbsp;&nbsp;
        To&nbsp;<input type="text" id="toAmount" value="0" />
    </div>
    <div >
        <label>Keyword</label>
        <input type="text" id="keyword" value="" />
    </div>
    <div>
        <div class="inline-block div-label" style="vertical-align: top;padding-top: 10px;">Expense Types</label></div>
        <div class="inline-block three-col" style="vertical-align: top;padding-top: 10px;">
            <input type="checkbox" checked="checked" value="all" />all<br/>
            <?php
            foreach ($expenseTypes as $k => $v) {
                echo "<input type='checkbox' value='" . $v["id"] . "' />" . $v["description"]."<br/>";
            }
            ?>
        </div>
    </div>
    <input type="button" name="filter" value="Filter" />
</form>

</div>
<script type="text/javascript">
    $(function() {
        $("#fromDate").datetimepicker();
        $("#toDate").datetimepicker();
    });
</script>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css"/ >
<script src="/js/jquery.datetimepicker.js"></script>