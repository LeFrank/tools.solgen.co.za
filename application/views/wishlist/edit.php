<?php ?>
<div class="row ">
    <div class="large-12 columns">
        <div id="editWishlistItem">
            <h3>Edit Item</h3>
            <?php echo validation_errors(); ?>

            <?php echo form_open('expense-wishlist/update') ?>
            <div class="row">
                <div class="large-4 columns">
                    <label for="name">Name *</label>
                    <input type="text" name="name" id="name" placeholder="Awesome new thing" autofocus value="<?php echo $wishlistItem->name; ?>"/><br />
                </div>
                <div class="large-1 columns">
                    <label for="priority">Priority</label>
                    <select name="priority" id="priority"> 
                        <?php foreach($priorities as $k=> $v){   ?>
                            <option value="<?php echo $k; ?>" <?php echo (($wishlistItem->priority == $k)? "selected='selected'":""); ?>><?php echo $v; ?></option>
                        <?php } ?>  
                    </select>
                </div>
                <div class="large-1 columns">
                    <label for="cost">Estimated Cost</label>
                    <input type="number" min="0.01" step="0.01" max="9999999999999" name="cost" id="cost" placeholder="0.00" value="<?php echo $wishlistItem->cost; ?>" /><br />
                </div>
                <div class="large-1 columns">
                    <label for="targetDate">Target Date</label>
                    <input  type="text" id="targetDate" name="targetDate" placeholder="<?php echo date('Y/m/d H:i:s'); ?>" value="<?php echo $wishlistItem->target_date; ?>"/>
                </div>
                <div class="large-1 columns">
                    <label for="status">Status</label>
                    <select name="status" id="status"> 
                        <?php foreach($statuses as $k=> $v){   ?>
                            <option value="<?php echo $k; ?>" <?php echo (($wishlistItem->status == $k)? "selected='selected'":""); ?>><?php echo $v; ?></option>
                        <?php } ?>    
                    </select>
                </div>
                <div class="large-5 columns">
                </div>
            </div>
            <div class="row"><div class="large-12 columns">&nbsp;</div></div>
            <div class="row">
                <div class="large-6 columns">
                    <label for="description">Item Description</label>
                    <textarea name="description" id="description" cols="20" rows="4" placeholder="What was special about it, or a description of the expense."><?php echo $wishlistItem->description; ?></textarea>
                </div>
                <div class="large-6 columns">
                    <label for="reason">Reason/Desire/Need/Motivation</label>
                    <textarea name="reason" id="reason" cols="20" rows="4" placeholder="What was special about it, or a description of the expense."><?php echo $wishlistItem->reason; ?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <span>* Required Field</span><br/><br/>
                </div>
            </div>
            <input type="submit" name="submit" value="Update" class="button"/>  <a href="/expense-wishlist" class="button secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
<script src="/js/third_party/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css"/ >
<script src="/js/jquery.datetimepicker.js"></script>
<script type="text/javascript">
    $(function() {
        $('form').attr('autocomplete', 'off');
        $("#expenseDate").datetimepicker();
        CKEDITOR.replace('description');
        CKEDITOR.replace('reason');
    });
</script>
