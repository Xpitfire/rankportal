<?php
require_once 'code/Util.php';

$productId = isset($_REQUEST['productId']) ? $_REQUEST['productId'] : null;

require 'inc/header.php'; ?>

    <h2>
        <?php if ($productId != null) { ?>
            Success :)
        <?php } else { ?>
            Ups... something went wrong :(
        <?php } ?>
    </h2>

<?php if ($productId != null) { ?>
    <p>Successfully added a new product: ID =  <?php echo escape($productId)?>.</p>
<?php } else { ?>
    <p>Failed to add a product!</p>
<?php } ?>

<?php require 'inc/footer.php';