<?php
require 'inc/header.php';
require_once 'code/DataManager.php';

$productId = isset($_REQUEST['productId']) ? $_REQUEST['productId'] : null;
$product = ($productId != null) ?  DataManager::getProduct($productId) : null;
$ratings = ($productId != null) ? DataManager::getRatings($productId) : null;

?>

    <table>
        <tr>
            <th>Product</th>
            <th>Vendor</th>
            <th>Creator</th>
        </tr>

        <?php if ($product != null)  { ?>
            <tr>
                <td><?php echo escape($product->getProductName()); ?></td>
                <td><?php echo escape($product->getVendor()); ?></td>
                <td><?php echo escape(DataManager::getUserForId($product->getUserId())->getUserName()); ?></td>
            </tr>

            <tr>
                <th>Date</th>
                <th>Comment</th>
                <th>Rating</th>
            </tr>

            <?php if ($ratings != null): ?>
                <?php foreach ($ratings as $rating) { ?>
                    <tr>
                        <td><?php echo escape($rating->getCreateDate()); ?></td>
                        <td><?php echo escape($rating->getComment()); ?></td>
                        <td><?php echo escape($rating->getRank()); ?></td>
                    </tr>
                <?php } ?>
            <?php endif; ?>

            <?php if ($user != null): ?>
                <tr>
                    <form method="POST" action="<?php action('addComment',
                        array('productId' => $product->getId(), 'userId' => $user->getId())); ?>">
                        <td>Type in a comment: <br> <input name="comment" /></td>
                        <td>Rating: <input name="rank" /></td>
                        <td><input type="submit" value="Add Comment" /></td>
                    </form>
                </tr>
            <?php endif; ?>
        <?php } ?>
    </table>

<?php require 'inc/footer.php';