<?php
/**
 * Created by PhpStorm.
 * User: id2
 * Date: 8/02/18
 * Time: 16:46
 */

$ytp = array();

$ytp_default = array(
	'modest'      => 'checked',
	'control'     => 'checked',
	'caption'     => 'checked',
	'annotations' => 'checked',
	'info'        => 'checked',
	'related'     => 'checked',
	'autoplay'    => '',
	'fullscreen'  => 'checked',
	'loop'        => '',
	'playsinline' => 'checked',
	'color'       => 'red'

);
if ( isset( $form_input['ytp'] ) ) {

	foreach ( $ytp_default as $key => $value ) {
		$ytp[ $key ] = ( isset( $form_input['ytp'][ $key ] ) ) ? $form_input['ytp'][ $key ] : '';
	}
} else {
	$ytp = $ytp_default;
}

if ( ! function_exists( 'meow_get_live_player_toggle' ) ) {
	function meow_get_live_player_toggle( $name = null, $label = null, $ytp = null ) {
		if ( is_null( $name ) || is_null( $label ) || is_null( $ytp ) ) {
			return '';
		}

		?>
        <div class="can-toggle can-toggle--size-small field-container ">
            <input class="mcss-ytp-<?php echo $name; ?> mcjs-live-player" id="field-ytp-<?php echo $name; ?>"
                   name="mc-main-settings[ytp][<?php echo $name; ?>]"
                   value="checked"
                   data-target="mcss-live-player-active-<?php echo $name; ?>"
                   type="checkbox" <?php echo $ytp[ $name ]; ?>>
            <label for="field-ytp-<?php echo $name; ?>">
                <div class="can-toggle__switch"
                     data-checked="<?php _e( 'On', MEOW_CASTER_SLUG ); ?>"
                     data-unchecked="<?php _e( 'Off', MEOW_CASTER_SLUG ); ?>"></div>
                <div class="can-toggle__label-text"><?php echo $label ?></div>
            </label>
        </div>
		<?php
	}
}

$svg_class = "";
foreach ( $ytp as $key => $value ) {
	if ( $value == 'checked' ) {
		$svg_class .= 'mcss-live-player-active-' . $key . ' ';
	}
}


?>
<h3 id="#YoutubeLivePrev"><?php _e( 'YouTube Player live preview', MEOW_CASTER_SLUG ); ?></h3>
<p><?php _e( 'All these settings are used as default settings to embed. Take some time here and save time on the embedding everywhere else.', MEOW_CASTER_SLUG ); ?></p>
<div class="mcss-formpart-liveplayer">
    <div class="mcss-player-container" data-classplayer="mcss-player-img <?php echo $svg_class; ?>">
		<?php echo file_get_contents( MEOW_CASTER_ASSETS_URL . '/img/live-player.svg' ); ?>
    </div>
    <div class="mcss-player-settings">
        <h4><?php _e( 'Default parameter for all YouTube player', MEOW_CASTER_SLUG ); ?></h4>
		<?php

		meow_get_live_player_toggle( 'modest', __( 'Modest Branding' ), $ytp );
		meow_get_live_player_toggle( 'control', __( 'Controls' ), $ytp );
		meow_get_live_player_toggle( 'caption', __( 'Caption' ), $ytp );
		meow_get_live_player_toggle( 'annotations', __( 'Annotation' ), $ytp );
		meow_get_live_player_toggle( 'info', __( 'Video information' ), $ytp );
		meow_get_live_player_toggle( 'related', __( 'Related video' ), $ytp );
		meow_get_live_player_toggle( 'fullscreen', __( 'Fullscreen button' ), $ytp );
		meow_get_live_player_toggle( 'autoplay', __( 'Autoplay' ), $ytp );
		//meow_get_live_player_toggle( 'loop', __( 'Loop' ), $ytp );
		meow_get_live_player_toggle( 'playsinline', __( 'UIWebView for iOS' ), $ytp );
		?>
        <div class="field-radio-group radio-group-2">
            <p class="field-label-radio"><?php _e( 'Progress bar color', MEOW_CASTER_SLUG ); ?><span
                        class="hint"><?php _e( '( Choose white disable modestbranding )', MEOW_CASTER_SLUG ); ?></span>
            </p>
            <div>
                <input type="radio" id="field-ytp-color-red" name="mc-main-settings[ytp][color]" value="red"
                       class="mcss-ytp-color mcjs-live-player custom-radio"
					<?php echo ( $ytp['color'] == 'red' ) ? 'checked' : ''; ?>>
                <label for="field-ytp-color-red"><?php _e( 'Red', MEOW_CASTER_SLUG ); ?></label>
            </div>
            <div>
                <input type="radio" id="field-ytp-color-white" name="mc-main-settings[ytp][color]" value="white"
                       class="mcss-ytp-color mcjs-live-player custom-radio"
					<?php echo ( $ytp['color'] == 'white' ) ? 'checked' : ''; ?>>
                <label for="field-ytp-color-white"><?php _e( 'White', MEOW_CASTER_SLUG ); ?></label>
            </div>
        </div>
    </div>

    <div class="mcss-player-container">
        <div id="mjs-player"></div>
    </div>
    <div class="mcss-player-settings">
        <div class="mcss-input-text-btn-left">
            <input type="url" id="mjs-player-test-link" class="mcss-input-text custom-input-text">
            <button id="mjs-player-test-launch"><?php _e( 'Test', MEOW_CASTER_SLUG ); ?></button>
        </div>
    </div>
</div>

