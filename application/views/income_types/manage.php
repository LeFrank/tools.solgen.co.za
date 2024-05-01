<?php ?>
<div class="row expanded">
    <div class="large-12 columns">
<div id="income-type-manage-feedback" class="hidden"></div>
<h3>Manager Personalized Income Types</h3>
<div>
    <p>My Income Types</p>
    <?php
    if (!empty($incomeTypes)) {
        ?>
        <table>
            <thead>
            <th>Description</th>
            <th>Template</th>
            <th>Enabled</th>
            <th>Create Date</th>
            <th>Last Updated</th>
            <th>Actions</th>
            </thead>
            <tbody>
                <?php foreach ($incomeTypes as $k => $v) { ?>
                    <tr>    
                        <td><?php echo $v["description"]; ?></td>
                        <td><?php echo $v["template"]; ?></td>
                        <td><?php echo $v["enabled"]; ?></td>
                        <td><?php echo $v["create_date"]; ?></td>
                        <td><?php echo $v["update_date"]; ?></td>
                        <td>
                            <a href="/income-types/edit/<?php echo $v["id"];?>">edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                            <a href="/income-types/delete/<?php echo $v["id"];?>" onclick="return confirm_delete()">delete</a></td>
                    </tr>
                    <?php
                }
                ?>
        </tbody>
    </table>
        <?php
    }else{
        echo "<p>No personlized Income Types exist.</p>";
    }
    ?>
</div>

<div id="manage-income-type-form">
    <h3>Create Income Type</h3>
    <?php echo validation_errors(); ?>

    <?php echo form_open('income-types/capture') ?>

    <label for="description">Description *</label>
    <input type="text" name="description" /><br />

    <label for="template">Template</label>
    <textarea name="template" id="template" cols="40" rows="5" ></textarea><br/><br/>
    
    <label for="enabled">Income Type</label>
    <select name="enabled">
        <option value="true">True</option>
        <option value="false">False</option>';
    </select><br /><br />
    <input type="submit" name="submit" value="Create Income Type" class="button"/>
</form>
</div>
    </div>
</div>
<script src="/js/third_party/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css"/ >
<script type="text/javascript">
    $(function() {
        CKEDITOR.replace('template');
    });
</script>