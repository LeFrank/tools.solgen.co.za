
        <div id="tasksHistoryContent" class="tasksHistoryContent" >
            <div id="historyGraph">
                <h2>Tasks History</h2>
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
                            echo "<td>" . "ToDo" . "</td>";
                            echo "<td>" . "ToDo" . "</td>";
                            echo "<td><a href='/tasks/edit/" . $v["id"] . "'>Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='/tasks/delete/" . $v["id"] . "' onclick='return confirm_delete()'>Delete</a></td>";
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