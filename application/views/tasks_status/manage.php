<?php ?>
<div class="row expanded">
    <div class="large-12 columns">
<div id="tasks-statuses-manage-feedback" class="hidden"></div>
<h3>Manager Personalized Tasks statuses</h3>
<div class="row expanded">
    <div class="large-12 columns">
    <p>My Tasks statuses</p>
    <?php
    if (!empty($tasksStatus)) {
        ?>
        <table class="tablesorter responsive expanded widget-zebra">
            <thead>
                <th>Name</th>
                <th>Description</th>
                <th>Text Colour</th>
                <th>Background Colour</th>
                <th>Actions</th>
            </thead>
            <tbody>
                <?php foreach ($tasksStatus as $k => $v) { ?>
                    <tr>    
                        <td><?php echo $v["name"]; ?></td>
                        <td><?php echo $v["description"]; ?></td>
                        <td><?php echo $v["text_colour"]; ?></td>
                        <td><?php echo $v["background_colour"]; ?></td>
                        <td>
                            <a href="/tasks/status/edit/<?php echo $v["id"];?>">edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                            <a href="/tasks/status/delete/<?php echo $v["id"];?>" onclick="return confirm_delete()">delete</a></td>
                    </tr>
                    <?php
                }
                ?>
        </tbody>
    </table>
        <?php
    }else{
        echo "<p>No personlized task statuses exist.</p>";
    }
    ?>
    </div>
</div>
<div class="row expanded">
    <div class="large-12 columns">
        <div id="manage-tasks-statuses-form">
            <h3>Create Task Status</h3>
            <?php echo validation_errors(); ?>

            <?php echo form_open('tasks/status/create') ?>
            <div class="row expanded">
                <div class="large-12 columns">
                <label for="name">Name *</label>
                <input type="text" name="name" autofocus/><br />
                </div>
                <div class="large-10 columns">
                </div>
            </div>  
            <div class="row expanded">
                <div class="large-12 columns">
                <label for="description">Description *</label>
                <textarea name="description" id="description" cols="40" rows="5" placeholder="As detailed and clear description of the problem, proposed solution and actions required to complete this task."></textarea><br/><br/>
                </div>
            </div>
            <div class="row expanded">
                <div class="large-5 columns">
                    <label for="text_colour">Text Colour</label>
                    <input type="color" name="text_colour" id="text_colour" value="" 
                        placeholder="#d8d8d8" onchange="changeColour(this)" />
                </div>
                <div class="large-2 columns">
                </div>
                <div class="large-5 columns">
                    <label for="background_colour">Background Colour</label>
                    <input type="color" name="background_colour" id="background_colour" value="" 
                        placeholder="#d8d8d8" onchange="changeColour(this)" />
                    </div>
                </div>
            </div>
                <input type="submit" name="submit" value="Create Task Domain" class="button"/>
            </form>
        </div>
    </div>
</div>
<script src="/js/third_party/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css"/ >
<script src="/js/jquery.datetimepicker.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>'
<script type="text/javascript">
    $(function() {
        CKEDITOR.replace('description');
    });
</script>
