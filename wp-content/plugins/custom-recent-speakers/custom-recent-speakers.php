<?php
/*
Plugin Name: Custom Recent Speakers
Plugin URI: http://richtech.com
Description: Display most recent posts from speakers.
Version: 1.0
Author: Richard Cruz
Author URI: http://richtech.com
*/

include_once('includes/custom_recent_speakers-display.php');

class custom_recent_speakers extends WP_Widget {

	function custom_recent_speakers() {
		//Load Language
		load_plugin_textdomain( 'custom-recent-speakers', false, dirname( plugin_basename( __FILE__ ) ) .  '/lang' );
		$widget_ops = array( 'description' => __( 'Shows most recent posts. You can customize it easily.', 'custom-recent-speakers' ) );
		//Create widget
		$this->WP_Widget( 'customrecentspeakers', __( 'Custom Recent Speakers', 'custom-recent-speakers' ), $widget_ops );
//        add_action( 'wp_print_scripts', 'addFrontendJavascript' );
//        add_action( 'wp_enqueue_scripts', 'addFrontendCss' );
	}

	function widget( $args, $instance ) {
//        wp_enqueue_style( 'myprefix-style', plugins_url('mystyle.css', __FILE__) );
//        addFrontendCss();
		extract( $args, EXTR_SKIP );
		echo $before_widget;
		$title = empty( $instance[ 'title' ] ) ? '' : apply_filters( 'widget_title', $instance[ 'title' ] );
		$link = empty( $instance[ 'link' ]) ? '' : $instance[ 'link' ];
		$parameters = array(
				'title' 	=> $title,
				'link' 		=> $instance[ 'link' ],
				'hideposttitle' => $instance[ 'hideposttitle' ],
				'show_type' => $instance[ 'show_type' ],
                'posts_speakers' => $instance['posts_speakers'],
				'shownum' 	=> (int) $instance[ 'shownum' ],
				'reverseorder' => (int) $instance[ 'reverseorder' ],
				'excerpt' 	=> (int) $instance[ 'excerpt' ],
				'excerptlengthwords' => (int) $instance[ 'excerptlengthwords' ],
			);

		if ( !empty( $title ) &&  !empty( $link ) ) {
				echo $before_title . '<a href="' . $link . '">' . $title . '</a>' . $after_title;
		}
		else if ( !empty( $title ) ) {
			 echo $before_title . $title . $after_title;
		}
        //print recent posts
		custom_recent_speakers($parameters);
		echo $after_widget;

  }

  function update($new_instance, $old_instance) {

		$instance = $old_instance;
		$instance['title'] = esc_attr($new_instance['title']);
		$instance['link'] = esc_attr($new_instance['link']);
		$instance['hideposttitle'] = $new_instance['hideposttitle'] ? 1 : 0;
		$instance['show_type'] = $new_instance['show_type'];
        $instance['posts_speakers'] = $new_instance['posts_speakers'];
		$instance['shownum'] = isset($new_instance['show-num']) ? (int) abs($new_instance['show-num']) : (int) abs($new_instance['shownum']);
		unset($instance['show-num']);

		$instance['postoffset'] = (int) abs($new_instance['postoffset']);
		$instance['reverseorder'] = $new_instance['reverseorder'] ? 1 : 0;

		$instance['excerpt'] = isset($new_instance['excerpt-length']) ? (int) abs($new_instance['excerpt-length']) : (int) abs($new_instance['excerpt']);
		unset($instance['excerpt-length']);

		$instance['excerptlengthwords'] = (int) abs($new_instance['excerptlengthwords']);
		return $instance;
 
	}

