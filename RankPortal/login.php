<?php
require 'inc/header.php'; 
require_once 'code/AuthenticationManager.php';

if (AuthenticationManager::isAuthenticated()) {
	redirect('start.php');
}

?>

<h2>Login</h2>

<form method="POST" action="<?php action('logIn'); ?>">
	<table>
		<tr>
			<th>User name:</th>
			<td><input name="userName" /></td>
		</tr>
		<tr>
			<th>Password:</th>
			<td><input type="password" name="password" /></td> 
		</tr>
	</table>
	<input type="submit" value="login" />
</form>

<?php 
require 'inc/footer.php';