<?php
// Supports
add_theme_support( 'post-thumbnails' );

$files_to_include = array(
	'sidebars.php',
	'date-archive-widget.php',
);
$dir = get_stylesheet_directory() . '/functions/';
foreach ( $files_to_include as $filename ) {
	$file = $dir . $filename;
	if ( file_exists( $file ) ) {
		include $file;
	}
}

function tweet_theme_action_wp_enqueue_scripts() {
	wp_enqueue_style( 'tweet-theme', get_stylesheet_directory_uri() . '/css/tweet-theme.css', array(), false, 'all' );
}
add_action( 'wp_enqueue_scripts', 'tweet_theme_action_wp_enqueue_scripts' );

function tweet_theme_exclude_replies( $query ) {
	if ( ! $query->is_main_query() || is_admin() || $query->is_search() ) {
		return;
	}

	if ( $query->is_tax() ) {
		return;
	}

	$taxquery = array(
        array(
            'taxonomy' => 'tweet-type',
            'field' => 'slug',
            'terms' => array( 'reply' ),
            'operator'=> 'NOT IN'
        )
    );

	$query->set( 'tax_query', $taxquery );

}
add_action( 'pre_get_posts', 'tweet_theme_exclude_replies' );

function tweet_theme_svg_icon( $icon = '' ) {
	if ( ! $icon ) {
		return;
	}
	$path = get_template_directory() . '/icons/' . $icon . '.svg';
	$args = [
		'css_class' => 'icon icon-' . $icon,
	];
	return tweet_theme_get_svg( $path, $args );
}

function tweet_theme_get_svg( $path, $args = array() ) {
	if ( ! $path ) {
		return;
	}
	$defaults = [
		'role' => 'image',
		'css_class' => '',
	];
	$args = wp_parse_args( $args, $defaults );
	$role_attr = $args['role'];
	$css_class = $args['css_class'];
	if ( is_array( $css_class ) ) {
		$css_class = implode( ' ', $css_class );
	}
	if ( file_exists( $path ) ) {
	 $svg = file_get_contents( $path );
	 $svg = preg_replace( '/(width|height)="[\d\.]+"/i', '', $svg );
	 $svg = str_replace( '<svg ', '<svg class="' . esc_attr( $css_class ) . '" role="' . esc_attr( $role_attr ) . '" ', $svg );
	 return $svg;
	}
}
