<?php
require 'inc/header.php';
require_once 'code/AuthenticationManager.php';

if (AuthenticationManager::isAuthenticated()) {
    redirect('start.php');
}

?>

    <h2>Login</h2>

    <form method="POST" action="<?php action('logIn'); ?>" role="form" data-toggle="validator">
        <div class="form-group">
            <label class="control-label" for="user">Username</label>
            <input name="userName" class="form-control" required="required" id="usr" />
        </div>
        <div class="form-group">
            <label class="control-label" for="pwd">Password</label>
            <input type="password" name="password" class="form-control" required="required" id="pwd"/>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
    </form>

<?php
require 'inc/footer.php';