<h3>Edit Expense Type</h3>
<?php echo validation_errors(); ?>

<?php echo form_open('expense-types/update') ?>

<input type="hidden" name="id" value="<?php echo $expenseType->id;?>" />
<label for="description">Description *</label>
<input type="text" name="description" value="<?php echo $expenseType->description;?>" /><br />

<label for="enabled">Enabled</label>
<select name="enabled">
    <option value="true" <?php echo ($expenseType->enabled == 1 )? "selected":"" ?>>True</option>
    <option value="false" <?php echo ($expenseType->enabled == 0 )? "selected":"" ?> >False</option>';
</select><br />
<input type="submit" name="submit" value="Create Expense Type" /><a href="/expense-types/manage" >Cancel</a>
</form>
