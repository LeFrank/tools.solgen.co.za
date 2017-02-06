<?php ?>
<div id="notesContent" class="row expanded" >
    <div class="large-12 columns" >
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
                        <div class="row expanded">
                            <div class="large-12 columns" >
                                <label for="title">Text
                                    <input type="text" name="searchText" placeholder="Topic, subject, content or tag text you wish to search for" value="" />
                                </label>
                            </div>
                        </div>
                        <div class="row expanded">
                            <div class="large-2 columns" >
                                <label>Date From  
                                    <input id="fromDate" type="text" value="<?php echo date('Y/m/d H:i:s', mktime(0, 0, 0, date("m") - 1, date("d"), date("Y"))); ?>" name="fromDate" />
                                </label>
                            </div>
                            <div class="large-2 columns">
                                <label>To 
                                    <input id="toDate" type="text" value="<?php echo date('Y/m/d H:i:s'); ?>" name="toDate" />
                                </label>
                            </div>
                            <div class="large-8 columns" ></div>
                        </div>
                        <div class="row expanded">
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
            <div class="row expanded">
                <div class="large-4 columns" id="tags">
                    <h3>Tags (<?php echo sizeOf($tags[0]); ?>)</h3>
                    <ol style="padding-left:20px;">
                        <?php
                        foreach ($tags[1] as $k => $v) {
                            echo '<li><a href="#" rel="' . $v . '" onclick="getNotesForTag(this);">' . $v . '( '. $tags[0][$v]["count"] .' )</a></li>';
                        }
                        ?>
                    </ol>
                </div>
                <div class="large-8 columns" id="tag-content">
                    <!-- content goes here -->
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/js/notes/tags.js" ></script>
<script type="text/javascript" src="/js/notes/history.js" ></script>