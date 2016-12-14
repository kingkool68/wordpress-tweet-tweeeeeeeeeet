<?php get_header(); ?>
<div class="holder">
	<main>
		<?php get_template_part( 'tweets' ); ?>
		<div class="pagination">
			<?php echo paginate_links(); ?>
		</div>
	</main>

	<?php get_template_part( 'profile' ); ?>
	<?php get_sidebar(); ?>
</div>
<?php get_footer();
