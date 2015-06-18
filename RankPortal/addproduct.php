<?php
require 'inc/header.php';
require_once 'code/AuthenticationManager.php';

$user = AuthenticationManager::getAuthenticatedUser();
?>

    <h2>Add Product</h2>

    <?php if ($user != null) { ?>
        <form method="POST" action="<?php action('addProduct', array('userId' => $user->getId())); ?>">
            <table>
                <tr>
                    <th>Product name*:</th>
                    <td><input name="productName" /></td>
                </tr>
                <tr>
                    <th>Vendor name*:</th>
                    <td><input name="vendor" /></td>
                </tr>
                <tr>
                    <th>Image Path:</th>
                    <td><input name="imagePath" /></td>
                </tr>
            </table>
            <input type="submit" value="Add Product" />
        </form>
    <?php } else { ?>

        <p>Please login to add new products.</p>

    <?php } ?>

<?php
require 'inc/footer.php';