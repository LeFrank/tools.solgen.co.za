<?php

/**
 * Description of tool_info_helper
 *
 * @author francois
 */
function geToolData(){
    $tools = array(
        1 => array("name" => "Expenses", "id" => 1, "colour"=>"#75ce66"),
        2 => array("name" => "Weather", "id" => 2, "colour"=>""),
        3 => array("name" => "Location", "id" => 3, "colour"=>""),
        4 => array("name" => "Timetable", "id" => 4, "colour"=>"#9933ff"),
        5 => array("name" => "Notes", "id" => 5, "colour"=>"#f0ca45"),
        6 => array("name" => "Timeline", "id" => 6, "colour"=>""),
        7 => array("name" => "Wishlist", "id" => 7, "colour"=>"#75ce66"),
        8 => array("name" => "Health", "id" => 8, "colour"=>"#c03b44"),
        9 => array("name" => "Resources", "id" => 9, "colour"=>"#0066cc"),
        10 => array("name" => "Lists", "id" => 10, "colour"=>"#0066cc")
    );
    return $tools;
}


function getToolInfo($id) {
    //return array_search($id, array_column($tools, 'id'));
    return geToolData()[$id];
}

function getAllToolsInfo(){
    return geToolData();
}
