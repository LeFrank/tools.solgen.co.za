<?php ?>
<form action="/notes/<?php echo (!empty($note->id) ? "update" : "capture" ); ?>" method="post" accept-charset="utf-8" id="captureNoteForm" name="captureNoteForm">
    <div class="row expanded">
        <div class="large-12 columns">
            <input type="hidden" id="id" name="id" value="<?php echo (!empty($note->id) ? $note->id : "" ); ?>" />
            <div class="error"><?php echo validation_errors(); ?></div>
        </div>
    </div>
    <?php if (empty($note->id)) { ?>
        <div class="row expanded">
            <div class="large-12 columns">
                <label for="title">Title *</label>
                <input type="text" autofocus value="<?php echo (!empty($note->heading) ? $note->heading : "" ); ?>" name="title" id="title" placeholder="I wonder if ..."  />
            </div>
        </div> 
    <?php } else { ?>
        <div class="row expanded">
            <div class="large-10 columns">
                <label for="title">Title *</label>
                <input type="text" autofocus value="<?php echo (!empty($note->heading) ? $note->heading : "" ); ?>" name="title" id="title" placeholder="I wonder if ..."  />
            </div>
            <div class="large-2 columns">

                <label for="title">Auto Save during this session?</label>
                <div class="switch large">
                    <input class="switch-input" id="auto_save" type="checkbox" name="auto_save" <?php echo ($userNotesConfigs["auto_save_note"]) ? 'checked' : ''; ?> data-id="<?php echo $userNotesConfigs["auto_save_note_id"]; ?>">
                    <label class="switch-paddle" for="auto_save">
                        <span class="show-for-sr">Do you like me?</span>
                        <span class="switch-active" aria-hidden="false">Yes</span>
                        <span class="switch-inactive" aria-hidden="true">No</span>
                    </label>
                </div>
            </div>
        </div>
    <?php } ?>    
    <div class="row expanded">
        <div class="large-12 columns">
            <label for="note_content">Note *</label>
            <textarea name="body" cols="40" rows="15" placeholder="Check into the thing ..."><?php echo (!empty($note->body) ? $note->body : "" ); ?></textarea>
        </div>
    </div>
    <div class="row expanded">
        <div class="large-12 columns">
            <label for="taggs">Tags</label>
            <ul id="noteTaggs" name="tags">
                <?php
                if (!empty($note->tagg)) {
                    $tags = explode(",", $note->tagg);
                    foreach ($tags as $k => $v) {
                        echo "<li>" . $v . "</li>";
                    }
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="row expanded">
        <div class="large-12 columns">
            <label for="date">Date</label>
            <input type="text" value="<?php echo (!empty($note->create_date) ? $note->create_date : date('Y/m/d H:i:s')); ?>" name="noteDate" id="noteDate"/>
        </div>
    </div>
    <div class="row expanded">
        <div class="large-12 columns">
            &nbsp;
        </div>
    </div>
    <div class="row expanded">
        <div class="large-12 columns">
            <input type="submit" id="submit-note" value="<?php echo (!empty($note->id) ? "Update" : "Capture" ); ?>"  class="button"  />&nbsp;&nbsp;&nbsp;&nbsp;
            <input id="cancel-new-note" type="button" value="Cancel" class="button secondary"/>
            &nbsp;&nbsp;<span id="note_status"></span>
        </div>
    </div>
</form>
<script type="text/javascript">
    $("#submit-note").click(function () {
        window.onbeforeunload = null;
    });
<?php
if (!empty($note->id)) {
    ?>

        function stopAutoSave() {
            clearInterval(refreshIntervalId);
            console.log("Stopping Auto Saver ");
            return null;
        }

        function startAutoSave() {
            // Auto save
            // get the target save interval. default 5 minutes
            // get auto save setting
            console.log("Starting Auto Saver ");
            // console.log(CKEDITOR.instances['body'].getData().length);
            var currentContentLength = CKEDITOR.instances['body'].getData().length
            refreshIntervalId = window.setInterval(function () {
                // console.log(currentContentLength + " ? " + CKEDITOR.instances['body'].getData().length);
                if (currentContentLength != CKEDITOR.instances['body'].getData().length) {
                    $.ajax({
                        method: "POST",
                        url: "/notes/update/",
                        data: {id: $("#id").val(), title: $("#title").val(), body: CKEDITOR.instances['body'].getData(), tags: $("#noteTaggs").val(), noteDate: $("#noteDate").val()}
                    }).done(function (msg, resp) {
                        if (resp === "success") {
                            $("#note_status").html("Note Auto-saved");
                            currentContentLength = CKEDITOR.instances['body'].getData().length;
                            delay(function () {
                                $("#note_status").html("Last Auto-save: " + moment().format('HH:mm:ss'));
                            }, 5000);
                        }
                    });
                }
            }, <?php echo $userNotesConfigs["auto_save_note_interval"] ?> * 1000 * 60);
            return null;
        }

        $(document).ready(function () {
            var refreshIntervalId = null;
            <?php if($userNotesConfigs["auto_save_note"] == 1){ ?>
                startAutoSave();
            <?php } ?>
            $("#auto_save").change(function () {
                console.log("Checked = " + $(this).is(":checked"));
                if ($(this).is(":checked")) {
                    startAutoSave();
                } else {
                    stopAutoSave();
                }
            });
        });
    <?php
}
?>
    $(document).ready(function () {
<?php
if (isset($exitCheck) && $exitCheck == true) {
    ?>
            window.onbeforeunload = confirmOnPageExit;
    <?php
}
if (!empty($note->tagg)) {
    ?>
            tagsVar = "[<?php echo $note->tagg; ?>]";
<?php } else { ?>
            tagsVar = "[]";
<?php } ?>

    });
</script>