  function form($instance) {

		if (isset($instance['spot1'])) $instance['spot'] = $instance['spot1'];
		if (isset($instance['show-num'])) $instance['shownum'] = $instance['show-num'];
		if (isset($instance['excerpt-length'])) $instance['excerpt'] = $instance['excerpt-length'];
		if (isset($instance['cus-field'])) $instance['cusfield'] = $instance['cus-field'];

		$instance = wp_parse_args( (array) $instance, custom_recent_speakers_defaults() );
		
		$title 		= esc_attr($instance['title']);
		$link 		= esc_attr($instance['link']);
		$hideposttitle = $instance['hideposttitle'];
		$show_type 	= $instance['show_type'];
        $posts_speakers = $instance['posts_speakers'];
		$shownum 	= (int) $instance['shownum'];
		$postoffset	= (int) $instance['postoffset'];
		$reverseorder = $instance['reverseorder'];
		$excerpt = (int) $instance['excerpt'];
		$excerptlengthwords = (int) $instance['excerptlengthwords'];
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' );?> 
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Title Link:');?> 
				<input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo $link; ?>" />
			</label>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hideposttitle'); ?>" name="<?php echo $this->get_field_name('hideposttitle'); ?>"<?php checked( $hideposttitle ); ?> />
			<label for="<?php echo $this->get_field_id('hideposttitle'); ?>"><?php _e('Hide post title?', 'custom-recent-speakers');?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('show_type'); ?>"><?php _e('Show:');?> 
				<select class="widefat" id="<?php echo $this->get_field_id('show_type'); ?>" name="<?php echo $this->get_field_name('show_type'); ?>">
				<?php
					global $wp_post_types;
					foreach($wp_post_types as $k=>$pt) {
						if($pt->exclude_from_search) continue;
						echo '<option value="' . $k . '"' . selected($k,$show_type,true) . '>' . $pt->labels->name . '</option>';
					}
				?>
				</select>
			</label>
		</p>
  <p>
      <label for="<?php echo $this->get_field_id('posts_speakers'); ?>"><?php _e('Posts to show:');?>
          <input class="widefat" id="<?php echo $this->get_field_id('posts_speakers'); ?>" name="<?php echo $this->get_field_name('posts_speakers'); ?>" type="text" value="<?php echo $posts_speakers; ?>"/><br />
          <small><?php _e('(Post ID, separator with comma(1,5,8))','custom-recent-speakers'); ?></small>
      </label>
  </p>
		<p>
			<label for="<?php echo $this->get_field_id('shownum'); ?>"><?php _e('Number of posts to show:');?> 
				<input id="<?php echo $this->get_field_id('shownum'); ?>" name="<?php echo $this->get_field_name('shownum'); ?>" type="text" value="<?php echo $shownum; ?>" size ="3" /><br />
				<small><?php _e('(at most 20)','custom-recent-speakers'); ?></small>
			</label>
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('reverseorder'); ?>" name="<?php echo $this->get_field_name('reverseorder'); ?>"<?php checked( $reverseorder ); ?> />
			<label for="<?php echo $this->get_field_id('reverseorder'); ?>"><?php _e('Show posts in reverse order?', 'custom-recent-speakers');?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('excerpt-length'); ?>"><?php _e('Excerpt length (letters):', 'custom-recent-speakers');?> 
				<input id="<?php echo $this->get_field_id('excerpt-length'); ?>" name="<?php echo $this->get_field_name('excerpt-length'); ?>" type="text" value="<?php echo $excerpt; ?>" size ="3" /><br />
				<small>(<?php _e('0 - Don\'t show excerpt', 'custom-recent-speakers');?>)</small>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('excerptlengthwords'); ?>"><?php _e('Excerpt length (words):', 'custom-recent-speakers');?> 
				<input id="<?php echo $this->get_field_id('excerptlengthwords'); ?>" name="<?php echo $this->get_field_name('excerptlengthwords'); ?>" type="text" value="<?php echo $excerptlengthwords; ?>" size ="3" /><br />
				<small>(<?php _e('0 - Use letter-excerpt', 'custom-recent-speakers');?>)</small>
			</label>
		</p>
		<?php
	} //end of form
}

add_action( 'widgets_init', create_function('', 'return register_widget("custom_recent_speakers");') );

function custom_recent_speakers_defaults() {
$defaults = array( 	'title' => __( 'Recent Posts', 'custom_recent_speakers' ),
					'link' => get_bloginfo( 'url' ) . '/blog/',
					'hideposttitle' => 0,
					'show_type' => 'post', 
					'postoffset' => 0, 
					'limit' => 10, 
					'shownum' => 10, 
					'reverseorder' => 0, 
					'excerpt' => 0, 
					'excerptlengthwords' => 0);
	return $defaults;
}


