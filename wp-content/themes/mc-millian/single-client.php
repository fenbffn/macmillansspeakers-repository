<?php
/**
 * Sample template for displaying single speaker posts.
 * Save this file as as single-speaker.php in your current theme.
 *
 * This sample code was based off of the Starkers Baseline theme: http://starkerstheme.com/
 */

get_header(); ?>
<div class="holder_content">
    <?php
    get_sidebar('left');
    ?>

    <div class="separate"></div>
    <section class="group-content-speaker">
        <?php if ( have_posts() ) : while (have_posts()) : the_post(); ?>
        <div id="post-<?php the_ID(); ?>" class="post_topic">
       <?php
        if ( has_post_thumbnail() ) {
            echo get_the_post_thumbnail( $postId, array( 100, 250 ) ) . '<br/>';
        } else {
            echo '<img style="border:1px solid #adadad;padding:2px" width="100" height="100" alt="7337178" class="attachment-100x250 wp-post-image" src="'.esc_url( home_url( '/' ) ).'wp-content/uploads/2013/02/no-image.png">';
        }
        remove_filter('the_title','wptitle2_the_title',999);
        echo '<h3>'.get_the_title().'</h3>';
        echo '<p>'.substr(strip_tags(get_the_content()),0,50).'</p><br/>';
        ?>
        </div>
        <?php
    endwhile; endif;
        //Reset Query
        wp_reset_query();
        ?>
    </section>
</div>
<?php get_footer(); ?>