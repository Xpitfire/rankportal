<?php 
require_once 'code/Util.php';
require_once 'code/AuthenticationManager.php';

$user = AuthenticationManager::getAuthenticatedUser();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Cp1252">
<title>Insert title here</title>
<link rel="stylesheet" href="css/main.css" type="text/css" />
</head>
<body>

<div class="header">
<h1>SCR4 Bookshop</h1>

<?php if ($user == null): ?>
	<p>Not logged in. [<a href="login.php">Login</a>]</p>
<?php else: ?>
<form method="post" action="<?php action('logout'); ?>">
	<p>Welcome, <?php echo escape($user->getUserName()); ?></p>
	<input type="submit" value="Logout" />
</form>

<?php endif; ?>



<div class="navigation">
<p>
<a href="start.php">Home</a> | <a href="list.php">List</a> | <a href="search.php">Search</a> | <a href="checkout.php">Checkout</a>
</p>
</div>

</div>