<?php
/**
 * Template for the metabox Sync
 *
 */

?>
<div id="meow-caster-video-sync" class="mcss-metabox-sync mcss-container">
    <div class="mcss-btn-line">
        <button class="mcss-btn-sync mcss-btn-sync-from mcss-btn-multi mcss-button-icon"
                data-ytvid="<?php echo $ytid; ?>"
                data-ytpid="false"
                data-sync="yt"
                title="<?php _e( 'Sync from YouTube', MEOW_CASTER_SLUG ); ?>"
        ></button>
        
    </div>
    <div class="mcss-sync-opt mcss-form mcjs-sync-opt">
        <ul>
            <li>
                <input type="radio" id="mcss-sync-default" name="sync-opt" class="custom-radio" value="default">
                <label for="mcss-sync-default"><?php _e( 'Default', MEOW_CASTER_SLUG ); ?></label>
            </li>
            <li>
                <input type="radio" id="mcss-sync-all" name="sync-opt" class="custom-radio" value="all">
                <label for="mcss-sync-all"><?php _e( 'Full sync', MEOW_CASTER_SLUG ); ?></label>
            </li>
            <li>

                <input type="radio" id="mcss-sync-part" name="sync-opt" class="custom-radio" value="part">
                <label for="mcss-sync-part"><?php _e( 'Partial sync', MEOW_CASTER_SLUG ); ?></label>

                <ul class="mcss-hide-by-radio">
                    <li><input type="checkbox"
                               id="mcss-sync-title"
                               name="_meow-caster-sync-settings[]"
                               value="title"
                               class="custom-checkbox">
                        <label for="mcss-sync-title"><?php _e( 'Title', MEOW_CASTER_SLUG ); ?></label></li>
                    <li><input type="checkbox"
                               id="mcss-sync-desc"
                               name="_meow-caster-sync-settings[]"
                               value="desc"
                               class="custom-checkbox">
                        <label for="mcss-sync-desc"><?php _e( 'Description', MEOW_CASTER_SLUG ); ?></label></li>
                    <li><input type="checkbox"
                               id="mcss-sync-tag"
                               name="_meow-caster-sync-settings[]"
                               value="tag"
                               title="<?php _e( 'Work only on import', MEOW_CASTER_SLUG ); ?>"
                               class="custom-checkbox">
                        <label for="mcss-sync-tag"><?php _e( 'Tags', MEOW_CASTER_SLUG ); ?></label></li>
                </ul>
            </li>
        </ul>

    </div>
    
</div>
