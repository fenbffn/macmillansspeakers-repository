<?php

/*
	Plugin Name: WP Title 2
	Plugin URI: http://blog.ickata.net/wp-title-2/
	Description: Add custom Heading, different from the Title, used in page links. Compatible with qTranslate Plugin.
	Author: Hristo Chakarov
	Version: 3.6
	Author URI: http://blog.ickata.net/
*/

/*

    Copyright 2008 HRISTO CHAKAROV  (email : mail@ickata.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	
*/


// Insert Initial Data
register_activation_hook(__FILE__,'wptitle2_initial');
function wptitle2_initial(){
	// Add default options: WP Title 2 is enabled on Posts, HTML is filtered
	if (!get_option('wp_title_2')){
		$default = array(
			'posts' 					=> 'enabled',
			'html' 						=> 'disabled',
			'admin_show_default_title' 	=> 'disabled',
			'post_types_support'		=> 'disabled',
			'post_types'				=> array()
		);
		add_option('wp_title_2',$default);
	}
}

// Get Options
$wptitle2_options = get_option('wp_title_2');
	
// if qTranslate is not activated, get the WP language
if (!function_exists('qtrans_loadConfig')) {
	if (WPLANG!='') 
		$q_config['enabled_languages'][0] = substr(WPLANG,0,strpos(WPLANG,'_')); // get the WP language
	else 
		$q_config['enabled_languages'][0] = 'en'; // default: English
}

// Admin init functions
add_action('admin_init','wptitle2_admin_init');
function wptitle2_admin_init(){
	
	global $wptitle2_options;
	
	// Update Options handler
	if ($_POST['action']=='update_wp_title_2'){
		$wptitle2_options = array(
			'posts' 					=> (($_POST['posts']==true) ? 'enabled' : 'disabled'),
			'html' 						=> (($_POST['html']==true) ? 'enabled' : 'disabled'),
			'admin_show_default_title' 	=> (($_POST['admin_show_default_title']==true) ? 'enabled' : 'disabled'),
			'post_types_support'		=> (($_POST['post_types_support']==true and !empty($_POST['post_types'])) ? 'enabled' : 'disabled'),
			'post_types'				=> (!empty($_POST['post_types'])) ? array_flip($_POST['post_types']) : array()
		);
		if (!update_option('wp_title_2',$wptitle2_options))
			add_option('wp_title_2',$wptitle2_options);
		header("Location:{$_SERVER['HTTP_REFERER']}&message=1");
	}
	
	// Show original Titles in Post/Page tables in Admin when enabled (from options)
	if ($wptitle2_options['admin_show_default_title']=='enabled')
		remove_filter('the_title','wptitle2_the_title',999);
	
}

// Init Function
add_action('init','wptitle2_init');
function wptitle2_init(){
	global $q_config;
	
	// Localize
	load_plugin_textdomain('wp_title_2', PLUGINDIR.'/'.dirname(plugin_basename(__FILE__)).'/lang');
}

// Add the additional input field in New/Edit Post/Page form
add_action('edit_form_advanced', 'wptitle2_addTitleField');
add_action('simple_edit_form', 'wptitle2_addTitleField');
add_action('edit_page_form', 'wptitle2_addTitleField');
function wptitle2_addTitleField() {
	
	global $post,$wptitle2_options,$q_config;
	
	if(
	   $post->post_type=='page' 
	   or ($post->post_type=='post' and $wptitle2_options['posts']=='enabled') 
	   or ($wptitle2_options['post_types_support']=='enabled' and isset($wptitle2_options['post_types'][$post->post_type]))
	)
	{
		foreach($q_config['enabled_languages'] as $v) {
			$customtitle = get_post_meta($post->ID, '_title_'.$v, true);
			if ($wptitle2_options['html']=='enabled') $customtitle = htmlspecialchars($customtitle,ENT_QUOTES);
?>
<fieldset class="customtitlediv" id="customtitle_<?php echo $v; ?>">
	<legend>
		<?php 
		_e('Heading (optional)','wp_title_2');
		echo ' (',( ($wptitle2_options['html']=='enabled') ? __('HTML is enabled, you need to properly encode all HTML entities','wp_title_2') : __('HTML is disabled','wp_title_2') ), ')';
		?>
	</legend>
	<div style="width:100%">
		<input class="customtitle" type="text" tabindex="1" size="30" name="title_<?php echo $v; ?>" value="<?php echo $customtitle; ?>" />
	</div>
</fieldset>
<?php
		} // endforeach
	} // endif
}

