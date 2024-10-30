<?php



?>
<div class="wrap" id="meow_caster_embed_tunnel">
    <form enctype="multipart/form-data" method="post" name="meow_caster_embed_tunnel">
        <div class="mcss-widgetform-step1">
            <p><?php _e( 'Select embedding type', MEOW_CASTER_SLUG ); ?></p>
            <div class="mcss-widgetform-radiosvg-container">
                <div class="mcss-widgetform-radiosvg">
                    <input id="mcss-widgetform-embedtype-player" name="mcss-widgetform-embedtype" type="radio"
                           value="player">
                    <label for="mcss-widgetform-embedtype-player"><img
                                src="<?php echo MEOW_CASTER_ASSETS_URL . 'img/player.svg'; ?>"
                                alt="<?php esc_attr_e( 'Video Player', MEOW_CASTER_SLUG ); ?>"/>
                        <span><?php esc_attr_e( 'Video', MEOW_CASTER_SLUG ); ?></span>
                    </label>
                </div>
                <div class="mcss-widgetform-radiosvg">
                    <input class="widefat" id="mcss-widgetform-embedtype-playlist" name="mcss-widgetform-embedtype"
                           type="radio" value="playlist">
                    <label for="mcss-widgetform-embedtype-playlist"><img
                                src="<?php echo MEOW_CASTER_ASSETS_URL . 'img/playlist.svg'; ?>"
                                alt="<?php esc_attr_e( 'Playlist Player ', MEOW_CASTER_SLUG ); ?>"/>
                        <span><?php esc_attr_e( 'Playlist', MEOW_CASTER_SLUG ); ?></span>
                    </label>
                </div>
                <div class="mcss-widgetform-radiosvg">
                    <input class="widefat" id="mcss-widgetform-embedtype-gallery" name="mcss-widgetform-embedtype"
                           type="radio" value="gallery">
                    <label for="mcss-widgetform-embedtype-gallery"><img
                                src="<?php echo MEOW_CASTER_ASSETS_URL . 'img/gallery.svg'; ?>"
                                alt="<?php esc_attr_e( 'Gallery', MEOW_CASTER_SLUG ); ?>"/>
                        <span><?php esc_attr_e( 'Gallery', MEOW_CASTER_SLUG ); ?></span>
                    </label>
                </div>
                <div class="mcss-widgetform-radiosvg">
                    <input class="widefat" id="mcss-widgetform-embedtype-live" name="mcss-widgetform-embedtype"
                           type="radio" value="live">
                    <label for="mcss-widgetform-embedtype-live"><img
                                src="<?php echo MEOW_CASTER_ASSETS_URL . 'img/live.svg'; ?>"
                                alt="<?php esc_attr_e( 'Live', MEOW_CASTER_SLUG ); ?>"/>
                        <span><?php esc_attr_e( 'Live', MEOW_CASTER_SLUG ); ?></span>
                    </label>
                </div>
                <div class="mcss-widgetform-radiosvg">
                    <input class="widefat" id="mcss-widgetform-embedtype-channel" name="mcss-widgetform-embedtype"
                           type="radio" value="channel">
                    <label for="mcss-widgetform-embedtype-channel"><img
                                src="<?php echo MEOW_CASTER_ASSETS_URL . 'img/channel.svg'; ?>"
                                alt="<?php esc_attr_e( 'Channel', MEOW_CASTER_SLUG ); ?>"/>
                        <span><?php esc_attr_e( 'Channel', MEOW_CASTER_SLUG ); ?></span>
                    </label>
                </div>
            </div>

        </div>
        <div class="mcss-widgetform-step-next  mcss-only-video ">
            <p>Select source to embed</p>
            <div class="mcss-widgetform-radio-plus">
                <input id="mcss-widgetform-useURL" name="mcss-widgetform-use" type="radio" value="url">
                <label for="mcss-widgetform-useURL"><?php esc_attr_e( 'by URL', MEOW_CASTER_SLUG ); ?></label>
                <div class="mcss-widgetform-radio-options">
                    <label for="mcss-widgetform-content-url"><?php esc_attr_e( 'URL', MEOW_CASTER_SLUG ); ?></label>
                    <input id="mcss-widgetform-content-url" name="mcss-widgetform-content-url" type="text">
                </div>
            </div>
            <div class="mcss-widgetform-radio-plus">
                <input id="mcss-widgetform-useID" name="mcss-widgetform-use" type="radio" value="content_id">
                <label for="mcss-widgetform-useID"><?php esc_attr_e( 'by ID', MEOW_CASTER_SLUG ); ?></label>
                <div class="mcss-widgetform-radio-options">
                    <label for="mcss-widgetform-content-id"><?php esc_attr_e( 'Content ID', MEOW_CASTER_SLUG ); ?></label>
                    <input id="mcss-widgetform-content-id" name="mcss-widgetform-content-id" type="text">
                </div>
            </div>


        </div>
        <div class="mcss-widgetform-step-next mcss-only-gallery">
	        <?php
	        $args        = array(
		        'post_type'   => 'meow-video-gallery',
		        'nopaging'    => true,
		        'post_status' => 'publish'
	        );
	        $url_mew_gal = admin_url( 'post-new.php?post_type=meow-video-gallery' );
	        $query       = query_posts( $args );
	        if ( is_null( $query ) || 0 === sizeof( $query ) ): ?>
                <p><?php echo sprintf( __( 'No gallery found. <a href="%s" target="_blank">Maybe you need to create one before.</a>', MEOW_CASTER_SLUG ), $url_mew_gal ); ?></p>
	        <?php else: ?>
                <div class="field-container mcss-container">
                    <label  for="mcss-widgetform-gallery-selector"><?php esc_attr_e( 'Pick a gallery', MEOW_CASTER_SLUG ); ?>
                        <br>
                        <span class="hint"><?php echo sprintf( __( '<a href="%s" target="_blank">Need a new gallery?</a>', MEOW_CASTER_SLUG ), $url_mew_gal ); ?></span>
                    </label>
                    <div class="custom-select">
                    <select class="mcss-widgetform-select-gallery" name="mcss-widgetform-gallery-selector"
                            id="mcss-widgetform-gallery-selector">
		                <?php
		                foreach ( $query as $post ) :
			                // get number of items in the gallery
			                $postmeta = get_post_meta( $post->ID );
			                $postmeta = maybe_unserialize( $postmeta['_meow-caster-video-gallery-list'][0] );

			                ?>
                            <option value="<?php echo $post->ID; ?>">
				                <?php echo $post->post_title . ' (' . sizeof( $postmeta['items'] ) . ')'; ?>
                            </option>
		                <?php endforeach; ?>
                    </select>
                </div>

                </div>

                <div class="field-container mcss-container">
                    <label class="custom-select-inline-label" for="mcss-widgetform-gallery-col">
				        <?php esc_attr_e( 'Gallery view', MEOW_CASTER_SLUG ); ?>
                    </label>
                    <div class="custom-select">
                        <select name="mcss-widgetform-gallery-col" id="mcss-widgetform-gallery-col">
					        <?php for ( $i = 1; $i < 5; $i ++ ): ?>
                                <option value="<?php echo $i; ?>"><?php echo sprintf( _n( '%s column', '%s columns', $i, MEOW_CASTER_SLUG ), $i ); ?></option>
					        <?php endfor; ?>
                        </select>
                    </div>

                </div>
                <p>
                    <label for="mcss-widgetform-gallery-title">
				        <?php esc_attr_e( 'Show video title', MEOW_CASTER_SLUG ); ?>
                        <input type="checkbox" value="on" name="mcss-widgetform-gallery-title"
                               id="mcss-widgetform-gallery-title">
                    </label>
                </p>
	        <?php endif;
	        wp_reset_postdata(); ?>
        </div>
        <div class="mcss-widgetform-step-next mcss-only-live">
            
            <div class="field-container mcss-container">
                <label class="custom-select-inline-label" for="mcss-widgetform-live-type"><?php _e( 'Display as ', MEOW_CASTER_SLUG ); ?></label>
                <div class="custom-select  mcss-widgetform-live-type">
	<select id="mcss-widgetform-live-type" name="mcss-widgetform-live-type">
        <option value="embed" <?php if( 'embed' ==="embed"){ echo "selected"; } ?>><?php _e( 'Embed player', MEOW_CASTER_SLUG ); ?></option>
        <option value="bar" <?php if( 'embed' ==="bar"){ echo "selected"; } ?>><?php _e( 'Bar with links', MEOW_CASTER_SLUG ); ?></option>
    </select>
