<?php
foreach($event as $k=>$v){
    $startDate = new DateTime($v->start_date);
    $endDate = new DateTime($v->end_date);
    echo '<div>';
    echo '  <h3>'.$v->name.'</h3>';
    echo '  </br>';
    echo '  <div><label>Date Period: </label>'.$startDate->format("Y-m-d H:i:s").' - '. $endDate->format("Y-m-d H:i:s") .'</div>';
    echo '  </br>';
    echo '  <div><label>Description: </label>'.$v->description.'</div>';
    echo '  </br>';
    echo '  <div><label>Category: </label>'.$v->tt_category_id.'</div>';
    echo '  </br>';
    echo '  <div><label>Repitition: </label>'.$v->repition_id.'</div>';
    echo '  </br>';
    echo '  <div><label>Expense Type: </label>'.$v->expense_type_id.'</div>';
    echo '  </br>';
    echo '  <div><label>Location: </label>'.$v->location_text.$v->location_id.'</div>';
    echo '</div>';
}
?>