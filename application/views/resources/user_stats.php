<?php ?>
<div class="row expanded">
    <div class="large-12 columns" id="statsContent" >
        &nbsp;
    </div>
</div>
<div class="row expanded" id="notes-stats-content">
    <div class="large-12 columns">
        <h3>Resource Statistics</h3>
    </div>
</div> 
<div class="row expanded">
    <div class="large-12 columns" id="statsContent" >
        <h4>Total Number of Resources: <strong><?php echo $resourceStats["total_count"]; ?></strong></h4>
    </div>
</div>  
<div class="row expanded">
    <div class="large-12 columns" id="statsContent" >
        &nbsp;
    </div>
</div>
<div class="row expanded">
    <div class="large-12 columns" id="statsContent" >
        <h4>Total File Size Utilization: <strong><?php echo $resourceStats["total_filesizes"]; ?></strong></h4>
    </div>
</div>
<br/>
<div class="row expanded">
    <div class="large-12 columns" id="statsContent" >
        <h4>Statistics Per Tool: </h4>
    </div>
</div>
<br/>
<?php
foreach ($resourceStats["total_for_user_per_tool"] as $k => $v) {
    ?>
    <div class="row expanded">
        <div class="large-4 columns" id="statsContent" >
            Tool Name: <strong><?php echo $v["tool_name"]; ?></strong>
        </div>
        <div class="large-4 columns" id="statsContent" >
            Number of Files: <strong><?php echo $v["file_count"]; ?></strong>
        </div>
        <div class="large-4 columns" id="statsContent" >
            File Size: <strong><?php echo $v["file_size"]; ?></strong>
        </div>
    </div>
    <div class="row expanded">
        <div class="large-12 columns" id="statsContent" >
            <hr/>
        </div>
    </div>
    <?php
}
?>





