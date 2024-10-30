<?php
/**
 * Created by PhpStorm.
 * User: id2
 * Date: 7/03/18
 * Time: 18:05
 */

namespace MeowCaster\Services;


use function MeowCaster\yt_url_to_id;

defined( 'ABSPATH' ) or die( 'Doh?!' );

class MeowShortCode {
	protected static $instance;
	public $consent = false; // [shortcode => function_name]
	public $consent_theme = 'dark';
	public $cookie = 'both';
	/**
	 * @since 0.9.0
	 */
	protected $version = '0.9.5';
	protected $roar;
	protected $shortcode_list = [];
	protected $youtube_param = null;

	protected function __construct() {
		$this->roar = MeowRoar::getInstance();

		$this->youtube_param = get_option( MEOW_CASTER_SETTINGS . '_youtube_player_settings' );
		$tmp                 = get_option( MEOW_CASTER_SETTINGS . '_base_settings' );

		$this->consent_status   = ( isset( $tmp['yts']['consent-status'] ) && $tmp['yts']['consent-status'] === 'on' ) ? 'on' : 'off';
		$this->consent_duration = ( isset( $tmp['yts']['consent'] ) ) ? $tmp['yts']['consent'] : 3;
		$this->consent_theme    = ( isset( $tmp['yts']['consent-theme'] ) ) ? $tmp['yts']['consent-theme'] : 'dark';
		$this->cookie           = ( isset( $tmp['yts']['cookie'] ) ) ? $tmp['yts']['cookie'] : 'both';


		if ( ! in_array( $this->cookie, [ 'both', 'cookie-only', 'nocookie-only' ] ) ) {
			$this->cookie = 'both';
		}
		$this->consent = ( isset( $_COOKIE['_mc_save_consent'] ) ) ? $_COOKIE['_mc_save_consent'] : false;
	}

	/**
	 * @return \MeowCaster\Services\MeowShortCode
	 */
	public static function getInstance() {
		is_null( self::$instance ) AND self::$instance = new self;

		return self::$instance;
	}
	// Manage registration

	/**
	 * Define what shortcode are active
	 *
	 * @return $this
	 */
	public function activation() {
		// active the usage of shortcode
		$tmp_list = array(
			'meow_yt_player'   => 'youtube_player',
			'meow_yt_playlist' => 'youtube_playlist',
			'meow_yt_channel'  => 'youtube_channel',
			'meow_yt_gallery'  => 'youtube_gallery',
			'meow_yt_live'     => 'youtube_live',
		);

		$this->shortcode_list = $tmp_list;

		return $this;
	}

	public function register() {
		// register all shortcode
		foreach ( $this->shortcode_list as $shortcode => $function_name ) {
			add_shortcode( $shortcode, array( $this, $function_name ) );
		}

		return $this;
	}

	public function generate_from_widget( $args, $instance ) {
		$array_shortcode = [
			'player'   => 'meow_yt_player',
			'playlist' => 'meow_yt_playlist',
			'gallery'  => 'meow_yt_gallery',
			'live'     => 'meow_yt_live',
			'channel'  => 'meow_yt_channel'
		];
		if ( ! array_key_exists( $instance['embedType'], $array_shortcode ) ) {
			return;
		}
		//embedType
		$sc_name    = $array_shortcode[ $instance['embedType'] ];
		$sc_content = null;
		$sc_param   = [
			'widget' => 1
		];

		//useBy
		if ( ! in_array( $sc_name, [ 'meow_yt_live', 'meow_yt_channel' ] ) ) {
			$useBy = ( $sc_name === 'meow_yt_gallery' ) ? 'gallery_id' : $instance['useBy'];

			switch ( $useBy ) {
				case 'url':
					$sc_param['url'] = strip_tags( $instance['url'] );
					break;
				case 'content_id':
					$sc_param['content_id'] = strip_tags( $instance['content_id'] );
					break;
				case 'gallery_id':
					$sc_param['id']  = strip_tags( $instance['gallery_id'] );
					$sc_param['col'] = strip_tags( $instance['gallery_col'] );
					if ( isset( $instance['gallery_title'] ) && strip_tags( $instance['gallery_title'] ) !== '' ) {
						$sc_param['title'] = strip_tags( $instance['gallery_title'] );
					}
					break;
				default:
					break;
			}
		} else {

			$view_instance     = ( $sc_name === 'meow_yt_live' ) ? 'live_type' : 'channel_view';
			$theme_instance    = ( $sc_name === 'meow_yt_live' ) ? 'live_theme' : 'channel_theme';
			$sc_param['view']  = strip_tags( $instance[ $view_instance ] );
			$sc_param['theme'] = strip_tags( $instance[ $theme_instance ] );
			if ( $sc_name === 'meow_yt_channel' ) {
				$sc_param['nb_vid'] = strip_tags( $instance['channel_nbvid'] );
			}

		}

		return $this->generator( $sc_name, $sc_param, $sc_content );
	}

