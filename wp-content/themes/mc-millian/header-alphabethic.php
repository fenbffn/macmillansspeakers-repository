<?php
/**
 * The Header for our theme.
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
    <link rel="stylesheet" href="<?php echo WP_CONTENT_URL; ?>/themes/mc-millian/css/reveal.css" type="text/css" media="screen, projection" />
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
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
    <link rel="shortcut icon" href="images/favicon.gif" type="image/x-icon"/>
    <script src="<?php echo WP_CONTENT_URL; ?>/themes/mc-millian/js/jquery-1.4.4.min.js"></script>
    <script src="<?php echo WP_CONTENT_URL; ?>/themes/mc-millian/js/jquery.reveal.js"></script>

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

</head>
<body>
<div class="bg">
    <!--start container-->
    <div id="container">
        <!--start header-->
        <header>
            <!--start logo-->
            <div id="logo">

                <?php $header_image = get_header_image();
                if ( ! empty( $header_image ) ) : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></a>
                    <?php endif; ?>
                <!--                    <img src="--><?php //bloginfo('template_directory'); ?><!--/images/logo.png" alt="logo"/>-->

                <h4 class="legend"><?php bloginfo( 'description' ); ?></h4>
            </div>
            <div class="separate"></div>
            <?php if (is_active_sidebar('header-widget-area')) : ?>

            <?php
            if(is_home() || is_front_page() ) :
                echo '<div class="speakers">';
                dynamic_sidebar('header-widget-area');
                echo '</div>';
            else:
                ?>
                <?php
                 if ( have_posts() ) : while (have_posts()) : the_post();
                     remove_filter('the_title','wptitle2_the_title',999);
                ?>
                <div class="page-title-speakers">
                    <h1 class="entry-title"><?php echo the_title();?></h1>
                    <span><?php add_filter('the_title','wptitle2_the_title',999); the_title(); ?>
                    </span>
                    <ul class="list-search">
                        <li><a class="<?php if($_GET['search']== 'A' || !isset($_GET['search'])) echo 'current-link'?>" href="<?php echo get_site_url(); ?>/speakers/?search=A" target="">A</a></li>
                        <li><a class="<?php if($_GET['search']== 'B') echo 'current-link'?>" href="<?php echo get_site_url(); ?>/speakers/?search=B" target="">B</a></li>
                        <li><a class="<?php if($_GET['search']== 'C') echo 'current-link'?>" href="<?php echo get_site_url(); ?>/speakers/?search=C" target="">C</a></li>
                        <li><a class="<?php if($_GET['search']== 'D') echo 'current-link'?>" href="<?php echo get_site_url(); ?>/speakers/?search=D" target="">D</a></li>
                        <li><a class="<?php if($_GET['search']== 'E') echo 'current-link'?>" href="<?php echo get_site_url(); ?>/speakers/?search=E" target="">E</a></li>
                        <li><a class="<?php if($_GET['search']== 'F') echo 'current-link'?>" href="<?php echo get_site_url(); ?>/speakers/?search=F" target="">F</a></li>
                        <li><a class="<?php if($_GET['search']== 'G') echo 'current-link'?>" href="<?php echo get_site_url(); ?>/speakers/?search=G" target="">G</a></li>
                        <li><a class="<?php if($_GET['search']== 'H') echo 'current-link'?>" href="<?php echo get_site_url(); ?>/speakers/?search=H" target="">H</a></li>
                        <li><a class="<?php if($_GET['search']== 'I') echo 'current-link'?>" href="<?php echo get_site_url(); ?>/speakers/?search=I" target="">I</a></li>
                        <li><a class="<?php if($_GET['search']== 'J') echo 'current-link'?>" href="<?php echo get_site_url(); ?>/speakers/?search=J" target="">J</a></li>
                        <li><a class="<?php if($_GET['search']== 'K') echo 'current-link'?>" href="<?php echo get_site_url(); ?>/speakers/?search=K" target="">K</a></li>
                        <li><a class="<?php if($_GET['search']== 'L') echo 'current-link'?>" href="<?php echo get_site_url(); ?>/speakers/?search=L" target="">L</a></li>
                        <li><a class="<?php if($_GET['search']== 'M') echo 'current-link'?>" href="<?php echo get_site_url(); ?>/speakers/?search=M" target="">M</a></li>
                        <li><a class="<?php if($_GET['search']== 'N') echo 'current-link'?>" href="<?php echo get_site_url(); ?>/speakers/?search=N" target="">N</a></li>
                        <li><a class="<?php if($_GET['search']== 'O') echo 'current-link'?>" href="<?php echo get_site_url(); ?>/speakers/?search=O" target="">O</a></li>
                        <li><a class="<?php if($_GET['search']== 'P') echo 'current-link'?>" href="<?php echo get_site_url(); ?>/speakers/?search=P" target="">P</a></li>
                        <li><a class="<?php if($_GET['search']== 'Q') echo 'current-link'?>" href="<?php echo get_site_url(); ?>/speakers/?search=Q" target="">Q</a></li>
                        <li><a class="<?php if($_GET['search']== 'R') echo 'current-link'?>" href="<?php echo get_site_url(); ?>/speakers/?search=R" target="">R</a></li>
                        <li><a class="<?php if($_GET['search']== 'S') echo 'current-link'?>" href="<?php echo get_site_url(); ?>/speakers/?search=S" target="">S</a></li>
                        <li><a class="<?php if($_GET['search']== 'T') echo 'current-link'?>" href="<?php echo get_site_url(); ?>/speakers/?search=T" target="">T</a></li>
                        <li><a class="<?php if($_GET['search']== 'U') echo 'current-link'?>" href="<?php echo get_site_url(); ?>/speakers/?search=U" target="">U</a></li>
                        <li><a class="<?php if($_GET['search']== 'V') echo 'current-link'?>" href="<?php echo get_site_url(); ?>/speakers/?search=V" target="">V</a></li>
                        <li><a class="<?php if($_GET['search']== 'W') echo 'current-link'?>" href="<?php echo get_site_url(); ?>/speakers/?search=W" target="">W</a></li>
                        <li><a class="<?php if($_GET['search']== 'X') echo 'current-link'?>" href="<?php echo get_site_url(); ?>/speakers/?search=X" target="">X</a></li>
                        <li><a class="<?php if($_GET['search']== 'Y') echo 'current-link'?>" href="<?php echo get_site_url(); ?>/speakers/?search=Y" target="">Y</a></li>
                        <li><a class="<?php if($_GET['search']== 'Z') echo 'current-link'?>" href="<?php echo get_site_url(); ?>/speakers/?search=Z" target="">Z</a></li>
                    </ul>
                </div>
                     <?php
                 endwhile; endif;
                //Reset Query
                wp_reset_query();
            endif;
            ?>

            <?php endif; ?>

        </header>