</div>
            </div>
            <div class="field-container mcss-container">
                <label class="custom-select-inline-label" for="mcss-widgetform-live-theme"><?php _e( 'Theme ', MEOW_CASTER_SLUG ); ?></label>
                <div class="custom-select  mcss-widgetform-live-theme">
	<select id="mcss-widgetform-live-theme" name="mcss-widgetform-live-theme">
        <option value="light" <?php if( 'light' ==="light"){ echo "selected"; } ?>><?php _e( 'light', MEOW_CASTER_SLUG ); ?></option>
        <option value="dark" <?php if( 'light' ==="dark"){ echo "selected"; } ?>><?php _e( 'dark', MEOW_CASTER_SLUG ); ?></option>
        <option value="raw" <?php if( 'light' ==="raw"){ echo "selected"; } ?>><?php _e( 'raw (so you use your custom style)', MEOW_CASTER_SLUG ); ?></option>
    </select>
</div>
            </div>

        </div>
        <div class="mcss-widgetform-step-next mcss-only-channel">
            
            <div class="field-container mcss-container">
                <label class="custom-select-inline-label" for="mcss-widgetform-channel-view"><?php _e( 'Display as ', MEOW_CASTER_SLUG ); ?></label>
                <div class="custom-select  mcss-widgetform-channel-view">
	<select id="mcss-widgetform-channel-view" name="mcss-widgetform-channel-view">
        <option value="banner" <?php if( 'banner' ==="banner"){ echo "selected"; } ?>><?php _e( 'Banner only', MEOW_CASTER_SLUG ); ?></option>
        <option value="grid" <?php if( 'banner' ==="grid"){ echo "selected"; } ?>><?php _e( 'Banner with grid ', MEOW_CASTER_SLUG ); ?></option>
    </select>
