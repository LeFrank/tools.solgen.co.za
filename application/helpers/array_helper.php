<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function mapKeyToId($doubleDimensionsArray, $includeMisc = true) {
    $returnArray = null;
    if (!empty($doubleDimensionsArray)) {
        if ($includeMisc) {
            $returnArray["0"] = array("id" => 0, "name"=> "miscellaneous","description" => "miscellaneous", "enabled" => 1, "create_date" => "2014-04-17 23:06:04", "user_id" => null, "default_measurement_name" => "Things");
        }
        if (null != $doubleDimensionsArray && !empty($doubleDimensionsArray)) {
            foreach ($doubleDimensionsArray as $k => $v) {
                $returnArray[$v["id"]] = $v;
            }
        }
    }
    return $returnArray;
}

function mapKeyTo($doubleDimensionsArray, $keyName) {
    $returnArray = null;
    if (!empty($doubleDimensionsArray)) {
        if (null != $doubleDimensionsArray && !empty($doubleDimensionsArray)) {
            foreach ($doubleDimensionsArray as $k => $v) {
                $returnArray[$v[$keyName]] = $v;
            }
        }
    }
    return $returnArray;
}

function getDaysOfWeek() {
    return $daysOfWeek = array("1" => "Monday", "2" => "Tuesday", "3" => "Wednesday", "4" => "Thursday", "5" => "Friday", "6" => "Saturday", "7" => "Sunday");
}

function arrayMap($array) {
    $arr = array();
    foreach ($array as $k => $v) {
        $arr[$v["id"]] = $v;
    }
    return $arr;
}

function arrayObjMap($array) {
    $arr = array();
    foreach ($array as $k => $v) {
        $arr[$v->id] = $v;
    }
    return $arr;
}


function multiArrGetKeyValFromObjById($sourceMultiDimenArr, $idName, $level = 1){
    $arr = array();
    foreach( $sourceMultiDimenArr as $k=>$v){
        if($v["status"] != "Failure"){
            $arr[] = $v[$idName];
        }
    }
    // echo "<pre>";
    // print_r($arr);
    // echo "</pre>";
    return $arr;
}