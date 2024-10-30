<?php
/**
 * Template for Shortcode youtube galleries
 *
 */

use function MeowCaster\yt_id_to_url;

$meta          = maybe_unserialize( $postmeta['_meow-caster-video-gallery-list'][0] );
$gallery_items = $meta['items'];
$col           = ( isset( $col ) ) ? $col : $meta['col'];
$title         = ( ( isset( $title ) && $title == 'on' ) || ( ! isset( $title ) && isset( $meta['title'] ) && $meta['title'] == 'on' ) ) ? true : false;

if ( $consent === false && $consent_status === 'on') {
	$lightbox_class = "";
	$target         = 'target="_blank"';
} else {
	$lightbox_class = 'glightbox';
	$target         = '';
}

?>
<div class="mcss-vgc mcss-video-gallery-grid<?php echo $col; ?>">
	<?php foreach ( $gallery_items as $item ) {
		$item     = json_decode( $item );
		$item_url = yt_id_to_url( $item->id, $item->list );
		$rand     = rand( 20, 1 );
		?>
        <div class="mcss-video-gallery-item">
            <a href="<?php echo $item_url; ?>" class="<?php echo $lightbox_class; ?>" <?php echo $target; ?> >
				<?php if ( ! $title ) { ?>
                    <span class="mcss-video-gallery-thumbcontainer">
                        <img src="<?php echo $item->thumbnail; ?>" title="<?php echo $item->title; ?>">
                    </span>
				<?php } else { ?>
                    <span class="mcss-video-gallery-thumbcontainer">
                        <img src="<?php echo $item->thumbnail; ?>" aria-labelledby="<?php echo $item->id . $rand; ?>">
                    </span>
                    <span id="#<?php echo $item->id . $rand; ?>"><?php echo $item->title; ?></span>
				<?php } ?>
            </a>
        </div>
	<?php } ?>
</div>