	// Getter

	public function generator( $name = false, $param = array(), $content = null ) {

		if ( ! $name || ! array_key_exists( $name, $this->shortcode_list ) || ! is_array( $param ) ) {
			return;
		}
		$sc = '[' . $name . ' ';

		if ( sizeof( $param ) !== 0 ) {
			foreach ( $param as $p => $val ) {
				$sc .= $p . '="' . $val . '" ';
			}
		}
		if ( ! is_null( $content ) ) {
			$sc .= ']' . $content . '[/' . $name;
		}
		$sc .= ']';

		return $sc;
	}

	public function youtube_player( $atts = null ) {
		if ( is_null( $atts ) ) {
			return;
		}

		$atts_default = array(
			'url'          => null,
			'content_id'   => null,
			'param'        => null,
			'direct_embed' => true,
			'widget'       => 0
		);
		$attributs    = shortcode_atts( $atts_default, $atts );

		if ( is_null( $attributs['url'] ) && ! is_null( $attributs['content_id'] ) ) {
			$content_id = $attributs['content_id'];
		} elseif ( ! is_null( $attributs['url'] ) && is_null( $attributs['content_id'] ) ) {
			$url = $attributs['url'];
		} else {
			return;
		}

		if ( is_null( $attributs['param'] ) ) {

			$attributs['param'] = '?' . $this->get_param();


		} elseif ( $attributs['param'] == '' ) {
			$attributs['param'] = '?';
		}

		if ( isset( $this->youtube_param['lazyload'] ) && $this->youtube_param['lazyload'] == 'on' ) {
			$attributs['direct_embed'] = false;
		}
		if ( ! $attributs['direct_embed'] ) {
			str_replace( 'autoplay=0&', '', $attributs['param'] );
			$attributs['param'] .= 'autoplay=1&';
		}

		// Hooks Before process
		if ( ! isset( $content_id ) && ! isset( $url ) ) {
			return false;
		}

		$youtube_id = ( isset( $content_id ) && ! is_null( $content_id ) ) ? $content_id : yt_url_to_id( $url );
		if ( ! $youtube_id ) {
			return false;
		}


		$attributs['videoID'] = $youtube_id;
		if ( $this->consent === 'without-cookie' ) {
			$attributs['url'] = 'https://www.youtube-nocookie.com/embed/' . $youtube_id;
		} else {
			$attributs['url'] = 'https://www.youtube.com/embed/' . $youtube_id;
		}

		$attributs = $this->addConsent( $attributs );

		// @TODO use local image instead of the YouTube image
		//$image_url     = 'https://img.youtube.com/vi/' . $youtube_id . '/maxresdefault.jpg';
		//$response      = wp_remote_request( $image_url );
		//$response_code = wp_remote_retrieve_response_code( $response );

		// Hooks Before view

		// Get view
		$html = $this->get_view( 'youtube-player', $attributs );


		// Hook after view
		return trim( $html );
	}

