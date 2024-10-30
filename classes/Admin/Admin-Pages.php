<?php
/**
 * Class All admin page call
 */

namespace MeowCaster\Admin;

use MeowCaster\Contents\MeowVideo;
use MeowCaster\Contents\MeowVideoGallery;
use function MeowCaster\meow_look;
use MeowCaster\Services\MeowCache;
use MeowCaster\Services\MeowGoogleClient;
use MeowCaster\Services\MeowNotif;
use MeowCaster\Services\MeowRoar;
use WP_Query;

defined( 'ABSPATH' ) or die( 'Doh?' );

/**
 * Class Admin_Pages
 *
 * @package MeowCaster\Admin
 */
Class Admin_Pages {

	protected static $instance;
	protected static $version = '1.0.0'; //receive error
	/**
	 * @var MeowRoar
	 */
	public $roar; //tag for debug
	/**
	 * @var MeowNotif
	 */
	public $notif; //tag for debug
	/**
	 * @var bool
	 */
	public $mc_debug = false; //tag for debug_i18n specifically
	/**
	 * @var bool
	 */
	public $mc_debug_i18n = false;
	/**
	 * @var array
	 */
	private $page_var = [];

	protected function __construct( MeowRoar $roar = null, MeowNotif $notif = null ) {
		if ( is_null( $roar ) ) {
			$this->roar = MeowRoar::getInstance();
		}
		if ( is_null( $notif ) ) {
			$this->notif = MeowNotif::getInstance();
		}
	}

	/**
	 * @return \MeowCaster\Admin\Admin_Pages
	 */
	public static function getInstance() {
		is_null( self::$instance ) AND self::$instance = new self;

		return self::$instance;
	}

	// Menu settings

	public static function custom_submenu_reorder( $menu_ord ) {

		global $submenu;

		//$target = 'edit.php?post_type=meow-video-gallery';
		$target = 'edit.php?post_type=meow-video-gallery';
		if ( ! array_key_exists( $target, $submenu ) ) {
			$target = 'edit.php?post_type=meow-video';
		}
		if ( ! array_key_exists( $target, $submenu ) ) {
			$target = MEOW_CASTER_SLUG;
		}
		// In case the menu isn't already call after the first activation
		if ( isset( $submenu[ $target ] ) ) {
			$meow_menu = $submenu[ $target ];
			// Extract the first element
			if ( $meow_menu[0][0] == 'Meow Caster' ) {
				array_shift( $meow_menu );
			}

			$submenu[ $target ] = $meow_menu;
		}

		return $menu_ord;
	}

	/**
	 * @return $this
	 */

	public function setup_menu() {

		$yt_full = MeowGoogleClient::ready();
		if ( is_admin() &&
		     ( current_user_can( 'edit_meow_caster_videos' ) && $yt_full ||
		       current_user_can( 'edit_meow_caster_galleries' ) ||
		       current_user_can( 'import_meow_caster_content' ) && $yt_full ||
		       current_user_can( 'manage_meow_caster_settings' ) )

		) {
			add_menu_page(
				MEOW_CASTER_NAME,
				MEOW_CASTER_NAME,
				'edit_posts',
				MEOW_CASTER_SLUG,
				'',
				MEOW_CASTER_ASSETS_URL . 'icon' . DIRECTORY_SEPARATOR . 'meow-caster-logo.svg',
				'10.0002'
			);
			if ( $yt_full ) {
				add_submenu_page(
					MEOW_CASTER_SLUG,
					//'edit.php?post_type=meow-video',
					__( 'All Video', MEOW_CASTER_SLUG ),
					__( 'All Video', MEOW_CASTER_SLUG ),
					'edit_meow_caster_videos',
					'edit.php?post_type=meow-video'
				);
			}
			add_submenu_page(
				MEOW_CASTER_SLUG,
				//'edit.php?post_type=meow-video',
				__( 'All Galleries', MEOW_CASTER_SLUG ),
				__( 'All Galleries', MEOW_CASTER_SLUG ),
				'edit_meow_caster_galleries',
				'edit.php?post_type=meow-video-gallery'
			);
			add_submenu_page(
				MEOW_CASTER_SLUG,
				//'edit.php?post_type=meow-video',
				__( 'Add Gallery', MEOW_CASTER_SLUG ),
				__( 'Add Gallery', MEOW_CASTER_SLUG ),
				'edit_meow_caster_galleries',
				'post-new.php?post_type=meow-video-gallery'
			);
			add_submenu_page(
				MEOW_CASTER_SLUG,
				__( 'Meow Tags', MEOW_CASTER_SLUG ),
				__( 'Meow Tags', MEOW_CASTER_SLUG ),
				'manage_meow_caster_taxonomy',
				'edit-tags.php?taxonomy=meow-video-tag&post_type=meow-video'
			);
			if ( $yt_full ) {
				add_submenu_page(
					MEOW_CASTER_SLUG,
					__( 'Add Videos into Galleries', MEOW_CASTER_SLUG ),
					__( 'Add Videos into Galleries', MEOW_CASTER_SLUG ),
					'edit_meow_caster_galleries',
					MEOW_CASTER_SLUG . '-video-to-gallery',
					[ $this, 'video_to_gallery' ]
				);
				add_submenu_page(
					MEOW_CASTER_SLUG,
					__( 'Import from YouTube', MEOW_CASTER_SLUG ),
					__( 'Import from YouTube', MEOW_CASTER_SLUG ),
					'import_meow_caster_content',
					MEOW_CASTER_SLUG . '-import-yt',
					[ $this, 'import_youtube' ]
				);

			}

			if ( in_array( $_SERVER['HTTP_HOST'], ['ground-zero-prem.local','ground-zero.local'] ) !== false ) {
				add_submenu_page(
					MEOW_CASTER_SLUG,
					'StyleGuide',
					'StyleGuide',
					'manage_options',
					MEOW_CASTER_SLUG . '-styleguide',
					[ $this, 'styleguide' ]
				);
			}
			// Settings
			add_submenu_page(
				MEOW_CASTER_SLUG,
				__( 'Settings', MEOW_CASTER_SLUG ),
				__( 'Settings', MEOW_CASTER_SLUG ),
				'manage_meow_caster_settings',
				MEOW_CASTER_SLUG,
				[ $this, 'form_base_settings' ]
			);

			// invisible in menu
			add_submenu_page(
				null,
				'MeowCaster Embed tunnel',
				'MeowCaster Embed tunnel',
				'embed_meow_caster_content',
				MEOW_CASTER_SLUG . '-embed-tunnel',
				[ $this, 'embed_tunnel' ]
			);
			add_submenu_page(
				null,
				'MeowCaster Video listing',
				'MeowCaster Video listing',
				'edit_meow_caster_galleries',
				MEOW_CASTER_SLUG . '-video-listing',
				[ $this, 'video_listing' ]
			);


			return $this;
		}
	}


	// Function for pages

	/**
	 *
	 */
	function form_base_settings() {

		$error         = false; //receive error
		$mc_debug      = false; //tag for debug
		$mc_debug_i18n = false; //tag for debug_i18n specifically

		$base_settings = get_option( MEOW_CASTER_SETTINGS . '_base_settings' );
		//$form_input = array();

		// form is submit
		if ( isset( $_POST[ MEOW_CASTER_SLUG_ . '_nonce' ] ) ) {
			if ( wp_verify_nonce( filter_input( INPUT_POST, MEOW_CASTER_SLUG_ . '_nonce' ), MEOW_CASTER_SLUG_ . '_base_settings' ) ) {
				//Process
				$processor    = Admin_Processor::getInstance();
				$form_process = $processor->form_settings_process();
				$form_input   = $form_process['response'];
			} else {
				$this->roar->addError( '6x1', array( __METHOD__, __FILE__ ) );
				if ( ! is_array( $base_settings ) ) {
					$form_input = maybe_unserialize( $base_settings );
				} else {
					$form_input = $base_settings;
				}
			}

		} else {
			if ( ! is_array( $base_settings ) ) {
				$form_input = maybe_unserialize($base_settings) ;
			} else {
				$form_input = $base_settings;
			}

		}

		$sync_param = get_option( MEOW_CASTER_SETTINGS . '_sync', 'miaou' );
		if ( $sync_param !== 'miaou' ) {
			if ( !isset($sync_param['method']) ||
			     ( isset($sync_param['method']) &&  strtolower( $sync_param['method'] ) == 'all' )  ){
				$form_input['yts']['sync']['method'] = 'all';
			} else {
				$form_input['yts']['sync']['method'] = 'part';
				$form_input['yts']['sync']['part']   = $sync_param['youtube'];

			}
		}
		// YOUTUBE PART
		$Gcli = MeowGoogleClient::getInstance();
		if ( in_array( get_option( MEOW_CASTER_SETTINGS . '_youtube_token', 'miaou' ), array( '', 'miaou' ) ) ) {

			if ( $Gcli->is_set( 'config' ) ) {
				$this->page_var['mc_youtube_authlink'] = $Gcli->createAuthUrl();
			}
			$this->page_var['mc_youtube_action'] = 'auth';
		} else {

			$this->page_var['mc_youtube_active'] = true;

			$this->page_var['mc_youtube_action'] = 'revoke';
		}
		// VIMEO PART


		//$mc_debug = new Vimeo();
		//$mc_debug = $form_input;

		//Add the variable to the page caller
		$this->page_var['mc_debug']      = &$mc_debug;
		$this->page_var['mc_debug_i18n'] = &$mc_debug_i18n;
		$this->page_var['form_input']    = &$form_input;
		$this->page_var['meow_cpt_opt']  = get_option( MEOW_CASTER_SETTINGS . '_cpt_load' );
		$this->get_view( 'form-settings', true, $this->page_var );
	}

	/**
	 * @param null  $page
	 * @param bool  $ob
	 * @param array $imported_var
	 * @param bool popin
	 */
	function get_view( $page = null, $ob = true, $imported_var = array(), $popin = false ) {
		if ( is_null( $page ) ) {
			die ( '?!' );
		}
		$this->setup_enqueue( $popin );


		//var_dump($var);
		extract( $imported_var, EXTR_REFS );
		if ( $ob ) {
			ob_start();
			// get view
			include( MEOW_CASTER_VIEWS_ADMIN_PATH . $page . '.php' );
			$html = ob_get_clean();

			// process
			echo $html;
		} else {
			include( MEOW_CASTER_VIEWS_ADMIN_PATH . $page . '.php' );
		}
	}

	// Page In Menu

	/**
	 * Get common admin script and style
	 *
	 * @param bool popin
	 */
	function setup_enqueue( $popin = false ) {
		//get CSS
		wp_enqueue_style( 'wp-color-picker' );

		//get JS
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'wp-color-picker' );

		// Special Case Popin iframe
		if ( $popin ) {
			wp_enqueue_style( MEOW_CASTER_PREFIX . 'popin' );
			wp_enqueue_script( MEOW_CASTER_PREFIX . 'popin-child' );
		}

		return $this;
	}

	/**
	 *
	 */
	function import_youtube() {

		$error         = false; //receive error
		$mc_debug      = false; //tag for debug
		$mc_debug_i18n = false; //tag for debug_i18n specifically


		// no POST come from here all in ajax


		//Add the variable to the page caller
		$this->page_var['mc_debug']        = &$mc_debug;
		$this->page_var['mc_debug_i18n']   = &$mc_debug_i18n;
		$this->page_var['cache']           = MeowCache::getInstance();
		$this->page_var['alreadyImported'] = MeowVideo::get_already_import();
		$this->get_view( 'import-youtube', true, $this->page_var );
	}


	/**
	 *
	 */
	function video_to_gallery() {

		$error         = false; //receive error
		$mc_debug      = false; //tag for debug
		$mc_debug_i18n = false; //tag for debug_i18n specifically


		// form is submit
		if ( isset( $_POST[ MEOW_CASTER_SLUG_ . '_nonce' ] ) ) {

			if ( wp_verify_nonce( filter_input( INPUT_POST, MEOW_CASTER_SLUG_ . '_nonce' ), MEOW_CASTER_SLUG_ . '_video_to_gallery' ) ) {
				//Process
				$processor    = Admin_Processor::getInstance();
				$form_process = $processor->video_to_gallery_process();

			} else {
				$this->roar->addError( '10x1', array( __METHOD__, __FILE__ ) );
			}

		}

		//Get All Video
		$this->page_var['videoItems'] = MeowVideo::get_all();
		// Get All Galleries
		$this->page_var['galleryItems'] = MeowVideoGallery::_get_all();

		//Add the variable to the page caller
		$this->page_var['mc_debug']      = &$mc_debug;
		$this->page_var['mc_debug_i18n'] = &$mc_debug_i18n;
		$this->page_var['cache']         = MeowCache::getInstance();

		$this->get_view( 'video-to-gallery', true, $this->page_var );
	}

	// Page Dev

	/**
	 *
	 */
	function styleguide() {

		$error         = false; //receive error
		$mc_debug      = false; //tag for debug
		$mc_debug_i18n = false; //tag for debug_i18n specifically


		$form_input = [];


		// form is submit
		if ( isset( $_POST[ MEOW_CASTER_SLUG_ . '_nonce' ] ) ) {
			if ( wp_verify_nonce( filter_input( INPUT_POST, MEOW_CASTER_SLUG_ . '_nonce' ), MEOW_CASTER_SLUG_ . '_main_config' ) ) {
				//Process
				$processor       = Admin_Processor::getInstance();
				$form_sp_process = $processor->form_main_process();

			} else {
				$this->roar->addError( '6x1', array( __METHOD__, __FILE__ ) );
			}
			if ( ! $this->roar->hasError() ) {
				$form_input = $_POST['mc-config'];
			}
		}

		$this->notif->addNotif( 'now', 'Notice Normal',
			[
				"dismiss"  => false,
				"type"     => "notice",
				"template" => false
			]
		);

		$this->notif->addNotif( 'now', 'Notice Error',
			[
				"dismiss"  => true,
				"type"     => "notice-error",
				"template" => false
			]
		);

		$this->notif->addNotif( 'now', 'Notice warning',
			[
				"dismiss"  => true,
				"type"     => "notice-warning",
				"template" => false
			]
		);
		$this->notif->addNotif( 'now', 'Notice Success',
			[
				"dismiss"  => false,
				"type"     => "notice-success",
				"template" => false
			]
		);
		$this->notif->addNotif( 'now', 'Notice Info',
			[
				"dismiss"  => true,
				"type"     => "notice-info",
				"template" => false
			]
		);
		$this->notif->addNotif( 'now', 'Notice Info',
			[
				"dismiss"  => true,
				"type"     => "meow-info",
				"template" => false
			]
		);
		$this->notif->addNotif( 'now', ' ',
			[
				"dismiss"  => true,
				"type"     => "meow-info",
				"template" => "notice-meow-plugin-prem"
			]
		);

		$this->notif->printAllNotifs();


		$this->roar->addError( '11x0' );
		$this->roar->addError( '11x1' );
		$this->roar->addError( '11x2', [ __METHOD__, __FILE__ ] );

		//Add the variable to the page caller
		$this->page_var['mc_debug']      = &$mc_debug;
		$this->page_var['mc_debug_i18n'] = &$mc_debug_i18n;
		$this->page_var['form_input']    = &$form_input;

		$this->get_view( 'styleguide', true, $this->page_var );
	}


	//Page Off menu

	/**
	 *
	 */
	function embed_tunnel() {

		$error         = false; //receive error
		$mc_debug      = false; //tag for debug
		$mc_debug_i18n = false; //tag for debug_i18n specifically


		$form_input = array();


		//Add the variable to the page caller
		$this->page_var['mc_debug']      = &$mc_debug;
		$this->page_var['mc_debug_i18n'] = &$mc_debug_i18n;
		$this->page_var['form_input']    = &$form_input;

		$this->get_view( 'popin/editor-embed-tunnel', true, $this->page_var, true );
	}

	/**
	 *
	 *
	 */
	function video_listing() {

		$error         = false; //receive error
		$mc_debug      = false; //tag for debug
		$mc_debug_i18n = false; //tag for debug_i18n specifically


		// form is submit
		// no POST come from here all in ajax
		//Meow Caster Video query
		$mcv_query = new WP_Query( [ 'posts_per_page' => - 1, 'post_type' => 'meow-video' ] );
		$items     = [];
		if ( $mcv_query->have_posts() ) {
			foreach ( $mcv_query->posts as $post ) {
				$post->metadata = get_post_meta( $post->ID );
				// if video is private take the serveur picture
				$post->thumbnail = 'https://i.ytimg.com/vi/' . $post->metadata['_meow-caster-videoyt-id'][0] . '/mqdefault.jpg';
			}
			$items = $mcv_query->posts;
			wp_reset_postdata();
		}

		//Add the variable to the page caller
		$this->page_var['mc_debug']      = &$mc_debug;
		$this->page_var['mc_debug_i18n'] = &$mc_debug_i18n;
		$this->page_var['items']         = $items;

		$this->get_view( 'popin/editor-video-listing', true, $this->page_var, true );
	}
}