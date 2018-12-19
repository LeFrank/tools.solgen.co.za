<?php 
?>
<div class="row expanded">
    <div class="large-12 columns">
        <form action="/notes/<?php echo (!empty($note->id) ? "update" : "capture" ); ?>" method="post" accept-charset="utf-8" id="captureNoteForm" name="captureNoteForm">
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
            <input type="submit" id="submit-note" value="<?php echo (!empty($note->id) ? "Update" : "Capture" ); ?>"  class="button"  />&nbsp;&nbsp;&nbsp;&nbsp;
            <input id="cancel-new-note" type="button" value="Cancel" class="button secondary"/>&nbsp;&nbsp;<span id="note_status"></span>
        </form>
    </div>
</div>
<script type="text/javascript">
    $("#submit-note").click(function(){
        window.onbeforeunload = null;
    });
    
    function stopAutoSave(){
        clearInterval(refreshIntervalId);
        return null;
    }
    
    function startAutoSave(){
        // Auto save
    // get the target save interval. default 5 minutes
    // get auto save setting
//        console.log(CKEDITOR.instances['body'].getData().length);
    <?php
        if(!empty($note->id)){
    ?>    
        var currentContentLength = CKEDITOR.instances['body'].getData().length
        refreshIntervalId = window.setInterval(function(){
//            console.log(currentContentLength + " ? " + CKEDITOR.instances['body'].getData().length);
            if(currentContentLength != CKEDITOR.instances['body'].getData().length){
                $.ajax({
                    method: "POST",
                    url: "/notes/update/",
                    data: {id: $("#id").val() , title: $("#title").val(), body: CKEDITOR.instances['body'].getData() , tags: $("#noteTaggs").val(), noteDate: $("#noteDate").val() }
                }).done(function (msg, resp) {
                    if(resp === "success"){
                        $("#note_status").html("Note Auto-saved");
                        currentContentLength = CKEDITOR.instances['body'].getData().length;
                        delay(function(){
                            $("#note_status").html("Last Auto-save: " + moment().format('hh:mm:ss') );
                        },5000);
                    }
                });
            }
        }, 5 * 1000 * 60 );
    <?php
        }
    ?>
        return null;
    }
    
$(document).ready(function () {
    var refreshIntervalId = null;
    startAutoSave();
    
<?php 
    if(isset($exitCheck) && $exitCheck == true){
        ?>
        window.onbeforeunload = confirmOnPageExit;
        <?php 
    }
    if (!empty($note->tagg)) { ?>
        tagsVar = "[<?php echo $note->tagg; ?>]";
    <?php } else { ?>
        tagsVar = "[]";
    <?php } ?>

    });
</script>