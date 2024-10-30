<?php
/**
 * Template for Shortcode youtube player
 *
 */

// Template URL


if ( $consent === false && $consent_status === 'on' && $is_live && $view === 'embed'):
	?>
    <div class="mcss-player-consent-container mcss-player-consent-theme-<?php echo $consent_theme; ?>"
         data-widget="<?php echo $widget; ?>"
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
			<?php if ( in_array( $cookie, [ 'both', 'cookie-only' ] ) ): ?>
                <button value="with-cookie" data-duration="<?php echo $consent_duration; ?>">Accept with cookie</button>
			<?php endif;
			if ( in_array( $cookie, [ 'both', 'nocookie-only' ] ) ):?>
                <button value="without-cookie" data-duration="<?php echo $consent_duration; ?>">Accept without cookie
                </button>
			<?php endif; ?>
        </div>

    </div>
<?php elseif ( $view === 'bar' ):

    if ( $consent === false && $consent_status === 'on') {
		$target         = 'target="_blank"';

		$btn_yt_title = sprintf( __('Subscribe to %s', MEOW_CASTER_SLUG), $channelInfo['snippet']['title']);
		$button_yt = '<a href="'. $url. 'channel/'. $channelInfo['id'].'?sub_confirmation=1" class="mcss-btn-youtube" title="'.$btn_yt_title.'" '.$target.'> Subscribe </a>';

	} else {
		$target         = '';
		$button_yt_theme = ($theme === 'dark')? 'dark' : 'default';
		$button_yt = '<div class="g-ytsubscribe" data-channelid="'.$channelInfo['id'].'" data-layout="default" data-theme="'.$button_yt_theme.'" data-count="default"></div>';
	}


    ?>
    <div class="mcss-live-bar mcss-live-bar-<?php echo $theme; ?> <?php echo ($is_live)? 'mcss-live-on': 'mcss-live-off';?>">
        <div class="mcss-live-bar-status">
            <div class="mcss-live-on-status">
                <span class="mcss-air">LIVE</span>
                <span class="mcss-visually-hidden"><?php _e( 'Live is on air!', MEOW_CASTER_SLUG ); ?></span>
            </div>
            <div class="mcss-live-off-status">
                <span class="mcss-visually-hidden"><?php _e( 'No live now!', MEOW_CASTER_SLUG ); ?></span>
            </div>
        </div>
        <div class="mcss-live-bar-info">

            <?php echo $channelInfo['snippet']['title']; ?>
        </div>
        <div class="mcss-live-bar-action">
	        <?php if( $is_live ){ ?>
                <a href="<?php echo $url.'?watch='. $videoId;?>" class="mcss-btn-youtube" title="<?php _e('Watch the stream',MEOW_CASTER_SLUG);?>" target="_blank"> <?php _e('Watch',MEOW_CASTER_SLUG);?></a>
	        <?php }
	        echo $button_yt ;?>
        </div>
    </div>
<?php elseif ( $consent && $consent_status === 'on' && $is_live && $view === 'embed'): ?>
	<?php if ( ! $direct_embed ) { ?>
        <div class="mcss-reframe mcss-embed-youtube" data-widget="<?php echo $widget; ?>"
             data-type="player" data-url="<?php echo $url . $param; ?>"></div>
	<?php } else { ?>
        <iframe class="mcss-reframe mcss-embed-direct" width="854" height="480"
                data-widget="<?php echo $widget; ?>" src="<?php echo $url . $param; ?>" frameborder="0"
                allow="autoplay; encrypted-media" allowfullscreen></iframe>
	<?php }
else : ;
?>
    <div class="mcss-live-msg mcss-live-msg-<?php echo $theme; ?>">
        <?php echo $noLiveMsg; ?>
    </div>
<?php endif;