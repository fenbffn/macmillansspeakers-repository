<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ric
 * Date: 21/01/13
 * Time: 12:37
 * To change this template use File | Settings | File Templates.
 */
function mcmillain_widgets_init() {
    // Area 1, located at the top of the sidebar.
    register_sidebar( array(
        'name' => __( 'Header Area', 'mcmillian' ),
        'id' => 'header-widget-area',
        'description' => __( 'The header area', 'mcmillian' ),
        'before_widget' => '',
        'after_widget' => '',
    ) );

    // Area 2, located below the Primary Widget Area in the sidebar. Empty by default.
    register_sidebar( array(
        'name' => __( 'Sidebar Left', 'mcmillian' ),
        'id' => 'sidebar-left-widget-area',
        'description' => __( 'The Sidebar Left Area', 'mcmillian' ),
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

    // Area 3, located in the footer. Empty by default.
    register_sidebar( array(
        'name' => __( 'Sidebar Right', 'mcmillian' ),
        'id' => 'sidebar-right-widget-area',
        'description' => __( 'The Sidebar Right Area', 'mcmillian' ),
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

    // Area 4, located in the footer. Empty by default.
    register_sidebar( array(
        'name' => __( 'Home Tabs Area', 'mcmillian' ),
        'id' => 'home-tabs-widget-area',
        'description' => __( 'The Content Home Tabs', 'mcmillian' ),
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
    // Area 4, located in the footer. Empty by default.
    register_sidebar( array(
        'name' => __( 'Pre Footer', 'mcmillian' ),
        'id' => 'pre-footer-area-widget-area',
        'description' => __( 'Pre  Footer area', 'mcmillian' ),
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
    // Area 4, located in the footer. Empty by default.
    register_sidebar( array(
        'name' => __( 'Footer Area', 'mcmillian' ),
        'id' => 'footer-area-widget-area',
        'description' => __( 'The Footer area', 'mcmillian' ),
        'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
}
/** Register sidebars by running twentyten_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'mcmillain_widgets_init' );

/* widgets aplication*/
class hot_topics_widget extends WP_Widget {

    function hot_topics_widget() {
        //Load Language
        load_plugin_textdomain( 'hot_topics_widget', false, dirname( plugin_basename( __FILE__ ) ) .  '/lang' );
        $widget_ops = array( 'description' => __( 'Shows hot topics' ) );
        //Create widget
        $this->WP_Widget( 'hottopicswidget', __( 'Hot Topics', 'hot_topics_widget' ), $widget_ops );

    }

    function widget( $args, $instance ) {
//        wp_enqueue_style( 'myprefix-style', plugins_url('mystyle.css', __FILE__) );
//        addFrontendCss();
        extract( $args, EXTR_SKIP );
        echo "<div class='clear'></div>";
        echo $before_widget;
        $title = empty( $instance[ 'title' ] ) ? '' : apply_filters( 'widget_title', $instance[ 'title' ] );
        $parameters = array(
            'title' 	=> $title,
        );

        if ( !empty( $title ) &&  !empty( $link ) ) {
            echo $before_title . '<a href="' . $link . '">' .'<span class="topic_header_bkg"></span>'. $title . '</a>' . $after_title;
        }
        else if ( !empty( $title ) ) {
            echo $before_title . '<span class="topic_header_bkg">'. $title . '</span>' . $after_title;
        }
        $taxonomy     = 'topics';
        $orderby      = 'count';
        $show_count   = 0;      // 1 for yes, 0 for no
        $pad_counts   = 0;      // 1 for yes, 0 for no
        $hierarchical = 1;      // 1 for yes, 0 for no
        $title        = '';
        $number       = 4;
        $args = array(
            'taxonomy'     => $taxonomy,
            'orderby'      => $orderby,
            'order'         => 'DESC',
            'show_count'   => $show_count,
            'pad_counts'   => $pad_counts,
            'hierarchical' => $hierarchical,
            'title_li'     => $title,
//            'style'        => 'none',
            'number'      => $number
        );
        echo "<ul class='topics'>";
        wp_list_categories( $args );
        echo "</ul>";
        echo "<div class='about-us-button'><a href='".esc_url( home_url( '/' ))."about-us/'>ABOUT US</a></div>";
        echo $after_widget;
        echo "<div class='clear'></div>";

    }

    function update($new_instance, $old_instance) {

        $instance = $old_instance;
        $instance['title'] = esc_attr($new_instance['title']);
        return $instance;

    }

    function form($instance) {

        $title 		= esc_attr($instance['title']);
        ?>
    <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' );?>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </label>
    </p>
    <?php
    } //end of form
}

add_action( 'widgets_init', create_function('', 'return register_widget("hot_topics_widget");') );

class wp_widget_custom extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_search', 'description' => __( "A search form for speaker") );
        parent::__construct('search', __('Search Speaker'), $widget_ops);
    }

 function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

        echo $before_widget;
        if ($title)
            echo $before_title . '<span class="search_header_bkg">' . $title . '</span>' . $after_title;

        // Use current theme search form if it exists
        $this->get_search_form_custom();
        ?>
        <div class="button_advanced_search">
            <a href="#" class="big-link" data-reveal-id="topics" data-animation="fade">
                <span class="left_button_advanced"></span>
                <span class="center_button_advanced">By Topic</span>
                <span class="right_button_advanced"></span>
            </a>
        </div>
        <div class="button_advanced_search">
            <a href="#" class="big-link" data-reveal-id="speakers" data-animation="fade">
                <span class="left_button_advanced"></span>
                <span class="center_button_advanced">By Name</span>
                <span class="right_button_advanced"></span>
            </a>
        </div>
        <div class="button_advanced_search">
            <a href="#" class="big-link" data-reveal-id="travels" data-animation="fade">
                <span class="left_button_advanced"></span>
                <span class="center_button_advanced">Travels From</span>
                <span class="right_button_advanced"></span>
            </a>
        </div>
        <div id="topics" class="reveal-modal safaritopic" style="display: none;margin-left: 50% !important;margin-top: 35%; overflow: hidden;position: absolute;">
            <?php
            $terms = get_terms("topics");
            $count = count($terms);

            if ($count > 0) {
                $contador = 0;
                $columna = 0;
                $topic_each_col = round($count / 3) + 1;
                echo "<ul class='col3'>";

                foreach ($terms as $term) {
                    if (++$contador < $topic_each_col) {
                         echo "<li>" . '<a href="' . network_site_url('/') . 'topics/' . $term->slug . '" title="' .  sprintf(__('View all post field under %s', 'my_localization_domain'), $term->name) . '">' . $term->name . "</a></li>";
                    } else {
                        echo "</ul>";
                        $contador = 0;

                        if (++$columna < 3) {
                            echo "<ul class='col3'>";
                        } else {
                            echo "</ul>";
						}
                    }
                }
            }
            ?>
        </div>
        <div id="speakers" class="reveal-modal reveal-modal-speaker safaritopic" style="display: none;margin-left: 0px !important;margin-top: -200px !important; overflow: hidden;position: absolute;">
            <?php
            $speakers = get_posts("post_type=speaker&post_status=publish&numberposts=-1&orderby=title&order=asc&suppress_filters=false");

            $count = count($speakers);

            if ($count > 0) {
                $speaker_each_col = round($count / 5) + 1;
                echo "<a href='" . network_site_url('/') . 'speakers' . "'>Browse all</a><br/>";
                $offset = 0;
                $speaker_col1 = get_posts("post_type=speaker&post_status=publish&offset=" . $offset . "&numberposts=" . $speaker_each_col . "&orderby=title&order=asc&suppress_filters=false");
                echo "<ul class='col'>";
                foreach ($speaker_col1 as $speaker) {
                    echo "<li>" . '<a href="' . get_permalink($speaker->ID) . '" title="' . sprintf(__('View all speaker field under %s', 'my_localization_domain'), $speaker->post_title) . '">' . $speaker->post_title . "</a></li>";
                }
                echo "</ul>";
                $offset = $offset + $speaker_each_col;
                $speaker_col2 = get_posts("post_type=speaker&post_status=publish&offset=" . $offset . "&numberposts=" . $speaker_each_col . "&orderby=title&order=asc&suppress_filters=false");
                echo "<ul class='col'>";
                foreach ($speaker_col2 as $speaker) {
                    echo "<li>" . '<a href="' . get_permalink($speaker->ID) . '" title="' . sprintf(__('View all speaker field under %s', 'my_localization_domain'), $speaker->post_title) . '">' . $speaker->post_title . "</a></li>";
                }
                echo "</ul>";
                $offset = $offset + $speaker_each_col;
                $speaker_col3 = get_posts("post_type=speaker&post_status=publish&offset=" . $offset . "&numberposts=" . $speaker_each_col . "&orderby=title&order=asc&suppress_filters=false");
                echo "<ul class='col'>";
                foreach ($speaker_col3 as $speaker) {
                    echo "<li>" . '<a href="' . get_permalink($speaker->ID) . '" title="' . sprintf(__('View all speaker field under %s', 'my_localization_domain'), $speaker->post_title) . '">' . $speaker->post_title . "</a></li>";
                }
                echo "</ul>";
                $offset = $offset + $speaker_each_col;
                $speaker_col4 = get_posts("post_type=speaker&post_status=publish&offset=" . $offset . "&numberposts=" . $speaker_each_col . "&orderby=title&order=asc&suppress_filters=false");
                echo "<ul class='col'>";
                foreach ($speaker_col4 as $speaker) {
                    echo "<li>" . '<a href="' . get_permalink($speaker->ID) . '" title="' . sprintf(__('View all speaker field under %s', 'my_localization_domain'), $speaker->post_title) . '">' . $speaker->post_title . "</a></li>";
                }
                echo "</ul>";
                $offset = $offset + $speaker_each_col;
                $speaker_col5 = get_posts("post_type=speaker&post_status=publish&offset=" . $offset . "&numberposts=" . $speaker_each_col . "&orderby=title&order=asc&suppress_filters=false");
                echo "<ul class='col'>";
                foreach ($speaker_col5 as $speaker) {
                    echo "<li>" . '<a href="' . get_permalink($speaker->ID) . '" title="' . sprintf(__('View all speaker field under %s', 'my_localization_domain'), $speaker->post_title) . '">' . $speaker->post_title . "</a></li>";
                }
                echo "</ul>";
            }
            ?>
        </div>
        <div id="travels" class="reveal-modal safaritopic" style="display: none;margin-left: 50% !important;margin-top: 35%; overflow: hidden;position: absolute;">
            <?php
            $terms = get_terms("travels");
            $count = count($terms);

            if ($count > 0) {
                $contador = 0;
                $columna = 0;
                $topic_each_col = round($count / 3) + 1;
                echo "<ul class='col3'>";

                foreach ($terms as $term)  {
                    if (++$contador < $topic_each_col) {
                         echo "<li>" . '<a href="' . network_site_url('/') . 'travels/' . $term->slug . '" title="' .  sprintf(__('View all post field under %s', 'my_localization_domain'), $term->name) . '">' . $term->name . "</a></li>";
                    } else {
                        //echo "Fin de columna" ;
                        echo "</ul>";
                        $contador = 0;

                        if (++$columna < 3) {
                            echo "<ul class='col3'>";
                        } else {
                            echo "</ul>";
						}
                    }
                }
            }
            ?>
        </div>
        <?php
        echo $after_widget;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '') );
        $title = $instance['title'];
        ?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
    <?php
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $new_instance = wp_parse_args((array) $new_instance, array( 'title' => ''));
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }
    function get_search_form_custom($echo = true) {
        do_action( 'get_search_form' );

        $search_form_template = locate_template('searchform.php');
        if ( '' != $search_form_template ) {
            require($search_form_template);
            return;
        }

        $form = '<form role="search" method="get" id="searchform" action="' . esc_url( home_url( '/' ) ) . '" >
	<div><label class="screen-reader-text" for="s">' . __('Search for:') . '</label>
	<input class="input_search" placeholder="by Name, Topic, Location" type="text" value="' . get_search_query() . '" name="s" id="s" />
	<input class="submit_rigth" type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
	</div>
	</form>';

        if ( $echo )
            echo apply_filters('get_search_form', $form);
        else
            return apply_filters('get_search_form', $form);
    }

}
add_action( 'widgets_init', create_function('', 'return register_widget("wp_widget_custom");') );


/**
 * Recent Videos Youtube widget class
 *
 */
class WP_Widget_Recent_Videos_Youtube extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_recent_videos', 'description' => __( "The most recent videos on your site") );
        parent::__construct('recent-posts', __('Recent Videos Youtube'), $widget_ops);
        $this->alt_option_name = 'widget_recent_videos';

        add_action( 'save_post', array($this, 'flush_widget_cache') );
        add_action( 'deleted_post', array($this, 'flush_widget_cache') );
        add_action( 'switch_theme', array($this, 'flush_widget_cache') );
    }

    function widget($args, $instance) {
        $cache = wp_cache_get('widget_recent_videos', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = $this->id;

        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo $cache[ $args['widget_id'] ];
            return;
        }

        ob_start();
        extract($args);

        $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Videos') : $instance['title'], $instance, $this->id_base);
        if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
            $number = 10;
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
        $r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ,'post_type'=>'jf_yfvp_youtube') ) );
        if ($r->have_posts()) :
            ?>
        <?php echo $before_widget; ?>
        <?php if ( $title ) echo $before_title . $title . $after_title; ?>
        <div class="videos"><h3>RECENT VIDEOS</h3>
            <ul class="list-videos">
                <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                <li style='background: url("<?php echo esc_url( home_url( '/' ) ); ?>wp-content/uploads/2013/06/play.png") no-repeat scroll 43px 30px transparent;'>
                    <?php
                    $url = get_the_content();
                    parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
                    $img_thumb = "i3.ytimg.com/vi/{$my_array_of_vars['v']}/default.jpg";
                    echo "<a class='fancybox iframe' href='http://www.youtube.com/embed/{$my_array_of_vars['v']}'><img src='http://{$img_thumb}' width='100' height='100' alt='' /></a>";
                    ?><br/>
                    <a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a>
                    <?php if ( $show_date ) : ?>
                    <span class="post-date"><?php echo get_the_date(); ?></span>
                    <?php endif; ?>
                </li>
                <?php endwhile; ?>
            </ul>
        </div><br/>
        <a href="http://www.youtube.com/user/macmillanspeakers" class="readmore-tabbs">see more</a>
        <?php echo $after_widget; ?>
        <?php
            // Reset the global $the_post as this query will have stomped on it
            wp_reset_postdata();

        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_recent_videos', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['show_date'] = (bool) $new_instance['show_date'];
        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_recent_videos']) )
            delete_option('widget_recent_videos');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('widget_recent_videos', 'widget');
    }

    function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
        ?>
    <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

    <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
        <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

    <p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>
    <?php
    }
}
add_action( 'widgets_init', create_function('', 'return register_widget("WP_Widget_Recent_Videos_Youtube");') );