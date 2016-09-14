
<div class="row ">
    <div class="large-12 columns">
        <h3>Edit Event Category</h3>
        <?php echo validation_errors(); ?>

        <?php echo form_open('eventCategory/capture') ?>

        <input type="hidden" name="id" value="<?php echo $eventCategory->id; ?>" />

        <label for="name">Name *</label>
        <input type="text" name="name" value="<?php echo $eventCategory->name; ?>" /><br />

        <label for="description">Description *</label>
        <textarea name="description" id="description"><?php echo $eventCategory->description; ?></textarea><br />
        <label for="showOnDashboard">Show On Dashboard</label>
        <select name="showOnDashboard">
            <option value="1" <?php echo ($eventCategory->appear_on_dashboard == 1 ) ? "selected" : "" ?>>Yes</option>
            <option value="0" <?php echo ($eventCategory->appear_on_dashboard == null || $eventCategory->appear_on_dashboard == 0 ) ? "selected" : "" ?> >No</option>';
        </select>
        <br/>
        <label for="reminder">Reminder</label>
        <select name="reminder">
            <option value="1" <?php echo ($eventCategory->reminder == 1 ) ? "selected" : "" ?>>Yes</option>
            <option value="0" <?php echo ($eventCategory->reminder == 0 ) ? "selected" : "" ?> >No</option>';
        </select>
        <br/>
        <label for="enabled">Enabled</label>
        <select name="enabled">
            <option value="1" <?php echo ($eventCategory->enabled == 1 ) ? "selected" : "" ?>>Yes</option>
            <option value="0" <?php echo ($eventCategory->enabled == 0 ) ? "selected" : "" ?> >No</option>';
        </select><br />
        <br />
        <input type="submit" name="submit" value="Create Event Category" class="button" />
        &nbsp;<a href="/timetable/event-categories" class="button secondary">Cancel</a>
        </form>
    </div>
</div>