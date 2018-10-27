<?php ?>
<form action="/notes/templates/<?php echo (!empty($note->id) ? "update" : "capture" ); ?>" method="post" accept-charset="utf-8" id="captureNoteTemplateForm">
    <div class="row expanded">
        <input type="hidden" id="id" name="id" value="<?php echo (!empty($note_template->id) ? $note_template->id : "" ); ?>" />
        <div class="error"><?php echo validation_errors(); ?></div>
        <!--<div class="row expanded">-->
        <div class="large-3 columns">
            <label for="name">Template Name *</label>
            <input type="text" autofocus value="<?php echo (!empty($note_template->name) ? $note_template->name : "" ); ?>" name="name" id="name" placeholder="Super common note in format where only alittle content changes ..."  />
        </div>
        <div class="large-3 columns">
            <label for="description">Description *</label>
            <input type="text" autofocus value="<?php echo (!empty($note_template->description) ? $note_template->description : "" ); ?>" name="description" id="description" placeholder="This is the most common type of ..."  />
        </div>
        <div class="large-3 columns">
            <label for="template_title">Template Title *</label>
            <input type="text" autofocus value="<?php echo (!empty($note_template->template_title) ? $note_template->template_title : "" ); ?>" name="template_title" id="template_title" placeholder="The title of the note ..."  />
        </div>
        <div class="large-3 columns">
            <label for="create_date">Date *</label>
            <input  type="text" id="create_date" name="create_date" placeholder="<?php echo date('Y/m/d H:i:s'); ?>" value="<?php echo(!empty($note_template->create_date) ? $note_template->create_date : date('Y/m/d H:i:s')); ?>"/>
        </div>
        <!--</div>-->
    </div>
    <div class="row expanded">
        <div class="large-12 columns">
            <br/>
            <label for="template_content">Template Content *</label>
            <textarea name="template_content" cols="40" rows="15" placeholder="Check into the thing ..."><?php echo (!empty($note_template->template_content) ? $note_template->template_content : "" ); ?></textarea>
        </div>
    </div>
    <div class="row expanded">
        <div class="large-12 columns">
            <label for="date">Date</label>
            <input type="text" value="<?php echo (!empty($note->create_date) ? $note->create_date : date('Y/m/d H:i:s')); ?>" name="noteDate" id="noteDate"/>
            <br/><br/>
            <input type="submit" id="submit-note" value="<?php echo (!empty($note->id) ? "Update" : "Capture" ); ?>"  class="button"  />&nbsp;&nbsp;&nbsp;&nbsp;
            <input id="cancel-new-note" type="button" value="Cancel" class="button secondary"/>
        </div>
    </div>
</form>
<script type="text/javascript">
    $("#submit-note").click(function () {
        window.onbeforeunload = null;
    });
<?php
if (isset($exitCheck) && $exitCheck == true) {
    ?>
        window.onbeforeunload = confirmOnPageExit;
        console.log("Check before exiting!");
<?php }
?>
</script>