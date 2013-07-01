<?php
/**
 * Sample template for displaying single speaker posts.
 * Save this file as as single-speaker.php in your current theme.
 *
 * This sample code was based off of the Starkers Baseline theme: http://starkerstheme.com/
 */

get_header('speaker'); ?>
<div class="holder_content">
    <?php
    get_sidebar('speaker-left');
    ?>

    <div class="separate"></div>
    <section class="group-content-speaker">
        <?php if ( have_posts() ) : while (have_posts()) : the_post(); ?>
        <?php get_template_part( 'content', 'single' ); ?>
        <?php
    endwhile; endif;
        //Reset Query
        wp_reset_query();
        ?>
    </section>
</div>
<?php get_footer(); ?>