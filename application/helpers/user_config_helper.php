<?php

function mapKeyToValue($doubleDimensionsArray) {
    $returnArray = null;
    if (!empty($doubleDimensionsArray)) {
        if (null != $doubleDimensionsArray && !empty($doubleDimensionsArray)) {
            foreach ($doubleDimensionsArray as $k => $v) {
//                print_r($v);
                $returnArray[$v["key"]] = $v["val"];
                $returnArray[$v["key"]."_id"] = $v["id"];
                $returnArray[$v["key"]."_tool_Id"] = $v["tool_id"];
            }
        }
    }
    return $returnArray;
}