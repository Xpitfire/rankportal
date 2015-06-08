<?php
require_once 'code/Util.php';
require_once 'code/ShoppingCart.php';
require_once 'code/AuthenticationManager.php';

$cartSize = ShoppingCart::size();

require 'inc/header.php'; ?>

    <h2>Checkout</h2>
    <p> You have <?php echo escape($cartSize) ?> items in your shopping cart.</p>

<?php if (AuthenticationManager::isAuthenticated()): ?>
    <?php if ($cartSize > 0): ?>

        <form method="POST" action="<?php action('placeOrder') ?>">
            <table>
                <tr>
                    <th>Name on card:</th>
                    <td><input name="nameOnCard"/></td>
                </tr>
                <tr>
                    <th>Card number:</th>
                    <td><input name="cardNumber"></td>
                </tr>
            </table>
            <input type="submit" value="place order"/>
        </form>

    <?php else: ?>
        <p>Please add some items to your cart.</p>
    <?php endif; ?>
<?php else: ?>
    <p>Please log in to place your order.</p>
<?php endif; ?>

<?php
require 'inc/footer.php';