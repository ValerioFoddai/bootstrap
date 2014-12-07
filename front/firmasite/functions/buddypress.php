<?php
add_action("wp_footer", "firmasite_buddypress_wpadminbar_fix");
function firmasite_buddypress_wpadminbar_fix(){
	if (is_buddypress() && is_admin_bar_showing()) { ?>
	<script>
	jQuery(document).ready(function() {
		jQuery("body").addClass("admin-bar");
	});
	</script>
	<?php 
	}
}

// http://codex.buddypress.org/extending-buddypress/bp-custom-php/
// Removing the links automatically created in a member's profile
add_action( 'bp_init', 'firmasite_remove_xprofile_links' );
function firmasite_remove_xprofile_links() {
    remove_filter( 'bp_get_the_profile_field_value', 'xprofile_filter_link_profile_data', 9, 2 );
}


add_action( 'after_setup_theme', "firmasite_social_buddypress_setup");
function firmasite_social_buddypress_setup() {
	// bp 1.7+
	add_theme_support( 'buddypress' );

	// Load the AJAX functions for the theme
	require( get_template_directory() . '/assets/_inc/ajax.php' );

	if ( ! is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
		// Register buttons for the relevant component templates
		// Friends button
		if ( bp_is_active( 'friends' ) )
			add_action( 'bp_member_header_actions',    'bp_add_friend_button',           5 );

		// Activity button
		if ( bp_is_active( 'activity' ) )
			add_action( 'bp_member_header_actions',    'bp_send_public_message_button',  20 );

		// Messages button
		if ( bp_is_active( 'messages' ) )
			add_action( 'bp_member_header_actions',    'bp_send_private_message_button', 20 );

		// Group buttons
		if ( bp_is_active( 'groups' ) ) {
			add_action( 'bp_group_header_actions',     'bp_group_join_button',           5 );
			add_action( 'bp_group_header_actions',     'bp_group_new_topic_button',      20 );
			add_action( 'bp_directory_groups_actions', 'bp_group_join_button' );
		}

		// Blog button
		if ( bp_is_active( 'blogs' ) )
			add_action( 'bp_directory_blogs_actions',  'bp_blogs_visit_blog_button' );
	}

	/** Notices ***********************************************************/
	if ( bp_is_active( 'messages' ) ) {
		add_action( 'wp_footer', "firmasite_sitewide_notices", 9009 );
	}
	
}

function firmasite_sitewide_notices() {
		// Do not show notices if user is not logged in
		if ( ! is_user_logged_in() )
			return;

		// add a class to determine if the admin bar is on or not
		$class = did_action( 'admin_bar_menu' ) ? 'admin-bar-on' : 'admin-bar-off';

		echo '<div id="sitewide-notice" class="' . $class . '">';
		firmasite_bp_message_get_notices();
		echo '</div>';
}

function firmasite_bp_message_get_notices() {
	global $userdata;

	$notice = BP_Messages_Notice::get_active();

	if ( empty( $notice ) )
		return false;

	$closed_notices = bp_get_user_meta( $userdata->ID, 'closed_notices', true );

	if ( !$closed_notices )
		$closed_notices = array();

	if ( is_array($closed_notices) ) {
		if ( !in_array( $notice->id, $closed_notices ) && $notice->id ) {
			?>
		<div id="message-<?php echo $notice->id ?>" class="info notice modal fade" rel="n-<?php echo $notice->id ?>" tabindex="-1" role="dialog" aria-hidden="false">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title"><?php echo stripslashes( wp_filter_kses( $notice->subject ) ) ?></h3>
              </div>
              <div class="modal-body">
                <p><?php echo stripslashes( wp_filter_kses( $notice->message) ) ?></p>
              </div>              
              <div class="modal-footer">
                <a href="#" id="close-notice" class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><?php _e( 'Close', 'firmasite' ) ?></a>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
		</div>
            <script> 
			jQuery(document).ready(function() {
				jQuery('#message-<?php echo $notice->id ?>').modal('show'); 
				jQuery("#message-<?php echo $notice->id ?> #close-notice").click(function(){ jQuery('#message-<?php echo $notice->id ?>').modal('hide'); });
            });
            </script>
			<?php
		}
	}
}


