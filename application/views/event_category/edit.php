<h3>Edit Event Category</h3>
<?php echo validation_errors(); ?>

<?php echo form_open('eventCategory/capture') ?>

<input type="hidden" name="id" value="<?php echo $eventCategory->id; ?>" />

<label for="name">Name *</label>
<input type="text" name="name" value="<?php echo $eventCategory->name; ?>" /><br />

<label for="description">Description *</label>
<textarea name="description" id="description"><?php echo $eventCategory->description; ?></textarea><br />

<label for="enabled">Enabled</label>
<select name="enabled">
    <option value="true" <?php echo ($eventCategory->enabled == 1 ) ? "selected" : "" ?>>True</option>
    <option value="false" <?php echo ($eventCategory->enabled == 0 ) ? "selected" : "" ?> >False</option>';
</select><br />
<input type="submit" name="submit" value="Create Event Category" /><a href="/timetable/event-categories" >Cancel</a>
</form>