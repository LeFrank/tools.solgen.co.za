
<?php ?>
<div class="row expanded">
    <div class="large-12 columns" >
        <div class="row expanded">
            <div class="large-12 columns" >
                <h1>Dashboard Overview ( Tasks: <?php echo sizeof($tasks); ?> )</h1>
            </div>
        </div>
        <div class="row expanded">
            <div class="large-4 columns" >
                <h3>Domains</h3>
                <?php
                    // Example: Display task domains and their counts
                    echo "<p>Number of Domains: ".sizeof($tasksDomains) ."</p>";
                    echo "<div><p>Number of Tasks Per Domain:</p>";
                    // print_r($tasks); 
                    foreach ($tasksDomains as $k => $v) {
                        $taskCount = 0;
                        foreach ($tasks as $task) {
                            if ($task['domain_id'] == $v['id']) {
                                $taskCount++;
                            }
                    }
                    echo "<p>&nbsp;&nbsp;&nbsp;&nbsp;". (!empty($v["emoji"]) ? json_decode($v["emoji"]) : "&nbsp;&nbsp;&nbsp;&nbsp;") ." ". $v['name'] . ": " . $taskCount . "</p>";
                    }
                    echo "</div>";
                    ?>
            </div>
            <div class="large-4 columns" >
                <h3>Statuses</h3>
                <?php
                    // Example: Display task domains and their counts
                    echo "<p>Number of Statuses: ".sizeof($tasksStatuses) ."</p>";
                    echo "<div><p>Number of Tasks Per Status:</p>";
                    // print_r($tasks); 
                    foreach ($tasksStatuses as $k => $v) {
                        $taskCount = 0;
                        foreach ($tasks as $task) {
                            if ($task['status_id'] == $v['id']) {
                                $taskCount++;
                            }
                        }
                        echo "<p>&nbsp;&nbsp;&nbsp;&nbsp;" . $v['name'] . ": " . $taskCount . "</p>";
                    }
                    echo "</div>";
                ?>
            </div>  
            <div class="large-4 columns">
                <h3>Importance Levels</h3>
                <?php
                // Example: Display task domains and their counts
                    echo "<p>Number of Importance Levels: ".sizeof($importanceLevels) ."</p>";
                    echo "<div><p>Number of Tasks Per Importance Level:</p>";
                    // print_r($tasks); 
                    foreach ($importanceLevels as $k => $v) {
                        $taskCount = 0;
                        foreach ($tasks as $task) {
                            if ($task['importance_level_id'] == $v['id']) {
                                $taskCount++;
                            }
                        }
                        echo "<p>&nbsp;&nbsp;&nbsp;&nbsp;" . $v['name'] . ": " . $taskCount . "</p>";
                    }
                    echo "</div>";
                ?>
            </div>  
        </div>  
        <br/>
        <div class="row expanded">
            <div class="large-4 columns">
                <h3>Urgency Levels</h3>
                <?php
                // Example: Display task domains and their counts
                    echo "<p>Number of Urgency Levels: ".sizeof($urgencyLevels) ."</p>";
                    echo "<div><p>Number of Tasks Per Urgency Level:</p>";
                    // print_r($tasks); 
                    foreach ($urgencyLevels as $k => $v) {
                        $taskCount = 0;
                        foreach ($tasks as $task) {
                            if ($task['urgency_level_id'] == $v['id']) {
                                $taskCount++;
                            }
                        }
                        echo "<p>&nbsp;&nbsp;&nbsp;&nbsp;" . $v['name'] . ": " . $taskCount . "</p>";
                    }
                    echo "</div>";
                ?>
            </div>  
            <div class="large-4 columns">
                <h3>Risk Levels</h3>
                <?php
                // Example: Display task domains and their counts
                    echo "<p>Number of Risk Levels: ".sizeof($riskLevels) ."</p>";
                    echo "<div><p>Number of Tasks Per Risk Level:</p>";
                    // print_r($tasks); 
                    foreach ($riskLevels as $k => $v) {
                        $taskCount = 0;
                        foreach ($tasks as $task) {
                            if ($task['risk_level_id'] == $v['id']) {
                                $taskCount++;
                            }
                        }
                        echo "<p>&nbsp;&nbsp;&nbsp;&nbsp;" . $v['name'] . ": " . $taskCount . "</p>";
                    }
                    echo "</div>";
                ?>
            </div>  
            <div class="large-4 columns">
                <h3>Gain Levels</h3>
                <?php
                // Example: Display task domains and their counts
                    echo "<p>Number of Gain Levels: ".sizeof($gainLevels) ."</p>";
                    echo "<div><p>Number of Tasks Per Gain Level:</p>";
                    // print_r($tasks); 
                    foreach ($gainLevels as $k => $v) {
                        $taskCount = 0;
                        foreach ($tasks as $task) {
                            if ($task['gain_level_id'] == $v['id']) {
                                $taskCount++;
                            }
                        }
                        echo "<p>&nbsp;&nbsp;&nbsp;&nbsp;" . $v['name'] . ": " . $taskCount . "</p>";
                    }
                    echo "</div>";
                ?>
            </div>  
        </div>
        <br/>
        <div class="row expanded">
            <div class="large-4 columns">
                <h3>Reward Category</h3>
                <?php
                // Example: Display task domains and their counts
                    echo "<p>Number of Reward Categories: ".sizeof($rewardsCategory) ."</p>";
                    echo "<div><p>Number of Tasks Per Reward Category:</p>";
                    // print_r($tasks); 
                    foreach ($rewardsCategory as $k => $v) {
                        $taskCount = 0;
                        foreach ($tasks as $task) {
                            if ($task['reward_category_id'] == $v['id']) {
                                $taskCount++;
                            }
                        }
                        echo "<p>&nbsp;&nbsp;&nbsp;&nbsp;" . $v['name'] . ": " . $taskCount . "</p>";
                    }
                    echo "</div>";
                ?>
            </div>  
            <div class="large-4 columns">
                <h3>Cycles</h3>
                <?php
                // Example: Display task domains and their counts
                    echo "<p>Number of Cycle Types: ".sizeof($cycles) ."</p>";
                    echo "<div><p>Number of Tasks Per Cycle:</p>";
                    // print_r($tasks); 
                    foreach ($cycles as $k => $v) {
                        $taskCount = 0;
                        foreach ($tasks as $task) {
                            if ($task['cycle_id'] == $v['id']) {
                                $taskCount++;
                            }
                        }
                        echo "<p>&nbsp;&nbsp;&nbsp;&nbsp;" . $v['name'] . ": " . $taskCount . "</p>";
                    }
                    echo "</div>";
                ?>
            </div>  
            <div class="large-4 columns">
                <h3>Scale</h3>
                <?php
                // Example: Display task domains and their counts
                    echo "<p>Number of Scale Types: ".sizeof($scales) ."</p>";
                    echo "<div><p>Number of Tasks Per Scale:</p>";
                    // print_r($tasks); 
                    foreach ($scales as $k => $v) {
                        $taskCount = 0;
                        foreach ($tasks as $task) {
                            if ($task['scale_id'] == $v['id']) {
                                $taskCount++;
                            }
                        }
                        echo "<p>&nbsp;&nbsp;&nbsp;&nbsp;" . $v['name'] . ": " . $taskCount . "</p>";
                    }
                    echo "</div>";
                ?>
            </div>  
        </div>
        <br/>
        <div class="row expanded">
            <div class="large-4 columns">
                <h3>Scope</h3>
                <?php
                // Example: Display task domains and their counts
                    echo "<p>Number of Scope Types: ".sizeof($scopes) ."</p>";
                    echo "<div><p>Number of Tasks Per Scope:</p>";
                    // print_r($tasks); 
                    foreach ($scopes as $k => $v) {
                        $taskCount = 0;
                        foreach ($tasks as $task) {
                            if ($task['scope_id'] == $v['id']) {
                                $taskCount++;
                            }
                        }
                        echo "<p>&nbsp;&nbsp;&nbsp;&nbsp;" . $v['name'] . ": " . $taskCount . "</p>";
                    }
                    echo "</div>";
                ?>
            </div>  
            <div class="large-4 columns">
                <h3>Forgotten or Abandoned</h3>
                <!-- Forgotten tasks are tasks where the start date has passed but the task is still in state that is None, Not Started -->
                <?php
                    $forgottenCount = 0;
                    $currentDate = date('Y-m-d');
                    foreach ($tasks as $task) {
                        if (in_array($task['status_id'], array(1,3,6,7)) && ($task['start_date'] < $currentDate)) {
                            $forgottenCount++;
                        }
                    }
                    echo "<p>Forgotten or Abandoned Tasks: " . $forgottenCount . "</p>"; 
                    ?>
            </div>  
            <div class="large-4 columns">
                <h3>Delayed</h3>
                <!-- Delayed tasks are tasks where the end date has passed but the task is still in a non-completed state -->
                <?php
                    $delayedCount = 0;
                    $currentDate = date('Y-m-d');
                    foreach ($tasks as $task) {
                        if (!in_array($task['status_id'], array(2,6,7)) && ($task['end_date'] < $currentDate)) {
                            $delayedCount++;
                        }
                    }
                    echo "<p>Delayed Tasks: " . $delayedCount . "</p>"; 
                    ?>
            </div>  
        </div>
        <br/>
        <div class="row expanded">
            <div class="large-6 columns">
                <h3>General Age Range of Incomplete Tasks</h3>
                <div>&nbsp;</div>
            </div>  
            <div class="large-6 columns">
                <h3>General Overview of Completed Tasks</h3>
                <div></div>
            </div>  
        </div>
    </div>
</div>