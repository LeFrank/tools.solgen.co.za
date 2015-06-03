<?php ?>

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
//            print_r($expenseTypes);
if (!empty($expenseTypesTotals)) {
    foreach ($expenseTypesTotals as $k => $v) {
        ?>
        <div class="row ">
            <div class="large-4 columns">
                <?php echo $expenseTypes[$k]["description"]; ?>
            </div>
            <div class="large-4 columns">
                <?php echo $v["value"]; ?>
            </div>
            <div class="large-4 columns">
                <input type="number" min="0.01" step="0.01" max="9999999999999" name="amount" placeholder="0.00" value="<?php echo $v["value"]; ?>" 
                       name="epenseType[]" id="epenseType<?php echo $k; ?>"/>
            </div>
        </div>
        <?php
    }
} 
?>
<div class="row ">
    <div class="large-4 columns">
        <h4>Totals</h4>
    </div>
    <div class="large-4 columns">
        <h4>Previous: <?php echo number_format($expensesTotal, 2, ".", ",");; ?></h4>
    </div>
    <div class="large-4 columns">
        <h4>Budget Limit: <?php echo number_format($expenseBudget->total_limit, 2, ".", ","); ?></h4>
    </div>
</div>
<br/>
<script type="text/javascript" src="/js/expense_budget_items/previous_period.js" ></script>