// Adding some CSS and JavaScript functions in the <head> in administration pages
add_action('admin_head','wptitle2_addHead',999);
function wptitle2_addHead() {
	
	global $post,$wptitle2_options;
	
	if (function_exists('qtrans_loadConfig')) : ?>

<script type="text/javascript">
<!--
jQuery(window).load(function(){
	jQuery('.customtitlediv').each(function(){
		lang = jQuery(this).attr('id').substr(jQuery(this).attr('id').lastIndexOf('_')+1);
		//alert(lang);
		jQuery(this).insertAfter(jQuery('input#qtrans_title_'+lang).parent().parent());
	});
});
//-->
</script>

<style type="text/css">

.customtitlediv{padding:2px 0 25px}
	
.customtitlediv legend{font-weight:bold}
	
.customtitlediv input{
	border:0 none;
	font-size:1.7em;
	outline-style:none;
	outline-width:medium;
	padding:0;
	width:100%;
	border:1px solid #CCCCCC;
	}

</style>

<?php else : ?>

<style type="text/css">

.customtitle {
	width:100%;
	margin:0;
	padding:4px 3px;
	font-size:1.7em;
	-moz-border-radius-bottomleft:6px;
	-moz-border-radius-bottomright:6px;
	-moz-border-radius-topleft:6px;
	-moz-border-radius-topright:6px;
	border:1px solid #DFDFDF;
	font-size:1.7em;
	outline-color:-moz-use-text-color;
	outline-style:none;
	outline-width:medium;}
	
<?php

if ($post->post_type=='page' 
	or ($wptitle2_options['posts']=='enabled' and $post->post_type=='post') 
	or ($wptitle2_options['post_types_support']=='enabled' and isset($wptitle2_options['post_types'][$post->post_type]))
) : ?>
#titlediv{padding-bottom:100px}
<?php endif; ?>

.customtitlediv{
	position:absolute;
	left:0;
	top:75px;
	width:100%;}
	
#post-body-content{position:relative}

#moremeta{right:auto; left:102%}

</style>

<?php endif; // end head styles 
	
}

// Add/Update our Heading in the DataBase
add_action('save_post', 'wptitle2_updateTitle');
function wptitle2_updateTitle($postID) {
	
	global $wpdb,$wptitle2_options,$q_config;
	
	if (isset($_POST)) {
		foreach($q_config['enabled_languages'] as $language) {
			if (isset($_POST['title_'.$language])) {
				
				$heading = $_POST['title_'.$language];
				if($wptitle2_options['html']=='disabled'){
					$heading = htmlspecialchars($heading);
				}
				
				// adding the heading to the database
				if (!update_post_meta($postID, '_title_'.$language,$heading)) 
					add_post_meta($postID, '_title_'.$language,$heading,true);
			}
		}
	}
}

// Changing the the_title() Template Tag
add_filter('the_title','wptitle2_the_title',999);
function wptitle2_the_title() {
	global $post,$q_config,$wptitle2_options;
	
	$args = func_get_args();
	
	if ($post->post_type=='post' && $wptitle2_options['posts']=='disabled') return $args[0]; // return original title if plugin is disabled for Posts
	
	remove_filter('the_title', 'wptitle2_the_title',999);
	$title = apply_filters('the_title',$post->post_title);
	add_filter('the_title', 'wptitle2_the_title',999);
	
	// check language
	$lang = (isset($q_config['language'])) ? $q_config['language'] : $q_config['enabled_languages'][0];
	
	if (!empty($title) && strpos($args[0],$title)==0 && strlen($args[0])==strlen($title) && $customtitle = get_post_meta($post->ID, '_title_'.$lang, true)) {
		return str_replace($title,$customtitle,$args[0]);
	} else {
		return $args[0];
	}
}

// Changing the wp_title() Template Tag
add_filter('wp_title','wptitle2_wp_title',999);
function wptitle2_wp_title() {
	global $post,$q_config,$wptitle2_options;
	
	$args = func_get_args();
	
	if ($post->post_type=='post' && $wptitle2_options['posts']=='disabled') return $args[0]; // return original title if plugin is disabled for Posts
	
	remove_filter('the_title', 'wptitle2_the_title',999);
	$title = apply_filters('the_title',$post->post_title);
	add_filter('the_title', 'wptitle2_the_title',999);
	
	// check language
	$lang = (isset($q_config['language'])) ? $q_config['language'] : $q_config['enabled_languages'][0];
	
	if ($customtitle = get_post_meta($post->ID, '_title_'.$lang, true)){ 
		if ($wptitle2_options['html']=='enabled')
			//return str_replace($title,htmlspecialchars(strip_tags($customtitle)),$args[0]);
			return str_replace($title,strip_tags($customtitle),$args[0]);
		else 
			return str_replace($title,$customtitle,$args[0]);
	}
	else return $args[0];
}

