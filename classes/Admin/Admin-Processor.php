<?php
/**
 * Class Admin Processor
 *
 * @package     Admin\Process
 *
 * @since       1.0.0
 * @php_version 5.3+
 *
 */

namespace MeowCaster\Admin;

use MeowCaster\Contents\MeowVideoGallery;
use MeowCaster\Services\MeowGoogleClient;
use MeowCaster\Services\MeowRoar;

defined( 'ABSPATH' ) or die( 'Doh?!' );


/**
 * Class Admin_Processor
 *
 * @since   0.6.0
 * @package MeowCaster\Admin
 */
class Admin_Processor {

	protected static $instance;

	protected static $version = '1.1.0';

	protected $roar;

	protected function __construct() {
		$this->roar = MeowRoar::getInstance();
	}


	/**
	 * @return \MeowCaster\Admin\Admin_Processor
	 */
	public static function getInstance() {
		is_null( self::$instance ) AND self::$instance = new self;

		return self::$instance;
	}

	public function form_settings_process() {
		$request  = '';
		$response = '';
		$error    = array();
		/*
		 * Form's part by service
		 *
		 * gs       => Global settings ( CPT, common to all platform )
		 * as       => Auth settings ( creds, auth, activation, ...)
		 *
		 * yts      => YouTube Settings
		 * ytp      => YouTube Player Settings
		 *
		 * vs       => Vimeo Settings
		 * vp       => Vimeo Player Settings
		 *
		 */
		$part = array( 'gs', 'as', 'yts', 'ytp', 'vs', 'capabilities' );
		//Get the POST request
		$request = $_POST['mc-main-settings'];

		// Parse it into little variable for each part
		$gs   = ( isset( $request['gs'] ) ) ? $request['gs'] : array();
		$as   = ( isset( $request['as'] ) ) ? $request['as'] : array();
		$yts  = ( isset( $request['yts'] ) ) ? $request['yts'] : array();
		$ytp  = ( isset( $request['ytp'] ) ) ? $request['ytp'] : array();
		$capa = ( isset( $request['capabilities'] ) ) ? $request['capabilities'] : [];
		//$vs  = ( isset( $request['vs'] ) ) ? $request['vs'] : array();

		// Global Part
		$gs = $this->settings_global_process( $gs );
		// Auth Part
		$as = $this->settings_auth_process( $as );

		// YouTube Part
		$yts = $this->settings_youtube_process( $yts );
		$ytp = $this->settings_youtube_player_process( $ytp );

		// Capabilities
		$capa = $this->settings_capabilities_process( $capa );

		// Others

		//compile the return to
		$request['gs']   = $gs;
		$request['as']   = $as;
		$request['yts']  = $yts;
		$request['ytp']  = $ytp;
		$request['capa'] = $capa;
		// just it for now
		$response = $request;

		if ( ! $this->roar->hasError() ) {
			update_option( MEOW_CASTER_SETTINGS . '_base_settings', $response );
		}


		return [ 'status' => 2, 'response' => $response ];
	}

	public function settings_global_process( $gs = null ) {

		// Slug part
		$meow_cpt_opt = get_option( MEOW_CASTER_SETTINGS . '_cpt_load' );
		if ( isset( $gs['meow-video-slug'] ) && $gs['meow-video-slug'] !== '' ) {
			$meow_cpt_opt['meow-video']['slug'] = $gs['meow-video-slug'];
		}
		if ( isset( $gs['meow-gallery-slug'] ) && $gs['meow-gallery-slug'] !== '' ) {
			$meow_cpt_opt['meow-gallery']['slug'] = $gs['meow-tag-slug'];
		}
		if ( isset( $gs['meow-tag-slug'] ) && $gs['meow-tag-slug'] !== '' ) {
			$meow_cpt_opt['meow-tag']['slug'] = $gs['meow-tag-slug'];
		}


		update_option( MEOW_CASTER_SETTINGS . '_cpt_load', $meow_cpt_opt );

		return $gs;
	}

	public function settings_auth_process( $as ) {

		if ( isset( $as['youtube-check-token'] ) ) {
			$this->settings_validate_token( $as );
		}
		if ( isset( $as['youtube-creds-file-btn'] ) && $as['youtube-creds-file-btn'] === 'submit_yt_creds' ) {
			$this->settings_validate_creds( $as );
		}
		if ( isset( $as['youtube-revoke-token'] ) ) {
			$MGCli = MeowGoogleClient::getInstance();
			$MGCli->revokeToken();
			$this->roar->addNotification( 'message', __( 'Youtube token have been revoked.', MEOW_CASTER_SLUG ) );
		}

		return $as;
	}

	public function settings_validate_token( $as = null ) {

		if ( isset( $as['youtube-check-token'] ) && isset( $as['youtube-token'] ) && ! is_null( $as['youtube-token'] ) ) {
			$sanitize_auth_code = sanitize_text_field( $as['youtube-token'] );
			$MGCli              = MeowGoogleClient::getInstance();
			$token_ok           = $MGCli->checkToken( $sanitize_auth_code );

			if ( $token_ok ) {
				update_option( MEOW_CASTER_SETTINGS . '_youtube', true );
			} else {
				$bs['error']['youtube-token'] = true;
				$this->roar->addError( '6x2' );
				$this->roar->addNotification( 'debug', '<b>Exception $token_ok</b>' );
			}
		}


	}

