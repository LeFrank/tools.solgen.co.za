<div class="row expanded">
    <div class="large-12 columns">
        <h3>Edit Task</h3>
        <?php echo validation_errors(); ?>

        <?php echo form_open('tasks/update') ?>
        <div class="row expanded">
            <div class="large-2 columns">
                <label for="domain_id">Domain</label>
                <select name="domain_id" id="domain_id"> 
                    <?php
                    foreach ($tasksDomains as $k => $v) {
                        if ($v["id"] == $task->domain_id) {
                            $selected = " selected";
                        } else {
                            $selected = "";
                        } 
                        echo '<option value="' . $v["id"] .'" ' .$selected.'>' . $v["name"] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="id" value="<?php echo $task->id; ?>" />
            <div class="large-8 columns">
                <label for="name">Name *</label>
                <input type="text" name="name" value="<?php echo $task->name; ?>" /><br />
            </div>

            <div class="large-2 columns">
                <label for="status">Status</label>
                <select name="status">
                    <?php
                        foreach ($tasksStatuses as $k => $v) {
                            if ($v["id"] == $task->status_id) {
                                $selected = " selected";
                            } else {
                                $selected = "";
                            } 
                            echo '<option value="' . $v["id"] . '" '. $selected .'  >' . $v["name"] . '</option>';
                        }
                    ?>
                </select>
            </div>
        </div>

        <div class="row expanded">
            <div class="large-12 columns">
                &nbsp;
            </div>
        </div>
        <div class="row expanded">
            <div class="large-2 columns">
                <label for="importance_level_id">Importance</label>
                <select name="importance_level_id">
                    <?php
                    foreach ($importanceLevels as $k => $v) {
                        $default = "";
                        if ($v["id"] == $task->importance_level_id) {
                            $default = " selected ";
                        }
                        echo '<option value="' . $v["id"] . '"' . $default . '>' . $v["name"] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="large-2 columns">
                <label for="urgency_level_id">Urgency</label>
                <select name="urgency_level_id">
                    <?php
                    foreach ($urgencyLevels as $k => $v) {
                        $default = "";
                        if ($v["id"] == $task->urgency_level_id) {
                            $default = " selected ";
                        }
                        echo '<option value="' . $v["id"] . '"' . $default . '>' . $v["name"] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="large-2 columns">
                <label for="risk_level_id">Risk</label>
                <select name="risk_level_id">
                    <?php
                    foreach ($riskLevels as $k => $v) {
                        $default = "";
                        if ($v["id"] == $task->risk_level_id) {
                            $default = " selected ";
                        }
                        echo '<option value="' . $v["id"] . '"' . $default . '>' . $v["name"] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="large-3 columns">
                <label for="gain_level_id">Gain </label>
                <select name="gain_level_id">
                    <?php
                    foreach ($gainLevels as $k => $v) {
                        $default = "";
                        if ($v["id"] == $task->gain_level_id) {
                            $default = " selected ";
                        }
                        echo '<option value="' . $v["id"] . '"' . $default . '>' . $v["name"] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="large-3 columns">
                <label for="reward_category_id">Reward</label>
                <select name="reward_category_id">
                    <?php
                    foreach ($rewardsCategory as $k => $v) {
                        $default = "";
                        if ($v["id"] == $task->reward_category_id) {
                            $default = " selected ";
                        }
                        echo '<option value="' . $v["id"] . '"' . $default . '>' . $v["name"] . '</option>';
                    }
                    ?>
                </select>

            </div>
        </div>

        <div class="row expanded">
            <div class="large-12 columns">
                <label for="description">Description</label>
                <textarea name="description" id="description" cols="40" rows="5" placeholder="As detailed and clear description of the problem, proposed solution and actions required to complete this task."><?php echo $task->description; ?></textarea><br/><br/>
            </div>
        </div>
        <!-- <label for="template">Template</label>
        <textarea name="template" id="template" cols="40" rows="5" ><?php echo $task->description; ?></textarea><br/><br/>
         -->
        <div class="row expanded">
            <div class="large-2 columns">
                <label for="start_date">Start Date</label>
                <input autocomplete="off" type="text" id="start_date" name="start_date" value="<?php echo $task->start_date; ?>" /><br/><br/>
            </div>
            <div class="large-2 columns">
                <label for="end_date">End Date</label>
                <input autocomplete="off" type="text" id="end_date" name="end_date" value="<?php echo $task->end_date; ?>" /><br/><br/>
            </div>
            <div class="large-2 columns">
                <label for="target_date">Target Date</label>
                <input autocomplete="off" type="text" id="target_date" name="target_date" value="<?php echo $task->target_date; ?>" /><br/><br/>
            </div>
            <div class="large-2 columns">
                <label for="cycle_id">Cycles</label>
                <select name="cycle_id">
                    <?php
                    foreach ($cycles as $k => $v) {
                        $default = "";
                        if ($v["id"] == $task->cycle_id) {
                            $default = " selected ";
                        }
                        echo '<option value="' . $v["id"] . '"' . $default . '>' . $v["name"] . '</option>';
                    }
                    ?>
                </select>
            </div>
                <div class="large-2 columns">
                <label for="scale_id">Scale</label>
                <select name="scale_id">
                    <?php
                    foreach ($scales as $k => $v) {
                        $default = "";
                        if ($v["id"] == $task->scale_id) {
                            $default = " selected ";
                        }
                        echo '<option value="' . $v["id"] . '"' . $default . '>' . $v["name"] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="large-1 columns">
                <label for="scope_id">Scope</label>
                <select name="scope_id">
                    <?php
                    foreach ($scopes as $k => $v) {
                        $default = "";
                        if ($v["id"] == $task->scope_id) {
                            $default = " selected ";
                        }
                        echo '<option value="' . $v["id"] . '"' . $default . '>' . $v["name"] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="large-1 columns">
                <label for="difficulty_level_id">Difficulty</label>
                <select name="difficulty_level_id">
                    <?php
                    foreach ($difficultyLevels as $k => $v) {
                        $default = "";
                        if ($v["id"] == $task->difficulty_level_id) {
                            $default = " selected ";
                        }
                        echo '<option value="' . $v["id"] . '"' . $default . '>' . $v["name"] . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <input type="submit" name="submit" value="Update Task" class="button" />        <a href="/tasks" >Cancel</a>
        </form>
    </div>
</div>
<script src="/js/third_party/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css"/ >
<script src="/js/jquery.datetimepicker.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    $(function() {
        CKEDITOR.replace('description');
        $("#start_date").datetimepicker();
        $("#end_date").datetimepicker();
        $("#target_date").datetimepicker();
    });
</script>