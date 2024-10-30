<?php
/**
 *
 */


$data_item = base64_encode( json_encode(
	[
		'id'        => $item->metadata['_meow-caster-videoyt-id'][0],
		'list'      => false,
		'post'      => $item->ID,
		'title'     => $item->post_title,
		'thumbnail' => $item->thumbnail
	]
) );

?>
<div class="mcss-video-list-elem" data-id="<?php echo $item->ID; ?>"
     data-ytid="<?php echo $item->metadata['_meow-caster-videoyt-id'][0]; ?>"
     data-name="<?php echo strtolower( $item->post_title ); ?>">
    <div class="mcss-vle-thumbnail-container">
        <img src="<?php echo $item->thumbnail; ?>">
    </div>
    <div class="mcss-vle-title">
		<?php echo $item->post_title; ?>
    </div>
    <div class="mcss-overlay">
        <button class="mcjs-vle-add"
                data-item="<?php echo $data_item; ?>"
        ><?php _e( 'Add this video', MEOW_CASTER_SLUG ); ?></button>
    </div>
</div>

