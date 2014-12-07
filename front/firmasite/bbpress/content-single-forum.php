<?php

/**
 * Single Topic Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<div id="bbpress-forums">

	<?php bbp_breadcrumb(); ?>

	<ul class="pager">
		<li class="next">
		<?php bbp_forum_subscription_link(); ?>
		</li>
	</ul>

	<?php do_action( 'bbp_template_before_single_forum' ); ?>

    <?php ob_start(); ?>

	<?php if ( post_password_required() ) : ?>

		<?php bbp_get_template_part( 'form', 'protected' ); ?>

	<?php else : ?>

		<?php //bbp_single_forum_description(); ?>
        
        
        <div class="bbp-forum-content panel panel-default"><div class="panel-body"><?php bbp_forum_content(); ?></div></div>

		<?php if ( bbp_get_forum_subforum_count() && bbp_has_forums() ) : ?>

			<?php bbp_get_template_part( 'loop', 'forums' ); ?>

		<?php endif; ?>

		<?php if ( !bbp_is_forum_category() && bbp_has_topics() ) : ?>

			<?php //bbp_get_template_part( 'pagination', 'topics'    ); ?>

			<?php bbp_get_template_part( 'loop',       'topics'    ); ?>

			<?php bbp_get_template_part( 'pagination', 'topics'    ); ?>

			<?php bbp_get_template_part( 'form',       'topic'     ); ?>

		<?php elseif ( !bbp_is_forum_category() ) : ?>

			<?php bbp_get_template_part( 'feedback',   'no-topics' ); ?>

			<?php bbp_get_template_part( 'form',       'topic'     ); ?>

		<?php endif; ?>
        

	<?php endif; ?>
    
	<?php   $forum_content = ob_get_contents(); 
            ob_get_clean();
            
            echo apply_filters("firmasite_forum_content", $forum_content);
    ?>

	<?php do_action( 'bbp_template_after_single_forum' ); ?>

</div>
