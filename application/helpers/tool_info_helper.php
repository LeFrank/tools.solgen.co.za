<?php

/**
 * Description of tool_info_helper
 *
 * @author francois
 */
function geToolData(){
    $tools = array(
        1 => array("name" => "Expenses", "id" => 1, "colour"=>"#75ce66", "hasOwnContent"=>True ),
        2 => array("name" => "Weather", "id" => 2, "colour"=>"", "hasOwnContent"=>False),
        3 => array("name" => "Location", "id" => 3, "colour"=>"", "hasOwnContent"=>True),
        4 => array("name" => "Timetable", "id" => 4, "colour"=>"#9933ff", "hasOwnContent"=>True),
        5 => array("name" => "Notes", "id" => 5, "colour"=>"#f0ca45", "hasOwnContent"=>True),
        6 => array("name" => "Timeline", "id" => 6, "colour"=>"", "hasOwnContent"=>False),
        7 => array("name" => "Wishlist", "id" => 7, "colour"=>"#75ce66", "hasOwnContent"=>True),
        8 => array("name" => "Health", "id" => 8, "colour"=>"#c03b44", "hasOwnContent"=>True),
        9 => array("name" => "Resources", "id" => 9, "colour"=>"#0066cc", "hasOwnContent"=>True),
        10 => array("name" => "Income", "id" => 10, "colour"=>"#0066cc", "hasOwnContent"=>True),
        11 => array("name" => "Tasks", "id" => 11, "colour"=>"#0066cc", "hasOwnContent"=>True)
    );
    return $tools;
}


function getToolInfo($id) {
    //return array_search($id, array_column($tools, 'id'));
    return geToolData()[$id];
}

function getAllToolsInfo($hasOwnContent=false){
    $tools =  geToolData();
    if($hasOwnContent){
        foreach($tools as $k=>$v){
            if($v["hasOwnContent"] != ""){
                $tools_filtered[] = $v;
            }
        }
        return $tools_filtered;
    }else{
        return $tools;
    }
}
