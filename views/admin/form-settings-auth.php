<h3 id="Auth"><?php use function MeowCaster\get_the_yt_channel_banner;

	_e( 'Authentification', MEOW_CASTER_SLUG ); ?></h3>
<p><?php _e( 'In order to use each feature of the plugin, you need to let this plugin access to your Youtube Account.', MEOW_CASTER_SLUG ); ?></p>
<p><?php _e( 'All data will be used in the plugin and won\'t be shared with a third party.', MEOW_CASTER_SLUG ); ?></p>
<div class="mcss-auth-container">
    <h4>Youtube</h4>
	<?php if ( $mc_youtube_action == "auth" ): ?>

		<?php if ( ! isset( $mc_youtube_authlink ) || $mc_youtube_authlink == null ): ?>
            <p>
                <label for="field-auth-youtube-creds">
                    <h5><?php _e( 'Step 1&nbsp;:&nbsp; Upload the Google credentials file', MEOW_CASTER_SLUG ); ?></h5>
                </label>
            </p>
            <div class="mcss-config-howto">
                <p><?php _e( 'How to get Google credentials file (in 2 minutes)', MEOW_CASTER_SLUG ); ?> : <a
                            href="https://www.youtube.com/embed/d9PXvwE8YuM"><?php _e( 'link to the video', MEOW_CASTER_SLUG ); ?></a></p>
                <div>
                    <iframe width="854" height="480"
                            src="https://www.youtube.com/embed/d9PXvwE8YuM"
                            frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>
                <div>
                    <ul class="mcss-config-howto-txt">
                        <li>
							<?php _e( 'Connect to ', MEOW_CASTER_SLUG ); ?>
                            <a href="https://console.cloud.google.com/">Google
                                Console</a>
                        </li>
                        <li><?php _e( 'Create a project', MEOW_CASTER_SLUG ); ?></li>
                        <li><?php _e( 'Activate the following libraries : <b>YouTube Data API , YouTube Reporting API and YouTube Analytics API</b>', MEOW_CASTER_SLUG ); ?></li>
                        <li><?php _e( 'Create a OAuth consent screen', MEOW_CASTER_SLUG ); ?>
                            <ul>
                                <li><?php _e( 'Fill in the project display name', MEOW_CASTER_SLUG ); ?></li>
                                <li><?php _e( 'Add in scope all youtube\'s scopes', MEOW_CASTER_SLUG ); ?></li>
                                <li><?php _e( 'Save', MEOW_CASTER_SLUG ); ?></li>
                            </ul>
                        </li>
                        <li><?php _e( 'Create credentials  ', MEOW_CASTER_SLUG ); ?>
                            <ul>
                                <li><?php _e( 'Create credential "OAuth2.0 Client ID"', MEOW_CASTER_SLUG ); ?></li>
                                <li><?php _e( 'Choose "Other"', MEOW_CASTER_SLUG ); ?></li>
                            </ul>
                        </li>
                        <li><?php _e( 'Download the credentials file and upload it here.', MEOW_CASTER_SLUG ); ?></li>
                    </ul>
                    <p>
                        <input id="field-auth-youtube-creds"
                               type="file"
                               name="mc-main-settings[as][youtube-creds-file]"
                               accept=".json"
                        />
                        <button id="youtube-check-creds"
                                name="mc-main-settings[as][youtube-creds-file-btn]"
                                value="submit_yt_creds"
                                type="submit"><?php _e( 'Upload credentials', MEOW_CASTER_SLUG ); ?></button>
                    </p>
                </div>
            </div>
            <p>
            <h5><?php _e( 'Step 2&nbsp;:&nbsp; Enter your Google token to use YouTube', MEOW_CASTER_SLUG ); ?></h5>
            </p>
		<?php else: ?>
            <p><?php
				_e( 'Step 1&nbsp;:&nbsp; Upload the Google credentials file', MEOW_CASTER_SLUG );
				_e( '&nbsp;:&nbsp; Done!', MEOW_CASTER_SLUG );
				?></p>
            <p>
                <label for="field-auth-youtube-token">
					<?php _e( 'Step 2&nbsp;:&nbsp; Enter your Google token to use YouTube', MEOW_CASTER_SLUG ); ?>
                    <a class="mcss-popup mcss-auth-youtube-authorize"
                       href="<?php echo $mc_youtube_authlink; ?>"><?php _e( 'Connect to Google in order to get your token', MEOW_CASTER_SLUG ); ?></a>
                </label>
            </p>
			<?php
			$youtube_token       = ( isset( $form_input['bs']['youtube-token'] ) ) ? $form_input['bs']['youtube-token'] : '';
			$youtube_error_class = ( isset( $form_input['bs']['error']['youtube-token'] ) ) ? 'mcss-field-error' : '';
			?>
            <input name="mc-main-settings[as][youtube-token]" type="text"
                   id="field-auth-youtube-token"
                   class="mcss-auth-youtube-token custom-input-text <?php echo $youtube_error_class; ?>"
                   value="<?php echo $youtube_token; ?>"
				<?php echo ( $mc_youtube_authlink == null ) ? 'disabled' : ''; ?>
            />
            <button id="youtube-check-token"
                    name="mc-main-settings[as][youtube-check-token]"
                    value="submit_token"
                    type="submit"><?php _e( 'Activate Youtube token', MEOW_CASTER_SLUG ); ?></button>
            </p>
		<?php endif; ?>

	<?php elseif ( $mc_youtube_action == "revoke" ): ?>

		<?php
		echo get_the_yt_channel_banner();
		?>
        <p>

            <button id="youtube-revoke-token"
                    name="mc-main-settings[as][youtube-revoke-token]"
                    value="revoke_youtube_token"
            ><?php _e( 'Revoke Youtube token', MEOW_CASTER_SLUG ); ?></button>
        </p>
	<?php endif; ?>
</div>