    <div id="pre-footer">
        <section class="group1_footer"></section>
        <div class="separate"></div>
        <div class="footer-section">
                        <?php dynamic_sidebar('pre-footer-area-widget-area'); ?>
<!--            --><?php //dynamic_sidebar('footer-area-widget-area'); ?>
        </div>
    </div>
    <!--start footer-->
    <div id="footer">
        <section class="group1_footer"></section>
        <div class="separate"></div>
        <div class="footer-section">
<!--            --><?php //dynamic_sidebar('pre-footer-area-widget-area'); ?>
            <?php dynamic_sidebar('footer-area-widget-area'); ?>
        </div>
    </div>
<!--end footer-->
    </div>
<!--end container-->

</div>
    <?php wp_footer(); ?>
<!--end bg-->
<!-- Free template distributed by http://freehtml5templates.com -->

<!--[if IE 7]>
        <link rel="stylesheet" href="<?php echo WP_CONTENT_URL; ?>/themes/mc-millian/css/ie7.css" />
        <![endif]-->

<script type="text/javascript">
    $(document).ready(function(){
        if((navigator.userAgent.indexOf("Safari")>0)&(navigator.userAgent.indexOf("Chrome")<0)){
            $('.topics li').css("width", "214px");
            $('.button_advanced_search a').css("text-decoration", "none");
            $('.safaritopic').css("margin-top", "0px");
        }
    });
</script>
</body>
</html>
