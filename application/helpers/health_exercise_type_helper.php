<?php

    function countByFieldValue($array, $fieldName, $fieldValue, $debug=false){
        $count = 0;
        foreach($array as $k=>$v){
//                    print_r($v);
//                    echo ">".$v[$fieldName]."<";
//            if(isset($v[$fieldName]) ){
//                if($debug){
//                }
                if($v[$fieldName] == $fieldValue){
                    $count +=1;
                }
//            }
        }
        return $count;
    }
?>