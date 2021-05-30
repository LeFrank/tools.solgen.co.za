<?php echo $error; ?>
<h3>Upload Resource</h3>
<form action="resource/do_upload" method="Post" class="dropzone">
    <div class="dropzone"></div>
    <button id="startUpload">UPLOAD</button>
</form>
<?php echo form_open_multipart('resource/do_upload'); ?>
<label for="note_content">File *</label>
<input type="file" name="userfile" size="20"  />
<br />
<label for="resource_description">Note *</label>
<textarea name="description" id="description" cols="40" rows="15" placeholder="This file is important because ..."></textarea>
<br/><br/>
<input type="submit" class="button" value="Upload" />
</form>
<br/>
<div class="row expanded">
    <div class="large-12 columns">
        <h3>Resources ( <?php echo $totalResources; ?> )</h3>
    </div>
</div>
<div class="pagination-centered">
    <?php echo $this->pagination->create_links(); ?>
</div>
<?php if (!empty($resources)) { ?>
    <div class="row expanded">
        <div class="large-12 columns">
            <div class="row expanded">
                <div class="large-1 columns">
                    &nbsp;
                </div>
                <div class="large-2 columns ">
                    <strong>Name</strong>
                </div>
                <div class="large-3 columns">
                    <strong>Description</strong>
                </div>
                <div class="large-2 columns">
                    <strong>Date</strong>
                </div>
                <div class="large-1 columns">
                    <strong>File Size</strong>
                </div>
                <div class="large-1 columns">
                    <strong>File Origin</strong>
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
    foreach ($resources as $k => $v) {
        ?>
        <div class="row expanded">
            <div class="large-1 columns">
                <img style="width:30px;margin-top:5px;" src="../../../images/third_party/icons/110942-file-formats-icons/svg/<?php echo ltrim($v["file_extension"], "."); ?>-file-format-symbol.svg">
            </div>
            <div class="large-2 columns">
                <strong><?php echo $v["original_name"]; ?></strong>
            </div>
            <div class="large-3 columns">
                <?php echo (empty($v["description"])) ? "&nbsp;" : $v["description"]; ?>
            </div>
            <div class="large-2 columns">
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
            <div class="large-1 columns">
                <?php echo $tools[$v["tool_id"]]["name"]; ?>
            </div>
            <div class="large-2 columns">
                <a href="/resource/delete/resource/<?php echo $v["id"]; ?>" onclick="return confirm_delete()">Delete</a>
                &nbsp;&nbsp;|&nbsp;&nbsp;
                <a target="_blank" href="/resource/view/<?php echo $v["id"]; ?>/<?php echo $v["filename"]; ?>">View</a>
                &nbsp;&nbsp;|&nbsp;&nbsp;
                <a href="/resource/download/<?php echo $v["id"]; ?>/<?php echo $v["filename"]; ?>">Download</a>
                &nbsp;&nbsp;|&nbsp;&nbsp;
                <a href="#/<?php echo $v["id"]; ?>">Re-Process</a>

            </div>
        </div>

        <hr>
        <?php
    }
} else {
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
<div class="pagination-centered">
    <?php echo $this->pagination->create_links(); ?>
</div>
<script src="/js/third_party/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/js/resources/index.js" ></script>