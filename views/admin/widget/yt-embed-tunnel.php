<?php
//var_dump( $this );

$class_step1 = '';
if ( esc_attr( $embedType ) == 'player' || esc_attr( $embedType ) == 'playlist' ) {
	$class_step1 = 'mcss-only-video';
} elseif ( esc_attr( $embedType ) == 'gallery' ) {
	$class_step1 = 'mcss-only-gallery';
}elseif ( esc_attr( $embedType ) == 'channel' ) {
	$class_step1 = 'mcss-only-channel';
}elseif ( esc_attr( $embedType ) == 'live' ) {
	$class_step1 = 'mcss-only-live';
}

?>
<div class="mcss-widgetform-wrap">
    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'widget_title' ) ); ?>"><?php esc_attr_e( 'Title', MEOW_CASTER_SLUG ); ?>
            <input id="<?php echo esc_attr( $this->get_field_id( 'widget_title' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'widget_title' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $widget_title ); ?>"/>
        </label>
    </p>
    <div class="mcss-widgetform-step1 <?php echo $class_step1; ?>">
        <p><?php _e( 'Select embedding type', MEOW_CASTER_SLUG ); ?></p>
        <div class="mcss-widgetform-radiosvg-container">
            <div class="mcss-widgetform-radiosvg">
                <input id="<?php echo esc_attr( $this->get_field_id( 'embedTypePlayer' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'embedType' ) ); ?>" type="radio"
                       value="player" <?php echo ( esc_attr( $embedType ) == 'player' ) ? 'checked' : ''; ?>>
                <label for="<?php echo esc_attr( $this->get_field_id( 'embedTypePlayer' ) ); ?>"><img
                            src="<?php echo MEOW_CASTER_ASSETS_URL . 'img/player.svg'; ?>"
                            alt="<?php esc_attr_e( 'Single Player', MEOW_CASTER_SLUG ); ?>"/>
                    <span><?php esc_attr_e( 'Video', MEOW_CASTER_SLUG ); ?></span></label>
            </div>
            <div class="mcss-widgetform-radiosvg">
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'embedTypePlaylist' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'embedType' ) ); ?>" type="radio"
                       value="playlist" <?php echo ( esc_attr( $embedType ) == 'playlist' ) ? 'checked' : ''; ?>>
                <label for="<?php echo esc_attr( $this->get_field_id( 'embedTypePlaylist' ) ); ?>"><img
                            src="<?php echo MEOW_CASTER_ASSETS_URL . 'img/playlist.svg'; ?>"
                            alt="<?php esc_attr_e( 'Playlist Player ', MEOW_CASTER_SLUG ); ?>"/>
                    <span><?php esc_attr_e( 'Playlist', MEOW_CASTER_SLUG ); ?></span></label>
            </div>
            <div class="mcss-widgetform-radiosvg">
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'embedTypeGallery' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'embedType' ) ); ?>" type="radio"
                       value="gallery" <?php echo ( esc_attr( $embedType ) == 'gallery' ) ? 'checked' : ''; ?>>
                <label for="<?php echo esc_attr( $this->get_field_id( 'embedTypeGallery' ) ); ?>"><img
                            src="<?php echo MEOW_CASTER_ASSETS_URL . 'img/gallery.svg'; ?>"
                            alt="<?php esc_attr_e( 'Gallery', MEOW_CASTER_SLUG ); ?>"/>
                    <span><?php esc_attr_e( 'Gallery', MEOW_CASTER_SLUG ); ?></span>
                </label>
            </div>
            <div class="mcss-widgetform-radiosvg">
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'embedTypeLive' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'embedType' ) ); ?>" type="radio"
                       value="live" <?php echo ( esc_attr( $embedType ) == 'live' ) ? 'checked' : ''; ?>>
                <label for="<?php echo esc_attr( $this->get_field_id( 'embedTypeLive' ) ); ?>"><img
                            src="<?php echo MEOW_CASTER_ASSETS_URL . 'img/live.svg'; ?>"
                            alt="<?php esc_attr_e( 'Live', MEOW_CASTER_SLUG ); ?>"/>
                    <span><?php esc_attr_e( 'Live', MEOW_CASTER_SLUG ); ?></span>
                </label>
            </div>
            <div class="mcss-widgetform-radiosvg">
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'embedTypeChannel' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'embedType' ) ); ?>" type="radio"
                       value="channel" <?php echo ( esc_attr( $embedType ) == 'channel' ) ? 'checked' : ''; ?>>
                <label for="<?php echo esc_attr( $this->get_field_id( 'embedTypeChannel' ) ); ?>"><img
                            src="<?php echo MEOW_CASTER_ASSETS_URL . 'img/channel.svg'; ?>"
                            alt="<?php esc_attr_e( 'Channel', MEOW_CASTER_SLUG ); ?>"/>
                    <span><?php esc_attr_e( 'Channel', MEOW_CASTER_SLUG ); ?></span>
                </label>
            </div>
        </div>
    </div>
	<?php
	/*
	 * @TODO [channel]
	 * @TODO [live]
	 */
	?>
    <div class="mcss-widgetform-step-next  mcss-only-video ">
        <p>Select source to embed</p>
        <div class="mcss-widgetform-radio-plus">
            <input id="<?php echo esc_attr( $this->get_field_id( 'use_url' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'useBy' ) ); ?>" type="radio"
                   value="url" <?php echo ( esc_attr( $useBy ) == 'url' ) ? 'checked' : ''; ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'use_url' ) ); ?>"><?php esc_attr_e( 'by URL', MEOW_CASTER_SLUG ); ?></label>
            <div class="mcss-widgetform-radio-options">
                <label for="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"><?php esc_attr_e( 'URL', MEOW_CASTER_SLUG ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'url' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $url ); ?>">
            </div>
        </div>
        <div class="mcss-widgetform-radio-plus">
            <input id="<?php echo esc_attr( $this->get_field_id( 'use_ID' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'useBy' ) ); ?>" type="radio"
                   value="content_id" <?php echo ( esc_attr( $useBy ) == 'content_id' ) ? 'checked' : ''; ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'use_ID' ) ); ?>"><?php esc_attr_e( 'by ID', MEOW_CASTER_SLUG ); ?></label>
            <div class="mcss-widgetform-radio-options">
                <label for="<?php echo esc_attr( $this->get_field_id( 'content_id' ) ); ?>"><?php esc_attr_e( 'Content ID', MEOW_CASTER_SLUG ); ?></label>
                <input id="<?php echo esc_attr( $this->get_field_id( 'content_id' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'content_id' ) ); ?>" type="text"
                       value="<?php echo esc_attr( $content_id ); ?>">
            </div>
        </div>

		<?php
		/*
		 * @TODO [librarie]
		 * @TODO [your channel]
		 */
		?>
    </div>
    <div class="mcss-widgetform-step-next mcss-only-gallery">
        <div class="field-container mcss-container">
            <label  for="<?php echo esc_attr( $this->get_field_id( 'gallery_id' ) ); ?>"><?php esc_attr_e( 'Pick a gallery(only published)', MEOW_CASTER_SLUG ); ?></label>
			<?php
			$args = array(
				'post_type'   => 'meow-video-gallery',
				'nopaging'    => true,
				'post_status' => 'publish'
			);

			$query = query_posts( $args );

			?>
            <div class="custom-select">
                <select class="mcss-widgetform-select-gallery"
                        name="<?php echo esc_attr( $this->get_field_name( 'gallery_id' ) ); ?>"
                        id="<?php echo esc_attr( $this->get_field_id( 'gallery_id' ) ); ?>">
                    <?php
                    foreach ( $query as $post ) :
                        // get number of items in the gallery
                        $postmeta = get_post_meta( $post->ID );
                        $postmeta = maybe_unserialize( $postmeta['_meow-caster-video-gallery-list'][0] );
                        $selected = ( $post->ID == esc_attr( $gallery_id ) ) ? 'selected' : '';

                        ?>
                        <option value="<?php echo $post->ID; ?>" <?php echo $selected; ?> >
                            <?php echo $post->post_title . ' (' . sizeof( $postmeta['items'] ) . ')'; ?>
                        </option>
                    <?php endforeach;
                    wp_reset_postdata();
                    ?>
                </select>
            </div>
        </div>
        <div class="field-container mcss-container">
            <label class="custom-select-inline-label" for="<?php echo esc_attr( $this->get_field_id( 'gallery_col' ) ); ?>">

				<?php esc_attr_e( 'Gallery view', MEOW_CASTER_SLUG ); ?>
            </label>
                <div class="custom-select">
                <select name="<?php echo esc_attr( $this->get_field_name( 'gallery_col' ) ); ?>"
                        id="<?php echo esc_attr( $this->get_field_id( 'gallery_col' ) ); ?>">
					<?php for ( $i = 1; $i < 5; $i ++ ):
						$selected = ( $i == esc_attr( $gallery_col ) ) ? 'selected' : '';
						?>
                        <option value="<?php echo $i; ?>" <?php echo $selected ?> ><?php echo sprintf( _n( '%s column', '%s columns', $i, MEOW_CASTER_SLUG ), $i ); ?></option>
					<?php endfor; ?>
                </select>
                </div>
        </div>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'gallery_title' ) ); ?>">
				<?php esc_attr_e( 'Show video title', MEOW_CASTER_SLUG ); ?>
                <input type="checkbox" value="on"
                       name="<?php echo esc_attr( $this->get_field_name( 'gallery_title' ) ); ?>"
                       id="<?php echo esc_attr( $this->get_field_id( 'gallery_title' ) ); ?>" <?php echo ( esc_attr( $gallery_title ) == 'on' ) ? 'checked' : ''; ?>>
            </label>
        </p>
    </div>
    <div class="mcss-widgetform-step-next mcss-only-live">
        
        <div class="field-container mcss-container">
            <label class="custom-select-inline-label" for="<?php echo esc_attr( $this->get_field_id( 'live_type' ) ); ?>"><?php _e( 'Display as ', MEOW_CASTER_SLUG ); ?></label>
            <div class="custom-select  mcss-widgetform-live-type">
	<select id="<?php echo esc_attr( $this->get_field_id( 'live_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'live_type' ) ); ?>">
        <option value="embed" <?php if( esc_attr( $live_type ) ==="embed"){ echo "selected"; } ?>><?php _e( 'Embed player', MEOW_CASTER_SLUG ); ?></option>
        <option value="bar" <?php if( esc_attr( $live_type ) ==="bar"){ echo "selected"; } ?>><?php _e( 'Bar with links', MEOW_CASTER_SLUG ); ?></option>
    </select>
