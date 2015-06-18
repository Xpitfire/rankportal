<?php
require_once 'code/Util.php';
require_once 'code/AuthenticationManager.php';

$user = AuthenticationManager::getAuthenticatedUser();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rating Portal</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link href="css/base.css" rel="stylesheet" />

</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Rating Portal</h1>

            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <?php if ($user != null) { ?>
                            <p class="navbar-brand">Welcome, <?php echo escape($user->getUserName()); ?></p>
                        <?php } ?>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li><a href="start.php">Home</a></li>
                            <li><a href="products.php">Products</a></li>
                            <li><a href="search.php">Search</a></li>
                            <li><a href="addproduct.php">Add Product</a></li>
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <?php if ($user == null): ?>
                                    <p>Not logged in. [<a href="login.php">Login</a>] or [<a href="signup.php">SignUp</a>]</p>
                                <?php else: ?>
                                    <form method="post" action="<?php action('logout'); ?>" role="form">
                                        <button class="btn btn-danger" type="submit" id="logout-btn">Logout</button>
                                    </form>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>

        <div class="jumbotron">