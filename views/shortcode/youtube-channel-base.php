<?php
/**
 * Template for Shortcode youtube player
 *
 *
 */
$channel = $channelInfo['channel']->getItems()[0];
$videos = $channelInfo['videos'];


$views = $channel['statistics']['viewCount'];
$subs = $channel['statistics']['subscriberCount'];
$vids = $channel['statistics']['videoCount'];

$channelThumbnail = $channel['snippet']['thumbnails']['medium']['url'];


$theme = $opt['theme'];
$videosView = $opt['view'];
if ( $consent === false ) {
	$lightbox_class = "";
	$target         = 'target="_blank"';

	$btn_yt_title = sprintf( __('Subscribe to %s', MEOW_CASTER_SLUG), $channel['snippet']['title']);
    $button_yt = '<a href="'. $url. 'channel/'. $channel['id'].'?sub_confirmation=1" class="mcss-btn-youtube" title="'.$btn_yt_title.'" '.$target.'> YouTube </a>';

} else {
	$lightbox_class = 'glightbox';
	$target         = '';
	$button_yt_theme = ($theme === 'dark')? 'dark' : 'default';
	$button_yt = '<div class="g-ytsubscribe" data-channelid="'.$channel['id'].'" data-layout="default" data-theme="'.$button_yt_theme.'" data-count="default"></div>';
}


?>
<div class="mcss-cer mcss-channel-embed-<?php echo $theme; ?>">
	<header class="mcss-cer-head">
		<img src="<?php echo $channelThumbnail; ?>" alt="" class="mcss-cer-logo">
		<div class="mcss-cer-title-container">
            <p class="mcss-cer-title"><?php echo $channel['snippet']['title']; ?></p>
            <?php echo $button_yt ;?>
        </div>
        <div class="mcss-cer-info">
	        <?php echo $channel['snippet']['description']; ?>
        </div>
        <div class="mcss-cer-stats">
            <span><?php echo sprintf( _n( '%s view', '%s views', (int) $views, MEOW_CASTER_SLUG ), \MeowCaster\meow_nice_counter($views) ); ?></span>
            <span><?php echo sprintf( _n( '%s subscriber', '%s subscribers', (int) $subs, MEOW_CASTER_SLUG ), \MeowCaster\meow_nice_counter($subs) ); ?></span>
            <span><?php echo sprintf( _n( '%s video', '%s videos', (int) $vids, MEOW_CASTER_SLUG ), \MeowCaster\meow_nice_counter($vids) ); ?></span>
        </div>
    </header>
    <?php if ( $videos !== [] && ! is_null( $videosView )  ): ?>
    <div class="mcss-cer-videos mcss-cer-videos-<?php echo $videosView; ?>">
        <?php if ( $videosView === 'slider'){ ?>
        <div class="mcss-cer-videos-prev">&lt;</div>
        <?php } ?>
        <div class="mcss-cer-videos-container">
            <?php
            foreach( $videos as $vid ){

                $item_url = $url . 'watch?v=' . $vid['id']['videoId'];
                $title = $vid['snippet']['title'];
                $thumbnail = $vid['snippet']['thumbnails']['medium']['url'];
                //var_dump( $vid['snippet']['thumbnails'] );
                ?>
                <div class="mcss-cer-video-item">
                    <a href="<?php echo $item_url; ?>" class="mcss-cer-video-thumbcontainer <?php echo $lightbox_class; ?>" <?php echo $target; ?> >
                        <img src="<?php echo $thumbnail; ?>" title="<?php echo $title; ?>">
                    </a>
                </div>
            <?php } ?>
        </div>
        <?php if ( $videosView === 'slider'){ ?>
        <div class="mcss-cer-videos-next">&gt;</div>
        <?php } ?>
    </div>
    <?php endif; ?>
</div><?php
//EOF