</div>
        </div>
        <div class="field-container mcss-container">
            <label class="custom-select-inline-label" for="<?php echo esc_attr( $this->get_field_id( 'live_theme' ) ); ?>"><?php _e( 'Theme ', MEOW_CASTER_SLUG ); ?></label>
            <div class="custom-select  mcss-widgetform-live-theme">
	<select id="<?php echo esc_attr( $this->get_field_id( 'live_theme' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'live_theme' ) ); ?>">
        <option value="light" <?php if( esc_attr( $live_theme ) ==="light"){ echo "selected"; } ?>><?php _e( 'light', MEOW_CASTER_SLUG ); ?></option>
        <option value="dark" <?php if( esc_attr( $live_theme ) ==="dark"){ echo "selected"; } ?>><?php _e( 'dark', MEOW_CASTER_SLUG ); ?></option>
        <option value="raw" <?php if( esc_attr( $live_theme ) ==="raw"){ echo "selected"; } ?>><?php _e( 'raw (so you use your custom style)', MEOW_CASTER_SLUG ); ?></option>
    </select>
</div>
        </div>

    </div>
    <div class="mcss-widgetform-step-next mcss-only-channel">
        
        <div class="field-container mcss-container">
            <label class="custom-select-inline-label" for="<?php echo esc_attr( $this->get_field_id( 'channel_view' ) ); ?>"><?php _e( 'Display as ', MEOW_CASTER_SLUG ); ?></label>
            <div class="custom-select  mcss-widgetform-channel-view">
	<select id="<?php echo esc_attr( $this->get_field_id( 'channel_view' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'channel_view' ) ); ?>">
        <option value="banner" <?php if( esc_attr( $channel_view ) ==="banner"){ echo "selected"; } ?>><?php _e( 'Banner only', MEOW_CASTER_SLUG ); ?></option>
        <option value="grid" <?php if( esc_attr( $channel_view ) ==="grid"){ echo "selected"; } ?>><?php _e( 'Banner with grid ', MEOW_CASTER_SLUG ); ?></option>
    </select>
