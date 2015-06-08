<?php
require_once 'code/ShoppingCart.php';
?>

<table>
  <tr>
    <th>Title</th>
    <th>Author</th>
    <th>Price</th>
  </tr>
  
  <?php foreach ($books as $book) { 
  $inCart = ShoppingCart::contains($book->getId());
  	?>
  <tr <?php if ($inCart) {?>class="inCart" <?php } ?>>
    <td><?php echo escape($book->getTitle()); ?></td>
    <td><?php echo escape($book->getAuthor()); ?></td>
    <td><?php echo escape($book->getPrice()); ?></td>
    <td>
    	<?php if ($inCart): ?>
    		<form method="POST" action="<?php action('removeFromCart', array('bookId' => $book->getId())); ?>">
    			<input type="submit" value="remove from cart" />
    		</form>
    	<?php else: ?>
    		<form method="POST" action="<?php action('addToCart', array('bookId' => $book->getId())); ?>">
    			<input type="submit" value="add to cart" />
    		</form>
    	<?php endif; ?>
    </td>
  </tr>
  <?php } ?>
</table>