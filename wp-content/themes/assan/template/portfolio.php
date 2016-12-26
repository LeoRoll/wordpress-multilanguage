<?php
//Template Name: 行业解决方案
get_header();
global $post;
?>

<div class="breadcrumb-wrap">
    <div class="container">
        <h3><?php the_title(); ?></h3>
        <ol class="breadcrumb">
            <?php the_breadcrumb(); ?>
        </ol>
    </div>
</div>
<div class="divide30"></div>
<div class="container">
    <?php
    if (have_posts()): while (have_posts()):the_post();
        ?>
        <div class="row">
            <div class="project-detail">
                <?php
                the_content();
                ?>
            </div>
        </div>
        <?php
        endwhile;
    endif;
    ?>
</div>
<div class="divide30"></div>
<?php get_footer(); ?>
