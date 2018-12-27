<?php ?>
<div id="notesContent" class="row expanded" >
    <div class="large-12 columns" >
        &nbsp;
    </div>
</div>
<div id="notesContent" class="row expanded" >
    <div class="large-12 columns" >
        <h2>Templates ( <?php echo count($notes_templates) ?> )</h2>
    </div>
</div>
<?php echo $capture_form; ?>
<?php foreach ($notes_templates as $k => $v) {
    ?>
    <div id="notesContent" class="row expanded" >
        <div class="large-12 columns" >
            <div class="large-4 columns" >

                <?php
                echo "<a href='/notes/options/templates/edit" . $v["id"] . "' >" . $v["name"] . "</a> - " . $v["description"] . "<br/>";
                ?>
            </div>
            <div class="large-8 columns" >
                <?php
                echo "Template Title:<br/> " . $v["template_title"] . "<br/><br/>Template Content:<br/> " . $v["template_content"];
                ?>
            </div>
        </div>
    </div>
    <?php
}?>