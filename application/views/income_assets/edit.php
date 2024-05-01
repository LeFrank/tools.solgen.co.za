<div class="row expanded">
    <div class="large-12 columns">
        <h3>Edit Income Assets</h3>
        <?php echo validation_errors(); ?>

        <?php echo form_open('income-assets/update') ?>

        <input type="hidden" name="id" value="<?php echo $incomeAsset->id; ?>" />
        <label for="description">Description *</label>
        <input type="text" name="description" value="<?php echo $incomeAsset->description; ?>" /><br />

        <label for="enabled">Enabled</label>
        <select name="enabled">
            <option value="true" <?php echo ($incomeAsset->enabled == 1 ) ? "selected" : "" ?>>True</option>
            <option value="false" <?php echo ($incomeAsset->enabled == 0 ) ? "selected" : "" ?> >False</option>';
        </select><br /><br />
        <input type="submit" name="submit" value="Create Income Assets" class="button"/> <a href="/income-assets/manage" >Cancel</a>
        </form>
    </div>
</div>