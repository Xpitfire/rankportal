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
                <th>User</th>
                <th>Rating</th>
            </tr>

            <?php if ($ratings != null): ?>
                <?php foreach ($ratings as $rating) { ?>
                    <tr>
                        <td><?php echo escape($rating->getCreateDate()); ?></td>
                        <td><?php echo escape($rating->getComment()); ?></td>
                        <td><?php echo escape(DataManager::getUserForId($rating->getUserId())->getUserName()); ?></td>
                        <td><?php echo escape($rating->getRank()); ?></td>
                        <td>
                            <?php if ($user != null && $user->getId() == $rating->getUserId()) { ?>
                                <form method="POST" action="<?php action('deleteRating', array('productId' => $productId, 'ratingId' => $rating->getId())); ?>">
                                    <input type="submit" value="Delete" />
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php endif; ?>

        <?php } ?>
    </table>

<?php if ($user != null && !DataManager::hasSubmittedRating($user->getId(), $productId)): ?>
    <div>
        <form method="POST" action="<?php action('addRating',
            array('productId' => $product->getId(), 'userId' => $user->getId())); ?>">
            <td>Type in a comment: <br> <input name="comment" /></td>
            <td>Rating: <input name="rank" /></td>
            <td><input type="submit" value="Add Comment" /></td>
        </form>
    </div>
<?php endif; ?>

<?php require 'inc/footer.php';