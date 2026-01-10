<?php
if ($this->session->flashdata("success") !== FALSE) {
    echo $this->session->flashdata("success");
}
?>
<div class="row expanded">
    <div class="large-12 columns">
        <h2>Tasks Overview</h2>

        <div id="latestTasks">
            <h3>Fifty Latest Tasks</h3>
            <?php if (is_array($tasks) && !empty($tasks)) {
                ?>
                <table id="taskSummary" class="tablesorter responsive expanded widget-zebra">
                    <thead>
                    <th/>
                    <th>Check</th>
                    <th>Domain</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Target Date</th>
                    <th>Importance</th>
                    <th>Urgency</th>
                    <th>Risk</th>
                    <th>Gain</th>
                    <th>Reward Category</th>
                    <th>Cycle</th>
                    <th>Scale</th>
                    <th>Scope</th>
                    <th>Difficulty</th>
                    <th>Notes</th>
                    <th>Artifacts</th>
                    <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php
                        $total = 0.0;
                        foreach ($tasks as $k => $v) {
                            $tr_style = "";
                            $checked = "";
                            if($v["status_id"] == 2){ // Completed
                                $tr_style = "style='"
                                    . "background-color: "
                                    . $tasksStatuses[$v["status_id"]]["background_colour"]
                                    . ";"
                                    . "color: "
                                    . $tasksStatuses[$v["status_id"]]["text_colour"]
                                    . ";"
                                    . "'";
                                $checked = " checked ";
                            }else{
                                $checked = "";
                            }
                            echo "<tr ".$tr_style.">";
                            echo "<td>" . ++$k . "</td>";
                            echo "<td style='
                                    text-align: center;vertical-align: middle;'>
                                <input style='
                                    width:30px; 
                                    height:30px;
                                    border-radius:5px;'
                                type='checkbox' 
                                id='".$v["id"]."' 
                                name='check_".$v["id"]."'
                                class='tasks_checkbox'
                                value='".$v["id"]."'
                                ".$checked."
                                >
                                <label for=check_".$v["id"]."'></label>
                                </td>";
                                $tr_style = "style='"
                                    . "background-color: "
                                    . $tasksDomains[$v["domain_id"]]["background_colour"]
                                    . ";"
                                    . "color: "
                                    . $tasksDomains[$v["domain_id"]]["text_colour"]
                                    . ";"
                                    . "'";
                            echo "<td ".$tr_style." >" . json_decode($tasksDomains[$v["domain_id"]]["emoji"]) . " " . $tasksDomains[$v["domain_id"]]["name"] . "</td>";
                            echo "<td>" . $v["name"] . "</td>";
                            echo "<td>" . $v["description"] . "</td>";
                            // echo "<td>" . $v["status_id"] . "</td>";
                            echo "<td>" . $tasksStatuses[$v["status_id"]]["name"]  . "</td>";
                            echo "<td>" . $v["create_date"] . "</td>";
                            echo "<td>" . $v["target_date"] . "</td>";
                            echo "<td>" . $importanceLevels[$v["importance_level_id"]]["name"] . "</td>"; 
                            echo "<td>" . $urgencyLevels[$v["urgency_level_id"]]["name"] . "</td>";
                            echo "<td>" . $riskLevels[$v["risk_level_id"]]["name"] . "</td>";
                            echo "<td>" . $gainLevels[$v["gain_level_id"]]["name"] . "</td>";
                            echo "<td>" . $rewardsCategory[$v['reward_category_id']]['name'] . "</td>";
                            echo "<td>" . $cycles[$v["cycle_id"]]["name"] . "</td>";
                            echo "<td>" . $scales[$v["scale_id"]]["name"] . "</td>";
                            echo "<td>" . $scopes[$v["scope_id"]]["name"] . "</td>";
                            echo "<td>" . $difficultyLevels[$v["difficulty_level_id"]]["name"] . "</td>";
                            echo "<td>" . "ToDo" . "</td>";
                            echo "<td>" . "ToDo" . "</td>";
                            echo "<td><a href='/tasks/task/" . $v["id"] . "'>Work</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='/tasks/edit/" . $v["id"] . "'>Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='/tasks/delete/" . $v["id"] . "' onclick='return confirm_delete()'>Delete</a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo "No Tasks Available.";
            }
            ?>
        </div>
        <br/>
    </div>
</div>
<div class="row expanded">
    <div class="large-12 columns">
        <h3>Create a Tasks</h3>
        <?php echo validation_errors(); ?>
        <?php echo form_open_multipart('tasks/capture') ?>
        <div class="row expanded">
            <div class="large-2 columns">
                <label for="domain_id">Domain</label>
                <select name="domain_id" id="domain_id"> 
                    <?php
                    foreach ($tasksDomains as $k => $v) {
                        echo '<option value="' . $v["id"] . '">' . $v["name"] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="large-8 columns">
                <label for="name">Name *</label>
                <input type="text" name="name" id="name" autofocus /><br />
            </div>

            <div class="large-2 columns">
                <label for="status">Status</label>
                <select name="status">
                    <?php
                    foreach ($tasksStatuses as $k => $v) {
                        $default = "";
                        if ($v["id"] == 1) {
                            $default = " selected ";
                        }
                        echo '<option value="' . $v["id"] . '"' . $default . '>' . $v["name"] . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row expanded">
            <div class="large-12 columns">
                &nbsp;
            </div>
        </div>
        <div class="row expanded">
            <div class="large-2 columns">
                <label for="importance_level_id">Importance</label>
                <select name="importance_level_id">
                    <?php
                    foreach ($importanceLevels as $k => $v) {
                        $default = "";
                        if ($v["default"] == true) {
                            $default = " selected ";
                        }
                        echo '<option value="' . $v["id"] . '"' . $default . '>' . $v["name"] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="large-2 columns">
                <label for="urgency_level_id">Urgency</label>
                <select name="urgency_level_id">
                    <?php
                    foreach ($urgencyLevels as $k => $v) {
                        $default = "";
                        if ($v["default"] == true) {
                            $default = " selected ";
                        }
                        echo '<option value="' . $v["id"] . '"' . $default . '>' . $v["name"] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="large-2 columns">
                <label for="risk_level_id">Risk</label>
                <select name="risk_level_id">
                    <?php
                    foreach ($riskLevels as $k => $v) {
                        $default = "";
                        if ($v["default"] == true) {
                            $default = " selected ";
                        }
                        echo '<option value="' . $v["id"] . '"' . $default . '>' . $v["name"] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="large-3 columns">
                <label for="gain_level_id">Gain </label>
                <select name="gain_level_id">
                    <?php
                    foreach ($gainLevels as $k => $v) {
                        $default = "";
                        if ($v["default"] == true) {
                            $default = " selected ";
                        }
                        echo '<option value="' . $v["id"] . '"' . $default . '>' . $v["name"] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="large-3 columns">
                <label for="reward_category_id">Reward</label>
                <select name="reward_category_id">
                    <?php
                    foreach ($rewardsCategory as $k => $v) {
                        $default = "";
                        if ($v["default"] == true) {
                            $default = " selected ";
                        }
                        echo '<option value="' . $v["id"] . '"' . $default . '>' . $v["name"] . '</option>';
                    }
                    ?>
                </select>

            </div>
        </div>

        <div class="row expanded">
            <div class="large-12 columns">
                <label for="description">Description</label>
                <textarea name="description" id="description" cols="40" rows="5" placeholder="As detailed and clear description of the problem, proposed solution and actions required to complete this task."></textarea><br/><br/>
            </div>
        </div>
        <div class="row expanded">
            <div class="large-2 columns">
                <label for="start_date">Start Date</label>
                <input autocomplete="off" type="text" id="start_date" name="start_date" value="<?php echo date('Y/m/d H:i:s'); ?>" /><br/><br/>
            </div>
            <div class="large-2 columns">
                <label for="end_date">End Date</label>
                <input autocomplete="off" type="text" id="end_date" name="end_date" value="<?php echo date('Y/m/d H:i:s'); ?>" /><br/><br/>
            </div>
            <div class="large-2 columns">
                <label for="target_date">Target Date</label>
                <input autocomplete="off" type="text" id="target_date" name="target_date" value="<?php echo date('Y/m/d H:i:s'); ?>" /><br/><br/>
            </div>
            <div class="large-2 columns">
                <label for="cycle_id">Cycles</label>
                <select name="cycle_id">
                    <?php
                    foreach ($cycles as $k => $v) {
                        $default = "";
                        if ($v["default"] == true) {
                            $default = " selected ";
                        }
                        echo '<option value="' . $v["id"] . '"' . $default . '>' . $v["name"] . '</option>';
                    }
                    ?>
                </select>
            </div>
                <div class="large-2 columns">
                <label for="scale_id">Scale</label>
                <select name="scale_id">
                    <?php
                    foreach ($scales as $k => $v) {
                        $default = "";
                        if ($v["default"] == true) {
                            $default = " selected ";
                        }
                        echo '<option value="' . $v["id"] . '"' . $default . '>' . $v["name"] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="large-1 columns">
                <label for="scope_id">Scope</label>
                <select name="scope_id">
                    <?php
                    foreach ($scopes as $k => $v) {
                        $default = "";
                        if ($v["default"] == true) {
                            $default = " selected ";
                        }
                        echo '<option value="' . $v["id"] . '"' . $default . '>' . $v["name"] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="large-1 columns">
                <label for="difficulty_level_id">Difficulty</label>
                <select name="difficulty_level_id">
                    <?php
                    foreach ($difficultyLevels as $k => $v) {
                        $default = "";
                        if ($v["default"] == true) {
                            $default = " selected ";
                        }
                        echo '<option value="' . $v["id"] . '"' . $default . '>' . $v["name"] . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <span>* Required Field</span><br/><br/>
    <input type="submit" name="submit" value="Record" class="button"/>
</form>
</div>
</div>
<script src="/js/third_party/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
<script src="/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/js/third_party/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="/js/third_party/math.js" ></script>
<script src="/js/third_party/jquery/ui/1.12.1/jquery-ui.js"></script>
<script src="/js/tasks/view.js"></script>
<script type="text/javascript">
    // const re = /(?:(?:^|[-+_*/])(?:\s*-?\d+(\.\d+)?(?:[eE][+-]?\d+)?\s*))+$/;
    // function test_expr(s) {
    //     console.log("%s is valid? %s", s, re.test(s));
    //     return true;
    // }
    $(function () {
        $("#start_date").datetimepicker();
        $("#end_date").datetimepicker();
        $("#target_date").datetimepicker();
        var timer = null;
        CKEDITOR.replace('description');
    });
</script>