<?php

/**
 * Replies Loop - Single Reply
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
<?php ob_start(); ?>
<div class="bbp-reply-header">

	<div class="bbp-meta">

		<?php if ( bbp_is_user_keymaster() ) : ?>

			<?php do_action( 'bbp_theme_before_reply_author_admin_details' ); ?>

			<div class="bbp-reply-ip hidden-xs"><?php bbp_author_ip( bbp_get_reply_id() ); ?> &nbsp;</div>

			<?php do_action( 'bbp_theme_after_reply_author_admin_details' ); ?>

		<?php endif; ?>

		<a href="<?php bbp_reply_url(); ?>" title="<?php bbp_reply_title(); ?>" class="bbp-reply-permalink">#<?php bbp_reply_id(); ?></a>

		<span class="bbp-reply-post-date"><?php bbp_reply_post_date(); ?></span>

		<?php if ( bbp_is_single_user_replies() ) : ?>

			<span class="bbp-header">
				<?php _e( 'in reply to: ', 'firmasite' ); ?>
				<a class="bbp-topic-permalink" href="<?php bbp_topic_permalink( bbp_get_reply_topic_id() ); ?>"><?php bbp_topic_title( bbp_get_reply_topic_id() ); ?></a>
			</span>

		<?php endif; ?>

		<div>
		<?php do_action( 'bbp_theme_before_reply_admin_links' ); ?>

		<?php bbp_reply_admin_links(); ?>

		<?php do_action( 'bbp_theme_after_reply_admin_links' ); ?>
        </div>

	</div><!-- .bbp-meta -->

</div><!-- .bbp-reply-header -->
<?php $reply_manage = ob_get_contents(); ob_end_clean(); ?>

<div id="post-<?php bbp_reply_id(); ?>" <?php bbp_reply_class(bbp_get_reply_id(), array("modal firmasite-modal-static")); ?>>
<div class="modal-dialog">
<div class="modal-content">
<div class="<?php echo firmasite_social_bbp_get_reply_class_modal();?> clearfix">
	<div class="col-xs-4 col-md-3 pull-left bbp-reply-author text-muted fs-content-thumbnail">

		<?php do_action( 'bbp_theme_before_reply_author_details' ); ?>

		<?php bbp_reply_author_link( array( 'sep' => '<div class=clearfix></div>', 'show_role' => true ) ); ?>

		<a href="#<?php bbp_reply_id(); ?>" class="" data-container="body" data-toggle="popover" data-rel="popover" data-html="true" data-placement="right" data-original-title="" data-content="<?php echo esc_attr($reply_manage); ?>">
            <span class="edit-link text-muted"><span class="icon-cog"></span> <?php _e( 'Details', 'firmasite' );?></span>
         </a>

		 <?php if ( class_exists( 'BBP_Walker_Reply' ) && bbp_thread_replies() ) : ?>
         <div class="pull-left text-muted">
            <?php bbp_reply_to_link(array('id' => bbp_get_reply_id(), 'link_before' => '<span class="icon-reply"></span> ', 'link_after' => ' &nbsp; ' )); ?>
         </div> 
		<?php endif; ?>
		 
		<?php do_action( 'bbp_theme_after_reply_author_details' ); ?>

	</div><!-- .bbp-reply-author -->

	<div class="bbp-reply-content fs-have-thumbnail">

		<?php do_action( 'bbp_theme_before_reply_content' ); ?>

		<?php bbp_reply_content(); ?>

		<?php do_action( 'bbp_theme_after_reply_content' ); ?>
	</div><!-- .bbp-reply-content -->
</div>
</div>
</div>
</div><!-- #post-<?php bbp_reply_id(); ?> -->
