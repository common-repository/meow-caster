<?php
/**
 *
 */

$attachement = wp_get_attachment_image_url( $item->postmeta['_thumbnail_id'], [ 640, 480 ] );

$data_item = base64_encode( json_encode(
	[
		'id'        => $item->postmeta['_meow-caster-videoyt-id'],
		'list'      => false,
		'post'      => $item->post->ID,
		'title'     => $item->post->post_title,
		'thumbnail' => $attachement
	]
) );
?>
<div class="mcss-vtg-item mcss-vtg-video-item"
     data-id="<?php echo $item->post->ID; ?>"
     data-name="<?php echo strtolower( $item->post->post_title ); ?>">
    <input type="checkbox"
           class="mcss-checkbox-hidden "
           id="mc-vtg-video-item<?php echo $item->post->ID; ?>"
           name="mc-vtg[video][items][]"
           value="<?php echo $data_item; ?>">
    <div class="mcss-vtg-item-thumb">
        <img src="<?php echo wp_get_attachment_image_url( $item->postmeta['_thumbnail_id'], [ 100, 100 ] ); ?>">
    </div>
    <div class="mcss-vtg-item-title">
		<?php echo $item->post->post_title; ?>
    </div>
    <div class="mcss-overlay">
        <label class="mcjs-vtg-add"
               for="mc-vtg-video-item<?php echo $item->post->ID; ?>"
        >+<span class="mcss-visually-hidden"><?php _e( 'Select this video', MEOW_CASTER_SLUG ); ?></span></label>
        <label class="mcjs-vtg-remove"
               for="mc-vtg-video-item<?php echo $item->post->ID; ?>"
        >−<span class="mcss-visually-hidden"><?php _e( 'Unselect this video', MEOW_CASTER_SLUG ); ?></span></label>
    </div>
</div>

