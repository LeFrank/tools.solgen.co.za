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
            $expenseIds = "";
            if (array_key_exists($v["expense_type_id"], $typeCollatedArray)) {
                $value              = $typeCollatedArray[$v["expense_type_id"]]["value"];
                $count              = $typeCollatedArray[$v["expense_type_id"]]["expenseCount"];
                $expenseIds         = $typeCollatedArray[$v["expense_type_id"]]["expenseIds"];
            } else {
                $typeCollatedArray[$v["expense_type_id"]] = array();
            }
            $typeCollatedArray[$v["expense_type_id"]] = array(
                "value" => floatVal($value) + floatVal($v["amount"]),
                "expenseCount" => $count + 1,
                "expenseIds"  => $v["id"]. "," . $expenseIds
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
            $expenseIds = "";
            if (array_key_exists($v["payment_method_id"], $paymentMethodCollatedArray)) {
                $value              = $paymentMethodCollatedArray[$v["payment_method_id"]]["value"];
                $count              = $paymentMethodCollatedArray[$v["payment_method_id"]]["expenseCount"];
                $expenseIds         = $paymentMethodCollatedArray[$v["payment_method_id"]]["expenseIds"];
            } else {
                $paymentMethodCollatedArray[$v["payment_method_id"]] = array();
            }
            $paymentMethodCollatedArray[$v["payment_method_id"]] = array(
                "value" => floatVal($value) + floatVal($v["amount"]),
                "expenseCount" => $count + 1,
                "expenseIds"  => $v["id"]. "," . $expenseIds
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
            $expenseId = "";
            if (array_key_exists($v["location"], $locationCollatedArray)) {
                $value = $locationCollatedArray[$v["location"]]["value"];
                $count = $locationCollatedArray[$v["location"]]["expenseCount"];
                $expenseId = $locationCollatedArray[$v["location"]]["expenseIds"];
            } else {
                $locationCollatedArray[$v["location"]] = array();
            }
            $locationCollatedArray[$v["location"]] = array(
                "value" => floatVal($value) + floatVal($v["amount"]),
                "expenseCount" => $count + 1,
                "expenseIds" => $v["id"]. "," . $expenseId
            );
        }
    }
    arsort($locationCollatedArray);
    return $locationCollatedArray;
}

function getDayOfWeekForExpense($expenses) {
    for ($i = 1; $i <= 7; $i++) {
        $dayOfWeekExpenses[$i] = array("value" => 0.00, "expenseCount" => 0, "expenseIds" => "");
    }
    if (null != $expenses) {
        foreach ($expenses as $k => $v) {
            $value = 0.00;
            $count = 0;
            $expenseIds = "";
            $dayOfWeek = date("N", strtotime($v["expense_date"]));
            if (array_key_exists($dayOfWeek, $dayOfWeekExpenses)) {
                $value      = $dayOfWeekExpenses[$dayOfWeek]["value"];
                $count      = $dayOfWeekExpenses[$dayOfWeek]["expenseCount"];
                $expenseIds  = $dayOfWeekExpenses[$dayOfWeek]["expenseIds"];
            }
            $dayOfWeekExpenses[$dayOfWeek] = array(
                "value" => floatVal($value) + floatVal($v["amount"]),
                "expenseCount" => $count + 1,
                "expenseIds" => $v["id"]. "," . $expenseIds
            );
        }
    }
    return $dayOfWeekExpenses;
}

function getExpensesForHourOfDay($expenses, $json = false) {
    for ($i = 0; $i <= 24; $i++) {
        $expenseForHourOfDay[sprintf('%02d', $i)] = array("value" => 0.00, "expenseCount" => 0, "data" => array());
    }
    if (null != $expenses) {
        foreach ($expenses as $k => $v) {
            $value = 0.00;
            $count = 0;
            $arr = array();
            $hourOfDay = date("H", strtotime($v["expense_date"]));
            if (array_key_exists($hourOfDay, $expenseForHourOfDay)) {
                $value = $expenseForHourOfDay[$hourOfDay]["value"];
                $count = $expenseForHourOfDay[$hourOfDay]["expenseCount"];
                $arr = $expenseForHourOfDay[$hourOfDay]["data"];
            }
            $expenseForHourOfDay[$hourOfDay] = array(
                "value" => floatVal($value) + floatVal($v["amount"]),
                "expenseCount" => $count + 1,
                "data" => $arr
            );
            array_push($expenseForHourOfDay[$hourOfDay]["data"], $v);
        }
    }
    if ($json) {
        $jsonDataArray = array();
        $countHourCount = 0;
        foreach ($expensesByHourOfDay as $k => $v) {
            $jsonDataArray[$countHourCount] = array($v["expenseCount"] . ((sizeOf($expensesByHourOfDay) != $countHourCount) ? ',' : ''));
            $countHourCount++;
        }
    } else {
        return $expenseForHourOfDay;
    }
}

function getExpensesOverPeriodJson($expenses) {
    $count = 0;
    $jsonDataArray = array();
    foreach ($expenses as $k => $v) {
        $jsonDataArray[$count] = array($v["expense_date"], floatVal($v["amount"]));
        $count++;
    }
    return $jsonDataArray;
}
