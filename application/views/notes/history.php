<?php ?>

<div id="notesContent" class="row" >
    <div class="large-12 columns" >
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
                    <div class="row">
                        <div class="large-12 columns" >
                            <label for="title">Text
                                <input type="text" name="searchText" placeholder="Topic, subject, content or tag text you wish to search for" value="" />
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-2 columns" >
                            <label>Date From  
                                <input id="fromDate" type="text" placeholder="<?php echo date('Y/m/d H:i:s', mktime(0, 0, 0, date("m") - 1, date("d"), date("Y"))); ?>" name="fromDate" />
                            </label>
                        </div>
                        <div class="large-2 columns">
                            <label>To 
                                <input id="toDate" type="text" placeholder="<?php echo date('Y/m/d H:i:s'); ?>" name="toDate" />
                            </label>
                        </div>
                        <div class="large-8 columns" ></div>
                    </div>
                    <div class="row">
                        <div class="large-12 columns" >
                            <br/>
                            <input type="submit" value="Search" text="Search" class="button" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="createNoteHistory" >
            <div id="createNoteForm" class="notesHistoryHidden createNote">
                <?php echo $capture_form; ?>
            </div>
        </div>
        <div id="Notes">
            <h3>Notes</h3>
            <div class="pagination-centered">
            <?php echo $this->pagination->create_links(); ?>
            </div>

            <?php
            if (is_array($notes) && !empty($notes)) {
                $curDate = null;
                $count = 0;
                foreach ($notes as $k => $v) {
                    if ($curDate == null) {
                        $curDate = date('Y/m/d', strtotime($v["create_date"]));
                        // write date 
                        echo "<div id=\"day_group_" . $count . "\" class=\"day_group_heading\">"
                        . "<div class=\"note_date\">" . date('l, jS \of F Y', strtotime($curDate)) . "</div>";
                    }
                    if ($curDate != date('Y/m/d', strtotime($v["create_date"]))) {
                        $curDate = date('Y/m/d', strtotime($v["create_date"]));
                        ?>
                    </div>
                    <br/>
                    <div id="day_group_<?php echo $count; ?>" class="day_group_heading">
                        <div class="note_date"><?php echo date('l, jS \of F Y', strtotime($curDate)) ?></div>
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
            echo '<div class="pagination-centered">';
            echo $this->pagination->create_links();
            echo '</div>';
        } else {
            echo "No notes.";
        }
        ?>
    </div>
</div>
</div>
</div>
<script type="text/javascript" src="/js/notes/history.js" ></script>