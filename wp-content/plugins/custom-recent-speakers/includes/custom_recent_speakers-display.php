<?php

function custom_recent_speakers_stylesheet() {
    $plugin_dir = 'custom-recent-speakers';
    if ( @file_exists( STYLESHEETPATH . '/custom-recent-speakers.css' ) )
        $mycss_file = get_stylesheet_directory_uri() . '/custom-recent-speakers.css';
    elseif ( @file_exists( TEMPLATEPATH . '/custom-recent-speakers.css' ) )
        $mycss_file = get_template_directory_uri() . '/custom-recent-speakers.css';
    else
        $mycss_file = plugins_url( 'css/custom-recent-speakers.css',dirname(__FILE__) );

    wp_register_style( 'custom-recent-speakers-css', $mycss_file );
    wp_enqueue_style( 'custom-recent-speakers-css' );

}
add_action('wp_print_styles', 'custom_recent_speakers_stylesheet');

function custom_recent_speakers_scripts_basic()
{
    // Register the script like this for a plugin:
    wp_register_script( 'jquery-1.8.1', plugins_url( 'js/jquery-1.8.1.min.js', dirname(__FILE__)) );
    wp_register_script( 'custom-script', plugins_url( 'js/custom.js',dirname(__FILE__)) );

    wp_enqueue_script( 'jquery-1.8.1' );
    wp_enqueue_script( 'custom-script' );
}
add_action( 'wp_enqueue_scripts', 'custom_recent_speakers_scripts_basic' );

//function custom_recent_speakers_js() {
//    $myjs_file = plugins_url( 'js/custom.js',dirname(__FILE__) );
//    $myjs_file2 = plugins_url( 'js/jquery-1.8.1.min.js',dirname(__FILE__) );
//
//    wp_register_style( 'custom', $myjs_file );
//    wp_enqueue_style( 'custom-recent-speakers-css' );
//
//}
//add_action('wp_print_styles', 'custom_recent_speakers_js');

?>