<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ric
 * Date: 21/01/13
 * Time: 12:38
 * To change this template use File | Settings | File Templates.
 */

/** add custom image thumnail */
if ( function_exists( 'add_image_size' ) ) {
    add_image_size( 'single-thumb', 600, 250 );
    add_image_size( 'single-medium', 744, 300 ); //514 pixels wide (and unlimited height)
    add_image_size( 'thumb-speaker',150,170);
//    add_image_size( 'homepage-thumb', 220, 180, true ); //(cropped)
}

add_action( 'after_setup_theme', 'mini_thumbnail_setup' );
function mini_thumbnail_setup() {
    /* Set Default Image Sizes*/
    grayscale_add_image_size('mini-thumbnail', 124, 136, true, true);
    grayscale_add_image_size('client-thumbnail', 130, 55, true, true);
}

function mc_millian_scripts_styles() {
    global $wp_styles;

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );


    wp_enqueue_script( 'mc-millian-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '1.0', true );


    if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'mc-millian' ) ) {
        $subsets = 'latin,latin-ext';

        /* translators: To add an additional Open Sans character subset specific to your language, translate
             this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language. */
        $subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'mc-millian' );

        if ( 'cyrillic' == $subset )
            $subsets .= ',cyrillic,cyrillic-ext';
        elseif ( 'greek' == $subset )
            $subsets .= ',greek,greek-ext';
        elseif ( 'vietnamese' == $subset )
            $subsets .= ',vietnamese';

        $protocol = is_ssl() ? 'https' : 'http';
        $query_args = array(
            'family' => 'Open+Sans:400italic,700italic,400,700',
            'subset' => $subsets,
        );
        wp_enqueue_style( 'mc-millian-fonts', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );
    }

    /*
      * Loads our main stylesheet.
      */
    wp_enqueue_style( 'style', get_stylesheet_uri() );

    /*
      * Loads the Internet Explorer specific stylesheet.
      */
    wp_enqueue_style( 'mc-millian-ie', get_template_directory_uri() . '/css/ie.css', array( 'mc-millian-style' ), '20121010' );
    $wp_styles->add_data( 'mc-millian-ie', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'mc_millian_scripts_styles' );

$args1 = array(
    'id' => 'featured-image-2',
    'post_type' => 'speaker',      // Set this to post or page
    'labels' => array(
        'name'      => 'Featured image large(width:1060px-height:440px)',
        'set'       => 'Set featured image 2',
        'remove'    => 'Remove featured image 2',
        'use'       => 'Use as featured image 2',
    )
);
new kdMultipleFeaturedImages( $args1 );



/** youtube filters **/
add_filter( 'yfvp_new_video_embed_code', 'myprefix_change_yfvp_post_content', 10, 1 );
/* Adds a little nonsense introduction to the video before embedding the
* iframe that was provided by default */
function myprefix_change_yfvp_post_content( $video_embed_code, $video_token ) {

    $new_content = 'My video post includes the token - ' . $video_token . ' - before embedding!';
    $new_content .= $video_embed_code;

    return $new_content;
}

add_filter( 'yfvp_new_video_item_title','myprefix_change_yfvp_post_title', 10, 1 );
/* Changes the default title from Youtube */
function myprefix_change_yfvp_post_title( $current_title ) {
    return 'This is a video: ' . $current_title;
}

/*** contact form 7 ****/
add_action( 'wpcf7_before_send_mail', 'my_conversion' );
function my_conversion( $cf7 )
{
    $email = $cf7->posted_data["your-email"];
    $first_name  = $cf7->posted_data["your-firstname"];
    $last_name  = $cf7->posted_data["your-lastname"];
    $phone = $cf7->posted_data["your-phone"];
    $company = $cf7->posted_data["your-company"];
    $message  = $cf7->posted_data["your-message"];
    $lead_source = $cf7->title;

    $post_items[] = 'oid=<YOU_SALESFORCE_OID>';
    $post_items[] = 'first_name=' . $first_name;
    $post_items[] = 'last_name=' . $last_name;
    $post_items[] = 'email=' . $email;
    $post_items[] = 'phone=' . $phone;
    $post_items[] = 'company=' . $company;
    $post_items[] = 'description=' . $message;
    $post_items[] = 'lead_source=' . $lead_source;

    if(!empty($first_name) && !empty($last_name) && !empty($email) )
    {
        $post_string = implode ('&', $post_items);
        // Create a new cURL resource
        $ch = curl_init();

        if (curl_error($ch) != "")
        {
            // error handling
        }

        $con_url = 'https://www.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8';
        curl_setopt($ch, CURLOPT_URL, $con_url);
        // Set the method to POST
        curl_setopt($ch, CURLOPT_POST, 1);
        // Pass POST data
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_string);
        curl_exec($ch); // Post to Salesforce
        curl_close($ch); // close cURL resource
    }
}

