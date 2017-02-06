<div class="row expanded" id="event-container">
    <div class="large-12 columns">
        <?php
            $startDate = new DateTime($event->start_date);
            $endDate = new DateTime($event->end_date);
            echo '<div class="search-event">';
            echo '  <h3>' . $event->name . '</h3>';
            echo '  </br>';
            echo '  <div><label>Date Period: </label>' . $startDate->format("Y-m-d H:i:s") . ' - ' . $endDate->format("Y-m-d H:i:s") . '</div>';
            echo '  </br>';
            echo '  <div><label>Description: </label>' . $event->description . '</div>';
            echo '  </br>';
            echo '  <div><label>Category: </label>' . ((key_exists($event->tt_category_id, $timetableCategories)) ? $timetableCategories[$event->tt_category_id]["name"] : "None") . '</div>';
            echo '  </br>';
            echo '  <div><label>Repitition: </label>' . ((key_exists($event->repition_id, $eventRepetition)) ? $eventRepetition[$event->repition_id]->name : "None") . '</div>';
            echo '  </br>';
            echo '  <div><label>Expense Type: </label>' . ((key_exists($event->expense_type_id, $expenseTypes)) ? $expenseTypes[$event->expense_type_id]["description"] : "None") . '</div>';
            echo '  </br>';
            if ($event->location_id == 0 && $event->location_text == "" && !key_exists($event->location_id, $locations)) {
                echo '  <div><label>Location: </label>None</div>';
            } else if ($event->location_id != 0 && key_exists($event->location_id, $locations)) {
                echo '  <div><label>Location: </label>' . $locations[$event->location_id]->name . '</div>';
            } else {
                echo '  <div><label>Location: </label>' . $event->location_text . '</div>';
            }
            echo '</div>';
            
        ?>
    </div>
</div>
<div class="row">
    <div class="large-12 columns">
        &nbsp;
    </div>
</div>
<div class="row">
    <div class="large-12 columns">
<?php
    echo '      <a href="/timetable/edit/'.$event->id.'" target="_blank" class="button">Edit</a>';
    echo '      &nbsp;&nbsp;';
    echo '      <a href="/timetable/delete/'.$event->id.'" id="delete" class="button secondary" >Delete</a>';
?>
    </div>
</div>