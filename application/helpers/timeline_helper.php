<?php
/*
 * Order by date
 * populate title
 * populate content with a 250 character limit
 * create link to view or widget
 */
function getEvent(){
    $event = (object) ["date" => "","id"=>"","toolId" => "","toolName" => "", "title"=>"", "body" => "", "url" => ""];
    return $event;
}
function timelineDataFormat( $tags = null) {
    $tagArr = array();
    $tagArrCount = array();
    foreach($tags as $k=>$v){
        $tagArr[$k] = $v["tagg"];
        $tagArrCount[$v["tagg"]]["count"] = 
                (isset( $tagArrCount[$v["tagg"]]["count"] )) ? $tagArrCount[$v["tagg"]]["count"] + 1 : 1 ;
    }
    return array($tagArrCount, array_unique($tagArr));
}

function timelineExpenseFormat($expenses, $timelineEvents, $expenseType){
    foreach($expenses as $k=> $v){
        $event = getEvent();
        $event->date = $v["expense_date"];
        $event->toolId = 1;
        $event->toolName = "expenses";
        $event->id = $v["id"];
        $event->title = "R".number_format($v["amount"], 2, '.', ',') . " - " . $expenseType[$v["expense_type_id"]]["description"];
        $event->body = /*substr( strip_tags(*/$v["description"] /*), 0 ,250)*/;
        $event->url = "expenses/edit/". $v["id"];
        $timelineEvents[] = $event;
    }
    return $timelineEvents;
}

function timelineNoteFormat($notes, $timelineEvents){
    foreach($notes as $k=> $v){
        $event = getEvent();
        $event->date = $v["create_date"];
        $event->toolId = 7;
        $event->toolName = "notes";
        $event->id = $v["id"];
        $event->title = $v["heading"];
        $event->body = /*substr( strip_tags(*/$v["body"]/*), 0 ,250) */;
        $event->url = "notes/view-note/". $v["id"];
        $timelineEvents[] = $event;
    }
    return $timelineEvents;
}

function timelineTimetableFormat($events, $timelineEvents, $timetableCategories){
    foreach($events as $k=> $v){
        $event = getEvent();
        $event->date = $v->start_date;
        $event->toolId = 3;
        $event->toolName = "timetable";
        $event->id = $v->id;
        $cat = (isset($timetableCategories[$v->tt_category_id]))? $timetableCategories[$v->tt_category_id]["name"] : " None";
        $event->title = $v->name . " - " . $cat;
        $event->body = $v->description;
        $event->url = "timetable/edit/". $v->id;
        $timelineEvents[] = $event;
    }
    return $timelineEvents;
}

function orderTimeline($events){
    arsort($events);
    return $events;
}