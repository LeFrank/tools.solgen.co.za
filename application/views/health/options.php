<?php
//print_r($userHealthConfigs);
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
                    <label for="target_weight">Target Weight</label>
                    <input type="number" name="target_weight" id="targe_weight"  step="0.1" <?php echo ((isset($userHealthConfigs["target_weight"])) ?  "value='".$userHealthConfigs["target_weight"]."'" : "placeholder='0.0'"); ?>/>
                </div>
                <div class="large-4 columns" >
                    <label for="target_waist">Target Waist Measurement</label>
                    <input type="number" name="target_waist" id="target_waist"  step="0.1" <?php echo ((isset($userHealthConfigs["target_waist"])) ?  "value='".$userHealthConfigs["target_waist"]."'" : "placeholder='0.0'"); ?>  />
                </div>
                <div class="large-4 columns" >
                    <label for="target_sleep">Daily Sleep Target</label>
                    <input type="number" name="target_sleep" id="target_sleep"  step="0.1" <?php echo ((isset($userHealthConfigs["target_sleep"])) ?  "value='".$userHealthConfigs["target_sleep"]."'" : "placeholder='0.0'"); ?>/>
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

<script type="text/javascript" src="/js/health/options/index.js" />