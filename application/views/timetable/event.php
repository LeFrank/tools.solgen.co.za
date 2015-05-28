<div class="row">
    <div class="large-12 columns">
        <?php
        foreach ($event as $k => $v) {
            $startDate = new DateTime($v->start_date);
            $endDate = new DateTime($v->end_date);
            echo '<div class="search-event">';
            echo '  <h3>' . $v->name . '</h3>';
            echo '  </br>';
            echo '  <div><label>Date Period: </label>' . $startDate->format("Y-m-d H:i:s") . ' - ' . $endDate->format("Y-m-d H:i:s") . '</div>';
            echo '  </br>';
            echo '  <div><label>Description: </label>' . $v->description . '</div>';
            echo '  </br>';
            echo '  <div><label>Category: </label>' . ((key_exists($v->tt_category_id, $timetableCategories)) ? $timetableCategories[$v->tt_category_id]["name"] : "None") . '</div>';
            echo '  </br>';
            echo '  <div><label>Repitition: </label>' . ((key_exists($v->repition_id, $eventRepetition)) ? $eventRepetition[$v->repition_id]->name : "None") . '</div>';
            echo '  </br>';
            echo '  <div><label>Expense Type: </label>' . ((key_exists($v->expense_type_id, $expenseTypes)) ? $expenseTypes[$v->expense_type_id]["description"] : "None") . '</div>';
            echo '  </br>';
            if ($v->location_id == 0 && $v->location_text == "" && !key_exists($v->location_id, $locations)) {
                echo '  <div><label>Location: </label>None</div>';
            } else if ($v->location_id != 0 && key_exists($v->location_id, $locations)) {
                echo '  <div><label>Location: </label>' . $locations[$v->location_id]->name . '</div>';
            } else {
                echo '  <div><label>Location: </label>' . $v->location_text . '</div>';
            }
            echo '</div>';
        }
        ?>
    </div>
</div>