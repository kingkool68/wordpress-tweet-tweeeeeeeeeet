<section class="profile">
	<?php
	$username = get_option( 'authenticated_twitter_user' );
	if ( get_query_var( 'twitter-user' ) ) {
		$username = get_query_var( 'twitter-user' );
	}
	$user = get_twitter_user( $username );
	$username = get_the_twitter_user_username( $user );

	$deets = array();
	if ( $location = get_the_twitter_user_location( $user ) ) {
		$deets[] = array(
			'html' => $location,
			'icon' => 'map-marker',
		);
	}
	if ( $url = get_the_twitter_user_url( $user ) ) {
		$deets[] = array(
			'html' => '<a href="' . esc_url( $url ) . '" target="_blank">' . Tweet_Archiver_Helpers::get_display_url( $url ) . '</a>',
			'icon' => 'link',
		);
	}
	$deets[] = array(
		'html' => '<a href="https://twitter.com/' . $username . '">twitter.com/' . $username . '</a>',
		'icon' => 'link',
	);
	if ( $join_date = get_the_twitter_user_join_date( $user, 'F j, Y' ) ) {
		$join_date_attr = get_the_twitter_user_join_date( $user, 'c' );
		$deets[] = array(
			'html' => 'Joined <time datetime="' . esc_attr( $join_date_attr ) . '">' . $join_date . '</time>',
			'icon' => 'heart',
		);
	}

	?>
	<a href="<?php echo esc_url( get_site_url() ); ?>" class="holder"><?php the_twitter_user_profile_image( 'large', array(), $user ); ?></a>
	<h1 class="name"><?php the_twitter_user_name( $user ); ?></h1>
	<p class="username">@<?php the_twitter_user_username( $user ); ?></p>
	<div class="description">
		<?php the_twitter_user_description( $user ); ?>
	</div>
	<?php
	if ( ! empty( $deets ) ) {
		echo '<ul class="deets">';
		foreach ( $deets as $deet ) {
			$icon = '';
			if ( $deet['icon'] ) {
				$icon = tweet_theme_svg_icon( $deet['icon'] ) . ' ';
			}
			echo '<li>' . $icon . $deet['html'] . '</li>';
		}
		echo '</ul>';
	}
	?>
</section>
