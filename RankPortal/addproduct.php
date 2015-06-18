<?php
require 'inc/header.php';
require_once 'code/AuthenticationManager.php';

$user = AuthenticationManager::getAuthenticatedUser();
?>

    <h2>Add Product</h2>

    <?php if ($user != null) { ?>

    <form method="POST" action="<?php action('addProduct', array('userId' => $user->getId())); ?>">
        <div class="form-group">
            <label class="control-label" for="prdname">Product Name</label>
            <input name="productName" class="form-control" id="prdname" required="required" />
        </div>
        <div class="form-group">
            <label class="control-label" for="vend">Vendor Name</label>
            <input name="vendor" class="form-control" id="vend" required="required" />
        </div>
        <div class="form-group">
            <label class="control-label" for="img">Image Path</label>
            <input name="imagePath" class="form-control" id="img" />
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Add Product</button>
    </form>

    <?php } else { ?>

        <p>Please login to add new products.</p>

    <?php } ?>

<?php
require 'inc/footer.php';