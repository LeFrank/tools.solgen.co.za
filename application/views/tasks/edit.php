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
                <label for="description">Description</label>
                <textarea name="description" id="description" cols="40" rows="5" placeholder="As detailed and clear description of the problem, proposed solution and actions required to complete this task."><?php echo $task->description; ?></textarea><br/><br/>
            </div>
        </div>
        <!-- <label for="template">Template</label>
        <textarea name="template" id="template" cols="40" rows="5" ><?php echo $task->description; ?></textarea><br/><br/>
         -->
        <div class="row expanded">
            <div class="large-4 columns">
                <label for="start_date">Start Date</label>
                <input autocomplete="off" type="text" id="start_date" name="start_date" value="<?php echo $task->start_date; ?>" /><br/><br/>
            </div>
            <div class="large-4 columns">
                <label for="end_date">End Date</label>
                <input autocomplete="off" type="text" id="end_date" name="end_date" value="<?php echo $task->end_date; ?>" /><br/><br/>
            </div>
            <div class="large-4 columns">
                <label for="target_date">Target Date</label>
                <input autocomplete="off" type="text" id="target_date" name="target_date" value="<?php echo $task->target_date; ?>" /><br/><br/>
            </div>
        </div>
        <input type="submit" name="submit" value="Update Task" class="button" />        <a href="/tasks" >Cancel</a>
        </form>
    </div>
</div>
<script src="/js/third_party/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css"/ >
<script src="/js/jquery.datetimepicker.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>'
<script type="text/javascript">
    $(function() {
        CKEDITOR.replace('description');
        $("#start_date").datetimepicker();
        $("#end_date").datetimepicker();
        $("#target_date").datetimepicker();
    });
</script>