	public function settings_validate_creds( $as = null ) {


		if ( $_FILES['mc-main-settings']['type']['as']['youtube-creds-file'] !== 'application/json' ) {
			$as['error']['youtube-creds'] = true;
			$this->roar->addError( '6x3' );

			return false;
		}
		$json = json_decode( file_get_contents( $_FILES['mc-main-settings']['tmp_name']['as']['youtube-creds-file'] ), true );
		if ( ! isset( $json['installed'] ) ) {
			$as['error']['youtube-creds'] = true;
			$this->roar->addError( '6x4' );

			return false;
		}

		if ( ! update_option( MEOW_CASTER_SETTINGS . '_youtube_creds',  $json  ) ) {
			$as['error']['youtube-creds'] = true;
			$this->roar->addError( '6x0' );

			return false;
		}

		$this->roar->addNotification( 'message', __( 'Google Credentials have been setup.', MEOW_CASTER_SLUG ) );

	}

	public function settings_youtube_process( $yts = null ) {
		$sync = $yts['sync'];
		$sync_opt = get_option( MEOW_CASTER_SETTINGS . '_sync' );
		if( !is_array($sync_opt) ){
			$sync_param = get_option( MEOW_CASTER_SETTINGS . '_sync' ) ;
		}
		unset( $yts['sync'] );
		if ( $sync['method'] === 'all' ) {
			$sync_param['method'] = 'all';
		} else {
			$sync_param['method'] = $sync['part'];
		}
		$yts['live']['no-live-msg'] = stripslashes($yts['live']['no-live-msg']);
		// Update option
		update_option( MEOW_CASTER_SETTINGS . '_sync', $sync_param  );


		return $yts;
	}

	public function settings_youtube_player_process( $ytp = null ) {

		// Update option
		update_option( MEOW_CASTER_SETTINGS . '_youtube_player_settings',  $ytp  );

		return $ytp;
	}

	protected function settings_capabilities_process( array $capa ) {

		$default_capa = [
			'manage_meow_caster_settings'        => 0,
			'edit_meow_caster_videos'            => 0,
			'edit_meow_caster_galleries'         => 0,
			'delete_meow_caster_videos'          => 0,
			'delete_meow_caster_galleries'       => 0,
			'import_meow_caster_content'         => 0,
			'embed_meow_caster_content'          => 0,
			'publish_meow_caster_videos'         => 0,
			'publish_meow_caster_galleries'      => 0,
			'read_private_meow_caster_videos'    => 0,
			'read_private_meow_caster_galleries' => 0,
			'manage_meow_caster_taxonomy'        => 0
		];

		foreach ( $capa as $role => $caps ) {

			$role = get_role( $role );
			$caps = array_merge( $default_capa, $caps );

			foreach ( $caps as $cap => $active ){
				if( $cap == 'menu_meow_caster' ||
				    ($role->name === 'administrator' && $cap ==='manage_meow_caster_settings') ){
					continue;
				}
				if( $active && !$role->has_cap($cap) ){
					$role->add_cap($cap);
					//meow_look('add cap to '. $role->name . ' on '.$cap ,true,true);
				} elseif( !$active && $role->has_cap($cap)){
					$role->remove_cap($cap);
					//meow_look('remove cap to '. $role->name . ' on '.$cap ,true,true);
				}else {
					//nothing else
				}
			}


		}

		return $capa;
	}

	public function settings_vimeo_process( $vs = null ) {
		return $vs;
	}

	public function settings_vimeo_player_process( $vp = null ) {
		return $vp;
	}

	public function form_settings_parser() {

	}

	public function video_to_gallery_process() {
		$input = $_POST['mc-vtg'];

		//decode video item
		$tmpVideoItems = [];
		foreach ( $input['video']['items'] as $key => $value ) {
			$tmpVideoItems[ $key ] = json_decode( base64_decode( $value ), true );
		}
		$input['video']['items'] = $tmpVideoItems;
		unset( $tmpVideoItems );

		// new gallery create
		if ( isset( $input['gallery']['new']['active'] ) && $input['gallery']['new']['active'] === 'on' ) {

			$args     = [
				'post_title'  => $input['gallery']['new']['title'],
				'post_status' => 'draft',
				'post_type'   => 'meow-video-gallery',
				'meta_input'  => [
					'_meow-caster-video-gallery-list'=> [
						'items'=> [],
						'col' => 3
					]

				]
			];
			$newGalId = wp_insert_post( $args );
			if ( ! is_numeric( $newGalId ) ) {
				$this->roar->addError( '10x0' );

				return $newGalId;
			} else {
				$input['gallery']['items'][] = $newGalId;
			}
		}

		//Meow video to gallery batch
		foreach ( $input['gallery']['items'] as $galleryID ) {

			$gallery = new MeowVideoGallery( $galleryID );
			foreach ( $input['video']['items'] as $item ) {

				$gallery->add_item( $item );
				$gallery->add_meow_video( $item['post'] );
				$gallery->_request_save();
			}


		}

		return true;
	}
}