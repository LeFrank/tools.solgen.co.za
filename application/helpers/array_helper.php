<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function mapKeyToId($doubleDimensionsArray){
    $returnArray["0"] = array("id" => 0 ,"description" => "miscellaneous",  "enabled" => 1, "create_date" => "2014-04-17 23:06:04", "user_id" => null);
    foreach($doubleDimensionsArray as $k=>$v){
        $returnArray[$v["id"]] = $v;
    }
    return $returnArray;
}