add_action( 'wp_enqueue_scripts', "firmasite_social_buddypress_scripts");
function firmasite_social_buddypress_scripts() {

	// Enqueue the global JS - Ajax will not work without it
	wp_enqueue_script( 'dtheme-ajax-js', get_template_directory_uri() . '/assets/_inc/global.js', array( 'jquery' ), bp_get_version() );

	// Add words that we need to use in JS to the end of the page so they can be translated and still used.
	$params = array(
		'my_favs'           => __( 'My Favorites', 'firmasite' ),
		'accepted'          => __( 'Accepted', 'firmasite' ),
		'rejected'          => __( 'Rejected', 'firmasite' ),
		'show_all_comments' => __( 'Show all comments for this thread', 'firmasite' ),
		'show_all'          => __( 'Show all', 'firmasite' ),
		'comments'          => __( 'comments', 'firmasite' ),
		'close'             => __( 'Close', 'firmasite' ),
		'view'              => __( 'View', 'firmasite' ),
		'mark_as_fav'	    => __( 'Favorite', 'firmasite' ),
		'remove_fav'	    => __( 'Remove Favorite', 'firmasite' )
	);
	wp_localize_script( 'dtheme-ajax-js', 'BP_DTheme', $params );
}



add_filter('bp_members_signup_error_message', "firmasite_bp_members_signup_error_message");
function firmasite_bp_members_signup_error_message($string){
	return '<div class="alert alert-danger">' . $string . '</div>';
}



add_filter( 'bp_get_the_profile_field_options_checkbox', 'firmasite_customize_bp_get_the_profile_field_options_checkbox',10,1);
function firmasite_customize_bp_get_the_profile_field_options_checkbox($html){
	return '<div class="checkbox">' . $html . '</div>';
}
add_filter( 'bp_get_the_profile_field_options_radio', 'firmasite_customize_bp_get_the_profile_field_options_radio',10,1);
function firmasite_customize_bp_get_the_profile_field_options_radio($html){
	return '<div class="radio">' . $html . '</div>';
}



add_action( 'bp_setup_nav', 'firmasite_buddypress_author_profile_nav' );
function firmasite_buddypress_author_profile_nav() {
	global $bp, $firmasite_settings;
	
	// Determine user to use
	if ( bp_displayed_user_id() )
		$author_id = bp_displayed_user_id();
	elseif ( bp_loggedin_user_id() )
		$author_id = bp_loggedin_user_id();
	else 
		$author_id = false;

	if(isset($author_id) && !empty($author_id)){
		$args = array( 'author' => $author_id, 'post_type' => 'post' );
		$firmasite_buddypress_author_posts = new WP_Query($args); 
	
		if($firmasite_buddypress_author_posts->found_posts > 0){
	
			bp_core_new_nav_item( array( 
				'name' => __( 'Site', 'firmasite' ), 
				'slug' => 'author', 
				'position' => 20, 
				'show_for_displayed_user' => true, 
				'screen_function' => 'firmasite_buddypress_author_profile_screen', 
				'default_subnav_slug' => 'posts', 
				'item_css_id' => 'author'	
			) );
		
			// Author Page link
			$author_page_link = trailingslashit(bp_core_get_user_domain($author_id) . 'site');
		
			bp_core_new_subnav_item(  array( 
				'name' => __( 'Posts', 'firmasite' ), 
				'slug' => 'posts', 
				'parent_url' => $author_page_link, 
				'parent_slug' => 'author', 
				'screen_function' => 'firmasite_buddypress_author_profile_screen', 
				'position' => 20, 
				'item_css_id' => 'posts' 
			) );
		}
	}
}
function firmasite_buddypress_author_profile_screen(){
	add_action( 'bp_template_content', 'firmasite_buddypress_author_profile_screen_content' );
	bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}
