<?php
require_once 'code/Util.php';
require_once 'code/AuthenticationManager.php';

$user = AuthenticationManager::getAuthenticatedUser();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=Cp1252">
    <title>Rating Portal</title>
    <link rel="stylesheet" href="css/base.css" type="text/css"/>
</head>
<body>
    <div class="header">

        <h1>Rating Portal</h1>

        <?php if ($user == null): ?>
            <p>Not logged in. [<a href="login.php">Login</a>] or [<a href="signup.php">SignUp</a>]</p>
        <?php else: ?>
            <form method="post" action="<?php action('logout'); ?>">
                <p>Welcome, <?php echo escape($user->getUserName()); ?></p>
                <input type="submit" value="Logout" />
            </form>

        <?php endif; ?>

        <div class="navigation">
            <p>
                <a href="start.php">Home</a> | <a href="products.php">Products</a> | <a href="search.php">Search</a> | <a href="addproduct.php">Add Product</a>
            </p>
        </div>
    </div>