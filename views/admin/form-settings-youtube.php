<?php

$yts = $form_input['yts'];

//var_dump( $form_input );
if ( ! isset( $yts['consent'] ) ) {
	$yts['consent'] = '31';
}
?>
    <h3 id="Youtube"><?php _e( 'Youtube settings', MEOW_CASTER_SLUG ); ?></h3>
    <p><?php _e( "All these settings are used as default settings to embed, sync and import videos or galleries.", MEOW_CASTER_SLUG ); ?></p>
<?php /* ?>
<div class="mcss-formpart-container">
    <h4><?php _e( 'Feature', MEOW_CASTER_SLUG ); ?></h4>
    <div class="can-toggle field-container">
        <input class="mcss-yts-lazyload" id="field-yts-"
               name="mc-main-settings[yts][tpl]"
               type="checkbox" <?php echo $yts['lazyload']; ?>>
        <label for="field-yts-tpl">
            <div class="can-toggle__switch"
                 data-checked="<?php _e( 'Enable', MEOW_CASTER_SLUG ); ?>"
                 data-unchecked="<?php _e( 'Disable', MEOW_CASTER_SLUG ); ?>"></div>
            <div class="can-toggle__label-text"><?php _e( 'Lazy load', MEOW_CASTER_SLUG ); ?></div>
        </label>
    </div>
</div>
    <?php */ ?>
    <div class="mcss-formpart-container">
        <h4><?php _e( 'Performance', MEOW_CASTER_SLUG ); ?></h4>
        <p><?php _e( 'To reduce your page loading time, enable this setting to not directly load the YouTube frame and have the preview image instead. With a click on it, the frame will be loaded.', MEOW_CASTER_SLUG ); ?></p>
        <div class="can-toggle field-container">
            <input class="mcss-yts-lazyload" id="field-yts-lazyload"
                   name="mc-main-settings[yts][lazyload]"
                   type="checkbox" <?php echo ( isset( $yts['lazyload'] ) && $yts['lazyload'] === 'on' ) ? 'checked' : ''; ?>>
            <label for="field-yts-lazyload">
                <div class="can-toggle__switch"
                     data-checked="<?php _e( 'Enable', MEOW_CASTER_SLUG ); ?>"
                     data-unchecked="<?php _e( 'Disable', MEOW_CASTER_SLUG ); ?>"></div>
                <div class="can-toggle__label-text"><?php _e( 'Lazy load', MEOW_CASTER_SLUG ); ?></div>
            </label>
        </div>
        <div class="mcss-live-opt mcss-form mcjs-live-opt">
            <h4><?php _e( 'YouTube Live/Broadcast embed/bar', MEOW_CASTER_SLUG ); ?></h4>
            <p><?php _e( 'You can embed your live too but what happen while you aren\'t on air?', MEOW_CASTER_SLUG ); ?></p>
            <div class="field-container mcss-container">
                <label class="custom-select-inline-label" for="mcss-live-no-type"><?php _e( 'When you have no live on air do you prefer&nbsp;:', MEOW_CASTER_SLUG ); ?></label>
                <div class="custom-select  mcss-live-no-type">
	<select id="mcss-live-no-type" name="mc-main-settings[yts][live][no-live-type]">
        <option value="bar" <?php if( $yts['live']['no-live-type'] ==="bar"){ echo "selected"; } ?>><?php _e( 'Show a bar your channel subscribe button', MEOW_CASTER_SLUG ); ?></option>
        <option value="custom" <?php if( $yts['live']['no-live-type'] ==="custom"){ echo "selected"; } ?>><?php _e( 'Show a awesome custom message ', MEOW_CASTER_SLUG ); ?></option>
    </select>
