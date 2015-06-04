<?php echo form_open('expense-budget-items/capture'); ?>
<input type="hidden" name="budget-id" value="<?php echo $budgetId?>" />
<input type="hidden" name="expense-period-id" value="<?php echo $periodId?>" />
<div class="row ">
    <div class="large-4 columns">
        <h4>Expense Type</h4>
    </div>
    <div class="large-4 columns">
        <h4>Previous Spend</h4>
    </div>
    <div class="large-4 columns">
        <h4>Budgetted Amount</h4>
    </div>
</div>
<br/>
<?php
if (!empty($expenseTypesTotals)) {
    $count =1;
    foreach ($expenseTypesTotals as $k => $v) {
        ?>
        <div class="row ">
            <div class="large-4 columns">
                <?php echo $count." ".$expenseTypes[$k]["description"]; ?>
            </div>
            <div class="large-4 columns">
                <?php echo number_format($v["value"],2,".",""); ?>
            </div>
            <div class="large-4 columns">
                <input type="hidden" name="expenseType[]" value="<?php echo $expenseTypes[$k]["id"]; ?>" />
                <input type="number"  step="1.00" max="99999999999.99" name="amount[]" placeholder="0.00" value="<?php echo round($v["value"]); ?>"
                       name="epenseType[]" id="epenseType['<?php echo $k; ?>']" class="align-right"/>
            </div>
        </div>
        <?php
        $count += 1;
    }
}
?>
<div class="row ">
    <div class="large-4 columns">

    </div>
    <div class="large-4 columns">

    </div>
    <div class="large-4 columns">
        <span id="assignmenTxt">Unassigned Funds: </span><span id="unassigned" ><?php echo number_format($expenseBudget->total_limit - $expensesTotal, 2, ".", ","); ?></span>
    </div>
</div>
<div class="row ">
    <div class="large-4 columns">
        <h4>Totals</h4>
    </div>
    <div class="large-4 columns">
        <h4>Previous: <?php
            echo number_format($expensesTotal, 2, ".", ",");
            ?></h4>
    </div>
    <div class="large-4 columns">
        <h4>Budget Limit: <?php echo number_format($expenseBudget->total_limit, 2, ".", ","); ?></h4><input type="hidden" id="currentBudgetCeiling" value="<?php echo number_format($expenseBudget->total_limit, 2, ".", ","); ?>" />
    </div>
</div>
<br/><br/>
<div class="row ">
    <div class="large-4 columns">
        <input type="submit" name="submit" value="Create Budget Items" class="button"/>
    </div>
</div>
</form>
<br/>
<script type="text/javascript" src="/js/expense_budget_items/previous_period.js" ></script>