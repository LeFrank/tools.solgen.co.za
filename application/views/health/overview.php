<?php 
    $numberOfDays = floor((strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24));
?>
<br/>
<div class="row expanded">
    <div class="large-12 columns" >
        <h2>Statistics for the period ( <?php echo $numberOfDays; ?> days ) &nbsp;</h2>
    </div>
</div>
<div class="row expanded">
    <?php echo form_open('/health') ?>
    <div class="large-4 columns" >
        <label>
            From<input type="text" name="fromDate" id="fromDate" value="<?php echo $startDate; ?>"/>
        </label>
    </div>
    <div class="large-4 columns" >
        <label>
            To<input type="text" name="toDate" id="toDate" value="<?php echo $endDate; ?>"/> 
        </label>
    </div>
    <div class="large-4 columns" style="vertical-align: central;margin-top:15px;" >
        <input type="submit" name="filter" value="Filter" id="filter"  class="button"/>
    </div>
    <?php echo form_close(); ?>
</div>
<div class="row expanded">
    <div class="large-12 columns" >
        <div class="large-4 columns" >
            <h2>Metrics</h2>
            <ul>
                <li>Metrics captured: <?php echo number_format($healthMetricsStats->total_captured, 2, ".", ""); ?></li>
                <li>Average Per Day: <?php echo number_format($healthMetricsStats->total_captured / $numberOfDays, 2, ".", ""); ?></li>
                <li>Average Weight: <?php echo number_format($healthMetricsStats->average_weight, 2, ".", ""); ?> Kg</li>
                <li>Minimum Weight: <?php echo number_format($healthMetricsStats->minimum_weight, 2, ".", ""); ?> Kg</li>
                <li>Maximum Weight: <?php echo number_format($healthMetricsStats->maximum_weight, 2, ".", ""); ?> Kg</li>
                <li>Average Waist: <?php echo number_format($healthMetricsStats->average_waist, 2, ".", ""); ?> cm</li>
                <li>Minimum Waist: <?php echo number_format($healthMetricsStats->minimum_waist, 2, ".", ""); ?> cm</li>
                <li>Maximum Waist: <?php echo number_format($healthMetricsStats->maximum_waist, 2, ".", ""); ?> cm</li>
                <li>Average Sleep: <?php echo number_format($healthMetricsStats->average_sleep, 2, ".", ""); ?> hours</li>
                <li>Minimum Sleep: <?php echo number_format($healthMetricsStats->minimum_sleep, 2, ".", ""); ?> hours</li>
                <li>Maximum Sleep: <?php echo number_format($healthMetricsStats->maximum_sleep, 2, ".", ""); ?> hours</li>
            </ul>
        </div>
        <div class="large-8 columns" >
            <h2>&nbsp;</h2>
            Graphs goes here
        </div>
    </div>
</div>
<div class="row expanded">
    <div class="large-12 columns" >    
        <div class="large-4 columns" >
            <h2>Exercises</h2>
            <ul>
                <li>Exercises captured: <?php echo number_format($exerciseStats->total_captured, 0, ".", ""); ?></li>
                <li>Once every <?php echo number_format($numberOfDays / $exerciseStats->total_captured , 2, ".", ""); ?> Days</li>
                <li>Number of Exercise Types: <?php echo number_format($exerciseStats->number_of_exercise_types, 0, ".", ""); ?></li>
                <li>Average Difficulty: <?php echo number_format($exerciseStats->average_difficulty, 0, ".", ""); ?></li>
                <li>Minimum Difficulty: <?php echo number_format($exerciseStats->minimum_difficulty, 0, ".", ""); ?></li>
                <li>Maximum Difficulty: <?php echo number_format($exerciseStats->maximum_difficulty, 0, ".", ""); ?></li>
            </ul>
            <h3>Per Exercise</h3>
            <?php
                foreach($exerciseByExcerciseTypeStats as $k=>$v){
            ?>
                <ul>
                    <li>Exercises Type: <?php echo $exerciseTypes[$v["exercise_type_id"]]["name"]; ?></li>
                    <li>Number of Exercises: <?php echo $v["exercise_count"]; ?></li>
                    <li>Average <?php echo $exerciseTypes[$v["exercise_type_id"]]["default_measurement_name"];?>: <?php echo number_format($v["average_value"], 0, ".", ","); ?></li>
                    <li>Minimum <?php echo $exerciseTypes[$v["exercise_type_id"]]["default_measurement_name"]; ?>: <?php echo number_format($v["minimum_value"], 0, ".", ","); ?></li>
                    <li>Maximum <?php echo $exerciseTypes[$v["exercise_type_id"]]["default_measurement_name"]; ?>: <?php echo number_format($v["maximum_value"], 0, ".", ","); ?></li>
                    <li>Average Distance: <?php echo number_format($v["average_distance"], 0, ".", ","); ?></li>
                    <li>Minimum Distance: <?php echo number_format($v["minimum_distance"], 0, ".", ","); ?></li>
                    <li>Maximum Distance: <?php echo number_format($v["maximum_distance"], 0, ".", ","); ?></li>
                </ul>
            <?php
                }
            ?>
        </div>
            <div class="large-8 columns" >
            <h2>&nbsp;</h2>
            Graphs goes here
        </div>
    </div>
</div>

<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
<script src="/js/jquery.datetimepicker.js"></script>
<script src="/js/third_party/jquery/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    $(function () {
        $("#fromDate").datetimepicker();
        $("#toDate").datetimepicker();
    });
</script>