</div>
            </div>
            <div class="mcss-live-no-msg-container">
                <label for="mcss-live-no-msg"><?php _e( 'The custom message your visitor will see when you haven\'t live on air', MEOW_CASTER_SLUG ); ?></label>
	            <?php wp_editor( $yts['live']['no-live-msg'],'mcss-live-no-msg', [
		            'textarea_name' => 'mc-main-settings[yts][live][no-live-msg]',
		            'media_buttons' => true,
	            ] ); ?>
            </div>

        </div>
        <div class="mcss-sync-opt mcss-form mcjs-sync-opt">
            <h4><?php _e( 'Default sync parameters', MEOW_CASTER_SLUG ); ?></h4>
            <ul>
                <li>
                    <input type="radio" id="mcss-sync-all" name="mc-main-settings[yts][sync][method]"
						<?php echo ( isset( $yts['sync']['method'] ) && strtolower( $yts['sync']['method'] ) === 'all' || ! isset( $yts['sync']['method'] ) ) ? 'checked' : ''; ?>
                           class="custom-radio" value="all">
                    <label for="mcss-sync-all"><?php _e( 'Full sync', MEOW_CASTER_SLUG ); ?></label>
                </li>
                <li>
                    <input type="radio" id="mcss-sync-part" name="mc-main-settings[yts][sync][method]"
						<?php echo ( isset( $yts['sync']['method'] ) && $yts['sync']['method'] === 'part' ) ? 'checked' : ''; ?>
                           class="custom-radio" value="part">
                    <label for="mcss-sync-part"><?php _e( 'Partial sync', MEOW_CASTER_SLUG ); ?></label>

                    <ul class="mcss-hide-by-radio">
                        <li><input type="checkbox"
                                   id="mcss-sync-title"
                                   name="mc-main-settings[yts][sync][part][]"
								<?php echo ( isset( $yts['sync']['part'] ) && in_array( 'title', $yts['sync']['part'] ) || ! isset( $yts['sync']['part'] ) ) ? 'checked' : ''; ?>
                                   value="title"
                                   class="custom-checkbox">
                            <label for="mcss-sync-title"><?php _e( 'Title', MEOW_CASTER_SLUG ); ?></label></li>
                        <li><input type="checkbox"
                                   id="mcss-sync-desc"
                                   name="mc-main-settings[yts][sync][part][]"
								<?php echo ( isset( $yts['sync']['part'] ) && in_array( 'desc', $yts['sync']['part'] ) || ! isset( $yts['sync']['part'] ) ) ? 'checked' : ''; ?>
                                   value="desc"
                                   class="custom-checkbox">
                            <label for="mcss-sync-desc"><?php _e( 'Description', MEOW_CASTER_SLUG ); ?></label></li>
                        <li><input type="checkbox"
                                   id="mcss-sync-tag"
                                   name="mc-main-settings[yts][sync][part][]"
								<?php echo ( isset( $yts['sync']['part'] ) && in_array( 'tag', $yts['sync']['part'] ) || ! isset( $yts['sync']['part'] ) ) ? 'checked' : ''; ?>
                                   value="tag"
                                   class="custom-checkbox">
                            <label for="mcss-sync-tag"><?php _e( 'Tags', MEOW_CASTER_SLUG ); ?></label></li>
                    </ul>
                </li>
            </ul>
        </div>
        <h4><?php _e( 'Importation default privacy', MEOW_CASTER_SLUG ); ?></h4>
        <div class="field-container mcss-container">
            <p class="mcss-hint"><?php _e( 'Select visibility on content importation.', MEOW_CASTER_SLUG ); ?>
                </p>
            <label class="custom-select-inline-label"
                   for="field-yts-import"><?php _e( 'Default privacy', MEOW_CASTER_SLUG ); ?></label>
            
            
            <div class="custom-select  mcss-yts-import">
	<select id="field-yts-import" name="mc-main-settings[yts][import]">
        <option value="publish" <?php if( $yts['import'] ==="publish"){ echo "selected"; } ?>>Publish</option>
        <option value="draft" <?php if( $yts['import'] ==="draft"){ echo "selected"; } ?>>Draft</option>
        <option value="private" <?php if( $yts['import'] ==="private"){ echo "selected"; } ?>>Private</option>
    </select>
</div>
            

        </div>


		<?php
		/*
		@todo select status for imported public video
		@todo select status for imported private video
		@todo select slug for meow video
		@todo select slug for meow video gallery
		*/
		?>
    </div>
<?php



