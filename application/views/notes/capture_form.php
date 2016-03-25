<?php ?>
<div class="row">
    <div class="large-12 columns">
        <form action="/notes/<?php echo (!empty($note->id) ? "update" : "capture" ); ?>" method="post" accept-charset="utf-8" id="captureNoteForm">
            <input type="hidden" id="id" name="id" value="<?php echo (!empty($note->id) ? $note->id : "" ); ?>" />
            <div class="error"><?php echo validation_errors(); ?></div>
            <label for="title">Title *</label>
            <input type="text" autofocus value="<?php echo (!empty($note->heading) ? $note->heading : "" ); ?>" name="title" id="title" placeholder="I wonder if ..."  />
            <br/>
            <label for="note_content">Note *</label>
            <textarea name="body" cols="40" rows="15" placeholder="Check into the thing ..."><?php echo (!empty($note->body) ? $note->body : "" ); ?></textarea>
            <br/>
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
            <br/>
            <label for="date">Date</label>
            <input type="text" value="<?php echo (!empty($note->create_date) ? $note->create_date : date('Y/m/d H:i:s')); ?>" name="noteDate" id="noteDate"/>
            <br/><br/>
            <input type="submit" value="<?php echo (!empty($note->id) ? "Update" : "Capture" ); ?>"  class="button"  />&nbsp;&nbsp;&nbsp;&nbsp;
            <input id="cancel-new-note" type="button" value="Cancel" class="button secondary"/>
        </form>
    </div>
</div>
<script type="text/javascript">
<?php if (!empty($note->tagg)) { ?>
        var tagsVar = "[<?php echo $note->tagg; ?>]";
<?php } else { ?>
        var tagsVar = "";
<?php } ?>
</script>