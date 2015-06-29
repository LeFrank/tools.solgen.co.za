<?php
// Offer choice.<br/>Use the actual expenses per type from the expense period of your choice for your baseline.
// <br/><br/><strong>OR</strong><br/><br/>
// Chose a previous months budget as your baseline
// <br/><br/><strong>OR</strong><br/><br/>
// Create items individually
?>
<div class="row ">
    <div class="large-12 columns">
        <div id="expense-period-manage-feedback" class="hidden"></div>
        <h3>Budget Limits For Period: <?php echo $expenseBudget->name; ?></h3>
        <p>Description: <?php echo $expenseBudget->description; ?></p>

    </div>
</div>
<div class="row ">
    <div class="large-12 columns">
        <div>
            <p>Expense Type Limits</p>
            <?php
            if (empty($expenseBudgetItems)) {
                echo "Create Items<br/>";
                ?>
                <div class="row ">
                    <div class="large-4 columns">
                        <input type="button" value="Use Expenses from Previous Period" 
                               class="button secondary" name="periodBtn" id="periodBtn" />
                    </div>
                    <div class="large-4 columns">
                        <input type="button" value="Use Previous Budget" 
                               class="button secondary" name="budgetBtn" id="budgetBtn" />
                    </div>
                    <div class="large-4 columns">
                        <input type="button" value="Use Expense Types" 
                               class="button secondary" name="typesBtn" id="typesBtn"/>
                    </div>
                </div>
                <div id="baselineItems" class="hidden">

                </div>
                <?php
            } else {
                echo "Show items";
            }
            ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    var budgetId = <?php echo $expenseBudget->id;?>;
    var periodId = <?php echo $expenseBudget->expense_period_id;?>;
</script>
<script type="text/javascript" src="/js/expense_budget_items/manage.js" ></script>