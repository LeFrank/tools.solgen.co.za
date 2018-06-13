<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="row expanded" >
    <div class="large-12 columns" >
        <h2>Exercise Tracker</h2>
    </div>
</div>
<div class="row expanded" >
    <div class="large-12 columns" >
        <form action="/health/exercise/capture" method="POST">
            <h3>Log Exercise(s)</h3>
            <div class="row expanded">
                <div class="large-2 columns">
                    <label for="exerciseStartDate">Start Date</label>
                    <input  type="text" id="exerciseStartDate" name="exerciseStartDate" placeholder="<?php echo date('Y/m/d H:i:s'); ?>" /><br/><br/>
                </div>
                <div class="large-2 columns">
                    <label for="exerciseEndDate">End Date</label>
                    <input  type="text" id="exerciseEndDate" name="exerciseEndDate" placeholder="<?php echo date('Y/m/d H:i:s'); ?>" /><br/><br/>
                </div>
                <div class="large-2 columns">
                    <label for="exerciseType">Exercise Type</label>
                    <select name="exerciseType" id="exerciseType" >
                        <?php 
                            foreach($expenseTypes as $k=>$v){
                                echo "<option value='".$v["id"]."'>".$v["name"]."</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="large-2 columns">
                    <label for="measurement_value">Measurement Name</label>
                    <input type="number" min="0.01" step="0.01" max="9999999999999" name="measurement_value" id="measurement_value" placeholder="0.00"/><br />
                </div>
                <div class="large-2 columns">
                    <label for="distance">Distance (Meters)*</label>
                    <input type="number" name="distance" id="distance" placeholder="1"/><br />
                </div>
                <div class="large-2 columns">
                    <label for="difficulty">Difficulty</label>
                    <input type="number" min="0" step="1" max="10" name="difficulty" id="difficulty" placeholder="5"/><br />
                </div>
            </div>
            <div class="row expanded">
                <div class="large-12 columns">
                    <label for="note">Description</label>
                    <textarea name="description" id="description" cols="40" rows="5" placeholder="Anything significant happened, or something that could have impact on your goals positive or negative."></textarea><br/><br/>
                </div>
            </div>
            <div class="row expanded">
                <div class="large-12 columns">
                    <span>* Required Field</span><br/><br/>
                    <input type="submit" name="submit" value="Record" class="button"/>
                </div>
            </div>
        </form>
    </div>
</div>
<hr/>
<div class="row expanded" >
    <div class="large-12 columns" >
        Metrics from <?php echo $startAndEndDate[0]; ?> to <?php echo $startAndEndDate[1]; ?><br/><br/>
            <?php if (is_array($exercises) && !empty($exercises)) {
                ?>
                <table id="health_metrics_history" class="tablesorter responsive">
                    <thead>
                        <tr>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Exercise Type</th>
                            <th>Measurement</th>
                            <th>Distance (meters)</th>
                            <th>Difficulty</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($exercises as $k => $v) {
                            echo "<tr>";
                            echo "<td>" . date_format(date_create($v["start_date"]), "l, d F Y @ H:i") . "</td>";
                            echo "<td>" . date_format(date_create($v["end_date"]), "l, d F Y @ H:i") . "</td>";
                            echo "<td>" . $v["exercise_type_id"] . "</td>";
                            echo "<td>" . $v["measurement_value"] . "</td>";
                            echo "<td>" . $v["distance"] . "</td>";
                            echo "<td>" . $v["difficulty"] . "</td>";
                            echo "<td>" . $v["description"] . "</td>";
                            echo "<td><a href='/health/metric/edit/" . $v["id"] . "'>Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='/health/metric/delete/" . $v["id"] . "' onclick='return confirm_delete()'>Delete</a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo "No metrics captured yet.";
            }
            ?>
    </div>
</div>
    
<script src="/js/third_party/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
<script src="/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/js/third_party/jquery.tablesorter.min.js"></script>
<script src="/js/third_party/jquery/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/location/autocomplete.js"></script>
<script type="text/javascript">
    $(function () {
        $("#exerciseStartDate").datetimepicker();
        $("#exerciseEndDate").datetimepicker();
        CKEDITOR.replace('description');
    });
</script>