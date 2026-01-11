<?php ?>
<div class="row expanded">
    <div class="large-3 columns" >
        <div class="row expanded">
            <div class="large-12 columns" >
                <div id="tasksHistoryFilter" class="tasksHistoryFilter">
                    <h3>Filter Tasks History</h3>
                    <div id="validation_errors" ></div>
                    <form accept-charset="utf-8" method="post" action="/tasks/export" id="filterTasksForm" >
                        <div class="row">
                            <div class="large-12 columns">
                                <fieldset>
                                    <legend>Filter by:</legend>
                                    <div>
                                        <input type="radio" id="create_date"  name="date_filter" value="create_date" />
                                        <label for="create_date">Create Date</label>
                                        <br/>
                                        <input type="radio" id="start_date" checked="checked" name="date_filter" value="start_date" />
                                        <label for="start_date">Start Date</label>                                          
                                        <br/>
                                        <input type="radio" id="target_date" name="date_filter" value="target_date" />
                                        <label for="target_date">Target Date</label>
                                        <br/>
                                        <input type="radio" id="end_date" name="date_filter" value="end_date" />
                                        <label for="end_date">End Date</label>
                                        <br/>
                                    </div>
                                </fieldset>
                            </div>      
                        </div>
                        <div class="row">
                            <div class="large-6 columns">
                                <label> Start Date From
                                    <input type="text" autocomplete="off" name="fromDate" id="fromDate" value="<?php echo $startAndEndDateforMonth[0]; ?>"/>
                                </label>
                            </div>
                            <div class="large-6 columns">
                                <label>
                                    Start Date To<input type="text" autocomplete="off" name="toDate" id="toDate" value="<?php echo $startAndEndDateforMonth[1]; ?>"/>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-12 columns">
                                <label>Keywords
                                    <input type="text" name="keyword" id="keyword" value="" />
                                </label>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="large-12 columns">
                                <input type="button" name="filter" value="Filter" id="filter" class="button" />
                                <input type="button" name="export" value="Export To CSV" id="export" class="button secondary" onClick="submit()"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-12 columns">
                                <label>Task Domains</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-12 columns">
                                <div class="row">
                                    <div class="large-6 columns">
                                        <input type="checkbox" checked="checked" value="all" name="tasksDomains[]" />
                                        <label>all</label>
                                    </div>
                                    <?php
                                    $count = 1;
                                    $breakCount = 2;
                                    foreach ($tasksDomains as $k => $v) {
                                        echo "<div class='large-6 columns'><input type='checkbox' value='" . $v["id"] . "' name='tasksDomains[]' /><label>" . $v["name"] . "</label></div>";
                                        $count++;
                                        if ($count % $breakCount === 0) {
                                            echo "</div><div class='row'>";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="large-12 columns">
                                Tasks Statuses
                                <div class="row">
                                    <div class="large-6 columns">                        
                                        <input type="checkbox" checked="checked" value="all" name="tasksStatuses[]" /><label>all</label>
                                    </div>
                                    <?php
                                    $pmCount = 1;
                                    $bpmBeakCount = 2;
                                    foreach ($tasksStatuses as $k => $v) {
                                        echo "<div class='large-6 columns'><input type='checkbox' value='" . $v["id"] . "' name='tasksStatuses[]' /><label>" . $v["name"] . "</label></div>";
                                        $pmCount++;
                                        if ($pmCount % $bpmBeakCount === 0) {
                                            echo "</div><div class='row'>";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="large-12 columns">
                                <input type="button" name="filter" value="Filter" id="filter" class="button" />
                                <input type="button" name="export" value="Export To CSV" id="export" class="button secondary" onClick="submit()"/>
                            </div>
                        </div> -->
                        <p>More Options: <span id="searchExpand"><img src="/images/third_party/icons/Search_icon.png" /></span></p>                                
                        <div id="dashboardContent" class="notesHistoryHidden">
                            <div class="row expanded">
                                <div class="large-12 columns">
                                    <label>Importance Levels</label>
                                    <br/>
                                    <div class="row">
                                        <div class="large-6 columns">                        
                                            <input type="checkbox" checked="checked" value="all" name="importanceLevels[]" /><label>all</label>
                                        </div>
                                        <?php
                                        $pmCount = 1;
                                        $bpmBeakCount = 2;
                                        foreach ($importanceLevels as $k => $v) {
                                            echo "<div class='large-6 columns'><input type='checkbox' value='" . $v["id"] . "' name='importanceLevels[]' /><label>" . $v["name"] . "</label></div>";
                                            $pmCount++;
                                            if ($pmCount % $bpmBeakCount === 0) {
                                                echo "</div><div class='row'>";
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="row expanded">
                                <div class="large-12 columns">
                                    <label>Urgency Levels</label>
                                    <br/>
                                    <div class="row">
                                        <div class="large-6 columns">                        
                                            <input type="checkbox" checked="checked" value="all" name="urgencyLevels[]" /><label>all</label>
                                        </div>
                                        <?php
                                        $pmCount = 1;
                                        $bpmBeakCount = 2;
                                        foreach ($urgencyLevels as $k => $v) {
                                            echo "<div class='large-6 columns'><input type='checkbox' value='" . $v["id"] . "' name='urgencyLevels[]' /><label>" . $v["name"] . "</label></div>";
                                            $pmCount++;
                                            if ($pmCount % $bpmBeakCount === 0) {
                                                echo "</div><div class='row'>";
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="row expanded">
                                <div class="large-12 columns">
                                    <label>Risk Levels</label>
                                    <br/>
                                    <div class="row">
                                        <div class="large-6 columns">                        
                                            <input type="checkbox" checked="checked" value="all" name="riskLevels[]" /><label>all</label>
                                        </div>
                                        <?php
                                        $pmCount = 1;
                                        $bpmBeakCount = 2;
                                        foreach ($riskLevels as $k => $v) {
                                            echo "<div class='large-6 columns'><input type='checkbox' value='" . $v["id"] . "' name='riskLevels[]' /><label>" . $v["name"] . "</label></div>";
                                            $pmCount++;
                                            if ($pmCount % $bpmBeakCount === 0) {
                                                echo "</div><div class='row'>";
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="row expanded">
                                <div class="large-12 columns">
                                    <label>Gain Levels</label>
                                    <br/>
                                    <div class="row">
                                        <div class="large-6 columns">                        
                                            <input type="checkbox" checked="checked" value="all" name="gainLevels[]" /><label>all</label>
                                        </div>
                                        <?php
                                        $pmCount = 1;
                                        $bpmBeakCount = 2;
                                        foreach ($gainLevels as $k => $v) {
                                            echo "<div class='large-6 columns'><input type='checkbox' value='" . $v["id"] . "' name='gainLevels[]' /><label>" . $v["name"] . "</label></div>";
                                            $pmCount++;
                                            if ($pmCount % $bpmBeakCount === 0) {
                                                echo "</div><div class='row'>";
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="row expanded">
                                <div class="large-12 columns">
                                    <label>Rewards Category</label>
                                    <br/>
                                    <div class="row">
                                        <div class="large-6 columns">                        
                                            <input type="checkbox" checked="checked" value="all" name="rewardsCategory[]" /><label>all</label>
                                        </div>
                                        <?php
                                        $pmCount = 1;
                                        $bpmBeakCount = 2;
                                        foreach ($rewardsCategory as $k => $v) {
                                            echo "<div class='large-6 columns'><input type='checkbox' value='" . $v["id"] . "' name='rewardsCategory[]' /><label>" . $v["name"] . "</label></div>";
                                            $pmCount++;
                                            if ($pmCount % $bpmBeakCount === 0) {
                                                echo "</div><div class='row'>";
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="row expanded">
                                <div class="large-12 columns">
                                    <label>Cycles</label>
                                    <br/>
                                    <div class="row">
                                        <div class="large-6 columns">                        
                                            <input type="checkbox" checked="checked" value="all" name="cycles[]" /><label>all</label>
                                        </div>
                                        <?php
                                        $pmCount = 1;
                                        $bpmBeakCount = 2;
                                        foreach ($cycles as $k => $v) {
                                            echo "<div class='large-6 columns'><input type='checkbox' value='" . $v["id"] . "' name='cycles[]' /><label>" . $v["name"] . "</label></div>";
                                            $pmCount++;
                                            if ($pmCount % $bpmBeakCount === 0) {
                                                echo "</div><div class='row'>";
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="row expanded">
                                <div class="large-12 columns">
                                    <label>Scales</label>
                                    <br/>
                                    <div class="row">
                                        <div class="large-6 columns">                        
                                            <input type="checkbox" checked="checked" value="all" name="scales[]" /><label>all</label>
                                        </div>
                                        <?php
                                        $pmCount = 1;
                                        $bpmBeakCount = 2;
                                        foreach ($scales as $k => $v) {
                                            echo "<div class='large-6 columns'><input type='checkbox' value='" . $v["id"] . "' name='scales[]' /><label>" . $v["name"] . "</label></div>";
                                            $pmCount++;
                                            if ($pmCount % $bpmBeakCount === 0) {
                                                echo "</div><div class='row'>";
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="row expanded">
                                <div class="large-12 columns">
                                    <label>Scopes</label>
                                    <br/>
                                    <div class="row">
                                        <div class="large-6 columns">                        
                                            <input type="checkbox" checked="checked" value="all" name="scopes[]" /><label>all</label>
                                        </div>
                                        <?php
                                        $pmCount = 1;
                                        $bpmBeakCount = 2;
                                        foreach ($scopes as $k => $v) {
                                            echo "<div class='large-6 columns'><input type='checkbox' value='" . $v["id"] . "' name='scopes[]' /><label>" . $v["name"] . "</label></div>";
                                            $pmCount++;
                                            if ($pmCount % $bpmBeakCount === 0) {
                                                echo "</div><div class='row'>";
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="row expanded">
                                <div class="large-12 columns">
                                    <label>Difficulty Levels</label>
                                    <br/>
                                    <div class="row">
                                        <div class="large-6 columns">                        
                                            <input type="checkbox" checked="checked" value="all" name="difficultyLevels[]" /><label>all</label>
                                        </div>
                                        <?php
                                        $pmCount = 1;
                                        $bpmBeakCount = 2;
                                        foreach ($difficultyLevels as $k => $v) {
                                            echo "<div class='large-6 columns'><input type='checkbox' value='" . $v["id"] . "' name='difficultyLevels[]' /><label>" . $v["name"] . "</label></div>";
                                            $pmCount++;
                                            if ($pmCount % $bpmBeakCount === 0) {
                                                echo "</div><div class='row'>";
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <br/>
                        </div>  
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="large-9 columns" >
        <div class="row expanded">
            <div class="large-12 columns" >
                <?php echo $history_table; ?>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
<script type="text/javascript" src="/js/jquery.datetimepicker.js" ></script>
<script type="text/javascript" src="/js/third_party/handlebars-v1.3.0.js" ></script>
<script type="text/javascript" src="/js/third_party/jquery.tablesorter.min.js"></script>
<script type="text/javascript">
    var default_start_date = "<?php echo $startAndEndDateforMonth[0]; ?>";
    var default_end_date = "<?php echo $startAndEndDateforMonth[1]; ?>";
</script>