
<?php /* Template Name: Page clean */ ?>
<?php

define('WP_USE_THEMES', false);
require('wp-blog-header.php');
?>
<div id="contact_form_pop">
    <?php if ( have_posts() ) : while (have_posts()) : the_post(); ?>
    <?php the_content(); ?>
    <?php
endwhile; endif;
    //Reset Query
    wp_reset_query();
    ?>
</div>
