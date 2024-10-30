<?php
/**
 * Created by PhpStorm.
 * User: id2
 * Date: 08/05/18
 * Time: 17:00
 */

if ( ! isset( $title ) ) {
	$title = '';
}
if ( ! isset( $thumb ) ) {
	$thumb = '';
}
if ( ! isset( $id ) ) {
	$id = '';
}
if ( ! isset( $type ) ) {
	$type = 'playlist';
}
if ( ! isset( $channel_name ) ) {
	$channel_name = '';
}
if ( isset( $imported ) && $imported === true ) {
	$import   = 'yes';
	$class_ok = 'mcss-btn-ok';
	$disabled = 'disabled';
} else {
	$class_ok = '';
	$disabled = '';
}
if ( ! isset( $status ) ) {
	$status = null;
}
switch ( $status ) {
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
		$display_status = $status;
		break;
}

?>
<div class="mcss-import-preview"
     data-import="<?php echo $import; ?>"
     data-name="<?php echo strtolower( $title ); ?>"
     data-privacy="<?php echo $status; ?>"
     data-search-match="no"
>
    <img src="<?php echo $thumb; ?>"/>
    <div class="mcss-preview-info">
        <h4>(<?php echo $display_status; ?>) <?php echo $title; ?></h4>
	    <?php
	    if ( $type === 'playlist' ):
		    ?><span class="playlist"><?php _e( 'Playlist from ', MEOW_CASTER_SLUG ); ?></span><?php
	    endif;
	    ?><span class="channel"><?php echo $channel_name; ?></span>
        <ul class="mcss-preview-taglist">
		    <?php if ( is_array( $tags ) && sizeof( $tags ) > 0 ) {
			    foreach ( $tags as $tag ) {
				    ?>
                    <li class="mcss-preview-tag"><?php echo $tag; ?></li>
			    <?php } // endforeach
		    } //endif
		    // ?>
        </ul>
    </div>
    <div class="mcss-import-validation">
        <button
                class="mcss-btn-multi mcjs-btn-import <?php echo $class_ok; ?>"
	        <?php echo $disabled; ?>
                data-type="<?php echo $type; ?>"
                data-ID="<?php echo $id; ?>"
        >
            <span class="base"><?php _e( 'Import', MEOW_CASTER_SLUG ); ?></span>
            <span class="error"><?php _e( 'Import fail', MEOW_CASTER_SLUG ); ?></span>
            <span class="wait"><?php _e( 'Import', MEOW_CASTER_SLUG ); ?></span>
            <span class="ok"><?php _e( 'Imported', MEOW_CASTER_SLUG ); ?></span>
        </button>
    </div>
</div>
