<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<div class="row">
    <div class="large-12 columns">
        <div id="captureExpenses">
            <h3>Capture Wishlist Item</h3>
            <?php echo validation_errors(); ?>

            <?php echo form_open('wishlist/capture') ?>
            <div class="row">
                <div class="large-4 columns">
                    <label for="name">Name *</label>
                    <input type="text" name="name" id="name" placeholder="Awesome new thing" autofocus /><br />
                </div>
                <div class="large-2 columns">
                    <label for="priority">Priority</label>
                    <select name="priority" id="priority"> 
                        <option value="0">None</option>
                        <option value="1">Low</option>
                        <option value="2">Low/Medium</option>
                        <option value="3">Medium</option>
                        <option value="4">Medium/High</option>
                        <option value="5">High</option>
                        <option value="6">High/Summit</option>
                        <option value="7">Summit</option>
                    </select>
                </div>
                <div class="large-2 columns">
                    <label for="cost">Estimated Cost</label>
                    <input type="number" min="0.01" step="0.01" max="9999999999999" name="cost" id="cost" placeholder="0.00" /><br />
                </div>
                <div class="large-2 columns">
                    <label for="targetDate">Target Date</label>
                    <input  type="text" id="targetDate" name="targetDate" placeholder="<?php echo date('Y/m/d H:i:s'); ?>" />
                </div>
                <div class="large-2 columns">
                    <label for="status">Status</label>
                    <select name="status" id="status"> 
                        <option value="0">None</option>
                        <option value="1">Some Day</option>
                        <option value="2">Awaiting Action</option>
                        <option value="3">In Progress</option>
                        <option value="4">Stopped, needs rethink</option>
                        <option value="5">Completed/Acquired/Done</option>
                        <option value="6">High</option>
                        <option value="7">High/Summit</option>
                        <option value="8">Summit</option>
                    </select>
                </div>
            </div>
            <div class="row"><div class="large-12 columns">&nbsp;</div></div>
            <div class="row">
                <div class="large-6 columns">
                    <label for="description">Item Description</label>
                    <textarea name="description" id="description" cols="20" rows="4" placeholder="What was special about it, or a description of the expense."></textarea>
                </div>
                <div class="large-6 columns">
                    <label for="reason">Reason/Desire/Need/Motivation</label>
                    <textarea name="reason" id="reason" cols="20" rows="4" placeholder="What was special about it, or a description of the expense."></textarea>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <span>* Required Field</span><br/><br/>
                </div>
            </div>
            <input type="submit" name="submit" value="Record" class="button"/>
            </form>
        </div>
    </div>
</div>
<script src="/js/third_party/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" />
<script src="/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/js/third_party/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="/js/expenses/expense_table.js" ></script>
<script type="text/javascript" src="/js/expenses/expense_capture.js" ></script>
<script type="text/javascript">
    $(function () {
        $("#targetDate").datetimepicker();
        CKEDITOR.replace('description');
        CKEDITOR.replace('reason');
    });
</script>