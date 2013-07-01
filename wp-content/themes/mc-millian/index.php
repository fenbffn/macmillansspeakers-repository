<?php
/**
 * The main template file.
 */

get_header();
?>
<div class="holder_content">
    <?php
    get_sidebar('left');
     ?>

    <div class="separate"></div>
        <section class="group2">
            <ul id="breadcump-home">
                <li class="<?php if($_GET['speakers']=='new') echo "current"; ?>"><a href="<?php  echo esc_url( home_url( '/' ))."?speakers=new" ?>" class="<?php if($_GET['speakers']=='new') echo "current"; ?>">NEW SPEAKERS</a></li>
                <li class="<?php if($_GET['speakers']=='popular' || !isset($_GET['speakers'])) echo "current"; ?>"><a href="<?php  echo esc_url( home_url( '/' ))."?speakers=popular" ?>" class="<?php if($_GET['speakers']=='popular' || !isset($_GET['speakers'])) echo "current"; ?>">MOST POPULAR</a></li>
            </ul>
            <div style="font-size: 8px; margin-top: 4px; position: absolute;right: -285px;margin-right: 0;z-index: 5;"> For photo credit information, please see individual author pages. </div>
<!--            --><?php //dynamic_content_gallery(); ?>
            <?php dynamic_sidebar('home-tabs-widget-area'); ?>
        </section>

    <?php get_sidebar('right'); ?>
</div>
<?php get_footer(); ?>