</div>
            </div>
            <div class="field-container mcss-container">
                <label class="custom-select-inline-label" for="mcss-widgetform-channel-theme"><?php _e( 'Theme ', MEOW_CASTER_SLUG ); ?></label>
                <div class="custom-select  mcss-widgetform-channel-theme">
	<select id="mcss-widgetform-channel-theme" name="mcss-widgetform-channel-theme">
        <option value="light" <?php if( 'light' ==="light"){ echo "selected"; } ?>><?php _e( 'light', MEOW_CASTER_SLUG ); ?></option>
        <option value="dark" <?php if( 'light' ==="dark"){ echo "selected"; } ?>><?php _e( 'dark', MEOW_CASTER_SLUG ); ?></option>
        <option value="raw" <?php if( 'light' ==="raw"){ echo "selected"; } ?>><?php _e( 'raw (so you use your custom style)', MEOW_CASTER_SLUG ); ?></option>
    </select>
</div>
            </div>
            <div class="field-container mcss-container">
                <label class="custom-select-inline-label" for="mcss-channel-nbVid"><?php _e( 'How many video with the banner? (Only grid view) ', MEOW_CASTER_SLUG ); ?></label>
                <div class="custom-select  mcss-widgetform-channel-nbVid">
	<select id="mcss-widgetform-channel-nbVid" name="mcss-widgetform-channel-nbVid">
        <option value="1" <?php if( '3' ==="1"){ echo "selected"; } ?>>1</option>
        <option value="2" <?php if( '3' ==="2"){ echo "selected"; } ?>>2</option>
        <option value="3" <?php if( '3' ==="3"){ echo "selected"; } ?>>3</option>
        <option value="4" <?php if( '3' ==="4"){ echo "selected"; } ?>>4</option>
        <option value="5" <?php if( '3' ==="5"){ echo "selected"; } ?>>5</option>
        <option value="6" <?php if( '3' ==="6"){ echo "selected"; } ?>>6</option>
        <option value="7" <?php if( '3' ==="7"){ echo "selected"; } ?>>7</option>
        <option value="8" <?php if( '3' ==="8"){ echo "selected"; } ?>>8</option>
        <option value="9" <?php if( '3' ==="9"){ echo "selected"; } ?>>9</option>
        <option value="10" <?php if( '3' ==="10"){ echo "selected"; } ?>>10</option>
        <option value="11" <?php if( '3' ==="11"){ echo "selected"; } ?>>11</option>
        <option value="12" <?php if( '3' ==="12"){ echo "selected"; } ?>>12</option>
        <option value="13" <?php if( '3' ==="13"){ echo "selected"; } ?>>13</option>
        <option value="14" <?php if( '3' ==="14"){ echo "selected"; } ?>>14</option>
        <option value="15" <?php if( '3' ==="15"){ echo "selected"; } ?>>15</option>
    </select>
</div>
            </div>
        </div>
        <?php
		//Only for the embed tunnel
		?>
        <button id="mcss-embed-tunnel-validator"
                class="mcss-embed-tunnel-validator"><?php esc_attr_e( 'Generate and include shortcode', MEOW_CASTER_SLUG ); ?>
        </button>
    </form>
</div>