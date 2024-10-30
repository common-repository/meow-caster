<?php

?>
<div class="wrap" id="meow_caster_video_listing">
    <div class="mcss-video-listing-header">
        <div>
            <div class="mcss-input-search">
                <label for="mcjs-input-search"><span><?php _e( 'Search', MEOW_CASTER_SLUG ) ?></span>
                    <input id="mcjs-input-search"
                           class="mcjs-input-search"
                           data-meow-target=".mcss-video-list-elem"
                           data-meow-target-container=".mcss-video-listing-content"
                           type="text">
                </label>
            </div>
        </div>
    </div>
    <div class="mcss-video-listing-content"><?php
		// php like this for no whitespace
		foreach ( $items as $item ) {

			echo \MeowCaster\get_view( 'admin/template/video-listing', false, [ 'item' => $item ] );
		}
		?></div>
</div>