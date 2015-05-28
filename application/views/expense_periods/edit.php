<div class="row ">
    <div class="large-12 columns">
        <h3>Edit Expense Period</h3>
        <?php echo validation_errors(); ?>

        <?php echo form_open('expense-periods/update') ?>

        <input type="hidden" name="id" value="<?php echo $expensePeriod->id; ?>" />
        <label for="name">Name *</label>
        <input type="text" name="name" value="<?php echo $expensePeriod->name; ?>" /><br />
        <label for="description">Description *</label>
        <input type="text" name="description" value="<?php echo $expensePeriod->description; ?>" /><br />
        <label for="startDate">Start Date *</label>
        <input  type="text" id="startDate" name="startDate" value="<?php echo $expense->start_date; ?>" /><br/><br/>
        <label for="endDate">End Date *</label>
        <input  type="text" id="endDate" name="endDate" value="<?php echo $expense->end_date; ?>" /><br/><br/>
        <input type="submit" name="submit" value="Create Expense Period" class="button" /><a href="/expense-periods/manage" >Cancel</a>
        </form>
    </div>
</div>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

