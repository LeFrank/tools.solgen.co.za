<?php ?>
<div class="row">
    <div class="large-12 columns">
        Results: <?php echo count($entries); ?> Entries.
    </div>
</div>
<div class="row">
    <div class="large-6 columns" id="entry-list">
        <?php
        $year = 0;
        $newYear = false;
        $month = "";
        $newMonth = false;
        $day = "";
        $newDay = false;
        $closeDay = false;
        foreach ($entries as $k => $v) {
            $date = new DateTime($v->start_date);
            if ($day != $date->format("d")) {
                if ($day != "" && $newDay) {
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    $newDay = false;
                }
            }
            if ($month != $date->format("m")) {
                if ($newMonth) {
                    echo "</div>";
                    $newMonth = false;
                }
            }
            if ($date->format("Y") != $year) {
                if ($newYear) {
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    $newYear = false;
                }
            }
            if ($date->format("Y") != $year) {
                $year = $date->format("Y");
                $newYear = true;
                echo '<div class="row">';
                echo '    <div class="large-12 colums">';
                echo '        <div class="year-block radius" id="year-block">';
                echo '            <div class="entries-year">'
                . $year
                . '</div>';
            }
            if ($month != $date->format("m")) {
                $month = $date->format("m");
                $newMonth = true;
                echo '            <div id="month-block" class="month-block">';
                echo '               <div class="entries-month">'
                . $date->format("F")
                . '</div>';
            }
            if ($day != $date->format("d")) {
                $day = $date->format("d");
                $newDay = true;
                echo '              <div id="entry-list-item-block" class="day-block">';
                echo '                  <div class="row" >';
                echo '                      <div class="large-3 columns text-left">';
                echo '                          ' . $date->format("d") . ' - ' . $date->format("l") . '';
                echo '                      </div>';
                echo '                      <div class="large-9 columns text-left">';
                echo '                          <div class="row">';
                echo '                              <a href="#" id="timetableEntry" onclick="getEvent(this);" rel="'.$v->id.'">';
                echo '                                  <div class="large-4 columns text-left">';
                $endDate = new DateTime($v->end_date);
                echo $date->format("H:i") . " - " . $endDate->format("H:i");
                echo '                                  </div>';
                echo '                                  <div class="large-8 columns text-left">';
                echo $v->name;
                echo '                                  </div>';
                echo '                              </a>';
                echo '                          </div>';
            } else {
                echo '                          <div class="row">';
                echo '                              <a href="#" id="timetableEntry" onclick="getEvent(this);" rel="'.$v->id.'">';
                echo '                                  <div class="large-4 columns text-left">';
                $endDate = new DateTime($v->end_date);
                echo '                                  ' . $date->format("H:i") . " - " . $endDate->format("H:i");
                echo '                                  </div>';
                echo '                                  <div class="large-8 columns text-left">';
                echo '                                      ' . $v->name;
                echo '                                  </div>';
                echo '                              </a>';
                echo '                          </div>';
            }
        }
        ?>
    </div>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
    <div class="large-6 columns" id="entry-item">

    </div>
</div>