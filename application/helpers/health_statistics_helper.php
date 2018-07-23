<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function getWaistOverDateRangeJson($metrics) {
//    echo "<pre>";
//    print_r($metrics);
//    echo "</pre>";
    $count = 0;
    $jsonDataArray = array();
    foreach ($metrics as $k => $v) {
        if(null != $v["waist"]){
            $jsonDataArray[$count] = array($v["measurement_date"], floatVal($v["waist"]));
            $count++;
        }
    }
    return $jsonDataArray;
}

function getWeightOverDateRangeJson($metrics) {
    $count = 0;
    $jsonDataArray = array();
    foreach ($metrics as $k => $v) {
        if(null != $v["weight"]){
            $jsonDataArray[$count] = array($v["measurement_date"], floatVal($v["weight"]));
            $count++;
        }
    }
    return $jsonDataArray;
}

function getSleepOverDateRangeJson($metrics) {
    $count = 0;
    $jsonDataArray = array();
    foreach ($metrics as $k => $v) {
        if(null != $v["sleep"]){
            $jsonDataArray[$count] = array($v["measurement_date"], floatVal($v["sleep"]));
            $count++;
        }
    }
    return $jsonDataArray;
}

function getSleepTargetOverDateRangeJson($metrics) {
    $count = 0;
    $jsonDataArray = array();
    foreach ($metrics as $k => $v) {
        if(null != $v["sleep"]){
            $jsonDataArray[$count] = array($v["measurement_date"], floatVal(8));
            $count++;
        }
    }
    return $jsonDataArray;
}

function getWeightTargetOverDateRangeJson($metrics) {
    $count = 0;
    $jsonDataArray = array();
    foreach ($metrics as $k => $v) {
        if(null != $v["weight"]){
            $jsonDataArray[$count] = array($v["measurement_date"], floatVal(96));
            $count++;
        }
    }
    return $jsonDataArray;
}


function getWaistTargetOverDateRangeJson($metrics) {
    $count = 0;
    $jsonDataArray = array();
    foreach ($metrics as $k => $v) {
        if(null != $v["waist"]){
            $jsonDataArray[$count] = array($v["measurement_date"], floatVal(91.44));
            $count++;
        }
    }
    return $jsonDataArray;
}


function getExerciseGraphDataPerType($exerciseTypes , $exercises){
    foreach($exerciseTypes as $k=>$v){
        $count = 0;
        $jsonDataArray = array();
        $jsonDataArray2 = array();
        $jsonDataArray3 = array();
        foreach ($exercises as $kk => $vv) {
            if($vv["exercise_type_id"] == $v["id"]){
                $jsonDataArray[$count] = array($vv["start_date"], floatVal($vv["measurement_value"]));
                $jsonDataArray2[$count] = array($vv["start_date"], floatVal($vv["difficulty"]));
                $jsonDataArray3[$count] = array($vv["start_date"], floatVal($vv["distance"]));
                $count++;
            }
        }
        $data[$v["id"]]["measurement_value"] = $jsonDataArray;
        $data[$v["id"]]["difficulty"] = $jsonDataArray2;
        $data[$v["id"]]["distance"] = $jsonDataArray3;
    }
    return $data;
}