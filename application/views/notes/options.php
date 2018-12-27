<?php ?>
<div id="notesContent" class="row expanded" >
    <div class="large-12 columns" >
        &nbsp;
    </div>
</div>
<div id="notesContent" class="row expanded" >
    <div class="large-12 columns" >
        <div class="option-label large-3 columns" >
            <h2>Auto Save</h2>
        </div>
        <div class="large-9 columns" >
            <div class="row expanded" >
                <div class="large-6 columns" >
                    Automatically Save Edited Notes: 
                    <div class="switch large">
                        <input class="switch-input" id="auto_save" type="checkbox" name="auto_save" <?php echo ($userNotesConfigs["auto_save_note"]) ? 'checked' : ''; ?> data-id="<?php echo $userNotesConfigs["auto_save_note_id"]; ?>">
                        <label class="switch-paddle" for="auto_save">
                            <span class="show-for-sr">Do you like me?</span>
                            <span class="switch-active" aria-hidden="false">Yes</span>
                            <span class="switch-inactive" aria-hidden="true">No</span>
                        </label>
                    </div>
                </div>
                <div class="large-6 columns" >
                    <label for="note_auto_save">Interval Between Automatically Saving Edited Notes ( Minutes )</label>
                    <span 
                        class="editable editable-expanded"
                        data-url="/notes/option/update/<?php echo $userNotesConfigs["auto_save_note_interval_id"]; ?>"
                        data-type="textarea"
                        data-text-only="true"
                        data-ok-button="OK"
                        data-cancel-button="Cancel" >
                            <?php echo (!empty($userNotesConfigs["auto_save_note_interval"])) ? $userNotesConfigs["auto_save_note_interval"] : ""; ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="notesContent" class="row expanded" >
    <div class="large-12 columns" >
        <hr/>
    </div>
</div>
<div id="notesContent" class="row expanded" >
    <div class="large-12 columns" >
        <div class="option-label large-3 columns" >
            <h2>Templates</h2>
        </div>
        <div class="large-9 columns" >
            Number of Templates: <?php echo count($notes_templates) ?><br/>
            <?php foreach ($notes_templates as $k => $v) {
                ?>
                <div id="notesContent" class="row expanded" >
                    <div class="large-12 columns" >
                        <div class="large-4 columns" >

                            <?php
                            echo $v["name"] . " - " . $v["description"] . "<br/>";
                            ?>
                        </div>
                        <div class="large-8 columns" >
                            <?php
                            echo "Template Title:<br/> " . $v["template_title"] . "<br/>";
                            ?>
                        </div>
                    </div>
                </div>
            <div id="notesContent" class="row expanded" >
                <div class="large-12 columns" >
                    <hr>
                </div>
            </div>
            <?php }
            ?>
            <a href="/notes/templates" >Manage Templates</a>
        </div>
    </div>
</div>
<div id="notesContent" class="row expanded" >
    <div class="large-12 columns" >
        <hr/>
    </div>
</div>
<div id="notesContent" class="row expanded" >
    <div class="large-12 columns" >
        &nbsp;
    </div>
</div>
<div id="notesContent" class="row expanded" >
    <div class="large-12 columns" >
        <div class="option-label large-3 columns" >
            <h2>Importance</h2>
        </div>
        <div class="large-9 columns" >
            Number of Templates: <?php echo count($notes_templates) ?><br/>
            <?php
            foreach ($notes_templates as $k => $v) {
                echo "<a href='/notes/options/templates/edit" . $v["id"] . "' >" . $v["name"] . "</a> - " . $v["description"] . "<br/>";
            }
            ?>
            <a href="/notes/templates" >Manage Templates</a>
        </div>
    </div>
</div>
<div id="notesContent" class="row expanded" >
    <div class="large-12 columns" >
        <hr/>
    </div>
</div>
<div id="notesContent" class="row expanded" >
    <div class="large-12 columns" >
        &nbsp;
    </div>
</div>
<div id="notesContent" class="row expanded" >
    <div class="large-12 columns" >
        <div class="option-label large-3 columns" >
            <h2>Ranking Measurements</h2>
        </div>
        <div class="large-9 columns" >
            Number of Ranking Measurements: <?php echo count($rankingMeasurements) ?><br/>
            <?php
            foreach ($rankingMeasurements as $k => $v) {
                echo "<a href='/notes/options/templates/edit'" . $v["id"] . " >" . $v["name"] . "</a> - " . $v["description"] . " ( " . $determinator[$v["positiveDeterminatior"]] . " ) <br/>";
            }
            ?>
            <a href="/notes/options/rankingMeasurement" >Create Additional Ranking Measurement</a>
        </div>
    </div>
</div>
<link rel="stylesheet" href="/css/third_party/thickbox/thickbox.css" type="text/css" media="screen" />
<script src="/js/third_party/jquery-ui.custom.min.js" type="text/javascript" ></script>
<script type="text/javascript" src="/js/third_party/jinplace-1.2.1.min.js"></script>
<script src="/js/notes/options.js" ></script>