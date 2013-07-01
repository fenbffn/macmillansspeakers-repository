<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ric
 * Date: 8/02/13
 * Time: 16:26
 * To change this template use File | Settings | File Templates.
 */
?>


<div id="post-<?php the_ID(); ?>" class="post_topic">
    <?php
        if ( has_post_thumbnail() ) {
//            $url = wp_get_attachment_url( get_post_thumbnail_id($postId) );
            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($postId),'medium');
//            echo get_the_post_thumbnail( $postId, array( 100, 250 ) ) . '<br/>';
            echo '<a href="'.get_permalink().'"><img width="100" height="150" alt="7337178" class="attachment-100x250 wp-post-image" src="'.$thumb['0'].'"></a>';
        } else {
            echo '<a href="'.get_permalink().'"><img style="border:1px solid #adadad;padding:2px" width="90" height="100" alt="7337178" class="attachment-100x250 wp-post-image" src="'.esc_url( home_url( '/' ) ).'wp-content/uploads/2013/02/no-image.png"></a>';
        }
        remove_filter('the_title','wptitle2_the_title',999);
        echo '<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
        add_filter('the_title','wptitle2_the_title',999);
        echo '<p>'.substr(strip_tags(get_the_title()),0,50).'</p><br/>';
//        echo '<p>'.substr(strip_tags(get_the_content()),0,50).'</p><br/>';
        echo '<a class="readmore-tabbs" href="'.get_permalink().'">read more</a>';
    ?>
</div>