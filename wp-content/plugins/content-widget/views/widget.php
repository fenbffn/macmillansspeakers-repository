<?php

// Block direct requests
defined( 'ABSPATH' ) or die( '-1' );

echo $before_widget;

if ( ! ( isset( $instance['hidetitle'] ) && $instance['hidetitle'] == 1 ) && ! empty( $title ) ) {
	echo $before_title . $title . $after_title;
} else {
    echo $before_title . $instance['custom_title'] . $after_title;
}

if ( ! ( isset( $instance['hidecontent'] ) && $instance['hidecontent'] == 1 ) ) {
            if( $instance['charlimit'] ) {
                $text = wp_trim_words( $text, $instance['charlimit'], $instance['delimiter'] );
            }

            echo ! empty( $instance['filter'] ) ? wpautop( $text ) : $text;
} else {
    $text = $instance['content'];
    if( $instance['charlimit'] ) {
        $text = wp_trim_words( $text, $instance['charlimit'], $instance['delimiter'] );
    }

    echo ! empty( $instance['filter'] ) ? wpautop( $text ) : $text;
}

if( $instance['charlimit'] && ! empty( $instance['readmore'] ) ) {
	printf( ' <a class="read-more" href="%s">%s</a>', get_permalink(), $instance['readmore'] );
}

echo $after_widget;