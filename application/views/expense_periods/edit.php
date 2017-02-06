<div class="row expanded">
    <div class="large-12 columns">
        <h3>Edit Expense Period</h3>
        <?php echo validation_errors(); ?>

        <?php echo form_open('expense-periods/update') ?>

        <input type="hidden" name="id" value="<?php echo $expensePeriod->id; ?>" />
        <label for="name">Name *</label>
        <input type="text" name="name" value="<?php echo $expensePeriod->name; ?>"  autofocus /><br />
        <label for="description">Description *</label>
        <input type="text" name="description" value="<?php echo $expensePeriod->description; ?>" /><br />
        <label for="startDate">Start Date *</label>
        <input  type="text" id="startDate" name="startDate" value="<?php echo $expensePeriod->start_date; ?>" /><br/><br/>
        <label for="endDate">End Date *</label>
        <input  type="text" id="endDate" name="endDate" value="<?php echo $expensePeriod->end_date; ?>" /><br/><br/>
        <label>Active</label>
        <select name="active" id="active-period">
            <option value="1" <?php echo (($expensePeriod->active == 1) ? "selected" : "") ; ?> >True</option>
            <option value="0" <?php echo (($expensePeriod->active == 0) ? "selected" : "") ; ?> >False</option>
        </select><br/><br/>
        <input type="submit" name="submit" value="Create Expense Period" class="button" /> <a href="/expense-periods/manage" class="button secondary">Cancel</a>
        </form>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
<script type="text/javascript" src="/js/jquery.datetimepicker.js" ></script>
<script type="text/javascript" src="/js/expense_periods/edit.js" ></script>