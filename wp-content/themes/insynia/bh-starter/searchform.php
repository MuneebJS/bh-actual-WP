<?php
/**
 * Custom search form.
 *
 * @package BH_Starter
 */
?>
<form role="search" method="get" class="search-form search-form--centered" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'bh-starter' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Search&hellip;', 'bh-starter' ); ?>" value="<?php echo get_search_query(); ?>" name="s">
	</label>
	<input type="submit" class="search-submit" value="<?php esc_attr_e( 'Search', 'bh-starter' ); ?>">
</form>
