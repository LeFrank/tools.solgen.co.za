<?php

function getWishlistPriorities() {
    $priorities = array(
        0 => "None",
        1 => "Low",
        2 => "Low/Medium",
        3 => "Medium",
        4 => "Medium/High",
        5 => "High",
        6 => "High/Summit",
        7 => "Summit");
    return $priorities;
}

function getWishlistStatuses() {
    $statuses = array(
        0 => "None",
        1 => "Some Day",
        2 => "Awaiting Action",
        3 => "In Progress",
        4 => "Rethink",
        5 => "Done"
    );
    return $statuses;
}
