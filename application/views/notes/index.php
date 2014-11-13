<?php 
	
	
?>

<div id="notesContent" class="notesContent" >
    <h2>Note Overview</h2>
    <div id="captureNote" >
        <h3>Capture Note</h3>
        <?php echo $capture_form;?>
    </div>
    <br/><br/>
    <div id="latestNotes">
    	<h3>Five Latest Notes</h3>
        <?php if (is_array($notes) && !empty($notes)) {
            $curDate = null;
            $count = 0;
            foreach($notes as $k=>$v){
                if($curDate== null){
                    $curDate = date('Y/m/d', strtotime($v["create_date"]));
                    // write date 
                    echo "<div id=\"day_group_".$count."\" class=\"day_group_heading\">"
                            . "<div class=\"note_date\">". date('l, jS \of F Y', strtotime($curDate)) ."</div>";
                }
                if($curDate != date('Y/m/d',strtotime($v["create_date"]))){
                    $curDate = date('Y/m/d',strtotime($v["create_date"])); ?>
                    </div>
                    <br/>
                    <div id="day_group_<?php echo $count;?>" class="day_group_heading">
                        <div class="note_date"><?php echo date('l, jS \of F Y', strtotime($curDate)) ?></div>
                    <?php } ?>
                    <br/>
                    <br/>
                    <div style="" id="time_grouping" class="time_grouping">
                        <?php echo date('H:i',strtotime($v["create_date"])); 
                            if(!empty($v["update_date"])){ ?>
                                <br/>
                                <span class="update_date">
                                    Last edited:
                                    <br/>
                                    <?php echo $v["update_date"]."<br/>No. of updates: ".$v["update_count"]; ?>
                                </span>
                        <?php }
                        ?>
                    </div>
                    <div id="note_content" >
                        <div id="title_content" class="note_title">
                            <?php echo $v["heading"]?>
                        </div>
                        <div id="body_content" class="note_body">
                            <?php echo $v["body"]?>
                        </div>
                        <div id="tags_content" class="note_tagg">
                            <?php echo $v["tagg"]?>
                        </div>
                        <div id="action_content" class="note_action">
                            <a href="/notes/edit/<?php echo $v["id"]; ?>">edit</a>
                            &nbsp;&nbsp;|&nbsp;&nbsp;
                            <a href="/notes/delete/<?php echo $v["id"]; ?>" >delete</a>                            
                        </div>
                    </div>
                    <div style="clear:both;" />
                </div>
                <?php $count++;
            }
            ?><br/><a href="/notes/history">See Notes>History</a>
                <?php
        } else {
            echo "No notes captured.";
        }
        ?>
    </div>
</div>