<?php
function getUniqueTagItems($tags = null) {
    $tagArr = array();
    foreach($tags as $k=>$v){
        $tagArr[$k] = $v["tagg"];
    }
    return array_unique($tagArr);
}