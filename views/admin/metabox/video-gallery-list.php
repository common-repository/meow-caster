<?php
/**
 *
 * '$name= meow-caster-yt-post-settings'
 */

use MeowCaster\Services\MeowGoogleClient;

if ( isset( $value['col'] ) ) {
	$col = $value['col'];
	unset( $value['col'] );
} else {
	$col = 3;
}
$items = ( isset( $value['items'] ) && $value !== '' ) ? $value['items'] : array();

$yt_full = MeowGoogleClient::ready();
?>
<div id="meow-caster-video-gallery-list" class="mcss-metabox-vgl-container mcss-form">
    <div class="mcss-vgl-form">
        <div class="mcss-vgl-form-add">

            <div class="mcss-vgl-form-add-imported">
	            <?php if ( $yt_full ): ?>
                    <a href="<?php echo esc_attr( $wizhref ); ?>"
                       class="thickbox button mcjs-tb-button mcss-btn-action"
                       data-meow-action="meow-video-listing"
                       title="<?php _e( 'Add from imported videos', MEOW_CASTER_SLUG ); ?>">
	                    <?php _e( 'Add from imported videos', MEOW_CASTER_SLUG ); ?>
                    </a>
	            <?php endif; ?>
            </div>
            <div>
                <label for="mcss-vgl-form-url">
	                <?php if ( $yt_full ):
		                _e( 'or from URL', MEOW_CASTER_SLUG );
	                else:
		                _e( 'Add from URL', MEOW_CASTER_SLUG );
	                endif;
	                ?>
                </label>
                <input type="url" id="mcss-vgl-form-url" class="custom-input-text">
                <button class="mcss-vgl-form-validator"
                        value="vidurl"><?php echo __( 'Add from URL', MEOW_CASTER_SLUG ); ?></button>
            </div>

        </div>
        <div class="mcss-vgl-form-display">
            <label for="mcss-vgl-form-col">
				<?php echo __( 'Number of columns ', MEOW_CASTER_SLUG ); ?>
            </label>
            <div class="custom-select">
                <select name="_meow-caster-video-gallery-list[col]" id="mcss-vgl-form-col">
                    <option value="1" <?php echo ( $col == '1' ) ? 'selected' : ''; ?>>1</option>
                    <option value="2" <?php echo ( $col == '2' ) ? 'selected' : ''; ?>>2</option>
                    <option value="3" <?php echo ( $col == '3' ) ? 'selected' : ''; ?>>3</option>
                    <option value="4" <?php echo ( $col == '4' ) ? 'selected' : ''; ?>>4</option>
                </select>
            </div>
            <div class="mcss-vgl-form-title can-toggle can-toggle--size-small">
                <input id="mcss-vgl-form-title"
                       name="_meow-caster-video-gallery-list[title]"
				    <?php echo ( isset( $value['title'] ) && $value['title'] === 'on' ) ? 'checked' : ''; ?>
                       type="checkbox">
                <label for="mcss-vgl-form-title">
                    <div class="can-toggle__switch"
                         data-checked="<?php _e( 'Show', MEOW_CASTER_SLUG ); ?>"
                         data-unchecked="<?php _e( 'Hide', MEOW_CASTER_SLUG ); ?>"></div>
                    <div class="can-toggle__label-text"><?php echo __( 'Show title', MEOW_CASTER_SLUG ); ?></div>
                </label>
            </div>
        </div>
    </div>
    <div id="mcss-vgl-container-list" data-col="<?php echo $col; ?>">
	    <?php
	    foreach ( $items as $item ) {
		    echo \MeowCaster\get_view( 'admin/template/vgl-content', true, [ 'item' => $item ] );
	    } ?>
    </div>
</div>
