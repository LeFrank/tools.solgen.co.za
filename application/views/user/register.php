<h2>Register</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('user/register') ?>

	<label for="firstname">First Name</label>
	<input type="input" name="firstname" /><br />

	<label for="lastname">Last Name</label>
	<input name="lastname"></input><br />
        
        <label for="email">Email</label>
	<input name="email"></input><br />
        
        <label for="password">Password</label>
	<input type="password" name="password"></input><br />
       
	<input type="submit" name="submit" value="Done" />

</form>