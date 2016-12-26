<?php
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
            $cats = wp_get_object_terms($post->ID, 'portfolio_category');
            $cat_name = '';
            $i = 1;
            $catcount = count($cats);
            if ($cats) {
                foreach ($cats as $cat) {
                    if ($i != $catcount) {
                        $cat_name .= $cat->name . " / ";
                    } else {
                        $cat_name .= $cat->name . "";
                    }
                    $i++;
                }
            }
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
