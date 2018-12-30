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
            <div class="large-3 columns" >

                <?php
                echo "<a href='/notes/options/templates/edit" . $v["id"] . "' >" . $v["name"] . "</a> - " . $v["description"] . "<br/>";
                ?>
            </div>
            <div class="large-7 columns" >
                <?php
                echo "Template Title:<br/> " . $v["template_title"] . "<br/><br/>Template Content:<br/> " . $v["template_content"];
                ?>
            </div>
            <div class="large-2 columns" >
                <a href="/notes/templates/edit/<?php echo $v["id"];?>">Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/notes/templates/delete/<?php echo $v["id"];?>" onclick="return confirm_delete()">Delete</a>
            </div>
        </div>
    </div>
    <?php
}?>