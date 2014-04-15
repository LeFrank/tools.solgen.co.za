<h2>Register</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('user/register') ?>

	<label for="firstname">Firstname</label>
	<input type="input" name="firstname" /><br />

	<label for="lastname">Lastname</label>
	<input name="lastname"></input><br />
        
        <label for="email">email</label>
	<input name="email"></input><br />
        
        <label for="password">password</label>
	<input type="password" name="password"></input><br />

        <label for="type">Type</label>
	<select name="user_type">
            <option value="user">user</option>
            <option value="admin">admin</option>
        <select><br />
        
	<input type="submit" name="submit" value="Done" />

</form>