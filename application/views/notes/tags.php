<?php ?>

<div id="notesContent" class="notesContent" >
    <h2>
        History 
        <span id="searchExpand"><img src="/images/third_party/icons/Search_icon.png" />
        </span>
        <span id="createNote"><img src="/images/third_party/icons/Add_icon.png" />
        </span>
    </h2>
    <div id="searchNotesHistory" >
        <div id="searchForm" class="notesHistoryHidden notesHistory">
            <form action="/notes/history/search" method="post" accept-charset="utf-8" id="SearchNoteForm">
                <label for="title">Text</label>
                <input type="text" name="searchText" placeholder="Topic, subject, content or tag text you wish to search for" value="" />
                <br/>
                <label>Date</label>
                From  
                <input id="fromDate" type="text" value="<?php echo date('Y/m/d H:i:s', mktime(0, 0, 0, date("m") - 1, date("d"), date("Y"))); ?>" name="fromDate" />
                To 
                <input id="toDate" type="text" value="<?php echo date('Y/m/d H:i:s'); ?>" name="toDate" />
                <br/>
                <input type="submit" value="Search" text="Search" />
            </form>
        </div>
    </div>
    <div id="createNoteHistory" >
        <div id="createNoteForm" class="notesHistoryHidden createNote">
            <?php echo $capture_form; ?>
        </div>
    </div>
    <div id="Notes">
        <div style="float:left; width:47%;padding:10 0px;">
            <h3>Tags (<?php echo sizeOf($tags); ?>)</h3>
            <ol style="padding-left:20px;">
            <?php
            
            foreach ($tags as $k => $v) {
                echo '<li><a href="#tag_'.$v.'" id="'.$k.'">'.$v.'</a></li>';
            }
            ?>
            </ol>
        </div>
        <div style="float:left; width:47%;border:solid 1px grey;">
            <h3>Notes Tags</h3>
            <?php echo $this->pagination->create_links(); ?>

            <?php
            if (is_array($notes) && !empty($notes)) {
                $tagg = null;
                $count = 0;
                foreach ($notes as $k => $v) {
                    if ($tagg == null) {
                        $tagg = $v["tagg"];
                        // write date 
                        echo "<div id=\"day_group_" . $count . "\" class=\"day_group_heading\">"
                        . "<div class=\"note_date\"><a id='tag_".$tagg."'>" . $tagg . "</a></div>";
                    }
                    if ($tagg != $v["tagg"]) {
                        $tagg = $v["tagg"];
                        ?>
                    </div>
                    <br/>
                    <div id="day_group_<?php echo $count; ?>" class="day_group_heading">
                        <div class="note_date"><a id="tag_<?php echo $tagg; ?>"><?php echo $tagg; ?></div>
                    <?php } ?>
                    <br/>
                    <br/>
                    <div style="" id="time_grouping" class="time_grouping">
                        <?php
                        echo date('H:i', strtotime($v["create_date"]));
                        if (!empty($v["update_date"])) {
                            ?>
                            <br/>
                            <span class="update_date">
                                Last edited:
                                <br/>
                                <?php echo $v["update_date"] . "<br/>No. of updates: " . $v["update_count"]; ?>
                            </span>
                        <?php }
                        ?>
                    </div>
                    <div id="note_content" >
                        <div id="title_content" class="note_title">
                            <?php echo $v["heading"] ?>
                        </div>
                        <div id="body_content" class="note_body">
                            <?php echo $v["body"] ?>
                        </div>
                        <div id="tags_content" class="note_tagg">
                            <?php echo $v["tagg"] ?>
                        </div>
                        <div id="action_content" class="note_action">
                            <a href="/notes/edit/<?php echo $v["id"]; ?>">edit</a>
                            &nbsp;&nbsp;|&nbsp;&nbsp;
                            <a href="/notes/delete/<?php echo $v["id"]; ?>" >delete</a>                            
                        </div>
                    </div>
                    <div style="clear:both;" />
                </div>
                <?php
                $count++;
            }
        } else {
            echo "No tags.";
        }
        ?>
    </div>
</div>
</div>
<script type="text/javascript" src="/js/notes/history.js" ></script>