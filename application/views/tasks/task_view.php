<?php
    // print_r($task);
?>

<div class="row expanded">
    <div class="large-12 columns" >
        <h2><?php echo $task->name; ?></h2>
        <div class="row expanded">
            <div class="large-2 columns">
                <?php 
                    $field_style = "style='padding-left:10px;padding-top:5px;padding-bottom:5px;"
                        . "background-color: "
                        . $tasksDomains[$task->domain_id]["background_colour"]
                        . ";"
                        . "color: "
                        . $tasksDomains[$task->domain_id]["text_colour"]
                        . ";"
                        . "'";
                ?>
                <label>Domain:</label><p  <?php echo $field_style; ?>><?php echo $tasksDomains[$task->domain_id]["name"]; ?></p><br/>
                <?php 
                    $field_style = "style='padding-left:10px;padding-top:5px;padding-bottom:5px;"
                        . "background-color: "
                        . $tasksStatuses[$task->status_id]["background_colour"]
                        . ";"
                        . "color: "
                        . $tasksStatuses[$task->status_id]["text_colour"]
                        . ";"
                        . "'";
                ?>
                <label>Status:</label><p <?php echo $field_style; ?> > <?php echo $tasksStatuses[$task->status_id]["name"]; ?></p><br/>
                <label>Importance:</label><p> <?php echo $importanceLevels[$task->importance_level_id]["name"]; ?></p><br/>
            </div>
            <div class="large-2 columns">
                <label>Scale:</label><p> <?php echo $scales[$task->scale_id]["name"]; ?></p><br/>
                <label>Scope:</label><p> <?php echo $scopes[$task->scope_id]["name"]; ?></p><br/>
                <label>Importance:</label><p> <?php echo $importanceLevels[$task->importance_level_id]["name"]; ?></p><br/>
            </div>
            <div class="large-2 columns">
                <label>Created On:</label><p><?php echo date_format(date_create($task->create_date), 'D,  d M Y - H:m'); ?></p><br/>
                <label>Start Date:</label><p><?php echo date_format(date_create($task->start_date), 'D,  d M Y - H:m'); ?></p><br/>
                <label>Target Date:</label><p><?php echo date_format(date_create($task->target_date), 'D,  d M Y - H:m'); ?></p><br/>
                <label>End Date:</label><p><?php echo date_format(date_create($task->end_date), 'D,  d M Y - H:m'); ?></p><br/>
            </div>
            <div class="large-2 columns">
                <label>Urgency:</label><p> <?php echo $urgencyLevels[$task->urgency_level_id]["name"]; ?></p><br/>
                <label>Risk:</label><p> <?php echo $riskLevels[$task->risk_level_id]["name"]; ?></p><br/>
                <label>Cycle:</label><p> <?php echo $cycles[$task->cycle_id]["name"]; ?></p><br/>
               
            </div>
            <div class="large-2 columns">
                 <label>Risk:</label><p> <?php echo $riskLevels[$task->risk_level_id]["name"]; ?></p><br/>
                <label>Gain:</label><p> <?php echo $gainLevels[$task->gain_level_id]["name"]; ?></p><br/>
                <label>Reward Category:</label><p> <?php echo $rewardsCategory[$task->reward_category_id]["name"]; ?></p><br/>
            </div>
            <div class="large-2 columns">
                 <label>Urgency:</label><p> <?php echo $urgencyLevels[$task->urgency_level_id]["name"]; ?></p><br/>
                  <label>Difficulty:</label><p> <?php echo $difficultyLevels[$task->difficulty_level_id]["name"]; ?></p><br/>
            </div>
        </div>
    </div>
