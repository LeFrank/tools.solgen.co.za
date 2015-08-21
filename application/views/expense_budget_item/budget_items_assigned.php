<div class="row ">
    <div class="large-12 columns">
        <table id="budget_expense_items" class="tablesorter hover-highlight focus-highlight widget-zebra">
            <input type="hidden" id="period-id" value="<?php echo $budgetId; ?>" />
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Category</th>
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
                $projected = 0;
                $overrage = 0;
                if (!empty($expenseBudgetItems)) {
                    $count = 1;
                    foreach ($expenseBudgetItems as $k => $v) {
                        $ttypes[$k] = true;
                        $valRemaining = ((array_key_exists($v["expense_type_id"], $expenseTypesTotals)) ? round($v["limit_amount"] - $expenseTypesTotals[$v["expense_type_id"]]["value"]) : round($v["limit_amount"]) );
                        ?>
                        <tr>
                            <td>
                                <?php echo $count; ?>
                            </td>
                            <td >
                                <?php echo $expenseTypes[$v["expense_type_id"]]["description"]; ?>
                            </td>
                            <td >
                                <?php echo $v["description"]; ?>
                            </td>
                            <td id="budget-amount" >
                                <?php echo number_format($v["limit_amount"], 2, ".", ""); ?>
                            </td>
                            <td id="spent-to-date" data-category="<?php echo $v["expense_type_id"]; ?>" 
                                data-expense-count="<?php echo ((array_key_exists($v["expense_type_id"], $expenseTypesTotals)) ? $expenseTypesTotals[$v["expense_type_id"]]["expenseCount"] : "0"); ?>"  
                                data-expense-ids="<?php echo ((array_key_exists($v["expense_type_id"], $expenseTypesTotals)) ? $expenseTypesTotals[$v["expense_type_id"]]["expenseIds"] : "0"); ?>"
                                >
                                    <?php
                                    echo ((array_key_exists($v["expense_type_id"], $expenseTypesTotals)) ? number_format($expenseTypesTotals[$v["expense_type_id"]]["value"], 2, ".", "") : "0.00" );
                                    $totalSpent = $totalSpent + ((array_key_exists($v["expense_type_id"], $expenseTypesTotals)) ? $expenseTypesTotals[$v["expense_type_id"]]["value"] : 0 );
                                    ?>&nbsp;&nbsp;(<?php echo ((array_key_exists($v["expense_type_id"], $expenseTypesTotals)) ? $expenseTypesTotals[$v["expense_type_id"]]["expenseCount"] : "0"); ?>)
                            </td>
                            <td id="remaining-for-period" data-category="<?php echo $v["expense_type_id"]; ?>" class="<?php
                            $percentage = 00;
                            if ($valRemaining == 0) {
                                echo "budget-item-complete";
                            } else if ($v["limit_amount"] != 0) {
                                $percentage = number_format(($valRemaining / $v["limit_amount"] * 100), 2, ".", "");
                                if ($percentage > 0 && $percentage <= 20) {
                                    echo "budget-item-danger";
                                } else if ($percentage > 20 && $percentage <= 50) {
                                    echo "budget-item-halfway";
                                } else if ($percentage > 50 && $percentage <= 100) {
                                    echo "budget-item-underspend";
                                } else if ($percentage < 0) {
                                    echo "budget-item-busted";
                                }
                            } else {
                                echo ($valRemaining < 0 ) ? "budget-item-busted" : "";
                            }
                            ?> ">
                                    <?php
                                    if ($valRemaining < 0) {
                                        $projected += abs($valRemaining);
                                        $overrage += $valRemaining;
                                    }
                                    echo number_format($valRemaining, 2, ".", "") . " (" . $percentage . "%)";
                                    ?>
                            </td>
                        </tr>
                        <?php
                        $count += 1;
                    }
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                    <td>
                        &nbsp;
                    </td>
                    <td>
                        &nbsp;
                    </td>
                    <td>
                        <h4>Budget Limit: <?php echo number_format($expenseBudget->total_limit, 2, ".", ""); ?></h4><input type="hidden" id="currentBudgetCeiling" value="<?php echo number_format($expenseBudget->total_limit, 2, ".", ","); ?>" />
                    </td>
                    <td>
                        <h4>Total Spent: <?php echo number_format($totalSpent, 2, ".", ","); ?></h4>
                    </td>
                    <td>
                        <h4>Current Status: <?php echo number_format($expenseBudget->total_limit - $totalSpent, 2, ".", ""); ?></h4>
                    </td>
                </tr>
            </tfoot>
        </table>
        <div class="row ">
            <div class="large-2 columns">  

            </div>
        </div>
        <div class="row ">
            <div class="large-12 columns">    
                <h4>
                    Projected For Period: <?php echo number_format($projected + $expenseBudget->total_limit, 2, ".", ","); ?>
                </h4>
                <br/>
                <?php
                if ($overrage < 0) {
                    ?>

                    <h4>
                        <?php
                        if ($overrage < 0) {
                            echo "Over By: " . number_format($overrage, 2, ".", ",");
                        }
                        ?>
                    </h4>
                <?php } ?>
            </div>
        </div>
        <br/>
    </div>
</div>
<div class="row ">
    <div class="large-12 columns">
        <label>Legend</label>
        <span class="budget-item-complete">Black = Budget item spend completed</span><br/>
        <span class="budget-item-busted">Red = Over Budget</span><br/>
        <span class="budget-item-underspend">Green = Less than half spent</span><br/>
        <span class="budget-item-halfway">Blue = Less than 80% spent</span><br/>
        <span class="budget-item-danger">Orange = Final 20% of spend, nearing full spend</span>
    </div>
</div>
<link rel="stylesheet" href="/css/third_party/thickbox/thickbox.css" type="text/css" media="screen" />
<script src="/js/third_party/jquery-ui.custom.min.js" type="text/javascript" ></script>
<script type="text/javascript" src="/js/third_party/thickbox-compressed.js"></script>
<script type="text/javascript" src="/js/third_party/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="/js/expense_budget_items/items.js" ></script>