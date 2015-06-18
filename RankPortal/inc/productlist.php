<?php
require_once 'code/AuthenticationManager.php';
require_once 'code/DataManager.php';

$user = AuthenticationManager::getAuthenticatedUser();
?>

<table>
    <tr>
        <th>Product</th>
        <th>Vendor</th>
        <th>Creator</th>
    </tr>

    <?php foreach ($products as $product) { ?>
        <tr>
            <td><?php echo escape($product->getProductName()); ?></td>
            <td><?php echo escape($product->getVendor()); ?></td>
            <td><?php echo escape(DataManager::getUserForId($product->getUserId())->getUserName()); ?></td>
            <td>
                <form method="POST" action="<?php action('showDetails', array('productId' => $product->getId())); ?>">
                    <input type="submit" value="Comments" />
                </form>
            </td>
        </tr>
    <?php } ?>
</table>