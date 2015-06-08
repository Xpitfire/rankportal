<?php 
require_once 'code/DataManager.php';
require_once 'code/Util.php';

$title = isset($_REQUEST['title']) ? $_REQUEST['title'] : null;
$skip = isset($_REQUEST['skip']) ? $_REQUEST['skip'] : 0;
$take = isset($_REQUEST['take']) ? $_REQUEST['take'] : 4;

$page = isset($title) ? DataManager::getBooksForSearchCriteriaWithPaging($title, $skip, $take) : null;
?>

<?php require 'inc/header.php'; ?>

<h2>Search</h2>

<form>
	<table>
		<tr>
			<th>Title</th>
			<td><input name="title" value="<?php echo htmlentities($title); ?>" /></td>
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
$books = $page->getResult();
require 'inc/booklist.php';
?>

<p>
<?php 
$p = 0;
$i = 0;
while ($i < $page->getTotalCount()) { ?>
	<a href="?title=<?php echo rawurlencode($title); ?>&skip=<?php echo rawurlencode($i); ?>&take=<?php echo rawurlencode($take); ?>"><?php echo escape(++$p); ?></a>
<?php 
	$i += $take;
} ?>
</p>

<?php } else { ?>
<p>No matching books found.</p>
<?php } ?>

<?php endif; ?>

<?php require 'inc/footer.php';