	protected function get_param() {
		$option = get_option( MEOW_CASTER_SETTINGS . '_youtube_player_settings' );
		if ( is_array( $option ) ) {
			$option_default = $option;
		}

		$param = '';
		$param .= ( isset( $option_default['modest'] ) && $option_default['modest'] == 'checked' ) ? 'modestbranding=1&' : '';
		$param .= ( isset( $option_default['control'] ) && $option_default['control'] == 'checked' ) ? '' : 'controls=0&';
		$param .= ( isset( $option_default['caption'] ) && $option_default['caption'] == 'checked' ) ? 'cc_load_policy=1&' : '';
		$param .= ( isset( $option_default['annotations'] ) && $option_default['annotations'] == 'checked' ) ? '' : 'iv_load_policy=3&';
		$param .= ( isset( $option_default['info'] ) && $option_default['info'] == 'checked' ) ? '' : 'showinfo=0&';
		$param .= ( isset( $option_default['related'] ) && $option_default['related'] == 'checked' ) ? '' : 'rel=0&';
		$param .= ( isset( $option_default['autoplay'] ) && $option_default['autoplay'] == 'checked' ) ? 'autoplay=1&' : '';
		$param .= ( isset( $option_default['fullscreen'] ) && $option_default['fullscreen'] == 'checked' ) ? '' : 'fs=0&';
		$param .= ( isset( $option_default['loop'] ) && $option_default['loop'] == 'checked' ) ? 'loop=1&' : '';
		$param .= ( isset( $option_default['playinline'] ) && $option_default['playinline'] == 'checked' ) ? 'playinline=1&' : '';
		$param .= ( isset( $option_default['color'] ) && $option_default['color'] == 'red' ) ? '' : 'color=white&';


		return $param;
	}


	// Generator

	public function addConsent( $attributs ) {
		// Add all variable around consent RGPD/Cookie
		$attributs['cookie']           = $this->cookie;
		$attributs['consent']          = $this->consent;
		$attributs['consent_duration'] = $this->consent_duration;
		$attributs['consent_theme']    = $this->consent_theme;
		$attributs['consent_status']   = $this->consent_status;

		return $attributs;

	}

	/** get view specific to shortcode with ob
	 *
	 * @param null  $page
	 * @param array $imported_var
	 */
	function get_view( $page = null, $imported_var = array() ) {
		if ( is_null( $page ) ) {
			die ( '?!' );
		}

		//var_dump($var);
		extract( $imported_var, EXTR_REFS );
		ob_start();
		// get view
		include( MEOW_CASTER_VIEWS_PATH . 'shortcode' . DIRECTORY_SEPARATOR . $page . '.php' );
		$html = ob_get_clean();

		// process
		return $html;

	}

	/** Shortcodes Youtube player
	 *  Display a Youtube Player
	 *  [meow_yt_player]
	 *
	 */

	// Shortcode functions

