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

function eventify($event){
//    title: 'Long Event',
//    start: '2014-06-07',
//    end: '2014-06-10'
    $count = 0;
    $data[$count] = array(
        "id" => $event->id,
        "title"=> $event->name,
        "description" => $event->description,
        "start"=> $event->start_date,
        "end"=> $event->end_date,
        "allDay" =>($event->all_day_event == 1)? true:false);
    return json_encode($data);
}

function locationAutocompletify($locations){
    foreach($locations as $k=>$v){
        $data[] = array(
            "id"   => $v->id, 
            "label" => $v->name . " - ". $v->address, 
            "value" => $v->address
        );
    }
    return json_encode($data);
}