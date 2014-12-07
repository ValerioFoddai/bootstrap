<?php global $firmasite_settings;
get_header( 'buddypress' ); ?>

	<div id="primary" class="content-area <?php echo $firmasite_settings["layout_primary_class"]; ?>">
		<div class="padder">

		<?php do_action( 'open_content' ); ?>
        <?php do_action( 'open_page' ); ?>
		<?php do_action( 'bp_before_activation_page' ); ?>

     <div class="panel panel-default">
       <div class="panel-body">
		<div class="page" id="activate-page">

			<?php if ( bp_account_was_activated() ) : ?>

				<h2 class="widgettitle"><?php _e( 'Account Activated', 'firmasite' ); ?></h2>

				<?php do_action( 'bp_before_activate_content' ); ?>

				<?php if ( isset( $_GET['e'] ) ) : ?>
					<p><?php _e( 'Your account was activated successfully! Your account details have been sent to you in a separate email.', 'firmasite' ); ?></p>
				<?php else : ?>
					<p><?php _e( 'Your account was activated successfully! You can now log in with the username and password you provided when you signed up.', 'firmasite' ); ?></p>
				<?php endif; ?>

			<?php else : ?>

				<h3 class="page-header"><?php _e( 'Activate your Account', 'firmasite' ); ?></h3>

				<?php do_action( 'bp_before_activate_content' ); ?>

				<p><?php _e( 'Please provide a valid activation key.', 'firmasite' ); ?></p>

				<form action="" method="get" class="standard-form" id="activation-form">

					<label for="key"><?php _e( 'Activation Key:', 'firmasite' ); ?></label>
					<input type="text" class="form-control" name="key" id="key" value="" />

					<p class="submit">
						<input type="submit" class="btn  btn-primary" name="submit" value="<?php _e( 'Activate', 'firmasite' ); ?>" />
					</p>

				</form>

			<?php endif; ?>

			<?php do_action( 'bp_after_activate_content' ); ?>
			<?php do_action( 'close_page' ); ?>
            <?php do_action( 'close_content' ); ?>

		</div><!-- .page -->
       </div>
     </div>

		<?php do_action( 'bp_after_activation_page' ); ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php get_sidebar( 'buddypress' ); ?>

<?php get_footer( 'buddypress' ); ?>
