<?php
/**
 * Template for the metabox Video Datalink
 *
 * display information from the video
 *      Type [YouTube|Vimeo|uploaded]
 *      URL if YT or Vimeo
 *      Gallery containing the video
 *
 *  {
 *    type: 'Youtube',
 *    url: '...',
 *    gallery: [ galleryID1, galleryID2, ... ]
 *  }
 *
 */

switch ( $datalink['privacyStatus'] ) {
	case 'private':
		$display_status = __( 'Private', MEOW_CASTER_SLUG );
		break;
	case 'public':
		$display_status = __( 'Public', MEOW_CASTER_SLUG );
		break;
	case 'unlisted':
		$display_status = __( 'Unlisted', MEOW_CASTER_SLUG );
		break;
	default:
		$display_status = 'undefined';
		break;
}

if ( $datalink['embeddable'] ) {
	$embeddage = __( 'Yes', MEOW_CASTER_SLUG );
} else {
	$embeddage = __( 'No', MEOW_CASTER_SLUG );
}

$channel_id = get_option( MEOW_CASTER_SETTINGS . '_youtube_channel_id', 'miaou' );

if( $channel_id === $datalink['channel_id']){
    $own = __('Yes', MEOW_CASTER_SLUG );
} else {
	$own = __('No', MEOW_CASTER_SLUG );
}


?>
<div id="meow-caster-video-datalink" class="mcss-metabox-vdl">
    <p><?php _e( 'Original title', MEOW_CASTER_SLUG ); ?>&nbsp;:&nbsp;<b><?php echo $datalink['title']; ?></b></p>
    <p><?php _e( 'Type', MEOW_CASTER_SLUG ); ?>&nbsp;:&nbsp;<b><?php echo $datalink['type']; ?></b></p>
    <p><?php _e( 'Privacy', MEOW_CASTER_SLUG ); ?>&nbsp;:&nbsp;<b><?php echo $display_status; ?></b></p>
    <p><?php _e( 'From my channel', MEOW_CASTER_SLUG ); ?>&nbsp;:&nbsp;<b><?php echo $own; ?></b></p>
    <p><?php _e( 'Embeddable', MEOW_CASTER_SLUG ); ?>&nbsp;:&nbsp;<b><?php echo $embeddage; ?></b></p>
    <p><?php _e( 'URL', MEOW_CASTER_SLUG ); ?>&nbsp;:&nbsp;<a href="<?php echo $datalink['url']; ?>"
                                                              target="_blank"><?php echo $datalink['url']; ?></a></p>
	<?php

	if ( isset( $datalink['gallery'] ) && sizeof( $datalink['gallery'] ) > 0 ):

		$nbGal = sizeof( $datalink['gallery'] );

		?>
        <p>
            <span><?php printf( _n( "In <b>%d</b> gallery&nbsp;:", "In <b>%d</b> galleries&nbsp;:", $nbGal, MEOW_CASTER_SLUG ), $nbGal ); ?></span>
        <ul class="mcjs-video-datalink-gallery">
			<?php foreach ( $datalink['gallery'] as $gallery_id ): ?>
                <li><?php echo get_the_title( $gallery_id ); ?>
	                <?php
	                // @TODO secure ajax action for delete the link between video and gallery
	                /*
					<button class="mcjs-video-gallery-remove" data-gallery-id="<?php echo $gallery_id; ?>">
						X
						<span class="mcss-visually-hidden"><?php _e( 'Remove from the gallery', MEOW_CASTER_SLUG ); ?></span>
					</button>*/
	                ?>
                </li>
			<?php endforeach; ?>
        </ul>
        </p>
	<?php endif;?>
</div>
