<?php
?>
<div id="notesContent" class="row expanded" >
    <div class="large-12 columns" >
        &nbsp;
    </div>
</div>
<div id="notesContent" class="row expanded" >
    <div class="large-12 columns" >
        <div class="option-label large-3 columns" >
            <h2>Templates</h2>
        </div>
        <div class="large-9 columns" >
            Number of Templates: <?php echo count($templates)?><br/>
            <?php foreach($templates as $k=>$v){
                ?>
                <div id="notesContent" class="row expanded" >
                    <div class="large-12 columns" >
                        <div class="large-4 columns" >
                            
                        <?php
                            echo "<a href='/notes/options/templates/edit'".$v["id"]." >".$v["name"]."</a> - ".$v["description"]."<br/>";
                            ?>
                        </div>
                        <div class="large-8 columns" >
                            <?php
                                echo "Title Template:<br/> ". $v["titleTemplate"] ."<br/><br/>Content Template:<br/> ".$v["contentTemplate"];
                                ?>
                        </div>
                    </div>
                </div>
            <?php
            }?>
            <a href="/notes/options/templates" >Create Templates</a>
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
            Number of Templates: <?php echo count($templates)?><br/>
            <?php foreach($templates as $k=>$v){
                echo "<a href='/notes/options/templates/edit'".$v["id"]." >".$v["name"]."</a> - ".$v["description"]."<br/>";
            }?>
            <a href="/notes/options/templates" >Create Templates</a>
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
            Number of Ranking Measurements: <?php echo count($rankingMeasurements)?><br/>
            <?php foreach($rankingMeasurements as $k=>$v){
                echo "<a href='/notes/options/templates/edit'".$v["id"]." >".$v["name"]."</a> - ".$v["description"]." ( ". $determinator[$v["positiveDeterminatior"]] ." ) <br/>";
            }?>
            <a href="/notes/options/rankingMeasurement" >Create Additional Ranking Measurement</a>
        </div>
    </div>
</div>