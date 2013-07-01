<?php
/**
 * The Header for speaker.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Mc Millian
 * @since Mc Millian 1.0
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
    <meta name="description" content="<?php bloginfo('description') ?>" />
<!--    <link rel="stylesheet" href="--><?php //bloginfo('stylesheet_url'); ?><!--" type="text/css" media="all" />-->
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
    <link rel="stylesheet" href="<?php echo WP_CONTENT_URL; ?>/themes/mc-millian/css/reveal.css" type="text/css" media="screen, projection" />
    <link rel="stylesheet" href="<?php echo WP_CONTENT_URL; ?>/themes/mc-millian/css/website.css" type="text/css" media="screen"/>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <title><?php
        /*
       * Print the <title> tag based on what is being viewed.
       */
        global $page, $paged;

        wp_title( '|', true, 'right' );

        // Add the blog name.
        bloginfo( 'name' );

        // Add the blog description for the home/front page.
        $site_description = get_bloginfo( 'description', 'display' );
        if ( $site_description && ( is_home() || is_front_page() ) )
            echo " | $site_description";

        // Add a page number if necessary:
        if ( $paged >= 2 || $page >= 2 )
            echo ' | ' . sprintf( __( 'Page %s', 'mcmillian' ), max( $paged, $page ) );

        ?></title>

    <link rel="icon" href="images/favicon.gif" type="image/x-icon"/>
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>

    <![endif]-->
<!--    <script src="--><?php //echo WP_CONTENT_URL; ?><!--/themes/mc-millian/js/jquery-1.4.4.min.js"></script>-->
    <script type="text/javascript" src="<?php echo WP_CONTENT_URL; ?>/themes/mc-millian/js/jquery.min.js"></script>
    <script src="<?php echo WP_CONTENT_URL; ?>/themes/mc-millian/js/jquery.reveal.js"></script>


<!--    <script type="text/javascript" src="--><?php //echo WP_CONTENT_URL; ?><!--/themes/mc-millian/js/prettify.js"></script>-->


    <link rel="shortcut icon" href="images/favicon.gif" type="image/x-icon"/>
    <!--    <link rel="stylesheet" type="text/css" href="css/styles.css"/>-->
    <?php
    /* We add some JavaScript to pages with the comment form
      * to support sites with threaded comments (when in use).
      */
    if ( is_singular() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );

    /* Always have wp_head() just before the closing </head>
      * tag of your theme, or you will break many plugins, which
      * generally use this hook to add elements to <head> such
      * as styles, scripts, and meta tags.
      */
    wp_head();
    ?>
    <script type="text/javascript" src="<?php echo WP_CONTENT_URL; ?>/themes/mc-millian/js/jquery.nicescroll.js"></script>
    <script type="text/javascript" src="<?php echo WP_CONTENT_URL; ?>/themes/mc-millian/js/custom.js"></script>
</head>
<body>
<div class="bg">
    <!--start container-->
    <div id="container">




