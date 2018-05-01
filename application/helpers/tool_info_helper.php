<?php

/**
 * Description of tool_info_helper
 *
 * @author francois
 */

function getToolInfo($id) {
$tools = array(
    1 => array("name" => "Expenses", "id" => 1),
    2 => array("name" => "Weather", "id" => 2),
    3 => array("name" => "Location", "id" => 3),
    4 => array("name" => "Timetable", "id" => 4),
    5 => array("name" => "Notes", "id" => 5),
    6 => array("name" => "Timeline", "id" => 6),
    7 => array("name" => "Wishlist", "id" => 7),
    8 => array("name" => "Health", "id" => 8),
    9 => array("name" => "Resources", "id" => 9)
);
    //return array_search($id, array_column($tools, 'id'));
    return $tools[$id];
}

function getAllToolsInfo(){
$tools = array(
    1 => array("name" => "Expenses", "id" => 1),
    2 => array("name" => "Weather", "id" => 2),
    3 => array("name" => "Location", "id" => 3),
    4 => array("name" => "Timetable", "id" => 4),
    5 => array("name" => "Notes", "id" => 5),
    6 => array("name" => "Timeline", "id" => 6),
    7 => array("name" => "Wishlist", "id" => 7),
    8 => array("name" => "Health", "id" => 8),
    9 => array("name" => "Resources", "id" => 9)
);
    return $tools;
}