// By default, WP uses the_title filter into wp_list_pages, we need to override it somehow
add_filter('wp_list_pages','wptitle2_list_pages',999);
add_filter('wp_nav_menu','wptitle2_list_pages',999);
function wptitle2_list_pages() {
	global $post,$q_config,$wpdb,$wptitle2_options;
	$args = func_get_args();
	
	// check language
	$lang = (isset($q_config['language'])) ? $q_config['language'] : $q_config['enabled_languages'][0];
	
	//$title = $post->post_title;
	remove_filter('the_title', 'wptitle2_the_title',999);
	$title = apply_filters('the_title',$post->post_title);
	
	// set the custom heading for title attribute in the <a> tags
	$headings = $wpdb->get_results("SELECT post_id,meta_value FROM {$wpdb->postmeta} WHERE meta_key = '_title_{$lang}'");
	if (!empty($headings)) {
		
		$titles = $wpdb->get_results("SELECT ID,post_title FROM {$wpdb->posts} WHERE post_type = 'page'");
		$org_titles = array();
		
		foreach ($titles as $v) $org_titles[$v->ID] = $v->post_title;
		
		foreach ($headings as $heading) {
			
			if ($heading->meta_value=='') continue; // if empty, skip and continue with others
			
			$org_title = apply_filters('the_title',$org_titles[$heading->post_id]);
			if ($wptitle2_options['html']=='enabled'){
				$heading->meta_value = strip_tags($heading->meta_value);
				$heading->meta_value = htmlspecialchars($heading->meta_value,ENT_QUOTES);
			}
			$org_title = str_replace('&#038;','&amp;',$org_title);
			$args[0] = str_replace('title="'.$org_title.'"','title="'.$heading->meta_value.'"',$args[0]);
		}
		
	}
	add_filter('the_title', 'wptitle2_the_title',999);
	
	if ($customtitle = get_post_meta($post->ID, '_title_'.$lang, true)) {
		$args[0] = str_replace('title="'.htmlspecialchars($customtitle).'"','title="'.htmlspecialchars(strip_tags($customtitle)).'"',$args[0]);
		return str_replace('>'.$customtitle.'<','>'.$title.'<',$args[0]);
	}
	else return $args[0];
}

// Draw WP Title 2 Options Page link
add_action('admin_menu','wptitle2_options_menu');
function wptitle2_options_menu(){
	if (function_exists('add_options_page'))
		add_options_page('WP Title 2','WP Title 2','manage_options','wptitle2_add_options_page','wptitle2_add_options_page');
}

