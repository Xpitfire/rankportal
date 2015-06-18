<?php
require 'inc/header.php';
require_once 'code/DataManager.php';

$productId = isset($_REQUEST['productId']) ? $_REQUEST['productId'] : null;
$product = ($productId != null) ?  DataManager::getProduct($productId) : null;
$ratings = ($productId != null) ? DataManager::getRatings($productId) : null;

?>

    <table class="table">
        <tr>
            <th>Product</th>
            <th>Vendor</th>
            <th>Creator</th>
        </tr>
        <tr>
            <td><?php echo escape($product->getProductName()); ?></td>
            <td><?php echo escape($product->getVendor()); ?></td>
            <td><?php echo escape(DataManager::getUserForId($product->getUserId())->getUserName()); ?></td>
        </tr>
    </table>

    <table class="table">
        <?php if ($product != null)  { ?>
            <tr>
                <th>Date</th>
                <th>Comment</th>
                <th>User</th>
                <th>Rating</th>
                <th></th>
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
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php endif; ?>

        <?php } ?>
    </table>

<?php if ($user != null && !DataManager::hasSubmittedRating($user->getId(), $productId)): ?>

    <form method="POST" action="<?php action('addRating', array('productId' => $product->getId(), 'userId' => $user->getId())); ?>" role="form">
        <div class="row">
            <div class="form-group">
                <label for="comment">Type in a comment and rate the product...</label>
                <textarea  name="comment" type="text" class="form-control input-lg" id="comment" rows="3"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label for="rate">Rating</label>
                <!--<input name="rank" id="rate" class="rating form-control input-lg" data-min="1" data-max="5" data-step="1"> -->
                <select class="form-control" id="rate" name="rank">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
        </div>
        <div class="row">
            <button type="submit" class="btn btn-default">Submit Rating</button>
        </div>
    </form>

<?php endif; ?>

<?php require 'inc/footer.php';