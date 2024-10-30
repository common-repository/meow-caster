<?php
/**
 * Template for Shortcode youtube player
 *
 */


if ( $consent === false && $consent_status === 'on') :
	?>
    <div class="mcss-player-consent-container mcss-player-consent-theme-<?php echo $consent_theme; ?>"
         data-widget="<?php echo $widget; ?>"
         data-id="<?php echo $videoID; ?>"
		<?php if ( $direct_embed ) { ?>
            data-direct=1
		<?php } ?>
         data-type="player"
         data-url="<?php echo $url . $param; ?>">
        <div class="mcss-player-consent-message">
            <p><?php _e( 'For watching this video, you have to accept to send information to ', MEOW_CASTER_SLUG ); ?>
                <b>Youtube</b>&nbsp;(<a
                        href="https://policies.google.com/privacy"
                        target="_blank"><?php _e( 'YouTube privacy policy', MEOW_CASTER_SLUG ); ?></a>)</p>
			<?php if ( $cookie === 'both' ): ?>
                <p><?php _e( 'You can access to <b>Youtube</b> with or without cookie as you pleased', MEOW_CASTER_SLUG ); ?></p>
			<?php endif; ?>
            <p><?php echo sprintf(
					_n( 'Your consent will be store in a cookie for this unique purpose for  %s day',
						'Your consent will be store in a cookie for this unique purpose for %s days', $consent_duration, MEOW_CASTER_SLUG )
					, $consent_duration );
				?>
            </p>
        </div>
        <div class="mcss-player-consent-btn-container">
            <?php if ( in_array( $cookie, ['both', 'cookie-only'] ) ):?>
            <button value="with-cookie" data-duration="<?php echo $consent_duration; ?>">Accept with cookie</button>
            <?php endif;
            if ( in_array( $cookie, ['both', 'nocookie-only'] ) ):?>
            <button value="without-cookie" data-duration="<?php echo $consent_duration; ?>">Accept without cookie
            </button>
            <?php endif; ?>
        </div>

    </div>
<?php else: ?>

	<?php if ( ! $direct_embed ) { ?>
        <div class="mcss-reframe mcss-embed-youtube" data-widget="<?php echo $widget; ?>"
             data-id="<?php echo $videoID; ?>"
             data-type="player" data-url="<?php echo $url . $param; ?>"></div>
	<?php } else {
		?>
        <iframe class="mcss-reframe mcss-embed-direct" width="854" height="480"
                data-widget="<?php echo $widget; ?>" src="<?php echo $url . $param; ?>" frameborder="0"
                allow="autoplay; encrypted-media" allowfullscreen></iframe>
	<?php }
endif;