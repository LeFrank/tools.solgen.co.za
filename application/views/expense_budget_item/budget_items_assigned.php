<div class="row ">
    <div class="large-12 columns">
        <table id="expense_history" class="tablesorter">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Description</th>
                    <th>Budgetted Amount</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $ttypes = array();
                if (!empty($expenseBudgetItems)) {
                    $count = 1;
                    foreach ($expenseBudgetItems as $k => $v) {
                        $ttypes[$k] = true;
                        ?>
                        <tr>
                            <td>
                                <?php echo $count; ?>
                            </td>
                            <td>
                                <?php echo $expenseTypes[$v["expense_type_id"]]["description"]; ?>
                            </td>
                            <td>
                                <?php echo round($v["limit_amount"]); ?>
                            </td>
                        </tr>
                        <?php
                        $count += 1;
                    }
                }
                ?>
                <tr>
                    <td>
                        <h4>Totals</h4>
                    </td>
                    <td>
                    </td>
                    <td>
                        <h4>Budget Limit: <?php echo number_format($expenseBudget->total_limit, 2, ".", ","); ?></h4><input type="hidden" id="currentBudgetCeiling" value="<?php echo number_format($expenseBudget->total_limit, 2, ".", ","); ?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
            </tbody>
        </table>
        <br/>
    </div>
</div>
<script type="text/javascript" src="/js/expense_budget_items/previous_period.js" ></script>