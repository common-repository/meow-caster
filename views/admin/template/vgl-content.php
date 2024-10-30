<?php
/**
 *
 * @var $item string JSON
 */


namespace MeowCaster;



$itemA = json_decode( $item, true );

$id      = ( isset( $itemA['id'] ) ) ? $itemA['id'] : '';
$post_id = ( isset( $itemA['post'] ) ) ? $itemA['post'] : '';
$title   = ( isset( $itemA['title'] ) ) ? $itemA['title'] : '';

if ( ( $id === '' || $id === false ) && $itemA['list'] !== false ) {
	$id = yt_list_to_id( $itemA['list'] );
}

?>
<div class="mcss-vgl-content" data-ytid="<?php echo $id; ?>" data-post-id="<?php echo $post_id; ?>">
    <i class="js-remove">❌</i>
	<?php if ( $post_id !== '' ):
		$thumbnail = ( isset( $itemA['thumbnail'] ) ) ? $itemA['thumbnail'] : '';
		?>
        <div class="mcss-vgl-content-img-post">
            <img class="mcss-vgl-content-img"
                 src="<?php echo $thumbnail; ?>">
        </div>
	<?php else: ?>
        <div class="mcss-vgl-content-img-url">
            <img class="mcss-vgl-content-img" src="https://i.ytimg.com/vi/<?php echo $id; ?>/maxresdefault.jpg">
        </div>
	<?php endif; ?>
    <input name="_meow-caster-video-gallery-list[items][]"
           value="<?php echo htmlentities( $item, ENT_QUOTES ); ?>" type="hidden">
    <p class="mcss-vgl-content-title"><?php echo $title; ?></p>
</div>
