<?php

/* When provided with a single task determine the age of the task from the moment it was created until todaay.
    * 
    * @param type $createDate
    * @return int Age in days
    */
function getTaskAgeByCreateDate($task){
    // print_r($task);
    // echo $task["create_date"];
    // echo "<br/>";
    // echo date('Y-m-d H:i');
    // echo "<br/>";
    $age = round(( strtotime(date('Y-m-d H:i')) - strtotime($task["create_date"])) / 86400);
    // echo "<br/><br/>";
    return $age;
}

/*
 * When provided with a single task determine the age of the task from the start date to today. 
 */
function getTaskAgeByStartDate($startDate){
    return 0;
}


/*
 * When provided with a single task determine the age of the task from the start date to the end_date ( When it was marked as Done). 
 */
function getTaskAgeByStartDateAndEndDate($task){
    $age = round(( strtotime($task["end_date"]) - strtotime($task["start_date"])) / 86400);
    return $age;
}

function getTaskTargettedAgeByStartDateAndEndDate($task){
    $age = round(( strtotime($task["target_date"]) - strtotime($task["start_date"])) / 86400);
    return $age;
}   
/*
* Get number of tasks beyond target date.
*/  
function getNumberOfTasksBeyondTargetDate($tasks = null){
    return 0;
}


/*
*   When provided with a list of tasks, get the average age range of incomplete tasks.
*   Incomplete tasks are tasks that are not in a 'completed' status.
*/
function getAverageAgeRangeOfIncompleteTasks($tasks = null){
    $averageRange = array("week" => 0, "month" => 0, "3months" => 0, "6months" => 0, "year" => 0, "moreThanYear" => 0);
    return $average;
}


// Should be a model query.
function getTasksBeyondTargetDate(){
    return 0;
}


