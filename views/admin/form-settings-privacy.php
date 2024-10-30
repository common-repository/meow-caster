<?php

?>

<h3 id="Privacy"><?php _e( 'Privacy settings', MEOW_CASTER_SLUG ); ?></h3>
<div class="mcss-privacy-container">
    
    <h4>
		<?php echo __( 'Activate the privacy', MEOW_CASTER_SLUG ); ?>
    </h4>
    <div class="field-container mcss-container">
        <p class="mcss-hint"><?php echo __( 'If you want to manage yourself RGPD/GDPR compliance, keep this setting disabled.', MEOW_CASTER_SLUG ); ?></p>
        <div class="can-toggle field-container">
            <input class="mcss-yts-consent-status" id="field-yts-consent-status"
                   name="mc-main-settings[yts][consent-status]"
                   type="checkbox" <?php echo ( isset( $yts['consent-status'] ) && $yts['consent-status'] === 'on' ) ? 'checked' : ''; ?>>
            <label for="field-yts-consent-status">
                <div class="can-toggle__switch"
                     data-checked="<?php _e( 'Enable', MEOW_CASTER_SLUG ); ?>"
                     data-unchecked="<?php _e( 'Disable', MEOW_CASTER_SLUG ); ?>"></div>
                <div class="can-toggle__label-text"><?php _e( 'Activate the consent for loading YouTube contents', MEOW_CASTER_SLUG ); ?></div>
            </label>
        </div>
    </div>
    <h4>
		<?php echo __( 'Visitor\'s Privacy', MEOW_CASTER_SLUG ); ?>
    </h4>
    <div class="field-container mcss-container">
        <p class="mcss-hint"><?php echo __( 'Choose how long time the cookie has to stay active before asking again for consent.', MEOW_CASTER_SLUG ); ?></p>
        <label class="custom-select-inline-label" for="field-yts-consent">
			<?php echo __( 'Youtube RGPD/GDPR consent lifespan', MEOW_CASTER_SLUG ); ?>
        </label>
        <div class="custom-select  mcss-yts-consent">
	<select id="field-yts-consent" name="mc-main-settings[yts][consent]">
        <option value="0.003472222" <?php if( $yts['consent'] ==="0.003472222"){ echo "selected"; } ?>><?php _e( '5 minutes ( for testing purpose )', MEOW_CASTER_SLUG ); ?></option>
        <option value="0.5" <?php if( $yts['consent'] ==="0.5"){ echo "selected"; } ?>><?php _e( '12 hours', MEOW_CASTER_SLUG ); ?></option>
        <option value="1" <?php if( $yts['consent'] ==="1"){ echo "selected"; } ?>><?php _e( '1 day', MEOW_CASTER_SLUG ); ?></option>
        <option value="3" <?php if( $yts['consent'] ==="3"){ echo "selected"; } ?>><?php _e( '3 days', MEOW_CASTER_SLUG ); ?></option>
        <option value="5" <?php if( $yts['consent'] ==="5"){ echo "selected"; } ?>><?php _e( '5 days', MEOW_CASTER_SLUG ); ?></option>
        <option value="7" <?php if( $yts['consent'] ==="7"){ echo "selected"; } ?>><?php _e( '1 week', MEOW_CASTER_SLUG ); ?></option>
        <option value="14" <?php if( $yts['consent'] ==="14"){ echo "selected"; } ?>><?php _e( '2 weeks', MEOW_CASTER_SLUG ); ?></option>
        <option value="31" <?php if( $yts['consent'] ==="31"){ echo "selected"; } ?>><?php _e( '1 Month ( 31 days )', MEOW_CASTER_SLUG ); ?></option>
    </select>
</div>

        <div>

            <label class="custom-select-inline-label" for="field-yts-cookie"><?php echo __( 'Visitors will access the videos', MEOW_CASTER_SLUG ); ?></label>

            <div class="custom-select  mcss-yts-cookie">
	<select id="field-yts-cookie" name="mc-main-settings[yts][cookie]">
        <option value="both" <?php if( $yts['cookie'] ==="both"){ echo "selected"; } ?>><?php _e( 'Let visitor choose', MEOW_CASTER_SLUG ); ?></option>
        <option value="cookie-only" <?php if( $yts['cookie'] ==="cookie-only"){ echo "selected"; } ?>><?php _e( 'With YouTube Cookies', MEOW_CASTER_SLUG ); ?></option>
        <option value="nocookie-only" <?php if( $yts['cookie'] ==="nocookie-only"){ echo "selected"; } ?>><?php _e( 'Without YouTube Cookies', MEOW_CASTER_SLUG ); ?></option>
    </select>
</div>
        </div>
    </div>
    <h4>
		<?php echo __( 'Consent Theme', MEOW_CASTER_SLUG ); ?>
        <?php $theme = (isset($yts['consent-theme']) )? $yts['consent-theme'] : 'dark' ;?>
    </h4>
    <div class="field-container mcss-container">
        <p class="mcss-hint"><?php echo __( 'Choose a colorscheme&nbsp;:', MEOW_CASTER_SLUG ); ?></p>
        <div class="mcss-player-consent-theme-selector">
            <?php
                $theme_available = ['dark','light','blue'];
                foreach($theme_available as $t):
                    $tl = ucfirst($t) . ' theme';
            ?>
            <p>
                <input id="field-yts-consent-theme-<?php echo $t ;?>"
                       name="mc-main-settings[yts][consent-theme]"
                       class="custom-radio mcss-yts-consent-theme-input"
                       value="<?php echo $t ;?>" type="radio"
                        <?php echo ( $theme === $t )? 'checked': '';?> >
                <label for="field-yts-consent-theme-<?php echo $t ;?>"><?php echo __( $tl , MEOW_CASTER_SLUG ); ?></label>

            </p>
            <?php endforeach;?>
        </div>
        <?php

            $consent_duration = 3 ;
        ?>
        <div class="mcss-player-consent-container <?php echo 'mcss-player-consent-theme-'.$theme ;?>"
             data-widget="1"
             data-id="123"
             data-type="player"
             data-url="#">
            <div class="mcss-player-consent-message">
                <p><?php _e( 'For watching this video, you have to accept to send information to ', MEOW_CASTER_SLUG ); ?>
                    <b>Youtube</b>&nbsp;(<a
                            href="https://policies.google.com/privacy"
                            target="_blank"><?php _e( 'YouTube privacy policy', MEOW_CASTER_SLUG ); ?></a>)</p>

                <p><?php _e( 'You can access to <b>Youtube</b> with or without cookie as you pleased', MEOW_CASTER_SLUG ); ?></p>

                <p><?php echo sprintf(
					    _n( 'Your consent will be store in a cookie for this unique purpose for  %s day',
						    'Your consent will be store in a cookie for this unique purpose for %s days', $consent_duration, MEOW_CASTER_SLUG )
					    , $consent_duration );
				    ?>
                </p>
            </div>
            <div class="mcss-player-consent-btn-container">
                <button value="with-cookie" data-duration="<?php echo $consent_duration; ?>">Accept with cookie</button>
                <button value="without-cookie" data-duration="<?php echo $consent_duration; ?>">Accept without cookie
                </button>
            </div>

        </div>



    </div>
</div>
