<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ric
 * Date: 8/02/13
 * Time: 16:26
 * To change this template use File | Settings | File Templates.
 */
?>
<?php //echo kd_mfi_get_featured_image_url( 'featured-image-2', 'speaker', 'single-medium' );?>
<div class="header_speaker" style="background: #353231 url('<?php echo get_bloginfo('template_directory');?>/images/fondo-speaker.jpg') no-repeat; width: 100%;height: 300px;">
    <div class="img-speaker">
    <?php
        if ( has_post_thumbnail() ) {
            echo get_the_post_thumbnail( get_the_ID(),'medium' ) . '<br/>';
        } else {
            echo '<img style="border:1px solid #adadad;padding:2px" width="100" height="100" alt="7337178" class="attachment-100x250 wp-post-image" src="'.esc_url( home_url( '/' ) ).'wp-content/uploads/2013/02/no-image.png">';
        }
		  $content2 = get_post_meta($post->ID, 'photo_credit', true);
        if ($content2 != NULL)
            echo "Photo credit: ". $content2;
        ?>
    </div>
    <div class="info-speaker">
        <div class="speaker-name">
            <h1><?php remove_filter('the_title','wptitle2_the_title',999); the_title(); ?></h1>
            <!-- this will print WP Title 2 Heading: -->
            <h2><?php add_filter('the_title','wptitle2_the_title',999); substr(strip_tags(the_title()),0,5); ?></h2>
        </div>
        <div class="dcfg-speaker">
            <div class="dfcg-text-speaker">
                <h3>Topics</h3>
                <p><?php
                    $comma = "";
                    $post_categories = wp_get_post_terms( get_the_ID(), 'topics',array("fields" => "all"));
                    foreach($post_categories as $term) {
                        echo $comma."<a href='".get_term_link($term->slug, 'topics')."'>".$term->name."</a>";
                        $comma = ", ";
                    }?>
                </p><br />
            </div>
            <div class="dfcg-text-speaker">
                <h3>Travels From</h3>
                <p><?php
                    $comma = "";
                    $post_categories = wp_get_post_terms( get_the_ID(), 'travels',array("fields" => "all"));
                    foreach($post_categories as $term) {
                        echo $comma."<a href='".get_term_link($term->slug, 'travels')."'>".$term->name."</a>";
                        $comma = ", ";
                    }?>
                </p><br />
            </div>
            <!--<a style="float: right !important;" href="mailto:speakers@macmillan.com?subject=Book <?php remove_filter('the_title','wptitle2_the_title',999); echo the_title(); ?> now." class="readmore-tabbs">BOOK THIS SPEAKER</a>
        -->
                <div id="danieldiv" style="display:none"  class="reveal-modal2">
                <p>
                    <?php echo do_shortcode('[contact-form-7 id="704" title="Book this speaker"]'); ?>
                </p>
				   <a onclick="$('#danieldiv').fadeOut();$('.reveal-modal-bg').fadeOut();return false;" href="#" style="position: absolute; right: 10px; top: 10px;">X</a>

            </div>

            <a data-animation="fade" href="#" data-reveal-id="danieldiv" href="mailto:speakers@macmillan.com?subject=Book <?php remove_filter('the_title','wptitle2_the_title',999); echo the_title(); ?> now." class="readmore-tabbs">BOOK THIS SPEAKER</a>

        </div>

    </div>

</div>
<section class="group2-speaker">
    <ul class='tabs'>
        <li><a href='#tab1'>BIO</a></li>
        <li><a href='#tab2'>BOOKS</a></li>
        <li><a href='#tab3'>SPEECHES</a></li>
        <li><a href="#tab4">REVIEWS</a></li>
    </ul>
    <div id='tab1' class="tab">
<!--        <div class="bio" id="bio">-->
            <h3>BIO</h3>
            <?php the_content();?>
            <?php
            $file = get_group('biography');
            ?>
            <br/>

			<?php $links = get_group('related_links'); ?>

			<?php foreach ($links as $link) : ?>
			<a href="<?php echo $link["related_links_link"][1]; ?>"><img src="<?php echo get_bloginfo("template_url"); ?>/images/text_html.png" /> <?php echo $link["related_links_link_name"][1]; ?></a> <br/>
			<?php endforeach; ?>

			<br/>

            <a target="_blank" href="../../genpdf/generar.php?id=<?php the_ID();?>" onClick="_gaq.push(['_trackEvent', 'Download Bio', 'download', '<?php echo the_title(); ?>', 5, true]);"><img src="<?php echo get_site_url(); ?>/wp-content/uploads/2013/02/icon-pdf.png" alt="pdf"/> Download Bio</a>

            <br/><br/>
            <div id="danieldiv" style="display:none"  class="reveal-modal2">
                <p>
                    <?php echo do_shortcode('[contact-form-7 id="704" title="Book this speaker"]'); ?>
                </p>

            </div>

            <a data-animation="fade" href="#" data-reveal-id="danieldiv" href="mailto:speakers@macmillan.com?subject=Book <?php remove_filter('the_title','wptitle2_the_title',999); echo the_title(); ?> now." class="readmore-tabbs">BOOK THIS SPEAKER</a>


            <!--        </div>-->
    </div>
    <div id='tab2' class="tab">

        <?php
        $works = get_group('works');
