<div class="row expanded">
    <div class="large-12 columns">
        <h3>Edit Income Type</h3>
        <?php echo validation_errors(); ?>

        <?php echo form_open('income-types/update') ?>

        <input type="hidden" name="id" value="<?php echo $incomeType->id; ?>" />
        <label for="description">Description *</label>
        <input type="text" name="description" value="<?php echo $incomeType->description; ?>" /><br />

        <label for="template">Template</label>
        <textarea name="template" id="template" cols="40" rows="5" ><?php echo $incomeType->template; ?></textarea><br/><br/>
        
        <label for="enabled">Enabled</label>
        <select name="enabled">
            <option value="true" <?php echo ($incomeType->enabled == 1 ) ? "selected" : "" ?>>True</option>
            <option value="false" <?php echo ($incomeType->enabled == 0 ) ? "selected" : "" ?> >False</option>';
        </select><br />
        <input type="submit" name="submit" value="Create Income Type" class="button" /><a href="/income-types/manage" >Cancel</a>
        </form>
    </div>
</div>
<script src="/js/third_party/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css"/ >
<script type="text/javascript">
    $(function() {
        CKEDITOR.replace('template');
    });
</script>