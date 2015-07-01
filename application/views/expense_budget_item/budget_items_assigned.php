<div class="row ">
    <div class="large-12 columns">
        <table id="budget_expense_items" class="tablesorter">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Description</th>
                    <th>Budgetted Amount</th>
                    <th>Spent So Far</th>
                    <th>Remaining This Period</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $ttypes = array();
                $totalSpent = 0;
                $totalRemaining = 0;
                if (!empty($expenseBudgetItems)) {
                    $count = 1;
                    foreach ($expenseBudgetItems as $k => $v) {
                        $ttypes[$k] = true;
                        $valRemaining = ((array_key_exists($v["expense_type_id"], $expenseTypesTotals))?round( $v["limit_amount"] - $expenseTypesTotals[$v["expense_type_id"]]["value"]) : round( $v["limit_amount"]) );
                        
                        ?>
                        <tr>
                            <td>
                                <?php echo $count; ?>
                            </td>
                            <td>
                                <?php echo $expenseTypes[$v["expense_type_id"]]["description"]; ?>
                            </td>
                            <td class="align-right">
                                <?php echo number_format($v["limit_amount"] , 2, ".", ""); ?>
                            </td>
                            <td class="align-right">
                                <?php 
                                    echo ((array_key_exists($v["expense_type_id"], $expenseTypesTotals))?  number_format($expenseTypesTotals[$v["expense_type_id"]]["value"] , 2, ".", "") : "0.00" ); 
                                    $totalSpent = $totalSpent + ((array_key_exists($v["expense_type_id"], $expenseTypesTotals))? $expenseTypesTotals[$v["expense_type_id"]]["value"] : 0 );
                                ?>
                            </td>
                            <td class="<?php echo ($valRemaining < 0 )?"budget-item-busted":""; ?> align-right">
                                <?php echo number_format($valRemaining , 2, ".", ""); ?>
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
                        <h4>Budget Limit: <?php echo number_format($expenseBudget->total_limit, 2, ".", ""); ?></h4><input type="hidden" id="currentBudgetCeiling" value="<?php echo number_format($expenseBudget->total_limit, 2, ".", ","); ?>" />
                    </td>
                    <td>
                        <h4><?php echo number_format($totalSpent, 2, ".", ","); ?></h4>

                    </td>
                    <td>
                        <h4><?php echo number_format($expenseBudget->total_limit - $totalSpent, 2, ".", ""); ?></h4>
                    </td>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                    </td>
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
<script type="text/javascript" src="/js/third_party/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="/js/expense_budget_items/items.js" ></script>