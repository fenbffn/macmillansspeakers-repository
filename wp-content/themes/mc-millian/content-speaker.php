<div id="post-<?php the_ID(); ?>" class="post_topic">
    <?php
    if ( has_post_thumbnail() ) {
        echo get_the_post_thumbnail( $postId, array( 100, 250 ) ) . '<br/>';
    } else {
        echo '<img style="border:1px solid #adadad;padding:2px" width="100" height="100" alt="7337178" class="attachment-100x250 wp-post-image" src="'.esc_url( home_url( '/' ) ).'wp-content/uploads/2013/02/no-image.png">';
    }
    remove_filter('the_title','wptitle2_the_title',999);
    echo '<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
    echo '<p>'.substr(strip_tags($post->post_content),0,50).'</p><br/>';
    echo '<a class="readmore-tabbs" href="'.get_permalink().'">read more</a>';
    ?>
</div>