</div>
<div class="row expanded">
    <div class="large-6 columns" >
        <?php echo form_open('tasks/update_short') ?>
            <label>Description:</label><br/>
            <textarea name="description" id="description" cols="40" rows="5" placeholder="As detailed and clear description of the problem, proposed solution and actions required to complete this task."><?php echo $task->description; ?></textarea><br/><br/>
            <input type="hidden" class="hidden" name="id" value="<?php echo $task->id; ?>" />
            <input type="hidden" class="hidden" name="taskId" id="taskId" value="<?php echo $task->id; ?>" />
            <input type="submit" name="submit" value="Update" class="button primary" />
            <a href="/tasks/edit/<?php echo $task->id; ?>" class="button">Edit Task</a>
        </form>
    </div>
    <div class="large-6 columns" >
        <br/><br/>
        <h2>Work Notes&nbsp</h2>
        <div>
            <div>
                <?php
                // print_r($workNotes);
                if(!empty($workNotes)){
                    foreach($workNotes as $kk=>$vv){
                        ?>
                        <div class="row expanded">
                            <div class="large-10 columns" >
                        <?php
                                echo "<p><strong>Added on: </strong>".date_format(date_create($vv["create_date"]), 'D,  d M Y - H:m')."</p>";
                        ?>
                                <span 
                                    class="editable"
                                    data-url="/tasks/work-note/update/<?php echo $vv["id"]; ?>"
                                    data-type="textarea"
                                    data-ok-button="OK"
                                    data-cancel-button="Cancel" 
                                    >
                                    <?php echo (!empty($vv["work_note"]))?nl2br($vv["work_note"]):""; ?>
                                </span>
                            </div>
                            <div class="large-2 columns" >
                                <p>
                                    <a href="/tasks/<?php echo $task->id; ?>/work-note/delete/<?php echo $vv["id"]; ?>" onclick="return confirm_delete();" id="work_note_delete_link">Delete</a>
                                </p>
                            </div>
                        </div>
                    <hr/>   
                    <br/>  
                <?php } 
                }?>
                <span 
                    class="editable"
                    data-url="/tasks/work-note/<?php echo $task->id; ?>"
                    data-type="textarea"
                    data-ok-button="OK"
                    data-cancel-button="Cancel" 
                    >
                    <?php echo (!empty($work_notes["work_note"]))?$work_notes["work_note"]:""; ?>
                </span>
                <br/>
            </div>
        </div>
        <br/>
        <h2>Artefacts&nbsp;</h2>
        <div id="artefact-list-view" name="artefact-list-view">
            <?php if (!empty($userContentArray)) { ?>
                <?php $this->load->view('tasks/task_view_artefacts_post_upload', ['userContentArray' => $userContentArray, 'tools' => $tools]); ?>
            <?php } ?>
        </div>
        <br/>
        <div>
            <?php echo form_open_multipart('tasks/task/'.$task->id.'/upload-artefact', array('id' => 'upload-artefact-form', 'name' => 'upload-artefact-form')); ?>
                
                <br /><br />
                <label id="drop-zone">
                    Drop images here, or click to upload.
                    <input type="file" id="task-artefacts" name="task-artefacts[]" multiple size="20" 
                    accept=".jpg, 
                        .png, 
                        .webp, 
                        .gif, 
                        .txt,
                        .md, 
                        .pdf, 
                        .xlxs, 
                        .doc, 
                        .docx, 
                        .csv, 
                        .json, 
                        .sql, 
                        .tar.gz, 
                        .zip,
                        .html"
                    />
                </label>
                <ul id="preview"></ul>
                <input type="button" id="upload-artefact-button" name="upload-artefact-button" class="button tertiary" value="Upload Artefact" />  
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

    });
</script>
<script type="text/javascript" >
    // var editableItemsIds = <?php //echo json_encode($editableItems); ?>;
</script>
<link rel="stylesheet" href="/css/third_party/thickbox/thickbox.css" type="text/css" media="screen" />
<script src="/js/third_party/jquery-ui.custom.min.js" type="text/javascript" ></script>
<script type="text/javascript" src="/js/third_party/thickbox-compressed.js"></script>
<script type="text/javascript" src="/js/third_party/jinplace-1.2.1.min.js"></script>
<script type="text/javascript" src="/js/third_party/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="/js/tasks/task_view.js" ></script>