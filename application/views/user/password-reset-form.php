<?php
    echo validation_errors();
    echo form_open('user/reset-user-password');
?>
<h3>Rest Password</h3>
<p>Enter your new password in the fields below.</p>
<label >Password</label>&nbsp;&nbsp;
<input id="password" name="password" type="password" value="" /><br/><br/>
<label >Confirm Password</label>&nbsp;&nbsp;
<input id="password1" name="password1"  type="password" value="" /><br/><br/>
<input id="token" name="token"  type="hidden" value="<?php echo $token;?>" />
<input type="submit" name="submit" value="Reset Password" />
</form>