<div class="row expanded" id="overviewSection">
    <div class="large-12 columns" >
        <h2>Tasks: <?php echo sizeof($tasks); ?></h2>
    </div>
</div>
<div class="row expanded">
    <div class="large-12 columns dnd_domains_area" >
        <h3>Domains</h3>
        <?php
            // Example: Display task domains and their counts
            echo "<p>Number of Domains: ".sizeof($tasksDomains) ."</p>";
            echo "<div><p>Number of Tasks Per Domain:</p>";

            // print_r($tasks); 
            foreach ($tasksDomains as $k => $v) {
                $domain[$v["id"]] = array();
                ?>
                <div class="large-1 columns"  >
                <?php
                    $taskCount = 0;
                    foreach ($tasks as $task) {
                        if ($task['domain_id'] == $v['id'] ) {
                            $taskCount++;
                            $domain[$v['id']][] = $task;
                        }
                    } ?>
                    <div class="dnd_domains_draggable_zone"  style="border: solid 5px <?php echo (array_key_exists("background_colour", $v)) ? $v["background_colour"] : "inherit";?>;"
                        ondrop="droppoint(event)" 
                        ondragover="allowDropOption(event)" 
                        id="drag_point_domain_<?php echo $v['id']; ?>"    
                    >
                        <h3>
                        <?php echo (!empty($v["emoji"]) ? json_decode($v["emoji"]) : "&nbsp;&nbsp;&nbsp;&nbsp;") ." ". $v['name'] . ": " . $taskCount; ?>
                        </h3>
                        <br/>
                        <?php
                            if ( empty($domain[$v["id"]]) ){
                                echo "<p>No Tasks</p>";
                            }else{
                                foreach ($domain[$v["id"]] as $task) {
                                    echo "<div id='drag".$task["id"]."'
                                            draggable='true' 
                                            ondragstart='dragpoint(event)' 
                                            class='domain_task_tile_draggable'
                                            style='cursor: grab;'>".
                                            "<div >".
                                            "TS: ". $task["id"] ." => ".$task["name"]  .
                                            "</div>".
                                        "</div>";
                                }
                            }
                        ?>
                        <br/>
                        <br/>
                        <br/>
                    </div>
                </div>  
            <?php 
                }
            echo "</div>";
            ?>
    </div>
</div>