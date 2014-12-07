<?php

/**
 * BuddyPress - Activity Stream (Single Item)
 *
 * This template is used by activity-loop.php and AJAX functions to show
 * each activity.
 *
 * @package BuddyPress
 * @subpackage bp-default
 */

?>

<?php do_action( 'bp_before_activity_entry' ); ?>

<li class="<?php bp_activity_css_class(); ?>" id="activity-<?php bp_activity_id(); ?>">
	<?php if ( bp_activity_has_content() ) { ?>
	<div class="col-xs-12 col-md-4 pull-left text-muted fs-content-thumbnail">
    <?php } else { ?>
	<div class="col-xs-12 text-muted">
    <?php } ?>
        <div class="activity-avatar">
            <a href="<?php bp_activity_user_link(); ?>">
    
                <?php bp_activity_avatar(); ?>
    
            </a>
        </div>
        <div class="activity-header">
    
            <?php bp_activity_action(); ?>
    
        </div>
    
        <?php if ( 'activity_comment' == bp_get_activity_type() ) : ?>
    
            <div class="activity-inreplyto">
                <strong><?php _e( 'In reply to: ', 'firmasite' ); ?></strong><?php bp_activity_parent_content(); ?> <a href="<?php bp_activity_thread_permalink(); ?>" class="view" title="<?php _e( 'View Thread / Permalink', 'firmasite' ); ?>"><?php _e( 'View', 'firmasite' ); ?></a>
            </div>
    
        <?php endif; ?>
    </div>

	<div class="activity-content">


		<?php if ( bp_activity_has_content() ) : ?>

			<div class="activity-inner fs-have-thumbnail">

				<?php bp_activity_content_body(); ?>

			</div>

		<?php endif; ?>

		<?php do_action( 'bp_activity_entry_content' ); ?>

		<?php if ( is_user_logged_in() ) : ?>

			<div class="activity-meta pull-right">

				<?php if ( bp_activity_can_comment() ) : ?>

					<a href="<?php bp_get_activity_comment_link(); ?>" class="button btn btn-default btn-xs acomment-reply bp-primary-action" id="acomment-comment-<?php bp_activity_id(); ?>"><?php printf( __( 'Comment <span>%s</span>', 'firmasite' ), bp_activity_get_comment_count() ); ?></a>

				<?php endif; ?>

				<?php if ( bp_activity_can_favorite() ) : ?>

					<?php if ( !bp_get_activity_is_favorite() ) : ?>

						<a href="<?php bp_activity_favorite_link(); ?>" class="button btn btn-default btn-xs fav bp-secondary-action" title="<?php esc_attr_e( 'Mark as Favorite', 'firmasite' ); ?>"><?php _e( 'Favorite', 'firmasite' ); ?></a>

					<?php else : ?>

						<a href="<?php bp_activity_unfavorite_link(); ?>" class="button btn btn-default btn-xs unfav bp-secondary-action" title="<?php esc_attr_e( 'Remove Favorite', 'firmasite' ); ?>"><?php _e( 'Remove Favorite', 'firmasite' ); ?></a>

					<?php endif; ?>

				<?php endif; ?>

				<?php if ( bp_activity_user_can_delete() ) bp_activity_delete_link(); ?>

				<?php do_action( 'bp_activity_entry_meta' ); ?>

			</div>

		<?php endif; ?>

	</div>

	<?php do_action( 'bp_before_activity_entry_comments' ); ?>

	<?php if ( ( is_user_logged_in() && bp_activity_can_comment() ) || bp_activity_get_comment_count() ) : ?>

		<div class="activity-comments">

			<?php bp_activity_comments(); ?>

			<?php if ( is_user_logged_in() ) : ?>

				<form action="<?php bp_activity_comment_form_action(); ?>" method="post" id="ac-form-<?php bp_activity_id(); ?>" class="ac-form"<?php bp_activity_comment_form_nojs_display(); ?>>
					<div class="ac-reply-content">
						<div class="ac-textarea">
							<textarea id="ac-input-<?php bp_activity_id(); ?>" class="ac-input" name="ac_input_<?php bp_activity_id(); ?>"></textarea>
						</div>
						<input type="submit" class="btn  btn-primary btn-sm" name="ac_form_submit" value="<?php _e( 'Post', 'firmasite' ); ?>" /> &nbsp; <?php _e( 'or press esc to cancel.', 'firmasite' ); ?>
						<input type="hidden" name="comment_form_id" value="<?php bp_activity_id(); ?>" />
					</div>

					<?php do_action( 'bp_activity_entry_comments' ); ?>

					<?php wp_nonce_field( 'new_activity_comment', '_wpnonce_new_activity_comment' ); ?>

				</form>

			<?php endif; ?>

		</div>

	<?php endif; ?>

	<?php do_action( 'bp_after_activity_entry_comments' ); ?>

</li>

<?php do_action( 'bp_after_activity_entry' ); ?>
