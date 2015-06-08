<?php
require_once 'code/DataManager.php';
require_once 'code/Util.php';

$categories = DataManager::getCategories();
$categoryId = isset($_REQUEST['categoryId']) ? $_REQUEST['categoryId'] : null;
$books = isset($categoryId) ? DataManager::getBooksForCategory($categoryId) : null;
?>

<?php require 'inc/header.php'; ?>

    <h2>List of Books</h2>

    <h3>Categories</h3>
<?php foreach ($categories as $cat) { ?>
    <span class="category"><a
            href="list.php?categoryId=<?php echo rawurlencode($cat->getId()); ?>"><?php echo $cat->getName(); ?></a></span>
<?php } ?>

<?php if (isset($books)): ?>
    <h3>Books in selected category: </h3>

    <?php if (sizeof($books) > 0) {
        require 'inc/booklist.php';
    } else { ?>
        <p>No books in this category.</p>
    <?php } ?>

<?php else: ?>
    <p>No category selected.</p>
<?php endif; ?>

<?php require 'inc/footer.php';