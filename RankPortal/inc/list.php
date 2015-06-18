<?php
require_once 'code/AuthenticationManager.php';
require_once 'code/DataManager.php';

$user = AuthenticationManager::getAuthenticatedUser();
?>

<table class="table">
    <tr>
        <th>Product</th>
        <th>Vendor</th>
        <th>Creator</th>
        <th>Entries</th>
        <th>Rating</th>
        <th></th>
        <th></th>
    </tr>

    <?php foreach ($products as $product) { ?>
        <?php
        $ratings = DataManager::getRatings($product->getId());
        $sumRating = 0;
        $ratingCnt = 0;
        ?>
        <tr>
            <td><?php echo escape($product->getProductName()); ?></td>
            <td><?php echo escape($product->getVendor()); ?></td>
            <td><?php echo escape(DataManager::getUserForId($product->getUserId())->getUserName()); ?></td>
            <?php if ($ratings != null) {
                foreach ($ratings as $r) {
                    $sumRating += $r->getRank();
                    ++$ratingCnt;
                }
                ?>
                <td><?php echo $ratingCnt; ?></td>
                <td><?php echo $sumRating / $ratingCnt; ?></td>
            <?php } else { ?>
                <td></td>
                <td></td>
            <?php } ?>
            <td>
                <form method="POST" action="<?php action('showDetails', array('productId' => $product->getId())); ?>">
                    <button type="submit" class="btn btn-default">Comments</button>
                </form>
            </td>
            <?php if ($user != null && $user->getId() == $product->getUserId()) { ?>
                <td>
                    <form method="POST" action="<?php action('deleteProduct', array('productId' => $product->getId())); ?>">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            <?php } else { ?>
                <td></td>
            <?php } ?>
        </tr>
    <?php } ?>
</table>