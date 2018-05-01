<?php echo $error; ?>
<?php echo form_open_multipart('resources/do_upload'); ?>
<input type="file" name="userfile" size="20" />
<br /><br />
<input type="submit" value="upload" />
</form>
<br/>
<?php if(!empty($resources)){?>
    <div class="row expanded">
        <div class="large-12 columns">
            <div class="row expanded">
                <div class="large-1 columns">
                    &nbsp;
                </div>
                <div class="large-3 columns">
                    Name
                </div>
                <div class="large-2 columns">
                    Date
                </div>
                <div class="large-1 columns">
                    File Size
                </div>
                <div class="large-1 columns">
                    File Origin
                </div>
                <div class="large-4 columns">
                    Actions
                </div>
            </div>
        </div>
    </div>
    <div class="row expanded">
        <div class="large-12 columns">
            &nbsp;
        </div>
    </div>
    <?php
    //        echo "<pre>";
    //        print_r($resources);
    //        echo "</pre>";
    foreach ($resources as $k => $v) {
        ?>
        <div class="row expanded">
            <div class="large-1 columns">
                <img style="width:30px;margin-top:5px;" src="../../../images/third_party/icons/110942-file-formats-icons/svg/<?php echo ltrim($v["file_extension"], "."); ?>-file-format-symbol.svg">
            </div>
            <div class="large-3 columns">
                <strong><?php echo $v["original_name"]; ?></strong>
            </div>
            <div class="large-2 columns">
                <?php echo $v["created_on"]; ?>
            </div>
            <div class="large-1 columns">
                <?php
                if ($v["filezise"] < 1024) {
                    echo $v["filezise"] . " KB";
                } elseif ($v["filezise"] > 1024 && $v["filezise"] < ( 1024 * 1024 )) {
                    echo $v["filezise"] / 1024 . " MB";
                }
                ?>
            </div>
            <div class="large-1 columns">
                <?php echo $tools[$v["tool_id"]]["name"]; ?>
            </div>
            <div class="large-4 columns">
                <a href="resources/delete/resource/<?php echo $v["id"];?>">Delete</a>
                &nbsp;&nbsp;|&nbsp;&nbsp;
                <a href="resources/view/resource/<?php echo $v["id"];?>">View</a>
                &nbsp;&nbsp;|&nbsp;&nbsp;
                <a href="#/<?php echo $v["id"];?>">Re-Process</a>

            </div>
        </div>

        <hr>
    <?php
    }
}else{
    ?>
    <div class="row expanded">
        <div class="large-12 columns">
            No resources have been uploaded yet.
        </div>
    </div>
<?php        
}
?>
</div>
</div>