function custom_recent_speakers($args = '', $echo = true) {
	global $wpdb;
	$defaults = custom_recent_speakers_defaults();
	//$defaults = array('separator' => ': ','show_type' => 'post', 'limit' => 10, 'excerpt' => 0, 'actcat' => 0, 'cats'=>'', 'cusfield' =>'', 'w' => 48, 'h' => 48, 'firstimage' => 0, 'showauthor' => 0, 'showtime' => 0, 'atimage' => 0, 'defimage' => '', 'format' => 'm/d/Y', 'spot' => 'spot1');

	$args = wp_parse_args( $args, $defaults );
	extract($args);

	$hideposttitle = (bool) $hideposttitle;

	$show_type = $show_type;

	$shownum = (int) abs($shownum);
	if(isset($limit) && $shownum == 10) $shownum = (int) $limit;


	$excerptlength = (int) abs($excerpt);
	$excerptlengthwords = (int) abs($excerptlengthwords);
	$excerpt = '';
    if(empty($posts_speakers) || ($_GET['speakers']=='new')) :
            if (($shownum < 1 ) || ($shownum > 20)) $shownum = 10;
                $query = "showposts=$shownum&post_type=$show_type&offset=$postoffset";
                $posts = get_posts($query); //get posts
                if ($reverseorder) $posts = array_reverse($posts);
                $postlist = '';

        echo '<ul class="speaker">';
        foreach($posts as $post_id) :
            $post = get_post($post_id);
            if ( has_post_thumbnail($post->ID)) {
                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'mini-thumbnail-gray' );
                $url = $thumb['0'];
                ?>
                    <li class="background-speaker" style="width:124px;height:136px; background: url('<?php echo $url; ?>');">
                        <a href="<?php echo get_permalink($post_id);?>" style="text-decoration: none;">
                            <div style="opacity: 0;" class="fdw-background">
                                <h5 style="font-weight: bold;"><?php echo strtoupper($post->post_title); ?></h5>
                                <?php if ($excerptlength) {
                                $excerpt = $post->post_excerpt;
                                $text = $post->post_content;
                                $text = strip_shortcodes( $text );
                                $text = str_replace(']]>', ']]&gt;', $text);
                                $text = strip_tags($text);
                                $excerpt_length = 10;
                                $words = explode(' ', $text, $excerpt_length + 1);
                                if ( '' == $excerpt ) {
                                    if (count($words) > $excerpt_length) {
                                        array_pop($words);
                                        $text = implode(' ', $words);
                                    }
                                    $excerpt = $text;
                                }
                            }
//                            print_r($post);
                                echo "<div class='excerpt'>".$excerpt."...</div><br/><a class='read-more' href='".get_permalink($post_id)."'>Read More</a>";
                                ?>
                            </div>
                        </a>
                <!--                    </li>-->
                <?php
                echo '</a></li>';
            }
        endforeach;
        echo "</ul>";

    else:
        $hideposttitle = (bool) $hideposttitle;
        $posts = explode(",",$posts_speakers);
        echo '<ul class="speaker">';
        foreach($posts as $post_id) :
            $post = get_post($post_id);
                if ( has_post_thumbnail($post->ID)) {
                    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'mini-thumbnail-gray' );
                    $url = $thumb['0'];
                    ?>
                    <li class="background-speaker" style="width:124px;height:136px; background: url('<?php echo $url; ?>');">
                        <a href="<?php echo get_permalink($post_id);?>" style="text-decoration: none;">
                        <div style="opacity: 0;" class="fdw-background">
                            <h5 style="font-weight: bold;"><?php echo strtoupper($post->post_title); ?></h5>
                            <?php if ($excerptlength) {
                                    $excerpt = $post->post_excerpt;
                                    $text = $post->post_content;
                                    $text = strip_shortcodes( $text );
                                    $text = str_replace(']]>', ']]&gt;', $text);
                                    $text = strip_tags($text);
                                    $excerpt_length = 10;
                                    $words = explode(' ', $text, $excerpt_length + 1);
                                    if ( '' == $excerpt ) {
                                        if (count($words) > $excerpt_length) {
                                            array_pop($words);
                                            $text = implode(' ', $words);
                                        }
                                        $excerpt = $text;
                                    }
                                 }
//                            print_r($post);
                            echo "<div class='excerpt'>".$excerpt."...</div><br/><a class='read-more' href='".get_permalink($post_id)."'>Read More</a>";
                        ?>
                        </div>
                        </a>
<!--                    </li>-->
                    <?php
                    echo '</a></li>';
                }
        endforeach;
        echo "</ul>";
    endif;
}
function addFrontendCss(){
    wp_enqueue_style('custom-recent-speakers', PLUGIN_PATH . 'css/custom-recent-speakers.css');
//    wp_enqueue_style('custom-recent-speakers');
}
function addFrontendJavascript(){
    wp_register_script('jq-hoverintent', PLUGIN_PATH . 'js/jquery.hoverintent.js', array('jquery'), '1.0',true);
    wp_enqueue_script('jq-hoverintent');
    wp_enqueue_script('jq-tools', PLUGIN_PATH . 'js/jquery.tools.js', array('jquery'),'1.0',true);
    wp_enqueue_script('erw-frontend-js', PLUGIN_PATH . 'js/widget-frontend.js', array('jquery', 'jq-hoverintent', 'jq-tools'),'1.0',true);

}

?>