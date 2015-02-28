<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function mapKeyToId($doubleDimensionsArray, $includeMisc = true) {
    $returnArray = null;
    if ($includeMisc) {
        $returnArray["0"] = array("id" => 0, "description" => "miscellaneous", "enabled" => 1, "create_date" => "2014-04-17 23:06:04", "user_id" => null);
    }
    if (null != $doubleDimensionsArray && !empty($doubleDimensionsArray)) {
        foreach ($doubleDimensionsArray as $k => $v) {
            $returnArray[$v["id"]] = $v;
        }
    }
    return $returnArray;
}

function getDaysOfWeek(){
    return $daysOfWeek = array("1" =>"Monday", "2" => "Tuesday", "3"=>"Wednesday" , "4" => "Thursday" , "5" => "Friday", "6" => "Saturday" , "7" => "Sunday");
}

function arrayMap($array){
    $arr = array();
    foreach($array as $k=>$v){
        $arr[$v["id"]] = $v;
    }
    return $arr;
}

function arrayObjMap($array){
    $arr = array();
    foreach($array as $k=>$v){
        $arr[$v->id] = $v;
    }
    return $arr;
}