<h3>Edit Payment Method</h3>
<?php echo validation_errors(); ?>

<?php echo form_open('payment-methods/update') ?>

<input type="hidden" name="id" value="<?php echo $paymentMethod->id;?>" />
<label for="description">Description *</label>
<input type="text" name="description" value="<?php echo $paymentMethod->description;?>" /><br />

<label for="enabled">Enabled</label>
<select name="enabled">
    <option value="true" <?php echo ($paymentMethod->enabled == 1 )? "selected":"" ?>>True</option>
    <option value="false" <?php echo ($paymentMethod->enabled == 0 )? "selected":"" ?> >False</option>';
</select><br />
<input type="submit" name="submit" value="Create Payment Method" /> <a href="/payment-methods/manage" >Cancel</a>
</form>
