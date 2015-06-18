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

    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="text-muted">
            <?php echo strftime("%c"); ?> - &copy; CopyRight 2015 Dinu Marius-Constantin
        </p>
    </div>
</footer>

<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</body>
</html>