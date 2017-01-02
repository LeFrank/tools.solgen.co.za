<?php
function getStartAndEndDateforWeek($week, $year)
{

    $time = strtotime("1 January $year", time());
    $day = date('w', $time);
    $time += ((7*($week-1))-$day)*24*3600;
    $return[0] = date('Y/m/d H:i', $time);
    $time += 6*24*3600;
    $return[1] = date('Y/m/d H:i', $time);
    return $return;
}

function getStartAndEndDateforMonth($month, $year){
    $return[0] = date('Y/m/d H:i',mktime(0, 0, 0, $month, 1,   $year));
    $return[1] = date('Y/m/d H:i',mktime(23, 59, 0, $month+1, 1-1,   $year));
    return $return;
}

function getStartAndEndDateforYear($year){
    $return[0] = date('Y/m/d H:i',mktime(0, 0, 0, 01, 01, $year));
    $return[1] = date('Y/m/d H:i',mktime(23, 59, 0, 13, 0, $year));
    return $return;
}

function getNextSevenDays(){
    $return[0] = date('Y/m/d H:i',mktime(0, 0, 0, date("m"),date("d") , date("Y")));
    $return[1] = date('Y/m/d H:i',mktime(23, 59, 0, date("m"), date("d")+7 , date("Y")));
    return $return;
}