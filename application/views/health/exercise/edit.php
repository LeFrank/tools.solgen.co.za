<div class="row expanded" >
    <div class="large-12 columns" >
        <h2>Edit Exercise</h2>
    </div>
</div>
<div class="row expanded" >
    <div class="large-12 columns" >
        <form action="/health/exercise/update" method="POST">
            <input type="hidden" id="id" name="id" value="<?php echo $exercise->id; ?>"/>
            <h3>Log Exercise(s)</h3>
            <div class="row expanded">
                <div class="large-2 columns">
                    <label for="exerciseStartDate">Start Date</label>
                    <input  type="text" id="exerciseStartDate" name="exerciseStartDate" value="<?php echo $exercise->start_date; ?>" /><br/><br/>
                </div>
                <div class="large-2 columns">
                    <label for="exerciseEndDate">End Date</label>
                    <input  type="text" id="exerciseEndDate" name="exerciseEndDate" value="<?php echo $exercise->end_date; ?>" /><br/><br/>
                </div>
                <div class="large-2 columns">
                    <label for="exerciseType">Exercise Type</label>
                    <select name="exerciseType" id="exerciseType" >
                        <option value="0">None</option>
                        <?php
                        foreach ($exerciseTypes as $k => $v) {
                            echo "<option value='" . $v["id"] . 
                                "' data-default_measurement_name=".$v["default_measurement_name"].
                                " ". (($exercise->exercise_type_id == $v["id"]) ? "selected='selected'" : "" )  ." >" . 
                                $v["name"] . 
                                "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="large-2 columns">
                    <label for="measurement_value" id="measurement_value_label">Measurement Name</label>
                    <input type="number" min="0.01" step="0.01" max="9999999999999" name="measurement_value" id="measurement_value" value="<?php echo $exercise->measurement_value; ?>"/><br />
                </div>
                <div class="large-2 columns">
                    <label for="distance">Distance (Meters)*</label>
                    <input type="number" name="distance" id="distance" value="<?php echo $exercise->distance; ?>"/><br />
                </div>
                <div class="large-2 columns">
                    <label for="difficulty">Difficulty</label>
<!--                    <input type="number" min="0" step="1" max="10" name="difficulty" id="difficulty" placeholder="5"/><br />-->
                    <select name="difficulty" id="difficulty" >
                        <option value="1" <?php echo (($exercise->difficulty == 1) ? "selected='selected'" : "" ); ?> >1 - Easy, no sweat</option>
                        <option value="2" <?php echo (($exercise->difficulty == 2) ? "selected='selected'" : "" ); ?>>2 - Easy with some variation in elevation</option>
                        <option value="3" <?php echo (($exercise->difficulty == 3) ? "selected='selected'" : "" ); ?>>3 - Easy with technical sections</option>
                        <option value="4" <?php echo (($exercise->difficulty == 4) ? "selected='selected'" : "" ); ?>>4 - Moderate, worked up a good sweat</option>
                        <option value="5" <?php echo (($exercise->difficulty == 5) ? "selected='selected'" : "" ); ?>>5 - Moderate with variations in elevations</option>
                        <option value="6" <?php echo (($exercise->difficulty == 6) ? "selected='selected'" : "" ); ?>>6 - Moderate with technical sections</option>
                        <option value="7" <?php echo (($exercise->difficulty == 7) ? "selected='selected'" : "" ); ?>>7 - Hard, endurance required</option>
                        <option value="8" <?php echo (($exercise->difficulty == 8) ? "selected='selected'" : "" ); ?>>8 - Hard, strength and stamina required</option>
                        <option value="9" <?php echo (($exercise->difficulty == 9) ? "selected='selected'" : "" ); ?>>9 - Hard, intense training and specific preparation required</option>
                        <option value="10" <?php echo (($exercise->difficulty == 10) ? "selected='selected'" : "" ); ?>>10 - Intense, pushed to beyond the limit</option>
                    </select>
                </div>
            </div>
            <div class="row expanded">
                <div class="large-12 columns">
                    <label for="note">Description</label>
                    <textarea name="description" id="description" cols="40" rows="5" ><?php echo $exercise->description; ?></textarea><br/><br/>
                </div>
            </div>
            <div class="row expanded">
                <div class="large-12 columns">
                    <span>* Required Field</span><br/><br/>
                    <input type="submit" name="submit" value="Update" class="button"/>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="/js/third_party/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
<script src="/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/js/third_party/jquery.tablesorter.min.js"></script>
<script src="/js/third_party/jquery/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/health/exercise/tracker.js"></script>