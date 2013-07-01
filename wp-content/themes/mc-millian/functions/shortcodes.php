<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ric
 * Date: 21/01/13
 * Time: 12:39
 * To change this template use File | Settings | File Templates.
 */
add_shortcode('hot_topic', 'hot_topic_shortcode');
add_filter( 'widget_text', 'do_shortcode' );
function hot_topic_shortcode($atts) {
    $output = '';
    extract(shortcode_atts(array(
        "category" => '',
        "count" => ''
    ), $atts));

    $taxonomy     = $category;
    $orderby      = 'count';
    $show_count   = 0;      // 1 for yes, 0 for no
    $pad_counts   = 0;      // 1 for yes, 0 for no
    $hierarchical = 1;      // 1 for yes, 0 for no
    $title        = '';
    $number       = $count;
    $args = array(
        'taxonomy'     => $taxonomy,
        'orderby'      => $orderby,
        'order'         => 'DESC',
        'show_count'   => $show_count,
        'pad_counts'   => $pad_counts,
        'hierarchical' => $hierarchical,
        'title_li'     => $title,
        'style'        => 'none',
        'number'      => $number
    );

//    $output .= '<ul>';
    $output .= wp_list_categories( $args );
//    $output .='</ul>';

    return $output;
}

/** Shortcode Question */
function question_f($atts, $content = null) {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            //List Links - espand/collapse
            jQuery('.links-expand').click(function(event) {
                jQuery(this).parent().parent().find('div').hide('slow');
                jQuery(this).hide('slow');
                jQuery(this).parent().find('.links-collapse').show('slow');
            });
            jQuery('.links-collapse').click(function(event) {
                jQuery(this).parent().parent().find('div').show('slow');
                jQuery(this).hide('slow');
                jQuery(this).parent().find('.links-expand').show('slow');
            });
        });
    </script>
    <?php
    extract(shortcode_atts(array(
        "q" => '',
    ), $atts));

    $output = '';

//    $content = explode("\n", $content);
    $output .= '<div class="content-link-list">';
    $output .= '<strong style="color:#9A0206"><span class="links-collapse"><img src="' . get_template_directory_uri() . '/images/plus.gif" /> </span>&nbsp;<span style="display:none;" class="links-expand"><img src="' . get_template_directory_uri() . '/images/minus.gif" /> </span> &nbsp;' . $q . '</strong>';
    $output .= '<div style="display:none;">';
    $output .= $content;
    $output .= '</div><br/>';
    $output .= '</div>';

    return $output;
}

add_shortcode('question', 'question_f');

function topics_shortcode($atts,$content=null) {
    $terms = get_terms("topics");
    $count = count($terms);
    $output = '';
    $output = '<h2>Topics</h2>';
    if ( $count > 0 ){
        $output .= "<ul>";
        foreach ( $terms as $term ) {
            $output .= "<li>" . '<a href="'.network_site_url( '/' ).'topics/' . $term->slug . '" title="' . sprintf(__('View all post filed under %s', 'my_localization_domain'), $term->name) . '">' . $term->name . "</a></li>";
        }
        $output .= "</ul>";
    }
    return $output;
}
add_shortcode('topics', 'topics_shortcode');

/* shortcode for list speakers by topic */
function speakers_by_topic_shortcode($atts,$content=null) {
    extract(shortcode_atts(array(
        "topic" => '',
        "cant"  => '', 
        "ids" => ''
    ), $atts));
    $output = '';
    /*
    query_posts(array(
            'post_type' => 'speaker',
            'showposts' => $cant,
            'tax_query' => array(
                array(
                    'taxonomy' => 'topics',
                    'terms' => $topic,
                    'field' => 'slug',
                )
            ),
            'orderby' => 'title',
            'order' => 'ASC' )
    );
   */
    
    //echo "HOLA";
    //query_posts( 'p=719' );
    
    $output .= '<div class="speakers-topics">';
    $parametro  = $ids;
$array = explode(",", $parametro);
    
foreach ($array as &$valor) {   
    
     query_posts(array(
            'post_type' => 'speaker',
            'showposts' => $cant,
            'p' => $valor,
            'orderby' => 'title',
            'order' => 'ASC' )
    );
    while ( have_posts() ) : the_post();
    
        $output .= '<div class="speakert">';
        if ( has_post_thumbnail() ) {
            $output .="<a href='".get_permalink()."'>".get_the_post_thumbnail( get_the_ID(),array(80,100))."</a>";
            
        } else {
            $output .= '<img style="border:1px solid #adadad;padding:2px" width="100" height="100" alt="7337178" class="attachment-100x250 wp-post-image" src="'.esc_url( home_url( '/' ) ).'wp-content/uploads/2013/02/no-image.png">';
        }
        remove_filter('the_title','wptitle2_the_title',999);
        $output .= "<h3><a href='".get_permalink()."'>".get_the_title()."</a></h3>";
        add_filter('the_title','wptitle2_the_title',999);
        $output .= "<p>".(get_the_title())."</p>";
        
        $output .= "<p style='line-height: 1.2em;'>".  substr(strip_tags( get_the_content()), 0, 190)."...<a class='read-more' href='".get_permalink($post_id)."'>Read More...</a></p><br />";
        
        $output .= '</div><br />';      






        
//        $speeches = get_group('speeches');
//        if(!empty($speeches))
//        {
//           $output .= "<p> SPEECHES: </br>";
//        
//            foreach($speeches[1]['speeches_speech'] as $speech) {
//                $output .= $speech."<br /><br/>";
//            }
//       $output .= "</p>";
//        }
//        
//        
//        $works = get_group('works',$valor);
//        
//         
//         //        print_r($works[1]['works_product']);
//         if(!empty($works))
//         {
//             $output .= "<p> BOOKS: </br>";
//            
//             foreach($works[1]['works_product'] as $work) {
//                $output .= $work."<br /><br/>";
//        }
//        $output .= "</p>";
//         }
         
        
    endwhile;
    
    wp_reset_query();
  }  
    
    
    $output .= '</div>';
    return $output;
    
    
     
}
add_shortcode('speakers_by_topic', 'speakers_by_topic_shortcode');