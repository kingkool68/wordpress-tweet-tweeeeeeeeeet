<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--><html <?php language_attributes(); ?>><!--<![endif]-->
<head prefix="og: http://ogp.me/ns#">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="referrer" content="unsafe-url">
	<?php if ( $post ) { ?>
	<meta name="date" content="<?= date('Ymd',strtotime($post->post_date)); ?>">
	<?php } ?>

	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<a id="top" href="#content" class="screen-reader-text skip-to-content-link">Skip to Content</a>
	<?php if ( ! is_404() ) :  ?>
	<header class="site-header">
		<?php
		$username = get_option( 'authenticated_twitter_user' );
		if ( get_query_var( 'twitter-user' ) ) {
			$username = get_query_var( 'twitter-user' );
		}
		$user = get_twitter_user( $username );
		$banner_id = get_post_meta( $user->ID, '_profile_banner_id', true );
		$banner_array = wp_get_attachment_image_src( $banner_id, 'full' );
		$banner_url = $banner_array[0];

		$link_color = get_post_meta( $user->ID, 'twitter_user_link_color', true );
		?>
		<style>
		a {
			color: #<?php echo $link_color; ?>;
		}
		</style>
		<div class="profile-banner-holder">
			<div class="profile-banner" style="background-image:url(<?php echo esc_url( $banner_url ); ?>); background-color:#<?php echo $link_color; ?>;">
		</div>
		<?php get_search_form(); ?>
	</header>
<?php endif; ?>