</div>
        </div>
        <div class="field-container mcss-container">
            <label class="custom-select-inline-label" for="<?php echo esc_attr( $this->get_field_id( 'channel_theme' ) ); ?>"><?php _e( 'Theme ', MEOW_CASTER_SLUG ); ?></label>
            <div class="custom-select  mcss-widgetform-channel-theme">
	<select id="<?php echo esc_attr( $this->get_field_id( 'channel_theme' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'channel_theme' ) ); ?>">
        <option value="light" <?php if( esc_attr( $channel_theme ) ==="light"){ echo "selected"; } ?>><?php _e( 'light', MEOW_CASTER_SLUG ); ?></option>
        <option value="dark" <?php if( esc_attr( $channel_theme ) ==="dark"){ echo "selected"; } ?>><?php _e( 'dark', MEOW_CASTER_SLUG ); ?></option>
        <option value="raw" <?php if( esc_attr( $channel_theme ) ==="raw"){ echo "selected"; } ?>><?php _e( 'raw (so you use your custom style)', MEOW_CASTER_SLUG ); ?></option>
    </select>
</div>
        </div>
        <div class="field-container mcss-container">
            <label class="custom-select-inline-label" for="<?php echo esc_attr( $this->get_field_id( 'channel_nbvid' ) ); ?>"><?php _e( 'How many video with the banner? (Only grid view) ', MEOW_CASTER_SLUG ); ?></label>
            <div class="custom-select  mcss-widgetform-channel-nbVid">
	<select id="<?php echo esc_attr( $this->get_field_id( 'channel_nbvid' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'channel_nbvid' ) ); ?>">
        <option value="1" <?php if( esc_attr( $channel_nbvid ) ==="1"){ echo "selected"; } ?>>1</option>
        <option value="2" <?php if( esc_attr( $channel_nbvid ) ==="2"){ echo "selected"; } ?>>2</option>
        <option value="3" <?php if( esc_attr( $channel_nbvid ) ==="3"){ echo "selected"; } ?>>3</option>
        <option value="4" <?php if( esc_attr( $channel_nbvid ) ==="4"){ echo "selected"; } ?>>4</option>
        <option value="5" <?php if( esc_attr( $channel_nbvid ) ==="5"){ echo "selected"; } ?>>5</option>
        <option value="6" <?php if( esc_attr( $channel_nbvid ) ==="6"){ echo "selected"; } ?>>6</option>
        <option value="7" <?php if( esc_attr( $channel_nbvid ) ==="7"){ echo "selected"; } ?>>7</option>
        <option value="8" <?php if( esc_attr( $channel_nbvid ) ==="8"){ echo "selected"; } ?>>8</option>
        <option value="9" <?php if( esc_attr( $channel_nbvid ) ==="9"){ echo "selected"; } ?>>9</option>
        <option value="10" <?php if( esc_attr( $channel_nbvid ) ==="10"){ echo "selected"; } ?>>10</option>
        <option value="11" <?php if( esc_attr( $channel_nbvid ) ==="11"){ echo "selected"; } ?>>11</option>
        <option value="12" <?php if( esc_attr( $channel_nbvid ) ==="12"){ echo "selected"; } ?>>12</option>
        <option value="13" <?php if( esc_attr( $channel_nbvid ) ==="13"){ echo "selected"; } ?>>13</option>
        <option value="14" <?php if( esc_attr( $channel_nbvid ) ==="14"){ echo "selected"; } ?>>14</option>
        <option value="15" <?php if( esc_attr( $channel_nbvid ) ==="15"){ echo "selected"; } ?>>15</option>
    </select>
</div>
        </div>
    </div>
</div>