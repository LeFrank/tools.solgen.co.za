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
        $event->toolId = 5;
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
        $event->toolId = 4;
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

function timelineResourceFormat($events, $timelineEvents, $toolInfo){
//    echo "<pre>";
//    print_r($events);
//    print_r($timelineEvents);
//    print_r($toolInfo);
//    echo "</pre>";
    foreach($events as $k=> $v){
        $event = getEvent();
        $event->date = $v["created_on"];
        $event->toolId = $v["tool_id"];
        $event->toolName = $toolInfo[9]["name"];
        $event->id = $v["id"];
        $event->title = "<img style='width:30px;margin-top:5px;' src='../../../images/third_party/icons/110942-file-formats-icons/svg/". ltrim($v["file_extension"], ".")."-file-format-symbol.svg'>" ."   ". $v["filename"] ;
        $filesize = "";
        if ($v["filezise"] < 1024) {
            $filesize =  $v["filezise"] . " KB";
        } elseif ($v["filezise"] > 1024 && $v["filezise"] < ( 1024 * 1024 )) {
            $filesize = round($v["filezise"] / 1024, 2) . " MB";
        }
        $event->body = 
                "File Origin: ".$toolInfo[$v["tool_id"]]["name"] .
                "<br/>File Name: <strong>". $v["original_name"]. "</strong>" .
                "<br/>Created On: ". $v["created_on"] . 
                "<br/>File Size: ". $filesize . 
                "<br/>Description: ". $v["description"];
        $event->url = "resources/view/resource/". $v["id"]."/".$v["filename"];
        $timelineEvents[] = $event;
    }
    return $timelineEvents;
}

function timelineHealthMetricsFormat($events, $timelineEvents, $toolInfo){
//    echo "<pre>";
//    print_r($events);
//    print_r($timelineEvents);
//    print_r($toolInfo);
//    echo "</pre>";
    foreach($events as $k=> $v){
        $event = getEvent();
        $event->date = $v["create_date"];
        $event->toolId = 8;
        $event->toolName = "Health - Metrics";
        $event->toolName = $toolInfo[8]["name"];
        $event->id = $v["id"];
        $event->title = "<i class='fas fa-weight' style='color:".$toolInfo[8]["colour"]."; font-size:24px'>&nbsp;</i>&nbsp;". $v["weight"] 
                ."&nbsp;&nbsp;<i class='fas fa-tape' style='color:".$toolInfo[8]["colour"]."; font-size:24px'>&nbsp;</i>&nbsp;" . $v["waist"] 
                . "&nbsp;&nbsp;<i class='fas fa-bed' style='color:".$toolInfo[8]["colour"]."; font-size:24px'>&nbsp;</i>&nbsp;" . $v["sleep"];
        $event->body = $v["note"];
        $event->url = "health/metric/edit/". $v["id"];
        $timelineEvents[] = $event;
    }
    return $timelineEvents;
}
function timelineHealthExercisesFormat($events, $timelineEvents, $toolInfo, $exerciseTypes){
    foreach($events as $k=> $v){
        $event = getEvent();
        $event->date = $v["created_date"];
        $event->toolId = 8;
        $event->toolName = "Health - Exercises";
        $event->toolName = $toolInfo[8]["name"];
        $event->id = $v["id"];
        $interval = date_diff(new DateTime($v["end_date"]), new DateTime($v["start_date"]));
        $duration = gmdate("h:i:s",strtotime($v["end_date"]) - strtotime($v["start_date"]));
        $event->title = "<i class='fas fa-". strtolower($exerciseTypes[$v["exercise_type_id"]]["name"])."' style='color:".$toolInfo[8]["colour"]."; font-size:24px'>&nbsp;</i>&nbsp;". $exerciseTypes[$v["exercise_type_id"]]["name"].
                "&nbsp;&nbsp;| Duration (aprox) : " . $interval->h. " hours, " .$interval->i . " minutes";
        $event->body = $v["description"];
        $event->url = "health/exercise/edit/". $v["id"];
        $timelineEvents[] = $event;
    }
    return $timelineEvents;
}

function orderTimeline($events){
    arsort($events);
    return $events;
}