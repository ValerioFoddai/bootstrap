<?php do_action( 'bp_before_profile_edit_content' );

if ( bp_has_profile( 'profile_group_id=' . bp_get_current_profile_group_id() ) ) :
	while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

<form action="<?php bp_the_profile_group_edit_form_action(); ?>" method="post" id="profile-edit-form" class="standard-form form-horizontal <?php bp_the_profile_group_slug(); ?>">

	<?php do_action( 'bp_before_profile_field_content' ); ?>

		<h4 ><?php printf( __( "Editing '%s' Profile Group", 'firmasite' ), bp_get_the_profile_group_name() ); ?></h4>

		<ul class="nav nav-tabs">

			<?php bp_profile_group_tabs(); ?>

		</ul>

		<div class="clear"></div>
		<div class="panel panel-default">
        <div class="panel-body">
		<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

			<div<?php bp_field_css_class( 'editfield' ); ?>>

				<?php if ( 'textbox' == bp_get_the_profile_field_type() ) : ?>
                	<div class="form-group">
                        <label class="control-label col-xs-12 col-md-3" for="<?php bp_the_profile_field_input_name(); ?>"><?php bp_the_profile_field_name(); ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'firmasite' ); ?><?php endif; ?></label>
                        <div class="col-xs-12 col-md-9">
                            <input type="text" class="form-control" name="<?php bp_the_profile_field_input_name(); ?>" id="<?php bp_the_profile_field_input_name(); ?>" value="<?php bp_the_profile_field_edit_value(); ?>" <?php if ( bp_get_the_profile_field_is_required() ) : ?>aria-required="true"<?php endif; ?>/>
                            <?php firmasite_profile_field_custom_change_field_visibility(); ?>
                        </div>
                    </div>
				<?php endif; ?>

				<?php if ( 'textarea' == bp_get_the_profile_field_type() ) : ?>
					<div class="form-group">
                        <label class="control-label col-xs-12 col-md-3" for="<?php bp_the_profile_field_input_name(); ?>"><?php bp_the_profile_field_name(); ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'firmasite' ); ?><?php endif; ?></label>
                        <div class="col-xs-12 col-md-9">
                            <?php echo firmasite_wp_editor(bp_get_the_profile_field_edit_value(), bp_get_the_profile_field_input_name(), bp_get_the_profile_field_input_name()); ?>
                            <?php /*<textarea rows="5" cols="40" name="<?php bp_the_profile_field_input_name(); ?>" id="<?php bp_the_profile_field_input_name(); ?>" <?php if ( bp_get_the_profile_field_is_required() ) : ?>aria-required="true"<?php endif; ?>><?php bp_the_profile_field_edit_value(); ?></textarea>*/ ?> 
                            <?php firmasite_profile_field_custom_change_field_visibility(); ?>
                        </div>
                    </div>
				<?php endif; ?>

				<?php if ( 'selectbox' == bp_get_the_profile_field_type() ) : ?>
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-md-3" for="<?php bp_the_profile_field_input_name(); ?>"><?php bp_the_profile_field_name(); ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'firmasite' ); ?><?php endif; ?></label>
                        <div class="col-xs-12 col-md-9">
                            <select name="<?php bp_the_profile_field_input_name(); ?>" id="<?php bp_the_profile_field_input_name(); ?>" <?php if ( bp_get_the_profile_field_is_required() ) : ?>aria-required="true"<?php endif; ?>>
                                <?php bp_the_profile_field_options(); ?>
                            </select>
                            <?php firmasite_profile_field_custom_change_field_visibility(); ?>
                        </div>
                    </div>

				<?php endif; ?>

				<?php if ( 'multiselectbox' == bp_get_the_profile_field_type() ) : ?>
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-md-3" for="<?php bp_the_profile_field_input_name(); ?>"><?php bp_the_profile_field_name(); ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'firmasite' ); ?><?php endif; ?></label>
                        <div class="col-xs-12 col-md-9">
                            <select name="<?php bp_the_profile_field_input_name(); ?>" id="<?php bp_the_profile_field_input_name(); ?>" multiple="multiple" <?php if ( bp_get_the_profile_field_is_required() ) : ?>aria-required="true"<?php endif; ?>>
        
                                <?php bp_the_profile_field_options(); ?>
        
                            </select>
        
                            <?php if ( !bp_get_the_profile_field_is_required() ) : ?>
        
                                <a class="clear-value" href="javascript:clear( '<?php bp_the_profile_field_input_name(); ?>' );"><?php _e( 'Clear', 'firmasite' ); ?></a>
        
                            <?php endif; ?>
                            
                            <?php firmasite_profile_field_custom_change_field_visibility(); ?>
                    	</div>
                    </div>

				<?php endif; ?>

				<?php if ( 'radio' == bp_get_the_profile_field_type() ) : ?>

					<div class="form-group">
						<label class="control-label col-xs-12 col-md-3"><?php bp_the_profile_field_name(); ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'firmasite' ); ?><?php endif; ?></label>
						<div class="col-xs-12 col-md-9">
							<?php bp_the_profile_field_options(); ?>
    
                            <?php if ( !bp_get_the_profile_field_is_required() ) : ?>
    
                                <a class="clear-value" href="javascript:clear( '<?php bp_the_profile_field_input_name(); ?>' );"><?php _e( 'Clear', 'firmasite' ); ?></a>
    
                            <?php endif; ?>
                            
                            <?php firmasite_profile_field_custom_change_field_visibility(); ?>
                        </div>
               		</div>

				<?php endif; ?>

				<?php if ( 'checkbox' == bp_get_the_profile_field_type() ) : ?>

					<div class="form-group">
						<label class="control-label col-xs-12 col-md-3"><?php bp_the_profile_field_name(); ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'firmasite' ); ?><?php endif; ?></label>
						<div class="col-xs-12 col-md-9">
							<?php bp_the_profile_field_options(); ?>
                            <?php firmasite_profile_field_custom_change_field_visibility(); ?>
                        </div>
					</div>

				<?php endif; ?>

				<?php if ( 'datebox' == bp_get_the_profile_field_type() ) : ?>
					<div class="form-group datebox">
						<label class="control-label col-xs-12 col-md-3" for="<?php bp_the_profile_field_input_name(); ?>_day"><?php bp_the_profile_field_name(); ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(required)', 'firmasite' ); ?><?php endif; ?></label>
						<div class="col-xs-12 col-md-9 form-inline">
                        <div class="row">
                        	<div class="col-md-4">
                            <select name="<?php bp_the_profile_field_input_name(); ?>_day" id="<?php bp_the_profile_field_input_name(); ?>_day" <?php if ( bp_get_the_profile_field_is_required() ) : ?>aria-required="true"<?php endif; ?>>
    
                                <?php bp_the_profile_field_options( 'type=day' ); ?>
    
                            </select>
    						</div>
                        	<div class="col-md-4">
                            <select name="<?php bp_the_profile_field_input_name(); ?>_month" id="<?php bp_the_profile_field_input_name(); ?>_month" <?php if ( bp_get_the_profile_field_is_required() ) : ?>aria-required="true"<?php endif; ?>>
    
                                <?php bp_the_profile_field_options( 'type=month' ); ?>
    
                            </select>
                            </div>
                            <div class="col-md-4">
                            <select name="<?php bp_the_profile_field_input_name(); ?>_year" id="<?php bp_the_profile_field_input_name(); ?>_year" <?php if ( bp_get_the_profile_field_is_required() ) : ?>aria-required="true"<?php endif; ?>>
    
                                <?php bp_the_profile_field_options( 'type=year' ); ?>
    
                            </select>
                            </div>
                       </div>
                            <?php firmasite_profile_field_custom_change_field_visibility(); ?>
                        </div>
					</div>
				<?php endif; ?>

			</div>

		<?php endwhile; ?>
        </div>
        </div>

	<?php do_action( 'bp_after_profile_field_content' ); ?>

	<div class="submit">
		<input type="submit" class="btn  btn-primary" name="profile-group-edit-submit" id="profile-group-edit-submit" value="<?php _e( 'Save Changes', 'firmasite' ); ?> " />
	</div>

	<input type="hidden" name="field_ids" id="field_ids" value="<?php bp_the_profile_group_field_ids(); ?>" />

	<?php wp_nonce_field( 'bp_xprofile_edit' ); ?>

</form>

<?php endwhile; endif; ?>

<?php do_action( 'bp_after_profile_edit_content' ); ?>