	/** shortcode YouTube Playlist
	 *  Display a Youtube Playlist
	 *  [meow_yt_playlist]
	 *
	 */
	public function youtube_playlist( $atts = null ) {
		if ( is_null( $atts ) ) {
			return;
		}
		$atts_default = array(
			'url'          => null,
			'content_id'   => null,
			'param'        => null,
			'direct_embed' => false,
			'widget'       => false
		);
		$attributs    = shortcode_atts( $atts_default, $atts );

		if ( is_null( $attributs['url'] ) && ! is_null( $attributs['content_id'] ) ) {
			$content_id = $attributs['content_id'];
		} elseif ( ! is_null( $attributs['url'] ) && is_null( $attributs['content_id'] ) ) {
			$url = $attributs['url'];
		} else {
			return;
		}

		if ( is_null( $attributs['param'] ) ) {

			$attributs['param'] = '&' . $this->get_param();


		} elseif ( $attributs['param'] == '' ) {
			$attributs['param'] = '&';
		}

		if ( isset( $this->youtube_param['lazyload'] ) && $this->youtube_param['lazyload'] == 'on' ) {
			$attributs['direct_embed'] = false;
		}
		if ( ! $attributs['direct_embed'] ) {
			str_replace( 'autoplay=0&', '', $attributs['param'] );
			$attributs['param'] .= 'autoplay=1&';
		}
		// Hooks Before process

		if ( ! isset( $content_id ) && ! isset( $url ) ) {
			return;
		}
		if ( isset( $url ) ) {
			$tmpId = yt_url_to_id( $url, 'playlist' );
			if ( ! $tmpId ) {
				echo 'Error URL to ID ';

				return;
			}
			list( $youtube_firstvid_id, $youtube_playlist_id ) = $tmpId;

			$attributs['videoID'] = $youtube_firstvid_id;
			$playId               = $youtube_playlist_id;
		} elseif ( isset( $content_id ) ) {
			$attributs['videoID'] = $content_id;
			$playId               = $content_id;
		}

		if ( $this->consent === 'without-cookie' ) {
			$attributs['url'] = 'https://www.youtube-nocookie.com/embed/videoseries?list=' . $playId;
		} else {
			$attributs['url'] = 'https://www.youtube.com/embed/videoseries?list=' . $playId;
		}

		$attributs = $this->addConsent( $attributs );
		// Hooks Before view

		// Get view
		$html = $this->get_view( 'youtube-playlist', $attributs );

		// Hook after view
		return $html;
	}

	/**  shortcode YouTube Gallery
	 *  Display a Youtube Gallery
	 *  [meow_yt_gallery]
	 *
	 */
	public function youtube_gallery( $atts = null ) {
		if ( is_null( $atts ) ) {
			return;
		}
		$atts_default = array(
			'id'     => null,
			'urls'   => null,
			'title'  => null,
			'desc'   => null,
			'col'    => 2,
			'widget' => false
		);
		$attributs    = shortcode_atts( $atts_default, $atts );

		if ( is_null( $attributs['id'] ) && is_null( $attributs['urls'] ) ) {
			return;
		}

		if ( ! is_null( $attributs['id'] ) ) {

			$attributs['post'] = get_post( $attributs['id'] );
			if ( ! isset( $attributs['post']->post_type ) || $attributs['post']->post_type != 'meow-video-gallery' ) {
				return;
			}
			$attributs['postmeta'] = get_post_meta( $attributs['id'] );

		}
		if ( ! is_numeric( $attributs['col'] ) ) {
			$attributs['col'] = intval( $attributs['col'] );
		}
		if ( $attributs['col'] < 1 && $attributs['col'] > 4 ) {
			$attributs['col'] = 2;
		}

		$attributs = $this->addConsent( $attributs );
		// Hooks Before process

		// PreProcess

		// Hooks Before view

		// Get view
		$html = $this->get_view( 'youtube-gallery', $attributs );

		// Hook after view
		return $html;
	}

	/** Shortcode YouTube Channel
	 *
	 * Display a Youtube Gallery
	 * [meow_yt_gallery]
	 *
	 */
	public function youtube_channel( $atts = null ) {
		if ( is_null( $atts ) ) {
			return;
		}

		$atts_default = array(
			'param'        => null,
			'direct_embed' => true,
			'theme'        => 'raw',
			'view'         => 'banner',
			'nb_vid'       => 5,
			'widget'       => 0
		);
		$attributs    = shortcode_atts( $atts_default, $atts );
		$channel_id   = get_option( MEOW_CASTER_SETTINGS . '_youtube_channel_id', false );

		if ( ! $channel_id ) {
			$attributs['param'] = '?';
		} else {
			$attributs['param'] = '?channel=' . $channel_id;
		}
		if ( is_null( $attributs['param'] ) ) {
			$attributs['param'] .= $this->get_param();
		}

		if ( isset( $this->youtube_param['lazyload'] ) && $this->youtube_param['lazyload'] == 'on' ) {
			$attributs['direct_embed'] = false;
		}
		if ( ! $attributs['direct_embed'] ) {
			str_replace( 'autoplay=0&', '', $attributs['param'] );
			$attributs['param'] .= 'autoplay=1&';
		}

		// Hooks Before process

		//Take the channel id

		if ( $this->consent === 'without-cookie' ) {
			$attributs['url'] = 'https://www.youtube-nocookie.com/';
		} else {
			$attributs['url'] = 'https://www.youtube.com/';
		}
		$this->enqueue_google_api();


		$attributs = $this->addConsent( $attributs );


		$attributs['opt'] = [
			'theme'  => $attributs['theme'],
			'view'   => $attributs['view'],
			'nb_vid' => $attributs['nb_vid']
		];

		// Live ?
		$myt = new MeowYouTube();
		if ( $attributs['view'] === 'banner' ) {
			$attributs['channelInfo'] = $myt->getChannelInfo();
		} else {
			$attributs['channelInfo'] = $myt->getChannelInfo( $attributs['view'], (int) $attributs['nb_vid'] );
		}

		// Hooks Before process

		// PreProcess

		// Hooks Before view

		// Get view
		$html = $this->get_view( 'youtube-channel-base', $attributs );

		// Hook after view


		return $html;
	}

