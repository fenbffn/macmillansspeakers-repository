
<?php /* Template Name: Page Alphabetic speakers */ ?>
<?php

define('WP_USE_THEMES', false);
require('wp-blog-header.php');

get_header('alphabethic');
?>
<div class="holder_content">
    <?php
    get_sidebar('left');
    $search = $_GET['search'];
    //$posts = get_posts("post_type=speaker&post_status=publish&numberposts=-1&orderby=title&order=ASC&suppress_filters=false");
    $posts = get_posts(array(
		"post_type" => "speaker",
		"post_status" => "publish",
		"numberposts" => -1,
		"orderby" => "title",
		"order" => "ASC",
		"suppress_filters" => false

	));
    ?>

    <div class="separate"></div>
    <section class="group-content">
        <?php foreach($posts as $post): ?>
        <?php
        $this_letter = strtoupper(substr($post->post_title,0,1));
        if($this_letter == $search && isset($search)) {
            get_template_part( 'content', 'speaker' );
        }else {
            if($this_letter == 'A' && !isset($search))
                get_template_part( 'content', 'speaker' );
        ?>
        <?php
        } endforeach; wp_reset_query();
        ?>
    </section>


</div>
<?php get_footer(); ?>
