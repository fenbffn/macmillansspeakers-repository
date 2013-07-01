<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ric
 * Date: 8/02/13
 * Time: 16:26
 * To change this template use File | Settings | File Templates.
 */
?>


<div id="post-<?php the_ID(); ?>" class='blog'>
    <?php the_content(); ?>
    <?php
    $posts =  get_posts("post_type=post&post_status=publish&numberposts=-1&orderby=title&order=asc&suppress_filters=false");
    foreach($posts as $post):
        echo '<h3>'.get_the_title().'</h3>';
        if ( has_post_thumbnail() ) {
            echo get_the_post_thumbnail( $postId, array( 210, 100 ) ) . '<br/>';
        } else {
            echo '<img style="border:1px solid #adadad;padding:2px" width="210" height="100" alt="7337178" class="attachment-100x250 wp-post-image" src="'.esc_url( home_url( '/' ) ).'wp-content/uploads/2013/02/no-image.png">';
        }
        echo '<p>'.substr(strip_tags($post->post_content),0,200).'</p><br/>';
        echo '<a class="readmore-tabbs" href="'.get_permalink().'">read more</a>';
    endforeach; wp_reset_query();
    ?>
</div>