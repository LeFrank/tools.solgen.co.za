<?php ?>
<div class="row expanded">
    <div class="large-12 columns">
        <div id="tasks-domains-manage-feedback" class="hidden"></div>
        <h3>Manager Personalized Tasks Domains</h3>
    </div>
    <div class="row expanded">
        <div class="large-12 columns">
            <p>My Tasks Domains</p>
            <?php
            if (!empty($tasksDomains)) {
                ?>
                <table>
                    <thead>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Text Colour</th>
                    <th>Background Colour</th>
                    <th>Emoji</th>
                    <th>Status</th>
                    <th>Create Date</th>
                    <th>Last Updated</th>
                    <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php foreach ($tasksDomains as $k => $v) { ?>
                            <tr>    
                                <td><?php echo $v["name"]; ?></td>
                                <td><?php echo $v["description"]; ?></td>
                                <td><?php echo $v["text_colour"]; ?></td>
                                <td><?php echo $v["background_colour"]; ?></td>
                                <td><?php echo json_decode($v["emoji"]); ?></td>
                                <td><?php echo $v["status_id"]; ?></td>
                                <td><?php echo $v["create_date"]; ?></td>
                                <td><?php echo $v["update_date"]; ?></td>
                                <td>
                                    <a href="/tasks/domains/edit/<?php echo $v["id"];?>">edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                    <a href="/tasks/domains/delete/<?php echo $v["id"];?>" onclick="return confirm_delete()">delete</a></td>
                            </tr>
                            <?php
                        }
                        ?>
                </tbody>
            </table>
                <?php
            }else{
                echo "<p>No personlized task domains exist.</p>";
            }
            ?>
        </div>
    </div>
    <div class="row expanded">
        <div class="large-12 columns" id="manage-tasks-domains-form">
            <h3>Create Task Domain</h3>
            <?php echo validation_errors(); ?>

            <?php echo form_open('tasks/domains/create') ?>
                <label for="name">Name *</label>
                <input type="text" name="name" /><br />

                <label for="description">Description *</label>
                <textarea id="description" name="description" /></textarea><br />
        </div>
    </div>
    <div class="row expanded">
        <div class="large-3 columns">
            <label for="enabled">Domain Status</label>
            <select name="enabled">
                <option value="true">True</option>
                <option value="false">False</option>';
            </select>
        </div>
        <div class="large-3 columns">
            <label for="emoji">Emoji </label>
            <input type="text" name="emoji" /><br />
        </div>
        <div class="large-3 columns">
                <label for="text_colour">Text Colour</label>
                <input type="color" name="text_colour" id="text_colour" value="" 
                    placeholder="#d8d8d8" onchange="changeColour(this)" />
                
        </div>
        <div class="large-3 columns">
                <label for="background_colour">Background Colour</label>
                <input type="color" name="background_colour" id="background_colour" value="" 
                    placeholder="#d8d8d8" onchange="changeColour(this)" />
        </div>

        </div>
    </div>
    <div class="row expanded">
        <div class="large-3 columns">
            <input type="submit" name="submit" value="Create Task Domain" class="button"/>
            </form>
        </div>
    </div>
</div>
<script src="/js/third_party/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css"/ >
<script src="/js/jquery.datetimepicker.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">
    $(function() {
        CKEDITOR.replace('description');

    });
</script>
