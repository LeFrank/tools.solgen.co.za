<?php

function mapKeyToValue($doubleDimensionsArray) {
    $returnArray = null;
    if (!empty($doubleDimensionsArray)) {
        if (null != $doubleDimensionsArray && !empty($doubleDimensionsArray)) {
            foreach ($doubleDimensionsArray as $k => $v) {
                $returnArray[$v["key"]] = $v["val"];
            }
        }
    }
    return $returnArray;
}