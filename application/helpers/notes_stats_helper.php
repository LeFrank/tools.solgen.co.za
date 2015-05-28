<?php
function getNotesForHourOfDay($notes, $json = false) {
    for ($i = 0; $i <= 24; $i++) {
        $notesForHourOfDay[sprintf('%02d', $i)] = array("value" => 0, "noteCount" => 0, "data" => array());
    }
    if (null != $notes) {
        foreach ($notes as $k => $v) {
            $value = 0.00;
            $count = 0;
            $arr = array();
            $hourOfDay = date("H", strtotime($v["create_date"]));
            if (array_key_exists($hourOfDay, $notesForHourOfDay)) {
                $value = $notesForHourOfDay[$hourOfDay]["value"];
                $count = $notesForHourOfDay[$hourOfDay]["noteCount"];
                $arr = $notesForHourOfDay[$hourOfDay]["data"];
            }
            $notesForHourOfDay[$hourOfDay] = array(
                "value" => $value + strlen($v["body"]),
                "noteCount" => $count + 1,
                "data" => $arr
            );
            array_push($notesForHourOfDay[$hourOfDay]["data"], $v);
        }
    }
    if ($json) {
        $jsonDataArray = array();
        $countHourCount = 0;
        foreach ($notesForHourOfDay as $k => $v) {
            $jsonDataArray[$countHourCount] = array($v["noteCount"] . ((sizeOf($notesForHourOfDay) != $countHourCount) ? ',' : ''));
            $countHourCount++;
        }
    } else {
        return $notesForHourOfDay;
    }
}