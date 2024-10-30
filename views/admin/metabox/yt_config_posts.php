<?php

/**
 *
 */


if ( ! function_exists( 'meow_get_metabox_toggle' ) ) {

	function meow_get_metabox_toggle( $name = null, $label = null, $input = null ) {
		if ( is_null( $name ) || is_null( $label ) || is_null( $input ) ) {
			return '';
		}
		?>
        <div class="can-toggle can-toggle--size-small field-container ">
            <input class="mcss-yt-mt-<?php echo $name; ?>" id="mc_metabox_youtube_custom_<?php echo $name; ?>"
                   name="meow-caster-yt-post-settings[<?php echo $name; ?>]"
                   value="checked"
	            <?php if ( isset( $input[ $name ] ) && $input[ $name ] == "checked" ) {
					echo 'checked';
				} ?>
                   type="checkbox">
            <label for="mc_metabox_youtube_custom_<?php echo $name; ?>">
                <div class="can-toggle__switch"
                     data-checked="<?php _e( 'On', MEOW_CASTER_SLUG ); ?>"
                     data-unchecked="<?php _e( 'Off', MEOW_CASTER_SLUG ); ?>"></div>
                <div class="can-toggle__label-text"><?php echo $label ?></div>
            </label>
        </div>
		<?php
	}
}

?>
<div id="meow-caster-yt-post-settings" class="mcss-metabox-yt">
	<?php
	meow_get_metabox_toggle( 'article_custom', __( 'Activate custom configuration for this article ', MEOW_CASTER_SLUG ), $value );
	?>
    <div id="mc_metabox_youtube_custom_container">
		<?php
		meow_get_metabox_toggle( 'modest', __( 'Modest Branding' ), $value );
		meow_get_metabox_toggle( 'control', __( 'Controls' ), $value );
		meow_get_metabox_toggle( 'caption', __( 'Caption' ), $value );
		meow_get_metabox_toggle( 'annotations', __( 'Annotation' ), $value );
		meow_get_metabox_toggle( 'info', __( 'Video information' ), $value );
		meow_get_metabox_toggle( 'related', __( 'Related video' ), $value );
		meow_get_metabox_toggle( 'fullscreen', __( 'Fullscreen button' ), $value );
		meow_get_metabox_toggle( 'autoplay', __( 'Autoplay' ), $value );
		meow_get_metabox_toggle( 'loop', __( 'Loop' ), $value );
		meow_get_metabox_toggle( 'playsinline', __( 'UIWebView for iOS' ), $value );
		?>
    </div>
</div>
