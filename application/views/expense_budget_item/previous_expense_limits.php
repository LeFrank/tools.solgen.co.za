<?php echo form_open('expense-budget-items/capture'); ?>
<input type="hidden" name="budget-id" id="budget-id" value="<?php echo $budgetId ?>" />
<input type="hidden" name="expense-period-id" value="<?php echo $periodId ?>" />
<div class="row expanded">
    <div class="large-12 columns">
        <table id="expense_history" class="tablesorter">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Description</th>
                    <th>Previous Budgetted Amount</th>
                    <th>Previous Spend</th>
                    <th>Budgetted Amount</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php
//                echo "<pre>";
//                print_r($wishlistItemsForPeriod);
//                echo "</pre>";
                $ttypes = array();
                $expenseTotalRunning = $expensesTotal;
                if (!empty($expenseTypesTotals)) {
                    $count = 1;
                    foreach ($expenseTypesTotals as $k => $v) {
                        $ttypes[$k] = true;
                        $wishlistItem = array("name" => "", "cost" => 0);
                        foreach ($wishlistItemsForPeriod as $kk => $vv) {
                            if ($expenseTypes[$k]["id"] == $vv["expense_type_id"]) {
//                                echo $vv["expense_type_id"] ." name: ".$vv["name"].", value: ". $vv["cost"]. "<br/>";
                                $wishlistItem["name"] = $vv["name"] . ", ";
                                $wishlistItem["cost"] += $vv["cost"];
                                $expenseTotalRunning += $vv["cost"];
                            }
                        }
                        ?>
                        <tr>
                            <td>
                                <?php echo $count; ?>
                            </td>
                            <td>
                                <?php echo $expenseTypes[$k]["description"]; ?>
                            </td>
                            <td>
                                <?php
                                if (isset($previousExpenseBudgetItems[$expenseTypes[$k]["id"]]["limit_amount"])) {
                                    echo number_format($previousExpenseBudgetItems[$expenseTypes[$k]["id"]]["limit_amount"], 2, ".", "");
                                } else {
                                    echo "0.00";
                                }
                                ?>
                            </td>
                            <td id="previous-period-type" data-category="<?php echo $expenseTypes[$k]["id"]; ?>" 
                                data-expense-count="<?php echo ((array_key_exists($expenseTypes[$k]["id"], $expenseTypesTotals)) ? $expenseTypesTotals[$expenseTypes[$k]["id"]]["expenseCount"] : "0"); ?>"  
                                data-expense-ids="<?php echo ((array_key_exists($expenseTypes[$k]["id"], $expenseTypesTotals)) ? $expenseTypesTotals[$expenseTypes[$k]["id"]]["expenseIds"] : "0"); ?>"
                                >
        <?php echo number_format($v["value"], 2, ".", ""); ?>
                                &nbsp;&nbsp;(<?php echo ((array_key_exists($expenseTypes[$k]["id"], $expenseTypesTotals)) ? $expenseTypesTotals[$expenseTypes[$k]["id"]]["expenseCount"] : "0"); ?>)
                            </td>
                            <td>
                                <input type="hidden" name="expenseType[]" value="<?php echo $expenseTypes[$k]["id"]; ?>" />
                                <input type="number"  step="1.00" max="99999999999.99" name="amount[]" placeholder="0.00" value="<?php echo round($v["value"] + ((!empty($wishlistItem)) ? $wishlistItem["cost"] : 0)); ?>"
                                       name="epenseType[]" id="epenseType['<?php echo $k; ?>']" class="align-right"/>
                            </td>
                            <td>
                                <input type="text"  name="description[]" placeholder="list the expenses you forsee" value="<?php echo (!empty($wishlistItem)) ? $wishlistItem["name"] : ""; ?>"
                                       name="description[]" id="description['<?php echo $k; ?>']" />
                            </td>
                        </tr>
                        <?php
                        $count += 1;
                    }
                    foreach ($expenseTypes as $k => $v) {
                        if (!array_key_exists($k, $ttypes)) {
                            $wishlistItem = array("name" => "", "cost" => 0);
                            foreach ($wishlistItemsForPeriod as $kk => $vv) {
                                if ($expenseTypes[$k]["id"] == $vv["expense_type_id"]) {
//                                    echo $vv["expense_type_id"] ." name: ".$vv["name"].", value: ". $vv["cost"]. "<br/>";
                                    $wishlistItem["name"] = $vv["name"] . ", ";
                                    $wishlistItem["cost"] += $vv["cost"];
                                    $expenseTotalRunning += $vv["cost"];
                                }
                            }
                            ?>
                            <tr>
                                <td>
                                    <?php echo $count; ?>
                                </td>
                                <td>
            <?php echo $expenseTypes[$k]["description"]; ?>
                                </td>
                                <td>
                                    0.00
                                </td>
                                <td>
                                    0.00
                                </td>
                                <td>
                                    <input type="hidden" name="expenseType[]" value="<?php echo $v["id"]; ?>" />
                                    <input type="number"  step="1.00" max="99999999999.99" name="amount[]" placeholder="0.00" value="<?php echo ((!empty($wishlistItem)) ? $wishlistItem["cost"] : "0.00") ?>"
                                           name="epenseType[]" id="epenseType['<?php echo $k; ?>']" class="align-right"/>
                                </td>
                                <td>
                                    <input type="text"  name="description[]" placeholder="list the expenses you forsee" value="<?php echo (!empty($wishlistItem)) ? $wishlistItem["name"] : ""; ?>"
                                           name="description[]" id="description['<?php echo $k; ?>']" />
                                </td>

                            </tr>
                            <?php
                            $count += 1;
                        }
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
                        <h4>Previous: <?php
                echo number_format($expensesTotal, 2, ".", ",");
                ?></h4>
                    </td>
                    <td>
                        <h4>Budget Limit: <?php echo number_format($expenseBudget->total_limit, 2, ".", ","); ?></h4><input type="hidden" id="currentBudgetCeiling" value="<?php echo number_format($expenseBudget->total_limit, 2, ".", ","); ?>" />
                    </td>
                    <td>
                        <h4><span id="assignedTxt">Assigned Funds: </span><span id="assigned" ><?php echo number_format($expenseTotalRunning, 2, ".", ","); ?></span></h4>
                        <input type="hidden" id="runningAssignedTotal" value="<?php echo $expenseTotalRunning; ?>" />
                    </td>
                    <td>
                        <h4><span id="assignmenTxt"><?php echo (($expenseBudget->total_limit - $expenseTotalRunning) > 0 ) ?"Unassigned Funds: " : "Items Overrun Limit by: " ;?></span><span id="unassigned" ><?php echo number_format($expenseBudget->total_limit - $expenseTotalRunning, 2, ".", ","); ?></span></h4>
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
                </tr>
            </tbody>
        </table>
        <br/>
        <div class="row ">
            <div class="large-4 columns">
                <input type="submit" name="submit" value="Create Budget Items" class="button"/>
            </div>
        </div>
        </form>
    </div>
</div>
<link rel="stylesheet" href="/css/third_party/thickbox/thickbox.css" type="text/css" media="screen" />
<script src="/js/third_party/jquery-ui.custom.min.js" type="text/javascript" ></script>
<script type="text/javascript" src="/js/third_party/thickbox-compressed.js"></script>
<script type="text/javascript" src="/js/third_party/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="/js/expense_budget_items/previous_period.js" ></script>