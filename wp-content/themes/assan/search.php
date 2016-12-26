<?php
/**
 * The template for displaying search results pages.
 *
 */
get_header();
?>
<div class="breadcrumb-wrap">
    <div class="container">
        <h3><?php printf(__('Search Results for: %s', 'assan'), get_search_query()); ?></h3>
        <ol class="breadcrumb">
            <?php the_breadcrumb(); ?>
        </ol>
    </div>
</div>
<!-- <div class="search-area">
    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <?php get_search_form();?>
            </div>
        </div>
    </div>
</div> -->
<div class="divide40"></div>
<div class="container">
    <div class="row">
        <div class="col-sm-3">
            <?php get_sidebar(); ?>
        </div>
        <div class="col-sm-9">
            <?php if (have_posts()) : ?>
                <?php
                // Start the loop.
                while (have_posts()) : the_post();

                    get_template_part('content', 'search');

                // End the loop.
                endwhile;

            // If no content, include the "No posts found" template.
            else :
                get_template_part('content', 'none');
            endif;
            ?>
            <?php assan_page_navi(); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
