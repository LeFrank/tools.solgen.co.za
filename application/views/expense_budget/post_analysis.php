<?php
$finalOutcome = number_format($totalSpent - $expenseBudget->total_limit, 2, ".", ",");
$overSpent = (($finalOutcome >= 0 ) ? TRUE : FALSE);
?>
<div class="row ">
    <div class="large-12 columns">
        <input type="hidden" name="budgetId" id="budgetId" value="<?php echo $budgetId; ?>" />
        <h2>
            <?php echo "Period: ". $expensePeriod->name;?>
        </h2>
        <h3>
            Goal: <?php echo $expenseBudget->description; ?>
        </h3>
        <p>
            How much did I spend in total?: <?php echo number_format($totalSpent, 2, ".", ","); ?>
        </p>
        <p>
            What was the limit of the period?: <?php echo number_format($expenseBudget->total_limit, 2, ".", ","); ?>
        </p>
        <p>
            How many days in this period?: <?php echo floor((strtotime($expensePeriod->end_date) - 
                    strtotime($expensePeriod->start_date)) / (60 * 60 * 24) + 1); ?> days 
                    ( <?php echo date('Y/m/d H:i',strtotime($expensePeriod->start_date)) . 
                            " to ". date('Y/m/d H:i', strtotime($expensePeriod->end_date)); ?> )
        </p>
        <p>
            Do I go over the total budget?: <?php echo (($overSpent) ? "Yes" : "No") ?>
        </p>
        <p>
            I was <strong><?php echo (($overSpent) ? "OVER" : "UNDER") ?></strong> by: <?php echo $finalOutcome; ?>
        </p>
        <p>
            Categories over spent: <?php echo $overSpentCategories["count"]; ?>
        </p>
        <p>
            Over spent total: <?php echo number_format($overSpentCategories["limitTotal"] - $overSpentCategories["amount"], 2, ".", ",");?> 
            on a limit of <?php echo number_format($overSpentCategories["limitTotal"], 2, ".", ","); ?> <br/>
        </p>
        <table id="budget_expense_items_over" class="tablesorter hover-highlight focus-highlight widget-zebra">
            <input type="hidden" id="period-id" value="<?php echo $budgetId; ?>" />
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Budgetted Amount</th>
                    <th>Spent</th>
                    <th># Expenses</th>
                    <th>Over By</th>
                    <th>Over By %</th>
                    <th>Comment</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $ttypes = array();
                $totalSpent = 0;
                $totalExpenses = 0;
                $totalRemaining = 0;
                $projected = 0;
                $overrage = 0;
                if (!empty($expenseBudgetItems)) {
                    $count = 1;
                    foreach ($expenseBudgetItems as $k => $v) {
                        if ($v["amount_sign"] == "-") {
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
                                        ?>
                                </td>
                                <td id="spent-to-date" data-category="<?php echo $v["expense_type_id"]; ?>" 
                                    data-expense-count="<?php echo ((array_key_exists($v["expense_type_id"], $expenseTypesTotals)) ? $expenseTypesTotals[$v["expense_type_id"]]["expenseCount"] : "0"); ?>"  
                                    data-expense-ids="<?php echo ((array_key_exists($v["expense_type_id"], $expenseTypesTotals)) ? $expenseTypesTotals[$v["expense_type_id"]]["expenseIds"] : "0"); ?>"
                                    >
                                        <?php
                                        $totalExpenses += ((array_key_exists($v["expense_type_id"], $expenseTypesTotals)) ? $expenseTypesTotals[$v["expense_type_id"]]["expenseCount"] : "0");
                                        echo ((array_key_exists($v["expense_type_id"], $expenseTypesTotals)) ? $expenseTypesTotals[$v["expense_type_id"]]["expenseCount"] : "0");
                                        ?>
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
                                        echo number_format(abs($valRemaining), 2, ".", "");
                                        ?>
                                </td>
                                <td>
                                    <?php
                                    echo abs($percentage);
                                    ?>
                                </td>
                                <td>
                                    <input type="hidden" name="id" id="id" value="<?php echo $v["id"]; ?>" />
                                    <textarea name="comment_<?php echo $v["id"]; ?>" 
                                        id="comment_<?php echo $v["id"]; ?>" 
                                        onkeyup="saveContent(this);"
                                        rows="3"
                                        cols="40"
                                        ><?php echo (!empty($v["comment"]))?$v["comment"]:"";?></textarea>
                                </td>
                            </tr>
                            <?php
                            $count += 1;
                        }
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
                        <h4>Budget Limit: <?php echo number_format($overSpentCategories["limitTotal"], 2, ".", ","); ?></h4>
                    </td>
                    <td>
                        <h4>Total Spent: <?php echo number_format($overSpentCategories["amount"], 2, ".", ","); ?></h4>
                    </td>
                    <td>
                        <h4>Total Expenses: <?php echo number_format($overSpentCategories["count"], 0); ?></h4>
                    </td>
                    <td>
                        <h4>Total Over Spent: <?php echo number_format($overSpentCategories["limitTotal"] - $overSpentCategories["amount"], 2, ".", ","); ?></h4>
                    </td>
                </tr>
            </tfoot>
        </table>
        <p>
            Were there overarching events or reasons for the overspends?
            <textarea name="overspend_comment" cols="40" rows="7" placeholder="Where did it go wrong :( ..." onkeyup="saveBudgetOverSpendComment(this);"
                      ><?php if(!empty($expenseBudget->over_spend_comment) && $expenseBudget->over_spend_comment != null){
                    echo $expenseBudget->over_spend_comment;
                }?></textarea>
        </p>
        <hr/>
        <p>
            Categories under spent: <?php echo $underSpentCategories["count"]; ?>
        </p>
        <p>
            Under Spend total: <?php echo number_format($underSpentCategories["amount"], 2, ".", ",");?> 
            on a limit of <?php echo number_format($underSpentCategories["limitTotal"], 2, ".", ","); ?> <br/>
        </p>
            <table id="budget_expense_items_under" class="tablesorter hover-highlight focus-highlight widget-zebra">
            <input type="hidden" id="period-id" value="<?php echo $budgetId; ?>" />
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Budgetted Amount</th>
                    <th>Spent</th>
                    <th># Expenses</th>
                    <th>Under By</th>
                    <th>Under By %</th>
                    <th>Comment</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $ttypes = array();
                $totalSpent = 0;
                $totalExpenses = 0;
                $totalRemaining = 0;
                $projected = 0;
                $overrage = 0;
                if (!empty($expenseBudgetItems)) {
                    $count = 1;
                    foreach ($expenseBudgetItems as $k => $v) {
                        if ($v["amount_sign"] == "+"  && $v["period_outcome_amount"] > 0) {
                            $ttypes[$k] = true;
                            $valRemaining = ((array_key_exists($v["expense_type_id"], $expenseTypesTotals)) ? (round($v["limit_amount"],2) - round($expenseTypesTotals[$v["expense_type_id"]]["value"], 2 )) : round($v["limit_amount"], 2) );
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
                                        ?>
                                </td>
                                <td id="spent-to-date" data-category="<?php echo $v["expense_type_id"]; ?>" 
                                    data-expense-count="<?php echo ((array_key_exists($v["expense_type_id"], $expenseTypesTotals)) ? $expenseTypesTotals[$v["expense_type_id"]]["expenseCount"] : "0"); ?>"  
                                    data-expense-ids="<?php echo ((array_key_exists($v["expense_type_id"], $expenseTypesTotals)) ? $expenseTypesTotals[$v["expense_type_id"]]["expenseIds"] : "0"); ?>"
                                    >
                                        <?php
                                        $totalExpenses += ((array_key_exists($v["expense_type_id"], $expenseTypesTotals)) ? $expenseTypesTotals[$v["expense_type_id"]]["expenseCount"] : "0");
                                        echo ((array_key_exists($v["expense_type_id"], $expenseTypesTotals)) ? $expenseTypesTotals[$v["expense_type_id"]]["expenseCount"] : "0");
                                        ?>
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
                                        echo number_format(abs($valRemaining), 2, ".", "");
                                        ?>
                                </td>
                                <td>
                                    <?php
                                    echo abs($percentage);
                                    ?>
                                </td>
                                <td>
                                    <input type="hidden" name="id" id="id" value="<?php echo $v["id"]; ?>" />
                                    <textarea name="comment_<?php echo $v["id"]; ?>" 
                                        id="comment_<?php echo $v["id"]; ?>" 
                                        onkeyup="saveContent(this);"
                                        rows="3"
                                        cols="40"><?php echo (!empty($v["comment"]))?$v["comment"]:"";?></textarea>
                                </td>
                            </tr>
                            <?php
                            $count += 1;
                        }
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
                        <h4>Budget Limit: <?php echo number_format($underSpentCategories["limitTotal"], 2, ".", ","); ?></h4>
                    </td>
                    <td>
                        <h4>Total Spent: <?php echo number_format($underSpentCategories["limitTotal"] - $underSpentCategories["amount"], 2, ".", ","); ?></h4>
                    </td>
                    <td>
                        <h4>Total Expenses: <?php echo number_format($underSpentCategories["count"], 0); ?></h4>
                    </td>
                    <td>
                        <h4>Total Unspent: <?php echo number_format($underSpentCategories["amount"], 2, ".", ",");  ?></h4>
                    </td>
                </tr>
            </tfoot>
        </table>
                </p>
        <p>
            Why did we not spend the allocated amounts?
            <textarea name="underspend_comment" cols="40" rows="7" placeholder="Because x happened that meant the y :| ..." onkeyup="saveBudgetUnderSpendComment(this);" 
                ><?php if(!empty($expenseBudget->uner_spend_comment) && $expenseBudget->under_spend_comment != null){
                    echo $expenseBudget->under_spend_comment;
                }?></textarea>
        </p>
        <h3>
            Closing thoughts on this period?
        </h3>
        <p>What went wrong? What went right? Anything significant happen that may make a difference in the future?
            <textarea name="post_budget_comment" cols="40" rows="7" 
                placeholder="Let it out..."
                onkeyup="saveBudgetOverallComment(this);" 
                ><?php if(!empty($expenseBudget->overall_comment) && $expenseBudget->overall_comment != null){
                    echo $expenseBudget->overall_comment;
                }?></textarea>
        </p>
        <!--    // Show the overall state of the budget for that period.<br/>
        // Overall give an honest account of what went right and what went wrong in this period<br/>
        // What do I want to know after a month
        // What did I spend?
        // Where did I go wrong?
        // Where did I go right?
        // what was the category that I spent the most on, and can I shrink it next month?
        // If I had unexpected expenses. What was it, could I have foreseen this expense and planned for it
        //      if yes then add it to the time table and use it for forecasting
        //      if no, make a note of it for retrospective analysis over the year period.
        -->
    </div>
</div>
<link rel="stylesheet" href="/css/third_party/thickbox/thickbox.css" type="text/css" media="screen" />
<script src="/js/third_party/jquery-ui.custom.min.js" type="text/javascript" ></script>
<script type="text/javascript" src="/js/third_party/thickbox-compressed.js"></script>
<script type="text/javascript" src="/js/third_party/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="/js/expense_budget/post_analysis.js" ></script>