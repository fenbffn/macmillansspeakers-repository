<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ric
 * Date: 21/01/13
 * Time: 12:35
 * To change this template use File | Settings | File Templates.
 */
function mcmillian_setup() {
    /*
      * Makes Twenty Twelve available for translation.
      *
      * Translations can be added to the /languages/ directory.
      * If you're building a theme based on Twenty Twelve, use a find and replace
      * to change 'mcmillian' to the name of your theme in all the template files.
      */
//    load_theme_textdomain( 'mcmillian', get_template_directory() . '/languages' );

    // This theme styles the visual editor with editor-style.css to match the theme style.
    add_editor_style();

    // Adds RSS feed links to <head> for posts and comments.
    add_theme_support( 'automatic-feed-links' );

    // This theme supports a variety of post formats.
    add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );

    // This theme uses wp_nav_menu() in one location.
    register_nav_menu( 'primary', __( 'Primary Menu', 'mcmillian' ) );

    /*
      * This theme supports custom background color and image, and here
      * we also set up the default background color.
      */
    add_theme_support( 'custom-background', array(
        'default-color' => 'e6e6e6',
    ) );

    // This theme uses a custom image size for featured images, displayed on "standard" posts.
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop
}
add_action( 'after_setup_theme', 'mcmillian_setup' );

if (!current_user_can('manage_options')) {
    add_filter('show_admin_bar', '__return_false');
}


require( get_template_directory() . '/inc/custom-header.php' );

function mcmillian_scripts_styles() {
    global $wp_styles;

    /*
      * Adds JavaScript to pages with the comment form to support
      * sites with threaded comments (when in use).
      */
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );

    /*
      * Adds JavaScript for handling the navigation menu hide-and-show behavior.
      */
//    wp_enqueue_script( 'mcmillian-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '1.0', true );

    if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'mcmillian' ) ) {
        $subsets = 'latin,latin-ext';

        /* translators: To add an additional Open Sans character subset specific to your language, translate
             this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language. */
        $subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'mcmillian' );

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
//        wp_enqueue_style( 'mcmillian-fonts', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );
    }

    /*
      * Loads our main stylesheet.
      */
//    wp_enqueue_style( 'mcmillian-style', get_stylesheet_uri() );

    /*
      * Loads the Internet Explorer specific stylesheet.
      */
//    wp_enqueue_style( 'mcmillian-ie', get_template_directory_uri() . '/css/ie.css', array( 'mcmillian-style' ), '20121010' );
//    $wp_styles->add_data( 'mcmillian-ie', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'mcmillian_scripts_styles' );

function mcmillian_wp_title( $title, $sep ) {
    global $paged, $page;

    if ( is_feed() )
        return $title;

    // Add the site name.
    $title .= get_bloginfo( 'name' );

    // Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
        $title = "$title $sep $site_description";

    // Add a page number if necessary.
    if ( $paged >= 2 || $page >= 2 )
        $title = "$title $sep " . sprintf( __( 'Page %s', 'mcmillian' ), max( $paged, $page ) );

    return $title;
}
add_filter( 'wp_title', 'mcmillian_wp_title', 10, 2 );

function mcmillian_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
            // Display trackbacks differently than normal comments.
            ?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'mcmillian' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'mcmillian' ), '<span class="edit-link">', '</span>' ); ?></p>
                <?php
            break;
        default :
            // Proceed with normal comments.
            global $post;
            ?>
            <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                <article id="comment-<?php comment_ID(); ?>" class="comment">
                    <header class="comment-meta comment-author vcard">
                        <?php
                        echo get_avatar( $comment, 44 );
                        printf( '<cite class="fn">%1$s %2$s</cite>',
                            get_comment_author_link(),
                            // If current post author is also comment author, make it known visually.
                            ( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'mcmillian' ) . '</span>' : ''
                        );
                        printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
                            esc_url( get_comment_link( $comment->comment_ID ) ),
                            get_comment_time( 'c' ),
                            /* translators: 1: date, 2: time */
                            sprintf( __( '%1$s at %2$s', 'mcmillian' ), get_comment_date(), get_comment_time() )
                        );
                        ?>
                    </header><!-- .comment-meta -->

                    <?php if ( '0' == $comment->comment_approved ) : ?>
                    <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'mcmillian' ); ?></p>
                    <?php endif; ?>

                    <section class="comment-content comment">
                        <?php comment_text(); ?>
                        <?php edit_comment_link( __( 'Edit', 'mcmillian' ), '<p class="edit-link">', '</p>' ); ?>
                    </section><!-- .comment-content -->

                    <div class="reply">
                        <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'mcmillian' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                    </div><!-- .reply -->
                </article><!-- #comment-## -->
            <?php
            break;
    endswitch; // end comment_type check
}
function mcmillian_entry_meta() {
    // Translators: used between list items, there is a space after the comma.
    $categories_list = get_the_category_list( __( ', ', 'mcmillian' ) );

    // Translators: used between list items, there is a space after the comma.
    $tag_list = get_the_tag_list( '', __( ', ', 'mcmillian' ) );

    $date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
        esc_url( get_permalink() ),
        esc_attr( get_the_time() ),
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() )
    );

    $author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
        esc_attr( sprintf( __( 'View all posts by %s', 'mcmillian' ), get_the_author() ) ),
        get_the_author()
    );

    // Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
    if ( $tag_list ) {
        $utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'mcmillian' );
    } elseif ( $categories_list ) {
        $utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'mcmillian' );
    } else {
        $utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'mcmillian' );
    }

    printf(
        $utility_text,
        $categories_list,
        $tag_list,
        $date,
        $author
    );
}