// Add Options Page
function wptitle2_add_options_page(){
	
	global $wptitle2_options,$wpdb;
	
?>
<div class="wrap">
	<h2>WP Title 2 <?php _e('Options') ?></h2>
	<?php if ($_GET['message']==1) : ?>
	<div id="message" class="updated fade below-h2">
		<p>
			<strong><?php _e('Settings saved.') ?></strong>
		</p>
	</div>
	<?php endif ?>
	
	<?php
	
	// get registered custom post types
	$post_types = get_post_types('','objects');
	unset($post_types['post'],$post_types['page'],$post_types['revision'],$post_types['attachment'],$post_types['nav_menu_item']);
		
	?>
	
	<form action="" method="post">
		<input type="hidden" name="action" value="update_wp_title_2" />
		<p>
			<input type="checkbox" name="posts" id="wp_title_posts"<?php echo ($wptitle2_options['posts']=='enabled') ? ' checked="checked"' : '' ?> />
			<label for="wp_title_posts">
				<?php _e('Enable WP Title 2 for Posts','wp_title_2') ?>
				<span class="description">
					(<?php _e('Check this in order to enable WP Title 2 Custom Heading for Posts','wp_title_2') ?>)
				</span>
			</label>
		</p>
		<?php if(!empty($post_types)) : ?>
		<p>
			<input type="checkbox" name="post_types_support" id="wp_title_post_types_support"<?php echo ($wptitle2_options['post_types_support']=='enabled') ? ' checked="checked"' : '' ?> />
			<label for="wp_title_post_types_support">
				<?php _e('Enable WP Title 2 for Custom Post Types','wp_title_2') ?>
				<span class="description">
					(<?php _e('Check this in order to enable WP Title 2 Custom Heading for Custom Post Types','wp_title_2') ?>)
				</span>
			</label>
		</p>
		<ul>
			<?php foreach($post_types as $post_type) : ?>
			<li style="margin-left:25px">
				<input type="checkbox" name="post_types[]" id="post_type_<?php echo $post_type->name ?>" value="<?php echo $post_type->name ?>"<?php echo (isset($wptitle2_options['post_types'][$post_type->name])) ? ' checked="checked"' : '' ?> />
				<label for="post_type_<?php echo $post_type->name ?>"><?php echo $post_type->label ?></label>
				
			</li>
			<?php endforeach ?>
			
		</ul>
		<script type="text/javascript">
		<!--
		jQuery(function(){
			var chb_post_type_support = jQuery('#wp_title_post_types_support'),
				post_type_support_p = chb_post_type_support.parent(),
				post_type_support_ul = post_type_support_p.next();
				
			if(chb_post_type_support.filter(':checked').length<=0)
				post_type_support_ul.hide();
				
			chb_post_type_support.change(function(){
				var elem = jQuery(this).filter(':checked');
				if(elem.length>0)
					post_type_support_ul.slideDown(300).find('input[type="checkbox"]').attr('checked','checked');
				else
					post_type_support_ul.slideUp(300).find('input[type="checkbox"]:checked').removeAttr('checked');
			});
		});
		//-->
		</script>
		<?php endif ?>
		
		<p>
			<input type="checkbox" name="html" id="wp_title_html"<?php echo ($wptitle2_options['html']=='enabled') ? ' checked="checked"' : '' ?> />
			<label for="wp_title_html">
				<?php _e('Enable HTML in WP Title 2 Heading','wp_title_2') ?>
				<span class="description">
					(<?php _e('Check here if you wish to write HTML code in your Heading fields. Otherwise, uncheck this (any HTML code will be filtered)','wp_title_2') ?>)
				</span>
			</label>
		</p>
		<p>
			<input type="checkbox" name="admin_show_default_title" id="wp_title_admin_show_default_title"<?php echo ($wptitle2_options['admin_show_default_title']=='enabled') ? ' checked="checked"' : '' ?> />
			<label for="wp_title_admin_show_default_title">
				<?php _e('Show default title in Administration\'s Post/Page view table','wp_title_2') ?>
				<span class="description">
					(<?php _e('Check here if you prefer to view your original Post/Page Titles (instead of your custom WP Title 2 Headings) when listing all Posts or Pages in the WordPress Administration','wp_title_2') ?>)
				</span>
			</label>
		</p>
		<p>
			<input type="submit" value="<?php _e('Save Changes') ?>" class="button-primary" />
		</p>
	</form>
</div>
<?php
}

// Add the 'WP Title 2 Recent Posts' Widget
add_action( 'widgets_init', 'wptitle2_load_widgets' );
function wptitle2_load_widgets(){
	register_widget( 'WP_Title_2_Widget_Recent_Posts' );
}
/**
 * WP_Title_2_Widget_Recent_Posts widget class
 *
 * @copied from WP_Widget_Recent_Posts (wp-includes/default-widgets.php#511)
 */
class WP_Title_2_Widget_Recent_Posts extends WP_Widget {

	function WP_Title_2_Widget_Recent_Posts() {
		$widget_ops = array('classname' => 'widget_recent_entries', 'description' => __( "The most recent posts on your blog") );
		$this->WP_Widget('wptitle2-recent-posts', 'WP Title 2 '.__('Recent Posts'), $widget_ops);
		$this->alt_option_name = 'wptitle2_widget_recent_entries';

		add_action( 'save_post', array(&$this, 'flush_widget_cache') );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache') );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('wptitle2_widget_recent_posts', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( isset($cache[$args['widget_id']]) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts') : $instance['title']);
		if ( !$number = (int) $instance['number'] )
			$number = 10;
		else if ( $number < 1 )
			$number = 1;
		else if ( $number > 15 )
			$number = 15;

		$r = new WP_Query(array('showposts' => $number, 'nopaging' => 0, 'post_status' => 'publish', 'caller_get_posts' => 1));
		if ($r->have_posts()) :
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul>
		<?php  while ($r->have_posts()) : $r->the_post(); ?>
		<li>
			<a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>">
				<?php 
				remove_filter('the_title', 'wptitle2_the_title',999); 
				if ( get_the_title() ) the_title(); else the_ID(); 
				add_filter('the_title', 'wptitle2_the_title',999);
				?> 
			</a>
		</li>
		<?php endwhile; ?>
		</ul>
		<?php echo $after_widget; ?>
<?php
			wp_reset_query();  // Restore global post data stomped by the_post().
		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_add('wptitle2_widget_recent_posts', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['wptitle2_widget_recent_entries']) )
			delete_option('wptitle2_widget_recent_entries');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('wptitle2_widget_recent_posts', 'widget');
	}

	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		if ( !isset($instance['number']) || !$number = (int) $instance['number'] )
			$number = 5;
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /><br />
		<small><?php _e('(at most 15)'); ?></small></p>
<?php
	}
}

?>