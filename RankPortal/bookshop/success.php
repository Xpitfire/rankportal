<?php
require_once 'code/Util.php';

$orderId = isset($_REQUEST['orderId']) ? $_REQUEST['orderId'] : null;

require 'inc/header.php'; ?>

<h2>Success</h2>

<?php if ($orderId != null) { ?>
<p>Thank you for your purchase.</p>

<p>Your order number is <?php echo escape($orderId)?>.</p>

<?php } ?>

<?php /*  */ ?>

<?php
require 'inc/footer.php';