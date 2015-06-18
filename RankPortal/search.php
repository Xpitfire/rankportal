<?php
require_once 'code/DataManager.php';
require_once 'code/Util.php';

$productName = isset($_REQUEST['productName']) ? $_REQUEST['productName'] : null;
$skip = isset($_REQUEST['skip']) ? $_REQUEST['skip'] : 0;
$take = isset($_REQUEST['take']) ? $_REQUEST['take'] : 4;

$page = isset($productName) ? DataManager::getProductsForSearchCriteriaWithPaging($productName, $skip, $take) : null;
?>

<?php require 'inc/header.php'; ?>

    <h2>Search</h2>

    <form>
        <table>
            <tr>
                <th>Product</th>
                <td><input name="productName" value="<?php echo htmlentities($productName); ?>" /></td>
            </tr>
        </table>
        <input type="submit" value="search" />
    </form>

<?php if (isset($page)): ?>
    <h3>Search Result</h3>

    <?php if (sizeof($page->getResult()) > 0) { ?>

        <p>
            Displaying result <?php echo escape($page->getPositionOfFirst()); ?> to <?php echo escape($page->getPositionOfLast()); ?> of <?php echo escape($page->getTotalCount()); ?>.
        </p>

        <?php
        $products = $page->getResult();
        require 'inc/list.php';
        ?>

        <p>
            <?php
            $p = 0;
            $i = 0;
            while ($i < $page->getTotalCount()) { ?>
                <a href="?productName=<?php echo rawurlencode($productName); ?>&skip=<?php echo rawurlencode($i); ?>&take=<?php echo rawurlencode($take); ?>"><?php echo escape(++$p); ?></a>
                <?php
                $i += $take;
            } ?>
        </p>

    <?php } else { ?>
        <p>No matching products found.</p>
    <?php } ?>

<?php endif; ?>

<?php require 'inc/footer.php';