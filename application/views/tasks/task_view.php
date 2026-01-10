<?php
    // print_r($task);
?>
<?php echo form_open('tasks/update_short') ?>
<div class="row expanded">
    <div class="large-12 columns" >
        <h1>Task Details</h1>
        <div class="row expanded">
            <div class="large-6 columns">
                <label>Task Name: </label>
                <p><?php echo $task->name; ?></p><br/>
                <label>Description:</label><p><?php echo $task->description; ?></p><br/>
                <div class="row expanded">
                    <div class="large-6 columns">
                        <label>Domain:</label><p><?php echo $tasksDomains[$task->domain_id]["name"]; ?></p><br/>
                        <label>Status:</label><p> <?php echo $tasksStatuses[$task->status_id]["name"]; ?></p><br/>
                    </div>
                    <div class="large-6 columns">
                        <label>Scale:</label><p> <?php echo $scales[$task->scale_id]["name"]; ?></p><br/>
                        <label>Scope:</label><p> <?php echo $scopes[$task->scope_id]["name"]; ?></p><br/>
                    </div>
                </div>
            </div>
            <div class="large-3 columns">
                <label>Created On:</label><p><?php echo date_format(date_create($task->create_date), 'D,  d M Y - H:m'); ?></p><br/>
                <label>Start Date:</label><p><?php echo date_format(date_create($task->start_date), 'D,  d M Y - H:m'); ?></p><br/>
                <label>Target Date:</label><p><?php echo date_format(date_create($task->target_date), 'D,  d M Y - H:m'); ?></p><br/>
            </div>
            <div class="large-3 columns">
                <label>Importance:</label><p> <?php echo $importanceLevels[$task->importance_level_id]["name"]; ?></p><br/>
                <label>Urgency:</label><p> <?php echo $urgencyLevels[$task->urgency_level_id]["name"]; ?></p><br/>
                <label>Risk:</label><p> <?php echo $riskLevels[$task->risk_level_id]["name"]; ?></p><br/>
                <label>Gain:</label><p> <?php echo $gainLevels[$task->gain_level_id]["name"]; ?></p><br/>
                <label>Reward Category:</label><p> <?php echo $rewardsCategory[$task->reward_category_id]["name"]; ?></p><br/>
                <label>Cycle:</label><p> <?php echo $cycles[$task->cycle_id]["name"]; ?></p><br/>
                <label>Difficulty:</label><p> <?php echo $difficultyLevels[$task->difficulty_level_id]["name"]; ?></p><br/>
            </div>
        </div>
    </div>
</div>
<div class="row expanded">
    <div class="large-6 columns" >
        <label>Description:</label><br/>
        <textarea name="description" id="description" cols="40" rows="5" placeholder="As detailed and clear description of the problem, proposed solution and actions required to complete this task."><?php echo $task->description; ?></textarea><br/><br/>
        <input type="hidden" class="hidden" name="id" value="<?php echo $task->id; ?>" />
        <input type="submit" name="submit" value="Update" class="button primary" />
        <a href="/tasks/edit/<?php echo $task->id; ?>" class="button">Edit Task</a>
    </div>
    <div class="large-6 columns" >
        <br/><br/>
        <h2>Notes</h2>
        <div>
            <!-- Notes will go here -->
            <ol>
                <li>Note 1</li>
                <li>Note 2</li> 
            </ol>
        </div>
        <h3>Add Artefacts</h3>
        <div>
            <!-- Artefact upload will go here -->
            <ol>
                <li>Artefact 1</li>
                <li>Artefact 2</li> 
            </ol>
        </div>
    </div>
</div>
</form>
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

<!-- 
stdClass Object ( 

[id] => 56 
[domain_id] => 15 
[name] => Personal => View of todays tasks 
[description] =>
Show tasks which are targetted for today, or for this week.

[status_id] => 4 
[user_id] => 1 
[create_date] => 2026-01-03 17:17:52 
[update_date] => 2026-01-03 17:17:52 
[start_date] => 2026-01-03 17:17:00 
[end_date] => 2026-01-04 17:29:00 
[target_date] => 2026-01-06 22:00:00 
[importance_level_id] => 5 
[urgency_level_id] => 5 
[risk_level_id] => 1 
[gain_level_id] => 9 
[reward_category_id] => 7 
[cycle_id] => 1 
[scale_id] => 2 
[scope_id] => 1 
[difficulty_level_id] => 1 ) -->