<?php
global $ctassan_data;
$footer_layout = $ctassan_data['footer_layout'];
$footer_skin = $ctassan_data['footer_skin'];
$columns_class = array(3 => "col-md-4", 4 => "col-md-3", 2 => "col-md-6");
?>
<?php if ($footer_skin == 'light'):
    ?>
    <footer class="footer-light-1">
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
        </div>
        <div class="footer-copyright text-center"><?php echo $ctassan_data['footer_copy_write']; ?></div>
    </footer>
<?php else: ?>
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
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="footer-btm">
                    <span><?php echo $ctassan_data['footer_copy_write']; ?></span>
                </div>
            </div>
        </div>
    </footer>
<?php endif; ?>
<div id="back-to-top">
    <a href="javascript:void();"><i class="fa fa-angle-up"></i></a>
</div>
<?php wp_footer(); ?>
</div>
</body>
</html>
