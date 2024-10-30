<?php
/**
 * Form to add 1:n videos to 1:n galleries
 *
 * Video to gallery
 * module CSS mcss-vtg-*
 *
 */

use function MeowCaster\get_view;

?>
<div class="mcss-wrapper mcss-form mcss-main-config mcjs-page-import">
    <main><?php
		$meow_page_title = __( 'Add Meow Video to Meow Gallery', MEOW_CASTER_SLUG );
		include 'header.php';
		?>
        <form action="#" method="post" enctype="multipart/form-data">
			<?php wp_nonce_field( MEOW_CASTER_SLUG_ . '_video_to_gallery', MEOW_CASTER_SLUG_ . '_nonce' ); ?>
            <div class="mcss-config-container mcss-vtg-container">

                <section class="mcss-vtg-video">

                    <h3><?php _e( 'Video', MEOW_CASTER_SLUG ); ?></h3>

                    <p><?php _e( 'You can add videos to a brand new gallery or/and to one or more galleries.', MEOW_CASTER_SLUG ); ?></p>

                    <p><?php _e( 'Select videos you want to send to gallery or galleries', MEOW_CASTER_SLUG ); ?></p>
                    <div class="mcss-vtg-filter">
                        <div class="mcss-vtg-search">
                            <label for="mcss-vtg-video-search"><?php _e( 'Search', MEOW_CASTER_SLUG ); ?>
                                <input id="mcss-vtg-video-search"
                                       class="mcss-input-text custom-input-text mcjs-input-search"
                                       data-meow-target=".mcss-vtg-video .mcss-vtg-item"
                                       data-meow-target-container=".mcss-vtg-video .mcss-vtg-listing"

                                       type="search"></label>
                        </div>
                        <div class="mcss-vtg-counter"
                             data-target=".mcss-vtg-video .mcss-vtg-listing">
                            <a href="#" class="mcss-vtg-counter-all mcss-vtg-link-disable">
                                <span><?php _e( 'All', MEOW_CASTER_SLUG ); ?></span>
                                (<span class="nb"><?php echo count( $videoItems ) ?></span>)
                            </a>
                            <a href="#" class="mcss-vtg-counter-selected">
                                <span><?php _e( 'Selected', MEOW_CASTER_SLUG ); ?></span>
                                (<span class="nb">0</span>)
                            </a>
                        </div>
                    </div>
                    <div class="mcss-vtg-listing">
						<?php

						foreach ( $videoItems as $item ) {
							echo get_view( 'admin/template/vtg-video-item', true, [ 'item' => $item ] );

						}

						?>
                    </div>
                </section>
                <section class="mcss-vtg-validation">
                    <button id="mcjs-btn-validator"
                            title="<?php _e( 'Add selected videos to selected galleries', MEOW_CASTER_SLUG ); ?>"></button>
                </section>
                <section class="mcss-vtg-gallery">
                    <h3><?php _e( 'Gallery', MEOW_CASTER_SLUG ); ?></h3>

                    <div class="mcss-vtg-gallery-new">
                        <div>
                            <input id="mc-vtg-gal-new" name="mc-vtg[gallery][new][active]" class="custom-checkbox"
                                   type="checkbox">
                            <label for="mc-vtg-gal-new"><?php _e( 'Add in new gallery', MEOW_CASTER_SLUG ); ?></label>
                            <div>
                                <label for="mc-vtg-gal-new-title">
									<?php _e( 'Title', MEOW_CASTER_SLUG ); ?>
                                    <input id="mc-vtg-gal-new-title" name="mc-vtg[gallery][new][title]"
                                           class="mcss-input-text custom-input-text"
                                           type="text">
                                </label>
                            </div>

                        </div>
                    </div>
                    <p><?php _e( 'and/or in existing gallery', MEOW_CASTER_SLUG ); ?></p>
                    <div class="mcss-vtg-filter">
                        <div class="mcss-vtg-search">
                            <label for="mcss-vtg-gallery-search"><?php _e( 'Search', MEOW_CASTER_SLUG ); ?>
                                <input id="mcss-vtg-gallery-search"
                                       class="mcss-input-text custom-input-text mcjs-input-search"
                                       data-meow-target=".mcss-vtg-gallery .mcss-vtg-item"
                                       data-meow-target-container=".mcss-vtg-gallery .mcss-vtg-listing"
                                       type="search"></label>
                        </div>
                        <div class="mcss-vtg-counter"
                             data-target=".mcss-vtg-gallery .mcss-vtg-listing">
                            <a href="#" class="mcss-vtg-counter-all mcss-vtg-link-disable">
                                <span><?php _e( 'All', MEOW_CASTER_SLUG ); ?></span>
                                (<span class="nb"><?php echo count( $galleryItems ) ?></span>)
                            </a>
                            <a href="#" class="mcss-vtg-counter-selected"
                            <span><?php _e( 'Selected', MEOW_CASTER_SLUG ); ?></span>
                            (<span class="nb">0</span>)
                            </a>
                        </div>
                    </div>

                    <div class="mcss-vtg-listing">
						<?php


						foreach ( $galleryItems as $item ) {
							echo get_view( 'admin/template/vtg-gallery-item', true, [ 'item' => $item ] );
						}

						?>
                    </div>

                </section>
            </div>
        </form>
    </main>
</div>
