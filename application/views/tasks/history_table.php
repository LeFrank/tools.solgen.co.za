
        <div id="tasksHistoryContent" class="tasksHistoryContent" >
            <div id="historyGraph">
            <h2>Tasks History ( <?php echo (null == $tasks) ? 0 : sizeof($tasks); ?> )</h2>
                Table of full data from <?php echo $startAndEndDateforMonth[0]; ?> to <?php echo $startAndEndDateforMonth[1]; ?><br/><br/>
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
                    <th>Age</th>
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
                            echo "<tr ".$tr_style." id='row_".$v["id"]."'>";
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
                            echo "<td><a href='/tasks/task/" . $v["id"] . "' class='plain-text' target='_blank'>" . $v["name"] . "</a></td>";
                            echo "<td>" . $v["description"] . "</td>";
                            // echo "<td>" . $v["status_id"] . "</td>";
                            echo "<td>" . $tasksStatuses[$v["status_id"]]["name"]  . "</td>";
                            echo "<td>" . $v["start_date"] . "</td>";
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
                            echo "<td>" . $v["num_notes"] . "</td>";
                            echo "<td>" . $v["num_artefacts"] . "</td>";
                            echo "<td>" . $v["age"] . "</td>";
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

        </div>
    </div>
</div>
<script type="text/javascript" src="/js/third_party/toastr/toastr.min.js" ></script>
<script type="text/javascript" src="/js/third_party/toastr/glimpse.js" ></script>
<script type="text/javascript" src="/js/third_party/toastr/glimpse.toastr.js" ></script>
<script type="text/javascript" src="/js/tasks/history_table.js" ></script>