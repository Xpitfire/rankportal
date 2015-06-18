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
        <th>Entries</th>
        <th>Rating</th>
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
            <?php } ?>
            <td></td>
            <td></td>
            <td>
                <form method="POST" action="<?php action('showDetails', array('productId' => $product->getId())); ?>">
                    <input type="submit" value="Comments" />
                </form>
            </td>
            <?php if ($user != null && $user->getId() == $product->getUserId()) { ?>
                <td>
                <form method="POST" action="<?php action('deleteProduct', array('productId' => $product->getId())); ?>">
                    <input type="submit" value="Delete" />
                </form>
                </td>
            <?php } ?>
        </tr>
    <?php } ?>
</table>