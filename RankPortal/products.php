<?php
require_once 'code/DataManager.php';
require_once 'code/Util.php';

$products = DataManager::getProducts();

require 'inc/header.php'; ?>

    <h2>List of Products</h2>

<?php if (isset($products) && sizeof($products) > 0) {
    require 'inc/list.php';
} else { ?>
    <p>No products found.</p>
<?php } ?>

<?php require 'inc/footer.php';