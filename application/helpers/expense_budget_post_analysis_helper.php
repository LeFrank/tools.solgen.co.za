<?php

/**
 * Analyse the  Budget Items and determine the End State for each category
 * @param type $expenseTypes
 * @param type $expenseBudgetItems
 * @param type $categorisedExpenseItems
 */
function analyseBudgetItemsEndState($expenseBudgetItems, $categorisedExpenseItems) {
    echo "HERE";
    foreach ($expenseBudgetItems as $k => $v) {
        if(array_key_exists($v["expense_type_id"], $categorisedExpenseItems)){
            $remainder = number_format( $v["limit_amount"] - $categorisedExpenseItems[$v["expense_type_id"]]["value"], 2, ".", "");
            $v["amount_sign"] = ($remainder >= 0 )?"+":"-";
            $v["period_outcome_amount"] = $remainder;
        }else{
            $v["amount_sign"] = "+";
            $v["period_outcome_amount"] = $v["limit_amount"];
        }
        $expenseBudgetItems[$k] = $v;
    }
    return $expenseBudgetItems;
}

/**
 * When given an array with all the categorisedExpenseItems.
 * Sum the total for all expenses and return.
 * @param type $categorisedExpenseItems
 * @return type
 */
function totalSpent($categorisedExpenseItems){
    $totalSpent = 0;
    foreach($categorisedExpenseItems as $k=>$v){
        $totalSpent = $totalSpent + $v["value"];
    }
    return $totalSpent;
}

function overSpentCategories($postStateBudgetItems){
    $overSpentCat["count"] = 0;
    $overSpentCat["limitTotal"] = 0;
    $overSpentCat["amount"] = 0;
    $overSpentCat["period_outcome_amount"] = 0;
    foreach ($postStateBudgetItems as $k => $v) {
        if($v["amount_sign"] == "-"){
            $overSpentCat["count"] += 1;
            $overSpentCat["amount"] += abs($v["period_outcome_amount"]) + $v["limit_amount"];
            $overSpentCat["limitTotal"] += $v["limit_amount"];
            $overSpentCat["period_outcome_amount"] += $v["period_outcome_amount"];
        }
    }
    return $overSpentCat;
}

function underSpentCategories($postStateBudgetItems){
    $underSpentCat["count"] = 0;
    $underSpentCat["limitTotal"] = 0;
    $underSpentCat["amount"] = 0;
    $underSpentCat["period_outcome_amount"] = 0;
     foreach ($postStateBudgetItems as $k => $v) {
        if($v["amount_sign"] == "+" && $v["period_outcome_amount"] > 0){
            $underSpentCat["count"] += 1;
            $underSpentCat["amount"] += abs($v["period_outcome_amount"]);
            $underSpentCat["limitTotal"] += $v["limit_amount"];
            $underSpentCat["period_outcome_amount"] += $v["period_outcome_amount"];
        }
    }
    return $underSpentCat;
}

function getRemainingBudgetForCategory($budgetItemAmount, $previouslySpent, $spentAmount){
    return $budgetItemAmount - $previouslySpent - $spentAmount;    
}