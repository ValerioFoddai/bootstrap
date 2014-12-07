<?php

/**
 * Search Loop - Single Topic
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
<?php 
global $firmasite_bbpress_count;
	$firmasite_bbpress_count++;
	$search_class = ( (int) $firmasite_bbpress_count % 2 ) ? ' panel-footer' : ' panel-body';
?>
	<div class="bbp-body modal firmasite-modal-static">
   		<div class="modal-dialog">
        <div class="modal-content">
<div id="topic-<?php bbp_topic_id(); ?>" <?php bbp_topic_class(); echo $search_class; ?>>
  <div class="pull-left">
	<div class="bbp-topic-title">
		<?php do_action( 'bbp_theme_before_topic_title' ); ?>

		<a class="bbp-topic-permalink lead" href="<?php bbp_topic_permalink(); ?>" title="<?php bbp_topic_title(); ?>"><?php bbp_topic_title(); ?></a>

		<?php do_action( 'bbp_theme_after_topic_title' ); ?>

		<div class="bbp-topic-title-meta">

			<?php if ( function_exists( 'bbp_is_forum_group_forum' ) && bbp_is_forum_group_forum( bbp_get_topic_forum_id() ) ) : ?>

				<?php _e( 'in group forum ', 'firmasite' ); ?>

			<?php else : ?>

				<?php _e( 'in forum ', 'firmasite' ); ?>

			<?php endif; ?>

			<a href="<?php bbp_forum_permalink( bbp_get_topic_forum_id() ); ?>"><?php bbp_forum_title( bbp_get_topic_forum_id() ); ?></a>

		</div><!-- .bbp-topic-title-meta -->
	</div>

		<?php echo firmasite_social_bbp_get_topic_pagination(); ?>
		<?php bbp_topic_row_actions(); ?>
  </div>
  <div class="pull-right text-muted">
    <small>
		<?php do_action( 'bbp_theme_before_topic_meta' ); ?>

		<div class="bbp-topic-meta clearfix">

			<div><span class="bbp-topic-reply-count badge"><?php bbp_show_lead_topic() ? bbp_topic_reply_count() : bbp_topic_post_count(); ?></span> <?php bbp_show_lead_topic() ? _e( 'Replies', 'firmasite' ) : _e( 'Posts', 'firmasite' ); ?></div>
			
			<?php do_action( 'bbp_theme_before_topic_started_by' ); ?>

			<div class="bbp-topic-started-by clearfix">&nbsp;<?php printf( __( 'Started by: %1$s', 'firmasite' ), bbp_get_topic_author_link( array( 'size' => '14' ) ) ); ?></div>

			<?php do_action( 'bbp_theme_after_topic_started_by' ); ?>

			<div class="bbp-topic-freshness clearfix">
				 &nbsp;<?php _e( 'Freshness', 'firmasite' ); ?>:
				 
				<?php do_action( 'bbp_theme_before_topic_freshness_author' ); ?>

				<span class="bbp-topic-freshness-author"><?php bbp_author_link( array( 'post_id' => bbp_get_topic_last_active_id(), 'size' => 14 ) ); ?></span>

				<?php do_action( 'bbp_theme_after_topic_freshness_author' ); ?>

				<?php do_action( 'bbp_theme_before_topic_freshness_link' ); ?>
		
				<?php echo firmasite_social_bbp_get_topic_freshness_link(); ?>
		
				<?php do_action( 'bbp_theme_after_topic_freshness_link' ); ?>
		
			</div>
			
			<?php if ( !bbp_is_single_forum() || ( bbp_get_topic_forum_id() !== bbp_get_forum_id() ) ) : ?>

				<?php do_action( 'bbp_theme_before_topic_started_in' ); ?>

				<div class="bbp-topic-started-in"><?php printf( __( 'in: <a href="%1$s">%2$s</a>', 'firmasite' ), bbp_get_forum_permalink( bbp_get_topic_forum_id() ), bbp_get_forum_title( bbp_get_topic_forum_id() ) ); ?></div>

				<?php do_action( 'bbp_theme_after_topic_started_in' ); ?>

			<?php endif; ?>



		</div>

		<?php do_action( 'bbp_theme_after_topic_meta' ); ?>

  </small></div>
	<div class="clearfix"></div>
	<hr />
	<div class="bbp-topic-content">

		<?php do_action( 'bbp_theme_before_topic_content' ); ?>

		<?php bbp_topic_content(); ?>

		<?php do_action( 'bbp_theme_after_topic_content' ); ?>

	</div><!-- .bbp-topic-content -->

</div><!-- #topic-<?php bbp_topic_id(); ?> -->

</div>
</div>
</div>