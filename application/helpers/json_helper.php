<?php
function autocompletifyLocation($phpArr){
    $cnt = 0;
    foreach($phpArr as $k=>$v){
        $data[$cnt] = array("id" => $v->id, "label" => $v->name);
        $cnt = $cnt+1;
    }
    return json_encode($data);
}

function eventifyArray($events){
//    title: 'Long Event',
//    start: '2014-06-07',
//    end: '2014-06-10'
    $count = 0;
    foreach($events as $k=>$v)
    {
        $data[$count] = array(
            "id" => $v->id,
            "title"=>$v->name,
            "description" => $v->description,
            "start"=>$v->start_date,
            "end"=>$v->end_date,
            "allDay" =>($v->all_day_event == 1)? true:false);
        $count = $count+1;
    }
    return json_encode($data);
}