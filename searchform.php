<form role="search" method="get" id="searchform" class="search-form" action="<?php echo esc_url( get_site_url() ); ?>">
	<label class="screen-reader-text" for="s">Search for:</label>
	<input type="text" class="text-input" value="<?php echo get_search_query(); ?>" name="s" id="s">
	<input type="submit" class="submit-button" value="Search">
</form>
