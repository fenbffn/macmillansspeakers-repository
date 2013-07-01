<?php
/**
 * The template for displaying all pages.
 */

get_header(); ?>
<div class="holder_content">
    <?php
    get_sidebar('left');
    ?>

    <div class="separate"></div>
    <section class="group-content">
        <?php

            if ( have_posts() ) : while (have_posts()) : the_post();
        ?>
        <?php get_template_part( 'content', 'archive' ); ?>
        <?php
    endwhile; endif;
        //Reset Query
        wp_reset_query();
        ?>
    </section>


</div>
<?php get_footer(); ?>
