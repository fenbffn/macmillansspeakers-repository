<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ric
 * Date: 8/02/13
 * Time: 16:26
 * To change this template use File | Settings | File Templates.
 */
?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php the_content(); ?>
</article>