	protected function enqueue_google_api() {

		if ( $this->consent !== false ) {
			wp_enqueue_script( 'google-api-js', 'https://apis.google.com/js/platform.js' );
		}
	}

	/** Shortcode YouTube Live
	 *
	 * Display a Youtube Gallery
	 * [meow_yt_live]
	 *
	 */
	public function youtube_live( $atts = null ) {
		if ( is_null( $atts ) ) {
			return;
		}

		$atts_default = array(
			'param'        => null,
			'direct_embed' => true,
			'view'         => 'embed',
			'theme'        => 'light',
			'widget'       => 0
		);
		$attributs    = shortcode_atts( $atts_default, $atts );


		$channel_id      = get_option( MEOW_CASTER_SETTINGS . '_youtube_channel_id', false );
		$yt_base_setting = get_option( MEOW_CASTER_SETTINGS . '_base_settings' );

		if ( ! $channel_id ) {
			$attributs['param'] = '?';
		} else {
			$attributs['param'] = '?channel=' . $channel_id;
		}
		if ( is_null( $attributs['param'] ) ) {
			$attributs['param'] .= $this->get_param();
		}

		if ( isset( $this->youtube_param['lazyload'] ) && $this->youtube_param['lazyload'] == 'on' ) {
			$attributs['direct_embed'] = false;
		}
		if ( ! $attributs['direct_embed'] ) {
			str_replace( 'autoplay=0&', '', $attributs['param'] );
			$attributs['param'] .= 'autoplay=1&';
		}

		// Hooks Before process

		//Take the channel id

		if ( $this->consent === 'without-cookie' ) {
			$attributs['url'] = 'https://www.youtube-nocookie.com/embed/live_stream';
		} else {
			$attributs['url'] = 'https://www.youtube.com/embed/live_stream';
		}

		$attributs = $this->addConsent( $attributs );

		// Live ?
		$myt                      = new MeowYouTube();
		$mytTmp                   = $myt->isLive();
		$attributs['is_live']     = $mytTmp['isLive']['status'];
		$attributs['videoId']     = $mytTmp['isLive']['id'];
		$attributs['channelInfo'] = $mytTmp['channelInfo'];

		// Take setting in count for the bar type
		if ( isset( $yt_base_setting['yts']['live']['no-live-type'] )
		     && $yt_base_setting['yts']['live']['no-live-type'] === 'bar' ) {
			$attributs['view'] = 'bar';
		}
		if ( ! $attributs['is_live'] && $attributs['view'] !== 'bar' ) {
			$attributs['noLiveMsg'] = $yt_base_setting['yts']['live']['no-live-msg'];
		}
		if ( $attributs['view'] === 'bar' ) {
			$this->enqueue_google_api();
		}
		// Hooks Before process

		// PreProcess

		// Hooks Before view

		// Get view
		$html = $this->get_view( 'youtube-live', $attributs );

		// Hook after view


		return $html;
	}

}