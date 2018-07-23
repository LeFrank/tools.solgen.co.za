<?php
?>
<div class="row expanded" >
    <div class="large-12 columns" >
        &nbsp;
    </div>
</div>
<div id="healthMetricOptions" class="row expanded" >
    <div class="large-12 columns" >
        <div class="option-label large-3 columns" >
            <h2>Metric Goals</h2>
        </div>
        <div class="large-9 columns" >
            <div  class="row expanded" >
                <div class="large-4 columns" >
                    <label for="targetWeight">Target Weight</label>
                    <input type="number" name="targetWeight" id="targetWeight"  step="0.1" placeholder="0.00"/>
                </div>
                <div class="large-4 columns" >
                    <label for="targetWaist">Target Waist Measurement</label>
                    <input type="number" name="targetWaist" id="targetWaist"  step="0.1" placeholder="0.00"/>
                </div>
                <div class="large-4 columns" >
                    <label for="targetSleep">Daily Sleep Target</label>
                    <input type="number" name="targetSleep" id="targetSleep"  step="0.1" placeholder="0.00" value="8.00"/>
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
        &nbsp;
    </div>
</div>
<div id="healthExerciseOptions" class="row expanded" >
    <div class="large-12 columns" >
        <div class="option-label large-3 columns" >
            <h2>Exercise Types</h2>
        </div>
        <div class="large-9 columns" >
            Number of Templates: <?php echo 6?><br/>
            <a href="/health/options/exerciseTypes" >Exercise Types</a>
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
            <h2>Difficulty Description</h2>
        </div>
        <div class="large-9 columns" >
            Difficulty Ratings: <?php echo 10;?><br/>
            <a href="/health/options/difficulty" >Update difficulty Rating.</a>
        </div>
    </div>
</div>