//        print_r($works[1]['works_product']);
        if(!empty($works))
		{
			echo "<h3>BOOKS</h3>";
			foreach($works[1]['works_product'] as $work) {
				echo str_replace("<img width=\"60\" height=\"28\" class=\"mac_mdash\" src=\"/images/mdash.gif\">", "", $work); "<br />";
			}
		}
        ?>
    </div>
    <div id='tab3' class="tab">

        <?php
        $speeches = get_group('speeches');
        if(!empty($speeches))
		{
			echo "<h3>SPEECHES</h3>";
            foreach($speeches[1]['speeches_speech'] as $speech) {
                echo $speech."<br /><br/>";
            }
		}
        else
            echo "<h3>COMING SOON </h3>";
        ?>
        <br/>

         <div id="danieldiv" style="display:none"  class="reveal-modal2">
                <p>
                    <?php echo do_shortcode('[contact-form-7 id="704" title="Book this speaker"]'); ?>
                </p>

            </div>

            <a data-animation="fade" href="#" data-reveal-id="danieldiv" href="mailto:speakers@macmillan.com?subject=Book <?php remove_filter('the_title','wptitle2_the_title',999); echo the_title(); ?> now." class="readmore-tabbs">BOOK THIS SPEAKER</a>



<!--        <a class="fancybox" href="mailto:speakers@macmillan.com?subject=Book --><?php //remove_filter('the_title','wptitle2_the_title',999); echo the_title(); ?><!-- now." class="readmore-tabbs">BOOK THIS SPEAKER</a>-->
<!--        <a class="fancybox readmore-tabbs" href="<?php echo esc_url( home_url( '/' ) ); ?>book-this-speaker/">BOOK THIS SPEAKER</a>
<!--        <div style="display:none" class="fancybox-hidden">-->
<!--            <div id="contact_form_pop">-->
<!--                --><?php //do_shortcode('[contact-form-7 id="704" title="Book this speaker"]'); ?>
<!--            </div>-->
<!--        </div>-->

        <br/><br/><br/>
        <?php
        $videos = get_group('videos');
        echo '';
        if(!empty($videos)):
        ?>
            <div class="videos"><h3>RECENT VIDEOS</h3>
            <ul class="list-videos">

                <?php

                foreach($videos as $video) {
                ?>
                    <li style='background: url("<?php echo esc_url( home_url( '/' ) ); ?>wp-content/uploads/2013/02/play.png") no-repeat scroll 43px 30px transparent;'>
                    <?php
                    $url = $video["videos_video"][1];
                    parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
                    $img_thumb = "i3.ytimg.com/vi/{$my_array_of_vars['v']}/default.jpg";
                    echo "<a class='fancybox iframe' href='http://www.youtube.com/embed/{$my_array_of_vars['v']}'><img src='http://{$img_thumb}' width='100' height='100' alt='' /></a>";
//                    echo "<iframe width='100' scrolling='no' height='100' src='".$video["videos_video"][1]."' frameborder='0' allowfullscreen></iframe><br/>";
                    echo $video["videos_description"][1];
                    ?>
                </li>
                <?php } ?>
            </ul>
        </div>
            <?php
        else:
            echo "<h3>Videos Comings Soon</h3>";
        endif;?>
    </div>
    <div id='tab4' class="tab">
		<?php $reviews = get_group('reviews'); ?>
        <?php if (!empty($reviews)) : ?>
		<h3>REVIEWS</h3>
        <?php foreach($reviews[1]['reviews_review'] as $review) : ?>
			<?php echo $review; ?><br /><br/>
		<?php endforeach; ?>
        <?php else: ?>
			<h3>COMING SOON </h3>
        <?php endif; ?>
    </div>

</section>
<section class="group3-speaker">
    <?php dynamic_sidebar('sidebar-right-widget-area'); ?>
</section>