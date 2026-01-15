<?php if (!empty($userContentArray)) { ?>
    <div class="row expanded">
        <div class="large-12 columns">
            <div class="row expanded">
                <div class="large-1 columns">
                    &nbsp;
                </div>
                <div class="large-4 columns ">
                    <strong>Name</strong>
                </div>
                <div class="large-3 columns">
                    <strong>Date</strong>
                </div>
                <div class="large-1 columns">
                    <strong>File Size</strong>
                </div>
                <div class="large-2 columns">
                    <strong>Actions</strong>
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
    foreach ($userContentArray as $k => $v) {
        ?>
        <div class="row expanded">
            <div class="large-1 columns">
                <img style="width:30px;margin-top:5px;" src="../../../images/third_party/icons/110942-file-formats-icons/svg/<?php echo ltrim($v["file_extension"], "."); ?>-file-format-symbol.svg">
            </div>
            <div class="large-4 columns">
                <a target="_blank" href="/resource/view/<?php echo $v["id"]; ?>/<?php echo $v["filename"]; ?>">
                    <?php echo $v["original_name"]; ?>
                </a>  
            </div>
            <div class="large-3 columns">
                <?php echo $v["created_on"]; ?>
            </div>
            <div class="large-1 columns">
                <?php
                if ($v["filezise"] < 1024) {
                    echo $v["filezise"] . " KB";
                } elseif ($v["filezise"] > 1024 && $v["filezise"] < ( 1024 * 1024 )) {
                    echo round($v["filezise"] / 1024, 2) . " MB";
                }
                ?>
            </div>
            <div class="large-2 columns">
                <a target="_blank" href="/resource/view/<?php echo $v["id"]; ?>/<?php echo $v["filename"]; ?>">View</a>
                <br/>
                <a href="/resource/delete/resource/<?php echo $v["id"]; ?>" onclick="return confirm_delete()">Delete</a>
                <br/>
                <a href="/resource/download/<?php echo $v["id"]; ?>/<?php echo $v["filename"]; ?>">Download</a>
                <br/>
            </div>
        </div>

        <hr>
        <?php
    }
} else {
    ?>
    <div class="row expanded">
        <div class="large-12 columns">
            No artefacts have been uploaded yet.
        </div>
    </div>
    <?php
}
?>
</div>
</div>