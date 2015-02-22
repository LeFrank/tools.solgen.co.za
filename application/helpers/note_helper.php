<?php
function getUniqueTagItems($tags = null) {
    $tagArr = array();
    $tagArrCount = array();
    foreach($tags as $k=>$v){
        $tagArr[$k] = $v["tagg"];
        $tagArrCount[$v["tagg"]]["count"] = 
                (isset( $tagArrCount[$v["tagg"]]["count"] )) ? $tagArrCount[$v["tagg"]]["count"] + 1 : 1 ;
    }
    return array($tagArrCount, array_unique($tagArr));
}