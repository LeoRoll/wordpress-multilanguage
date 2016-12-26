<?php
//Template Name: Comming Soon 1
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <?php
        global $ctassan_data;
        if ($ctassan_data['cs_launch_ate']):
            $cs_launch_ate = $ctassan_data['cs_launch_ate'];
        else:
            $cs_launch_ate = "2017/01/01";
        endif;
        ?>

        <div class="wrapper">
            <div class="coming-soon" style="background: url('<?php echo $ctassan_data['cs_header_bg_image']; ?>');background-size: cover;">
                <div class="overlay"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text-center">  
                            <div class="margin30 text-center">
                                <h2 class="title">
                                    <?php
                                    if ($ctassan_data['logo_image']):
                                        echo '<img src="' . $ctassan_data['logo_image'] . '" alt="' . $ctassan_data['logo_alt'] . '"/>';
                                    else:
                                        bloginfo('name');
                                    endif;
                                    ?>
                                </h2>
                            </div>
                            <h1><?php echo bloginfo('description'); ?></h1>
                            <div class="count-down-1" id="clock"></div>
                        </div>
                    </div>
                </div>
            </div><!--coming soon image-->
            <div class="divide60"></div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3 text-center">
                        <div class="soon-inner">
                            <h3>Our website is under construction</h3>
                            <p>WE'LL BE HERE SOON WITH OUR NEW AWESOME SITE, SUBSCRIBE TO BE NOTIFIED.</p>
                            <div class="subscribe-form  assan-newsletter">
                                <?php
                                if (function_exists('mc4wp_form')) {
                                    mc4wp_form();
                                }
                                ?>
                            </div>
                            <div class="divide70"></div>
                            <?php if ($ctassan_data['cs_facebook'] || $ctassan_data['cs_twitter'] || $ctassan_data['cs_google_plus'] || $ctassan_data['cs_linkedin'])  ?>
                            <div>
                                <?php if ($ctassan_data['cs_facebook']): ?>
                                    <a href="<?php echo $ctassan_data['cs_facebook']; ?>" class="social-icon si-dark si-facebook">
                                        <i class="fa fa-facebook"></i>
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if ($ctassan_data['cs_twitter']): ?>
                                    <a href="<?php echo $ctassan_data['cs_twitter']; ?>" class="social-icon si-dark si-twitter">
                                        <i class="fa fa-twitter"></i>
                                        <i class="fa fa-twitter"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if ($ctassan_data['cs_google_plus']): ?>
                                    <a href="<?php echo $ctassan_data['cs_google_plus']; ?>" class="social-icon si-dark si-google-plus">
                                        <i class="fa fa-google-plus"></i>
                                        <i class="fa fa-google-plus"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if ($ctassan_data['cs_linkedin']): ?>
                                    <a href="<?php echo $ctassan_data['cs_linkedin']; ?>" class="social-icon si-dark si-linkedin">
                                        <i class="fa fa-linkedin"></i>
                                        <i class="fa fa-linkedin"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divide20"></div>
                <div  class="text-center soon-copyright"><?php echo $ctassan_data['footer_copy_write']; ?></div>
            </div>
            <div class="divide30"></div>
            <?php wp_footer(); ?>
            <script type="text/javascript">
                jQuery(document).ready(function ($) {
                    $('#clock').countdown("<?php echo $cs_launch_ate; ?>", function (event) {
                        $(this).html(event.strftime('<div class="counts"><span>%w</span> <p>weeks</p></div> '
                                + '<div class="counts"><span>%d</span> <p>days</p></div> '
                                + '<div class="counts"><span>%H</span> <p>hr</p></div> '
                                + '<div class="counts"><span>%M</span> <p>min</p></div> '
                                + '<div class="counts"><span>%S</span> <p>sec</p></div>'));
                    });
                });
            </script>
        </div>
    </body>
</html>
