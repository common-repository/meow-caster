<?php
/**
 * Form main configuration
 */


if ( ! isset( $form_input ) ) {
	$form_input = array();
}
if ( ! isset( $mc_debug ) ) {
	$mc_debug = false;
}
?>
    <div class="mcss-wrapper mcss-form mcss-main-config">
        <main>
		    <?php
		$meow_page_title = __( 'Settings', MEOW_CASTER_SLUG );
		include 'header.php';
		?>
            <form action="#" method="post" enctype="multipart/form-data">
				<?php wp_nonce_field( MEOW_CASTER_SLUG_ . '_base_settings', MEOW_CASTER_SLUG_ . '_nonce' ); ?>
                
                <div class="mcss-config-container">
                    <div class="mcss-tabs">
                        <div class="mcss-tabs-side">
                            <ul>
                                <li><a href="#Auth"><?php _e( 'Auth', MEOW_CASTER_SLUG ); ?></a></li>
                                <li><a href="#Youtube"><?php _e( 'YouTube settings', MEOW_CASTER_SLUG ); ?></a></li>
                                <li><a href="#YoutubeLivePrev"><?php _e( 'YouTube Player Preview', MEOW_CASTER_SLUG ); ?></a>
                                </li>
                                <li><a href="#UserCap"><?php _e( 'Capabilities', MEOW_CASTER_SLUG ); ?></a></li>
                                <li><a href="#Privacy"><?php _e( 'Privacy settings', MEOW_CASTER_SLUG ); ?></a>
                                </li>
	                            <?php /*
			                    // @TODO v2.0 with vimeo support
			                    if ( isset( $form_input['bs']['vimeo-public'] ) && $form_input['bs']['vimeo-public'] == 'on' ): ?>
                                    <li><a href="#Vimeo"><?php _e( 'Vimeo settings', MEOW_CASTER_SLUG ); ?></a></li>
			                    <?php endif; */ ?>
                            </ul>
                            <div class="sticky-side">
                                <div class="mcss-submission">
                                    <button id="mcss-form-submit" class="mcss-button-good mcss-button-validation" type="submit"
                                            value="update_config"
                                            name="mcss-form-config">
					                    <?php echo __( 'Save settings', MEOW_CASTER_SLUG ); ?>
                                    </button>
                                </div>
                                <aside><?php /* link or ads for the premium version */ ?></aside>
                            </div>
                        </div>
                        <div>
                            <section class="mcss-config-section">
			                    <?php
			                    include 'form-settings-auth.php';
			                    ?>
                            </section>
                        </div>
	                    <?php ?>
                            <div>
                                <section class="mcss-config-section">
									<?php
									include 'form-settings-youtube.php';
									?>
                                </section>
                            </div>
                        <div>
                            <section class="mcss-config-section">
			                    <?php
			                    include 'form-settings-youtube-livepreview.php';
			                    ?>
                            </section>
                        </div>
                        <div>
                            <section class="mcss-config-section">
			                    <?php
			                    include 'form-settings-user-cap.php';
			                    ?>
                            </section>
                        </div>
                        <div>
                            <section class="mcss-config-section">
			                    <?php
			                    include 'form-settings-privacy.php';
			                    ?>
                            </section>
                        </div>
	                    <?php
						/*
						if ( isset( $form_input['bs']['vimeo-public'] ) && $form_input['bs']['vimeo-public'] == 'on' ):
							?>
                            <div>
                                <section class="mcss-config-section">
									<?php
									include 'form-settings-vimeo.php'
									?>
                                </section>
                            </div>
						<?php
						endif;
                                */
						?>
            </form>
        </main>
    </div>
<?php
//EOF