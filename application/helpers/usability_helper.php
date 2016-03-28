<?php

function getPageTitle($data, $toolName="", $functionName="" , $message=""){
    $data["globalTitle"] = $toolName;
    if(!empty($functionName)){
        $data["globalTitle"] = $data["globalTitle"] . " > ".$functionName;
    }
    if(!empty($message)){
        $data["globalTitle"] = $message . " - " . $data["globalTitle"];
    }
    return $data;
}
