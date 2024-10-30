<?php

namespace MeowCaster;

// Internal Use
use MeowCaster\Admin\Admin;
use MeowCaster\Admin\Admin_Pages;
use MeowCaster\Contents\MeowVideo;
use MeowCaster\Contents\MeowVideoGallery;
use MeowCaster\Front\Front;
use MeowCaster\Services\MeowUpdate;

// WP Use
defined( 'ABSPATH' ) or die( 'Doh?!' );

class MeowCasterFree {


	/**
	 * @var
	 */
	protected static $instance;

	protected static $version = '0.9.0';

	/**
	 * @return \MeowCaster\MeowCasterFree
	 */
	public static function getInstance() {
		is_null( self::$instance ) AND self::$instance = new self;

		return self::$instance;
	}

	public function register_menu() {

		$AdminPage = Admin_Pages::getInstance();
		$AdminPage->setup_menu();

		return $this;
	}


	public function run() {
		//run the basics plugin in

		//dev special
		$this->_dev_check_wp_options();

		//MeowShortCode
		$this->add_action();

		//Common feature
		require MEOW_CASTER_FUNCTIONS_PATH . 'common.php';

		if ( is_admin() ) {
			$admin_ctrl = new Admin();
			$admin_ctrl->run();
		} else {
			$front_ctrl = new Front();
			$front_ctrl->run();
		}

		return $this;

	}

	protected function add_action( $endpoint = false ) {

		// Menu

		add_action( 'admin_menu', [ $this, 'register_menu' ] );
		add_filter( 'custom_menu_order', '\MeowCaster\Admin\Admin_Pages::custom_submenu_reorder' );

		// Update
		$meow_update = new MeowUpdate();
		$meow_update->setup_action();

		// remove media button on Meow CPT
		add_action( 'admin_head', [ $this, 'media_button_on_cpt' ] );

		add_filter( 'dashboard_glance_items', [ $this, 'add_glance_count' ], PHP_INT_MAX, 1 );

		// CPT
		$meow_video         = new MeowVideo( null );
		$meow_video_gallery = new MeowVideoGallery( null );
		$meow_video->_register_action();
		$meow_video_gallery->_register_action();


		// Widget
		add_action( 'widgets_init', [ $this, 'register_widget' ] );



	}

	public function add_glance_count( $items = [] ) {

		if ( is_admin() &&
		     ! ( current_user_can('edit_meow_caster_videos') ||
		       current_user_can('edit_meow_caster_galleries') ||
		       current_user_can('import_meow_caster_content')  ||
		       current_user_can('manage_meow_caster_settings') )

		){
			// Do nothing
			return $items;
		}

			$sub_items = [];
		$cpt       = [ 'meow-video', 'meow-video-gallery' ];

		foreach ( $cpt as $type ) {


			$num_posts = wp_count_posts( $type );

			if ( $num_posts ) {

				$published = intval( $num_posts->publish );
				$post_type = get_post_type_object( $type );

				$text = _n( '%s ' . $post_type->labels->singular_name, '%s ' . $post_type->labels->name, $published, MEOW_CASTER_SLUG );
				$text = sprintf( $text, number_format_i18n( $published ) );

				if ( current_user_can( $post_type->cap->edit_posts ) ) {
					$sub_items[] = sprintf( '<a class="%1$s-count mcss-at-glance-' . $type . '" href="edit.php?post_type=%1$s"><span>%2$s</span></a>', $type, $text ) . "\n";
				} else {
					$sub_items[] = sprintf( '<span class="%1$s-count mcss-at-glance-' . $type . '">%2$s</span>', $type, $text ) . "\n";
				}
			}
		}

		$items[] = '</ul><h3>Meow Contents</h3><ul class="mcss-at-glance"><li>' . implode( '</li><li>', $sub_items ) . '</li></ul><ul>	';

		return $items;

	}

	public function media_button_on_cpt() {
		global $current_screen;

		$array_media_btn_ban = array(
			'meow-video',
			'meow-video-gallery'
		);
		// use 'post', 'page' or 'custom-post-type-name'
		if ( in_array( $current_screen->post_type, $array_media_btn_ban ) ) {
			remove_action( 'media_buttons', 'media_buttons' );
		}
	}

	public function register_widget() {
		register_widget( 'MeowCaster\Widget\YoutubeEmbed' );
	}


	protected function _dev_check_wp_options() {

		foreach ( $this::getOptions() as $key => $value ) {
			if ( get_option( $key, 'miaou' ) === 'miaou' ) {
				add_option( $key, $value, false );
			}
		}

	}

	public static function getOptions() {
		$base  = MEOW_CASTER_SETTINGS;
		$base_ = $base . '_';

		return [
			$base                              => [],
			$base_ . 'version'                 => MEOW_CASTER_VERSION,
			$base_ . 'flush_request'           => false,
			$base_ . 'cpt_load'                => [
				'meow-video'   => [
					'slug'   => 'meow-video',
					'public' => false
				],
				'meow-gallery' => [
					'slug'   => 'meow-video-gallery',
					'public' => false
				],
				'meow-tag'     => [
					'slug'   => 'meow-tag',
					'public' => false
				]
			],
			$base_ . 'sync'                    => [ 'method' => 'all' ],
			$base_ . 'youtube'                 => false,
			$base_ . 'youtube_creds'           => 'miaou',
			$base_ . 'youtube_token'           => 'miaou',
			$base_ . 'youtube_etags'           => [
				'listing-import' => null
			],
			$base_ . 'base_settings'        => [
				'yts' => [
					'live'=> [
						'no-live-type' => 'bar',
						'no-live-msg' => 'Sorry,  we aren\'t streaming for now!'
					],
					'cookie'  => 'both',
					'import'  => 'draft',
					'consent' => '3',
					'consent-status' => 'off',
					'consent-theme' => 'dark'
				]
			],
			$base_ . 'youtube_player_settings' => []
		];

	}

}
