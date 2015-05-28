<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo validation_errors();

echo form_open('user/send-reset-password-email');
?>
<h3>Rest Password</h3>
<p>Enter your email address in the field below.</p>
<label >Email</label>&nbsp;&nbsp;
<input id="email" name="email" value="" /><br/><br/>
<input type="submit" name="submit" value="Reset Password" />
</form>