<?php
/**
 * The template for displaying all pages.
 */

get_header('topics'); ?>
<div class="holder_content">
    <?php
    get_sidebar('left');

    $term =	$wp_query->queried_object;
//    print_r($term->count);
//    echo $term->name;
    $cant = 12;

    $pages = round($term->count / $cant);
    if (!isset($_GET['page']) || $_GET['page'] == '0' || $_GET['page'] == '1'){
         $offset = 0;
         $page = 2;
    } else {
        $page = ($_GET['page'])-1;
        $offset = ($page*$cant) + 1;
        $page = ($page)+2;
    }
    $args = array(
        'post_type' => 'speaker',
        "topics" => $term->slug,
        'post_status' => 'publish',
        'posts_per_page' => 12,
        'order' => 'asc',
        'orderby' => 'title',
        'caller_get_posts'=> 1,
        'offset' => $offset
    );

    $wp_query = null;
    $wp_query = new WP_Query($args);

    ?>

    <div class="separate"></div>
    <section class="group-content">
        <div class="pagination">
        <?php if (!isset($_GET['page']) || $_GET['page'] == '0' || $_GET['page'] == '1'){?>
            <p>
                DISPLAYING<span><?php echo ' 1'.'-'.$cant ?></span> OF <span><?php echo $term->count ?></span>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>topics/<?php echo $term->slug; ?>/?page=<?php echo $page ?>"><img src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/uploads/2013/02/next.png" alt=""></a>
            </p>
        <?php } else {?>
            <?php $cant_post =  $wp_query->post_count;?>
            <p><a href="<?php echo esc_url( home_url( '/' ) ); ?>topics/<?php echo $term->slug; ?>/?page=<?php echo $page-2 ?>"><img src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/uploads/2013/02/before.png" alt="" /></a>
                DISPLAYING<span><?php echo ' '.$offset.'-'.(($cant_post+$offset)) ?></span> OF <span><?php echo $term->count ?></span>
                <?php if(($cant_post+$offset) < $term->count): ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>topics/<?php echo $term->slug; ?>/?page=<?php echo $page ?>"><img src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/uploads/2013/02/next.png" alt="" /></a>
                    <?php endif; ?>
            </p>
        <?php } ?>
        </div>
        <?php

            if ($wp_query->have_posts() ) : while ($wp_query->have_posts()) : $wp_query->the_post();
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
