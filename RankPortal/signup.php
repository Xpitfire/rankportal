<?php
require 'inc/header.php';
require_once 'code/AuthenticationManager.php';

if (AuthenticationManager::isAuthenticated()) {
    redirect('start.php');
}

?>

    <h2>SignUp</h2>

    <form method="POST" action="<?php action('signup'); ?>">
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
        <input type="submit" value="register" />
    </form>

<?php
require 'inc/footer.php';