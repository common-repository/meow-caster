<?php
/**
 * Created by PhpStorm.
 * User: id2
 * Date: 18/03/18
 * Time: 18:22
 */

namespace MeowCaster\Widget;

use MeowCaster\Services\MeowShortCode;
use WP_Widget;

class YoutubeEmbed extends \WP_Widget {


	protected static $version = '1.0.0';
	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'mcss-widget-yt',
			'description' => esc_html__( 'Display player, playlist or gallery from YouTube', MEOW_CASTER_SLUG ),
		);
		parent::__construct( 'meow_caster_youtube_widget', esc_html__( 'Youtube Embed with MeowCaster', MEOW_CASTER_SLUG ), $widget_ops );
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		echo $before_widget;
		if ( esc_html( $instance['widget_title'] ) != '' ):
			echo $before_title . esc_html( $instance['widget_title'] ) . $after_title;
		endif;

		ob_start();
		?>
        <div class="meow_caster_widget_yt_embed_container">
		<?php echo trim( do_shortcode( MeowShortCode::getInstance()->generate_from_widget( $args, $instance ) ) );
		?></div><?php

		echo trim( ob_get_clean() );
		echo $after_widget;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		// get value and make default value
		$widget_title  = ! empty( $instance['widget_title'] ) ? $instance['widget_title'] : null;
		$useBy         = ! empty( $instance['useBy'] ) ? $instance['useBy'] : 'url';
		$embedType     = ! empty( $instance['embedType'] ) ? $instance['embedType'] : null;
		$url           = ! empty( $instance['url'] ) ? $instance['url'] : null;
		$content_id    = ! empty( $instance['content_id'] ) ? $instance['content_id'] : null;
		$gallery_id    = ! empty( $instance['gallery_id'] ) ? $instance['gallery_id'] : null;
		$gallery_col   = ! empty( $instance['gallery_col'] ) ? $instance['gallery_col'] : null;
		$gallery_title = ! empty( $instance['gallery_title'] ) ? $instance['gallery_title'] : null;
		$live_theme    = ! empty( $instance['live_theme'] ) ? $instance['live_theme'] : null;
		$live_type    = ! empty( $instance['live_type'] ) ? $instance['live_type'] : null;
		$channel_nbvid   = ! empty( $instance['channel_nbvid'] ) ? $instance['channel_nbvid'] : null;
		$channel_theme   = ! empty( $instance['channel_theme'] ) ? $instance['channel_theme'] : null;
		$channel_view   = ! empty( $instance['channel_view'] ) ? $instance['channel_view'] : null;

		include( MEOW_CASTER_VIEWS_PATH . 'admin' . DIRECTORY_SEPARATOR . 'widget' . DIRECTORY_SEPARATOR . 'yt-embed-tunnel.php' );
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                  = array();
		$instance['widget_title']  = ( ! empty( $new_instance['widget_title'] ) ) ? strip_tags( $new_instance['widget_title'] ) : '';
		$instance['useBy']         = ( ! empty( $new_instance['useBy'] ) ) ? strip_tags( $new_instance['useBy'] ) : '';
		$instance['embedType']     = ( ! empty( $new_instance['embedType'] ) ) ? strip_tags( $new_instance['embedType'] ) : '';
		$instance['url']           = ( ! empty( $new_instance['url'] ) ) ? strip_tags( $new_instance['url'] ) : '';
		$instance['content_id']    = ( ! empty( $new_instance['content_id'] ) ) ? strip_tags( $new_instance['content_id'] ) : '';

		$instance['gallery_id']    = ( ! empty( $new_instance['gallery_id'] ) ) ? strip_tags( $new_instance['gallery_id'] ) : '';
		$instance['gallery_col']   = ( ! empty( $new_instance['gallery_col'] ) ) ? strip_tags( $new_instance['gallery_col'] ) : '';
		$instance['gallery_title'] = ( ! empty( $new_instance['gallery_title'] ) ) ? strip_tags( $new_instance['gallery_title'] ) : '';

		$instance['live_theme'] = ( ! empty( $new_instance['live_theme'] ) ) ? strip_tags( $new_instance['live_theme'] ) : '';
		$instance['live_type'] = ( ! empty( $new_instance['live_type'] ) ) ? strip_tags( $new_instance['live_type'] ) : '';

		$instance['channel_theme']    = ( ! empty( $new_instance['channel_theme'] ) ) ? strip_tags( $new_instance['channel_theme'] ) : '';
		$instance['channel_view']   = ( ! empty( $new_instance['channel_view'] ) ) ? strip_tags( $new_instance['channel_view'] ) : '';
		$instance['channel_nbvid'] = ( ! empty( $new_instance['channel_nbvid'] ) ) ? strip_tags( $new_instance['channel_nbvid'] ) : '';

		return $instance;
	}
}