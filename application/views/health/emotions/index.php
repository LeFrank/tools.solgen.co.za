<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="row expanded" >
    <div class="large-12 columns" >
        <h2>Emotions</h2>
    </div>
</div>
<div class="row expanded" >
    <div class="large-12 columns" >
        <form action="/health/emotions/capture" method="POST">
            <h3>How are you feeling.</h3>
            <div class="emotionIconRow">
            <?php 
                foreach($emotionIcons as $k=>$v){
                    echo "<span style='height:110px;'><a src='#' id='".$v["id"]."' onClick='recordEmotion(".$v["id"].");'><img src='/images/third_party/icons/".$v["icon"]."' class='emotionIcon' style='color:".$v["colour"].";' alt='".$v["name"]."' title='".$v["name"]."' /></a></span>";
                }
            ?>
            </div>
        </form>
    </div>
</div>
<hr/>
<div class="row expanded">
    <?php echo form_open('/health/metrics') ?>
    <div class="large-4 columns" >
        <label>
            From<input type="text" name="fromDate" id="fromDate" value="<?php echo $startDate; ?>"/>
        </label>
    </div>
    <div class="large-4 columns" >
        <label>
            To<input type="text" name="toDate" id="toDate" value="<?php echo $endDate; ?>"/> 
        </label>
    </div>
    <div class="large-4 columns" style="vertical-align: central;margin-top:15px;" >
        <input type="submit" name="filter" value="Filter" id="filter"  class="button"/>
    </div>
    <?php echo form_close(); ?>
</div>
<script src="/js/health/emotions/index.js" ></script>
