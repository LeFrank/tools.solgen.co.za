<?php
function getStartAndEndDate($week, $year)
{

    $time = strtotime("1 January $year", time());
    $day = date('w', $time);
    $time += ((7*($week-1))-$day)*24*3600;
    $return[0] = date('Y/m/d H:i', $time);
    $time += 6*24*3600;
    $return[1] = date('Y/m/d H:i', $time);
    return $return;
}