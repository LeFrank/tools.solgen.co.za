<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function getExpensesTotal($expenses = null) {
    $total = 0;
    if (null != $expenses) {
        foreach ($expenses as $k => $v) {
            $total += $v["amount"];
        }
    }
    return $total;
}

function getAveragePerExpense($total = null, $expenses = null) {
    $average = 0;
    if (null != $expenses) {
        $average = $total / sizeof($expenses);
    }
    return $average;
}

function getArrayOfTypeAmount($expenses = null) {
    $typeCollatedArray["0"] = 0;
    if (null != $expenses) {
        foreach ($expenses as $k => $v) {
            $value = 0.00;
            $count = 0;
            if (array_key_exists($v["expense_type_id"], $typeCollatedArray)) {
                $value = $typeCollatedArray[$v["expense_type_id"]]["value"];
                $count = $typeCollatedArray[$v["expense_type_id"]]["expenseCount"];
            } else {
                $typeCollatedArray[$v["expense_type_id"]] = array();
            }
            $typeCollatedArray[$v["expense_type_id"]] = array(
                "value" => floatVal($value) + floatVal($v["amount"]),
                "expenseCount" => $count + 1
            );
        }
    }
    arsort($typeCollatedArray);
    return $typeCollatedArray;
}

function getArrayOfPaymentMethodAmount($expenses) {
    $paymentMethodCollatedArray["0"] = 0;
    if (null != $expenses) {
        foreach ($expenses as $k => $v) {
            $value = 0.00;
            $count = 0;
            if (array_key_exists($v["payment_method_id"], $paymentMethodCollatedArray)) {
                $value = $paymentMethodCollatedArray[$v["payment_method_id"]]["value"];
                $count = $paymentMethodCollatedArray[$v["payment_method_id"]]["expenseCount"];
            } else {
                $paymentMethodCollatedArray[$v["payment_method_id"]] = array();
            }
            $paymentMethodCollatedArray[$v["payment_method_id"]] = array(
                "value" => floatVal($value) + floatVal($v["amount"]),
                "expenseCount" => $count + 1
            );
        }
    }
    arsort($paymentMethodCollatedArray);
    return $paymentMethodCollatedArray;
}

function getArrayOfLocationAmount($expenses) {
    $locationCollatedArray["0"] = 0;
    if (null != $expenses) {
        foreach ($expenses as $k => $v) {
            $value = 0.00;
            $count = 0;
            if (array_key_exists($v["location"], $locationCollatedArray)) {
                $value = $locationCollatedArray[$v["location"]]["value"];
                $count = $locationCollatedArray[$v["location"]]["expenseCount"];
            } else {
                $locationCollatedArray[$v["location"]] = array();
            }
            $locationCollatedArray[$v["location"]] = array(
                "value" => floatVal($value) + floatVal($v["amount"]),
                "expenseCount" => $count + 1
            );
        }
    }
    arsort($locationCollatedArray);
    return $locationCollatedArray;
}

function getDayOfWeekForExpense($expenses) {
    for($i=1;$i <= 7;$i++){
        $dayOfWeekExpenses[$i] = array("value" => 0.00,"expenseCount" =>0);
    }
//    $dayOfWeekExpenses = array(1, 2, 3, 4, 5, 6, 7);
    if (null != $expenses) {
        foreach ($expenses as $k => $v) {
            $value = 0.00;
            $count = 0;
            $dayOfWeek = date("N", strtotime($v["expense_date"]));
            if (array_key_exists($dayOfWeek, $dayOfWeekExpenses)) {
                $value = $dayOfWeekExpenses[$dayOfWeek]["value"];
                $count = $dayOfWeekExpenses[$dayOfWeek]["expenseCount"];
            }
            $dayOfWeekExpenses[$dayOfWeek] = array(
                "value" => floatVal($value) + floatVal($v["amount"]),
                "expenseCount" => $count + 1
            );
        }
    }
    return $dayOfWeekExpenses;
}
