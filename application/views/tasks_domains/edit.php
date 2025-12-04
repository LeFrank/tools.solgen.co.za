<div class="row expanded">
    <div class="large-12 columns">
        <h3>Edit  Task Domain</h3>
        <?php echo validation_errors(); ?>

        <?php echo form_open('tasks/domains/update') ?>

        <input type="hidden" name="id" value="<?php echo $taskDomain->id; ?>" />
        <label for="name">Name *</label>
        <input type="text" name="name" value="<?php echo $taskDomain->name; ?>" /><br />

        <label for="description">Description *</label>
        <textarea id="description" name="description" /><?php echo $taskDomain->description; ?></textarea><br />
    </div>
</div>
<div class="row expanded">
    <div class="large-3 columns">
        <label for="enabled">Domain Status</label>
        <select name="enabled">
            <option value="true">True</option>
            <option value="false">False</option>
        </select>
    </div>
        <div class="large-3 columns">
        <label for="emoji">Emoji </label>
        <input type="text" name="emoji" value="<?php echo json_decode($taskDomain->emoji); ?>"/><br />
    </div>
    <div class="large-3 columns">
       <label for="text_colour">Text Colour</label>
        <input type="color" name="text_colour" id="text_colour" value="<?php echo $taskDomain->text_colour; ?>" 
            placeholder="#d8d8d8" onchange="changeColour(this)" />
    </div>    
    <div class="large-3 columns">
        <label for="background_colour">Background Colour</label>
        <input type="color" name="background_colour" id="background_colour" value="<?php echo $taskDomain->background_colour; ?>" 
            placeholder="#d8d8d8" onchange="changeColour(this)" />
    </div>
</div>
<div class="row expanded">
    <div class="large-12 columns">
        <input type="submit" name="submit" value="Save" class="button" />&nbsp;&nbsp;
        <a href="/tasks/domains/manage" >Cancel</a>
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

    });
</script>