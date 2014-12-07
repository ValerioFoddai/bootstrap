<?php

/**
 * Search Loop - Single Reply
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
<?php ob_start(); ?>
<div class="bbp-reply-header">

	<div class="bbp-meta">

		<span class="bbp-reply-post-date"><?php bbp_reply_post_date(); ?></span>

		<a href="<?php bbp_reply_url(); ?>" title="<?php bbp_reply_title(); ?>" class="bbp-reply-permalink">#<?php bbp_reply_id(); ?></a>

		<?php do_action( 'bbp_theme_before_reply_admin_links' ); ?>

		<?php bbp_reply_admin_links(); ?>

		<?php do_action( 'bbp_theme_after_reply_admin_links' ); ?>

	</div><!-- .bbp-meta -->

</div><!-- .bbp-reply-header -->
<?php $reply_manage = ob_get_contents(); ob_end_clean(); ?>

<div id="post-<?php bbp_reply_id(); ?>" <?php bbp_reply_class(bbp_get_reply_id(), array("modal firmasite-modal-static")); ?>>
<div class="modal-dialog">
<div class="modal-content">
<?php 
global $firmasite_bbpress_count;
	$firmasite_bbpress_count++;
	$search_class = ( (int) $firmasite_bbpress_count % 2 ) ? ' panel-footer' : ' panel-body';
?>
<div class="<?php echo firmasite_social_bbp_get_reply_class_modal(bbp_reply_id()). $search_class; ?>">
	<h5 class="bbp-search-replies-result-meta text-muted">

		<a href="<?php bbp_reply_url(); ?>" class="bbp-reply-permalink">#<?php bbp_reply_id(); ?></a>
		<?php _e( 'In reply to: ', 'firmasite' ); ?>
		<a class="bbp-topic-permalink" href="<?php bbp_topic_permalink( bbp_get_reply_topic_id() ); ?>"><?php bbp_topic_title( bbp_get_reply_topic_id() ); ?></a>

	</h5><!-- .bbp-search-replies-result-meta -->
	<hr />
	<div class="col-xs-4 col-md-3 pull-left bbp-reply-author text-muted clearfix">

		<?php do_action( 'bbp_theme_before_reply_author_details' ); ?>

		<?php bbp_reply_author_link( array( 'sep' => '', 'show_role' => true ) ); ?>

		<?php if ( bbp_is_user_keymaster() ) : ?>

			<?php do_action( 'bbp_theme_before_reply_author_admin_details' ); ?>

			<div class="bbp-reply-ip hidden-xs"><?php bbp_author_ip( bbp_get_reply_id() ); ?></div>

			<?php do_action( 'bbp_theme_after_reply_author_admin_details' ); ?>

		<?php endif; ?>
		<a href="#<?php bbp_reply_id(); ?>" class="" data-container="body" data-toggle="popover" data-rel="popover" data-html="true" data-placement="right" data-original-title="" data-content="<?php echo esc_attr($reply_manage); ?>">
			<span class="edit-link text-muted"><span class="icon-cog"></span> <?php _e( 'Details', 'firmasite' );?></span>
		 </a>
		<?php do_action( 'bbp_theme_after_reply_author_details' ); ?>

	</div><!-- .bbp-reply-author -->

	<div class="bbp-reply-content">

		<?php do_action( 'bbp_theme_before_reply_content' ); ?>

		<?php bbp_reply_content(); ?>

		<?php do_action( 'bbp_theme_after_reply_content' ); ?>

		<div class="clearfix"></div>
	</div><!-- .bbp-reply-content -->
</div>
</div>
</div>
</div><!-- #post-<?php bbp_reply_id(); ?> -->
