<?php
/**
 *
 *
 * @var $item \MeowCaster\Services\MeowVideoGallery
 */


?>
<div class="mcss-vtg-item mcss-vtg-gallery-item"
     data-id="<?php echo $item->post->ID; ?>"
     data-name="<?php echo strtolower( $item->post->post_title ); ?>">
    <input type="checkbox"
           class="mcss-checkbox-hidden"
           id="mc-vtg-gallery-item<?php echo $item->post->ID; ?>"
           name="mc-vtg[gallery][items][]"
           value="<?php echo $item->post->ID; ?>">

    <div class="mcss-vtg-item-title">
		<?php echo $item->post->post_title; ?>
        <p><?php printf( _n( "contains <b>%d</b> video", "contains <b>%d</b> videos", $item->count(), MEOW_CASTER_SLUG ), $item->count() ); ?></p>
    </div>
    <div class="mcss-overlay">
        <label class="mcjs-vtg-add"
               for="mc-vtg-gallery-item<?php echo $item->post->ID; ?>"
        >+<span class="mcss-visually-hidden"><?php _e( 'Select this gallery', MEOW_CASTER_SLUG ); ?></span></label>
        <label class="mcjs-vtg-remove"
               for="mc-vtg-gallery-item<?php echo $item->post->ID; ?>"
        >−<span class="mcss-visually-hidden"><?php _e( 'Unselect this gallery', MEOW_CASTER_SLUG ); ?></span></label>
    </div>
</div>

