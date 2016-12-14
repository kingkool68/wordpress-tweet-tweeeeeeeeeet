<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<article class="tweet">
		<div class="context">
			<?php if ( is_retweet() ) : ?>
				<span class="retweeted-text"><?php echo tweet_theme_svg_icon('retweet'); ?> Retweeted</span>
			<?php endif; ?>
			<?php if ( $reply = get_the_tweet_reply_permalink() ) : ?>
				<a href="<?php the_tweet_reply_permalink(); ?>" class="reply-link"><?php echo tweet_theme_svg_icon('reply'); ?> In reply to <?php the_tweet_reply_full_name(); ?></a>
			<?php endif; ?>
		</div>

		<header class="header">
			<a href="<?php the_tweet_username_link(); ?>" class="username-link">
				<?php the_tweet_profile_image(); ?>
				<span class="full-name"><?php the_tweet_full_name(); ?></span>
				<span class="username">@<?php the_tweet_username(); ?></span>
			</a>
				<span class="bullet">&bull;</span> <a href="<?php the_permalink(); ?>" class="date"><?php the_tweet_date(); ?></a>
		</header>

		<section class="content">
			<?php the_content(); ?>
			<?php the_tweet_media( 'large' ); ?>
		</section>

		<footer class="tweet-actions">
			<a href="<?php the_reply_intent_url(); ?>" title="Reply" class="reply"><?php echo tweet_theme_svg_icon('reply'); ?> <span class="screen-reader-text">Reply</span></a>
			<a href="<?php the_retweet_intent_url(); ?>" title="Retweet" class="retweet"><?php echo tweet_theme_svg_icon('retweet'); ?> <span class="screen-reader-text">Retweet</span></a>
			<a href="<?php the_like_intent_url(); ?>" title="Like" class="like"><?php echo tweet_theme_svg_icon('heart'); ?> <span class="screen-reader-text">Like</span></a>
			<a href="<?php the_tweet_permalink(); ?>" title="View on Twitter" class="twitter"><?php echo tweet_theme_svg_icon('twitter'); ?> <span class="screen-reader-text">View on Twitter</span></a>
			<a href="<?php the_permalink(); ?>" title="View permalink" class="permalink"><?php echo tweet_theme_svg_icon('link'); ?> <span class="screen-reader-text">Permalink</span></a>
		</footer>
	</article>
<?php endwhile; endif; ?>
