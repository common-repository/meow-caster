<?php
/**
 * Banner multi usage for YouTube Channel presenting in the backoffice
 */


?>
<div class="mcss-youtube-channel-banner">
    <img src="<?php echo $thumb; ?>">
    <div class="mcss-channel-info">
        <span class="mcss-channel-linked"><?php _e( 'Linked with', MEOW_CASTER_SLUG ); ?></span>
        <p class="mcss-channel-title"><?php echo $name; ?> <a href="<?php echo $url; ?>"
                                                              target="_blank"><?php _e( 'Go to channel', MEOW_CASTER_SLUG ); ?></a>
        </p>
        <div class="mcss-channel-stats">
            <span><?php echo sprintf( _n( '%s view', '%s views', (int) $views, MEOW_CASTER_SLUG ), $views ); ?></span> -
            <span><?php echo sprintf( _n( '%s subscriber', '%s subscribers', (int) $subs, MEOW_CASTER_SLUG ), $subs ); ?></span>
            -
            <span><?php echo sprintf( _n( '%s video', '%s videos', (int) $videos, MEOW_CASTER_SLUG ), $videos ); ?></span>
        </div>
    </div>
</div>