// Add the Author Posts page to the screen
function firmasite_buddypress_author_profile_screen_content() {
	global $firmasite_settings, $bp;
	
	global $wp_query;
	$temp = $wp_query;
	
	// Determine user to use
	if ( bp_displayed_user_id() )
		$author_id = bp_displayed_user_id();
	elseif ( bp_loggedin_user_id() )
		$author_id = bp_loggedin_user_id();

	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args = array( 'author' => $author_id, 'paged' => $paged, 'post_type' => 'post' );
	$wp_query = new WP_Query($args); 
	if($wp_query->have_posts()):
	while($wp_query->have_posts()) : $wp_query->the_post();
        global $post;
		global $more;
		$more = 0;
        get_template_part( 'templates/loop', $post->post_type );
	endwhile; 
	
	// http://codex.wordpress.org/Function_Reference/paginate_links
	$big = 999999999; // need an unlikely integer
	
	$author_pagination =  paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		//'prev_next'    => false,
		'format' => '?paged=%#%',
		'type'         => 'list',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages
	) );
	// Remove first page from pagination
	if (strpos($author_pagination,'/author/posts/') === false) 
	$author_pagination = str_replace( "/author/", "/author/posts/", $author_pagination );
	echo '<div class="clearfix"></div>' . $author_pagination;
	
	endif;
	$wp_query = $temp;
    wp_reset_query(); // reset the query
}


// Changes the blog author links on a buddypress site to link to the author's buddypress member profile.
add_filter( 'author_link', "firmasite_buddypress_fix_author_link",10,3);
function firmasite_buddypress_fix_author_link($link, $author_id, $author_nicename) {
   if (function_exists('bp_core_get_user_domain')) {
      $user_link = trailingslashit(bp_core_get_user_domain($author_id) . 'author');
      return $user_link;
   }
   return $link;
}

// Redirecting author page's to buddypress ones
add_filter('template_redirect','firmasite_buddypress_author_redirect_pages');
function firmasite_buddypress_author_redirect_pages(){
	global $bp, $firmasite_settings;

	if (is_author()){
		$author = get_queried_object();
		$author_page_link = trailingslashit(bp_core_get_user_domain($author->ID) . 'author');

        wp_redirect( $author_page_link, 301 );
        exit();
	}
}

function firmasite_profile_field_custom_change_field_visibility(){ ?>
    <p class="description text-muted"><?php bp_the_profile_field_description(); ?></p>

	<?php if ( bp_current_user_can( 'bp_xprofile_change_field_visibility' ) ) : ?>
        <p class="field-visibility-settings-toggle text-muted" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>">
            <?php printf( __( 'This field can be seen by: <span class="current-visibility-level">%s</span>', "firmasite" ), bp_get_the_profile_field_visibility_level_label() ) ?> <a href="#" class="visibility-toggle-link"><?php _e( 'Change', "firmasite" ); ?></a>
        </p>

        <div class="field-visibility-settings well well-sm" id="field-visibility-settings-<?php bp_the_profile_field_id() ?>">
            <fieldset>
                <legend><?php _e( 'Who can see this field?', "firmasite" ) ?></legend>

                <?php bp_profile_visibility_radio_buttons() ?>

            </fieldset>
            <a class="field-visibility-settings-close" href="#"><?php _e( 'Close', "firmasite" ) ?></a>
        </div>
    <?php else : ?>
        <div class="field-visibility-settings-notoggle text-muted" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>">
            <?php printf( __( 'This field can be seen by: <span class="current-visibility-level">%s</span>', "firmasite" ), bp_get_the_profile_field_visibility_level_label() ) ?>
        </div>
    <?php endif ?>

    <?php do_action( 'bp_custom_profile_edit_fields' ); ?>

<?php }
