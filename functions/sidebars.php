<?php
$args = array(
	'name'          => 'Tweet Sidebar',
	'id'            => 'tweet-sidebar',
	'description'   => '',
	'class'         => '',
	'before_widget' => '<section class="widget %2$s">',
	'after_widget'  => '</section>',
	'before_title'  => '<h2 class="title">',
	'after_title'   => '</h2>',
);
register_sidebar( $args );
