<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function humanReadifyFilesize($filesize){
    $humanReadibleFilezise = "";
//    echo (1024 * 1024 ) . " <br/>";
//    echo ( pow(1024 , 2)) . " <br/>";
//    echo (1024 * 1024 * 1024) . " <br/>";
//    echo ( pow(1024 , 3)) . " <br/>";
    if ($filesize < 1024) {
        $humanReadibleFilezise =  $filesize . " KB";
    } elseif ($filesize > 1024 && $filesize < ( pow(1024 ,2))) {
        $humanReadibleFilezise = round($filesize/ 1024, 2) . " MB";
    } elseif ($filesize > pow(1024 ,2) && $filesize <  pow(1024 ,3) ) {
        $humanReadibleFilezise = round($filesize/ pow(1024 ,2), 2) . " GB";
    } elseif ($filesize > pow(1024 ,3) && $filesize < pow(1024 ,4)) {
        $humanReadibleFilezise = round($filesize/ pow(1024 ,3), 2) . " TB";
    }
    
    return $humanReadibleFilezise;
}

function formatStatsperTool($statsArr, $toolsInfo){
    $formattedArr = array();
    foreach($statsArr as $k=>$v){
        $formattedArr[$k]["tool_id"] = $v["tool_id"];
        $formattedArr[$k]["tool_name"] = $toolsInfo[$v["tool_id"]]["name"];
        $formattedArr[$k]["file_count"] = $v["file_count"];
        $formattedArr[$k]["file_size"] = humanReadifyFilesize($v["file_size"]);
    }
    return $formattedArr;
}
