<?php
//print_r($userHealthConfigs);
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
                    <span 
                        class="editable"
                            data-url="/health/option/update/<?php echo $userHealthConfigs["target_weight_id"]; ?>"
                            data-type="textarea"
                            data-ok-button="OK"
                            data-cancel-button="Cancel" >
                             <?php echo (!empty($userHealthConfigs["target_weight"])) ? $userHealthConfigs["target_weight"] : ""; ?>
                     </span>
                </div>
                <div class="large-4 columns" >
                    <label for="target_waist">Target Waist Measurement</label>
                    <span 
                        class="editable"
                            data-url="/health/option/update/<?php echo $userHealthConfigs["target_waist_id"]; ?>"
                            data-type="textarea"
                            data-ok-button="OK"
                            data-cancel-button="Cancel" >
                             <?php echo (!empty($userHealthConfigs["target_waist"])) ? $userHealthConfigs["target_waist"] : ""; ?>
                     </span>
                </div>
                <div class="large-4 columns" >
                    <label for="target_sleep">Daily Sleep Target</label>
                    <span 
                        class="editable"
                            data-url="/health/option/update/<?php echo $userHealthConfigs["target_sleep_id"]; ?>"
                            data-type="textarea"
                            data-ok-button="OK"
                            data-cancel-button="Cancel" >
                             <?php echo (!empty($userHealthConfigs["target_sleep"])) ? $userHealthConfigs["target_sleep"] : ""; ?>
                     </span>
                </div>
            </div>
        </div>
        <br/>
        <br/>
        <div class="large-9 columns" >
            <div  class="row expanded" >
                <div class="large-4 columns" >
                    
                </div>
                <div class="large-4 columns" >
                    
                </div>
                <div class="large-4 columns" >
                    <label for="neg_trigger_sleep">Number of days target missed warning?</label>
                    <span 
                        class="editable"
                            data-url="/health/option/update/<?php echo $userHealthConfigs["neg_trigger_sleep_id"]; ?>"
                            data-type="textarea"
                            data-ok-button="OK"
                            data-cancel-button="Cancel" >
                             <?php echo (!empty($userHealthConfigs["neg_trigger_sleep"])) ? $userHealthConfigs["neg_trigger_sleep"] : ""; ?>
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
<link rel="stylesheet" href="/css/third_party/thickbox/thickbox.css" type="text/css" media="screen" />
<script src="/js/third_party/jquery-ui.custom.min.js" type="text/javascript" ></script>
<script type="text/javascript" src="/js/third_party/jinplace-1.2.1.min.js"></script>
<script src="/js/health/options/index.js" ></script>