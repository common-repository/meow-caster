<?php
/**
 * View for plugin config
 */

use function \MeowCaster\get_view;
use function \MeowCaster\get_the_yt_channel_banner;


?>
<div class="mcss-wrapper mcss-form mcss-main-config mcjs-page-import">
    <main><?php
	    $meow_page_title = __( 'Import from YouTube', MEOW_CASTER_SLUG );
		include 'header.php';
		?>
        <div class="mcss-config-container">
            <div class="mcss-tabs">
                <div class="mcss-tabs-side">
                    <ul>
                        <li><a href="#ImportURL"><?php _e( 'Import by URL', MEOW_CASTER_SLUG ); ?></a></li>
                        <li><a href="#ImportVideo"><?php _e( 'Import my videos', MEOW_CASTER_SLUG ); ?></a></li>
                        
                    </ul>
                    <div class="sticky-side">
                    </div>
                </div>
                <div>
                    <section id="mcjs-preview-url-import" class="mcss-config-section mcjs-preview-url-import">
                        <h3 id="ImportURL"><?php _e( 'Import using URL', MEOW_CASTER_SLUG ); ?></h3>
                        <div class="mcss-config-choice mcss-config-choice-txt">
                            <label for="mcss_import_url_url"
                                   class="mcss-label-text"><?php _e( 'URL', MEOW_CASTER_SLUG ); ?></label>
                            <input id="mcss_import_url_url" name="mcss_import_url_url"
                                   class="mcss-input-text custom-input-text"
                                   placeholder="<?php _e( 'YouTube URL', MEOW_CASTER_SLUG ); ?>" value=""
                                   type="url">
                        </div>
                        <div class="mcss-import-url-preview">
                            <div class="mcss-placeholder">
                                <img src="" alt="chargement">
                            </div>
						    <?php
						    echo get_view( 'admin/import-yt-preview', true, array() );
						    ?>
                        </div>
                    </section>
                </div>
                <div>
                    <section class="mcss-config-section mcss-import-channel">
			            <?php
			            echo get_the_yt_channel_banner();
			            ?>
                        <h3 id="ImportVideo"><?php _e( 'Import videos using my channel content', MEOW_CASTER_SLUG ); ?></h3>
                        <div class="mcss-config-information">
				            <?php _e( 'You can directly import videos from your channel. However, video listing from YouTube is expensive on the API\'s Quota. That\'s why you have to click on "Refresh my list"', MEOW_CASTER_SLUG ); ?>
                            <p>
                                <button
                                        class="mcss-btn-multi mcss_import_refresh_list_video"
                                >
                                    <span class="base"><?php _e( 'Refresh my list', MEOW_CASTER_SLUG ); ?></span>
                                    <span class="error"><?php _e( 'Refresh fail', MEOW_CASTER_SLUG ); ?></span>
                                    <span class="wait"><?php _e( 'Reload list', MEOW_CASTER_SLUG ); ?></span>
                                    <span class="ok"><?php _e( 'Refresh done', MEOW_CASTER_SLUG ); ?></span>

                                </button>
                                

                            </p>
                        </div>
			            <?php // if listing already exist ?>
                        <div id="mcss-import-listing">
                            <div class="mcss-import-listing-filter">
                                <div class="mcss-import-listing-counter">
                                    <span class="nb">0</span>
                                    <span class="singular"><?php _e( 'video', MEOW_CASTER_SLUG ); ?></span>
                                    <span class="plural"
                                          style="display:none;"><?php _e( 'videos', MEOW_CASTER_SLUG ); ?></span>
                                </div>
                                <div class="mcss-import-listing-counter-imported">
                                    <span class="nb">0</span>
                                    <span class="singular"><?php _e( 'imported video', MEOW_CASTER_SLUG ); ?></span>
                                    <span class="plural"
                                          style="display:none;"><?php _e( 'imported videos', MEOW_CASTER_SLUG ); ?></span>
                                </div>
                                <p>
                                    <label for="mcss-import-listing-search"><?php _e( 'Search', MEOW_CASTER_SLUG ); ?>
                                        <input id="mcss-import-listing-search" class="mcss-input-text custom-input-text"
                                               type="search"></label>
                                </p>
                                <div class="can-toggle">
                                    <input id="mcss-import-listing-hide" type="checkbox" checked>
                                    <label for="mcss-import-listing-hide">
                                        <div class="can-toggle__switch"
                                             data-checked="<?php _e( 'Show', MEOW_CASTER_SLUG ); ?>"
                                             data-unchecked="<?php _e( 'Hide', MEOW_CASTER_SLUG ); ?>"></div>
                                        <div class="can-toggle__label-text"><?php _e( 'Already imported', MEOW_CASTER_SLUG ); ?></div>
                                    </label>
                                </div>
                            </div>
                            <div class="mcss-import-listing-content">
					            <?php
					            // $cache is MeowCache Obj uncomment for completion
					            $pagesItems = unserialize( $cache->get_cache( 'last', 'listing-vid-yt' ) );
					            if ( $pagesItems === false ) {
						            $pagesItems = [];
					            }
					            foreach ( $pagesItems as $items ) {

						            foreach ( $items as $item ) {
							            
								            if (  in_array( $item['status']['privacyStatus'] ,
									            ['private', 'unlisted'] ) ) {
									            continue;
								            }
							            
							            
				                        $snippet  = $item['snippet'];
							            
								            $imported = ( in_array( $item['id']['videoId'], $alreadyImported ) ) ? true : false;
							            
							            
				                        $param    = [
					                        'title'        => $snippet['title'],
					                        'channel_name' => $snippet['channelTitle'],
					                        'thumb'        => $snippet['thumbnails']['medium']['url'],
					                        'id'           => $item['id']['videoId'],
					                        'type'         => 'video',
					                        'imported'     => $imported,
					                        'status'       => $item['status']['privacyStatus'],
					                        //'tags'         => $snippet['tags']
				                        ];

				                        echo get_view( 'admin/import-yt-preview', true, $param );
			                        }
					            }

					            ?>
                            </div>
                        </div>
                    </section>
                </div>
                
                <?php /*
                <div>
                    <section class="mcss-config-section">
                        <h3 id="Other"><?php _e( 'I don\'t know, goddammit', MEOW_CASTER_SLUG ); ?></h3>
                    </section>
                </div>
                */ ?>
            </div>
        </div>
    </main>
</div>
