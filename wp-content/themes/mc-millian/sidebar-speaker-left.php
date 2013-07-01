<?php //if (is_active_sidebar('sidebar-left-widget-area')) : ?>
<section class="group1">
    <div id="logo">

        <?php $header_image = get_header_image();
        if ( ! empty( $header_image ) ) : ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></a>
            <?php endif; ?>
        <!--                    <img src="--><?php //bloginfo('template_directory'); ?><!--/images/logo.png" alt="logo"/>-->

        <h4 class="legend"><?php bloginfo( 'description' ); ?></h4>
    </div>
    <div class="clear"></div>
    <?php dynamic_sidebar('sidebar-left-widget-area'); ?>
</section>
<?php //endif; ?>
