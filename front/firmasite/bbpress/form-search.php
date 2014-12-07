<?php

/**
 * Search 
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
<form role="search" method="get" id="bbp-search-form" class="search-form" action="<?php bbp_search_url(); ?>">
	<label class="screen-reader-text hidden sr-only" for="bbp_search"><?php _e( 'Search for:', 'firmasite' ); ?></label>
	<input type="hidden" name="action" value="bbp-search-request" />
	<div class="input-group">
		<input class="form-control" tabindex="<?php bbp_tab_index(); ?>" type="text" value="<?php echo esc_attr( bbp_get_search_terms() ); ?>" placeholder="<?php _e( 'Search for:', 'firmasite' ); ?>" name="bbp_search" id="bbp_search" />
        <div class="input-group-btn">
			<input tabindex="<?php bbp_tab_index(); ?>" class="button btn btn-default" type="submit" id="bbp_search_submit" value="<?php esc_attr_e( 'Search', 'firmasite' ); ?>" />
        </div>
	</div>
</form>
