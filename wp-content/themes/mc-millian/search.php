<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */



define('WP_USE_THEMES', false);
require('wp-blog-header.php');

get_header('search');
?>
<div class="holder_content">
    <?php
    get_sidebar('left');

    ?>

			<?php if ( have_posts() ) : ?>


				<?php /* Start the Loop */ ?>
            <section class="group-content">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						get_template_part( 'content', 'archive' );
					?>

				<?php endwhile; ?>
            </section>

			<?php else : ?>
<section class="group-content">
				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentyeleven' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->
</section>
			<?php endif; ?>

			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_footer(); ?>