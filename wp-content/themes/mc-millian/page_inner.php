
<?php /* Template Name: Page Sidebar Left */ ?>
<?php

define('WP_USE_THEMES', false);
require('wp-blog-header.php');

get_header();
?>
<div class="holder_content">
    <?php
    get_sidebar('left');
    ?>

    <div class="separate"></div>
    <section class="group-content">
        <?php if ( have_posts() ) : while (have_posts()) : the_post(); ?>
            <?php the_content(); ?>
        <?php
         endwhile; endif;
        //Reset Query
        wp_reset_query();
        ?>
    </section>


</div>
<?php get_footer(); ?>
