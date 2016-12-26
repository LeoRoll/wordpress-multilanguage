<?php
global $ctassan_data;
$footer_layout = $ctassan_data['footer_layout'];
$columns_class = array(3 => "col-md-4", 4 => "col-md-3", 2 => "col-md-6");
?>
<?php if (is_active_sidebar('shop-prefooter')): ?>
    <div class="shop-pre-footer">
        <div class="container">
            <div class="row">
                <?php dynamic_sidebar('shop-prefooter'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<footer id="footer">
    <div class="container">
        <div class="row">
            <?php
            for ($i = 1; $i <= $footer_layout; $i++) {
                $sidebar = 'footer-' . $i;
                ?>
                <div class="<?php echo $columns_class[$footer_layout] ?> col-sm-6 col-xs-12 margin30">
                    <?php dynamic_sidebar($sidebar); ?>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="footer-btm">
                    <span><?php echo $ctassan_data['footer_copy_write']; ?></span>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</div>
</body>
</html>