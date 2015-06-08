<?php 
require_once 'code/Util.php';
?>

<?php if (isset($errors) && is_array($errors)): ?>
<div class="errors">
	<ul>
	<?php foreach($errors as $errMsg):?>
		<li><?php echo escape($errMsg);?>
	<?php endforeach;?>
	</ul>
</div>
<?php endif; ?>


<div class="footer">
<p>
<?php echo strftime("%c"); ?>
</p>
</div>
</body>
</html>