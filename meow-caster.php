<?php
/**
 * Plugin Name: Meow Caster
 * Plugin URI: https://meow.codes/meow-caster/
 * Description: Tools for WebCaster for WordPress
 * Version: 1.1.2
 * Author: Meow.codes
 * Author URI: https://meow.codes/
 * Text Domain: meow-caster
 * Domain Path: /lang
 * Licence: GPLv2
 */

namespace MeowCaster;

defined( 'ABSPATH' ) or die( 'Doh?!' );


/**
 * Class MeowCaster
 *
 * Provide basic setup and run for this plugin
 *
 * @package MeowCaster
 */
class MeowCasterInit {

	public static $custom_cap = [
		'manage_meow_caster_settings' => 'manage_options', //Manage settings

		'edit_meow_caster_videos'            => 'edit_posts', //Edit Meow Video
		'edit_meow_caster_galleries'         => 'edit_posts', //Edit Meow Gallery
		'delete_meow_caster_videos'          => 'delete_posts', //Delete Meow Gallery
		'delete_meow_caster_galleries'       => 'delete_posts', //Delete Meow Gallery
		'publish_meow_caster_videos'         => 'publish_posts',
		'publish_meow_caster_galleries'      => 'publish_posts',
		'read_private_meow_caster_videos'    => 'edit_posts',
		'read_private_meow_caster_galleries' => 'edit_posts',

		'import_meow_caster_content' => 'edit_posts', // Use Importation
		'embed_meow_caster_content'  => 'edit_posts', // Use Embed function

		'manage_meow_caster_taxonomy' => 'edit_posts',
		'menu_meow_caster'            => 'edit_posts',
	];
	/**
	 * @var
	 */
	protected static $instance;

	/**
	 * @return \MeowCaster\MeowCasterInit
	 */
	public static function init() {
		is_null( self::$instance ) AND self::$instance = new self;

		return self::$instance;
	}

	private static function remove_cap() {
		global $wp_roles;
		$roles = wp_roles()->roles;

		$capa_list = [];
		$meow_capa = [];
		foreach ( $wp_roles->roles as $role ) {
			$capa_list = array_merge( $capa_list, $role['capabilities'] );
		}
		foreach ( array_keys( $capa_list ) as $capa ) {
			if ( strpos( $capa, 'meow_caster' ) ) {
				$meow_capa[] = $capa;
			}
		}
		foreach ( $roles as $key => $array_role ) {
			$role = get_role( $key );
			foreach ( $meow_capa as $cap ) {
				if ( $role->has_cap( $cap ) ) {
					$role->remove_cap( $cap );
				}
			}
		}
	}

	/**
	 *
	 */
	function load() {
		// Autosave isn't part of plugin
		if ( defined( 'DOING_AUTOSAVE' ) ) {
			return;
		}
		// Autoload
		require_once '_autoload.php';

		// Prepare basics
		$this->define()
		     ->register()
		     ->lang();

		// Capability select on first run
		$settings = get_option( MEOW_CASTER_SETTINGS );
		if ( ! isset( $settings['first-run'] ) ) {
			$this->add_cap();
			$settings['first-run'] = 1;
			update_option( MEOW_CASTER_SETTINGS, $settings );
		}

		$mcf = MeowCasterFree::getInstance();
		$mcf->run();


		/**
		 * Trigger for loaded events
		 *
		 */
		do_action( MEOW_CASTER_SLUG_ . '_loaded' );
	}

	/**
	 * Load the i18n domain in order to translate
	 *
	 * @return $this
	 */
	function lang() {
		load_plugin_textdomain( 'meow-caster', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );

		return $this;
	}

	/**
	 * Register plugin basic hook
	 *
	 * @return $this
	 */
	function register() {
		register_activation_hook( __FILE__, [ $this, 'activate' ] );
		register_deactivation_hook( __FILE__, [ $this, 'desactivate' ] );

		return $this;
	}

	/**
	 * Define all plugin's const
	 *
	 * @return $this
	 */
	function define() {
		define( 'MEOW_CASTER_NAME', 'Meow Caster' );
		define( 'MEOW_CASTER_SLUG', 'meow-caster' );
		define( 'MEOW_CASTER_PREFIX', 'mc-' );
		define( 'MEOW_CASTER_VERSION', '1.1.2' );
		/**
		 *  special slug with underscore for trigger
		 */
		define( 'MEOW_CASTER_SLUG_', str_replace( '-', '_', MEOW_CASTER_SLUG ) );
		/**
		 * settings option name in database
		 */
		define( 'MEOW_CASTER_SETTINGS', MEOW_CASTER_SLUG_ . '_settings' );
		/**
		 * Menu slug basic
		 */
		define( 'MEOW_CASTER_MENU_SLUG', 'edit.php?post_type=meow-video-gallery' );

		// Plugin process constant
		/**
		 * Plugin main file
		 */
		define( 'MEOW_CASTER_FILE', __FILE__ );

		/**
		 * Plugin main file's path
		 */
		define( 'MEOW_CASTER_PATH', realpath( plugin_dir_path( MEOW_CASTER_FILE ) ) . DIRECTORY_SEPARATOR );

		/**
		 * Plugin functions common (front & admin) path
		 */
		define( 'MEOW_CASTER_FUNCTIONS_PATH', realpath( MEOW_CASTER_PATH . 'functions' ) . DIRECTORY_SEPARATOR );
		/**
		 * Plugin function admin path
		 */
		define( 'MEOW_CASTER_FUNCTIONS_ADMIN_PATH', realpath( MEOW_CASTER_FUNCTIONS_PATH . 'admin' ) . DIRECTORY_SEPARATOR );
		/**
		 * Plugin function front path
		 */
		define( 'MEOW_CASTER_FUNCTIONS_FRONT_PATH', realpath( MEOW_CASTER_FUNCTIONS_PATH . 'front' ) . DIRECTORY_SEPARATOR );

		/**
		 * Plugin classes path
		 */
		define( 'MEOW_CASTER_CLASSES_PATH', realpath( MEOW_CASTER_PATH . 'classes' ) . DIRECTORY_SEPARATOR );

		/**
		 * Plugin views common path
		 */
		define( 'MEOW_CASTER_VIEWS_PATH', realpath( MEOW_CASTER_PATH . 'views' ) . DIRECTORY_SEPARATOR );
		/**
		 * Plugin views admin path
		 */
		define( 'MEOW_CASTER_VIEWS_ADMIN_PATH', realpath( MEOW_CASTER_VIEWS_PATH . 'admin' ) . DIRECTORY_SEPARATOR );
		/**
		 * Plugin views front path
		 */
		define( 'MEOW_CASTER_VIEWS_FRONT_PATH', realpath( MEOW_CASTER_VIEWS_PATH . 'front' ) . DIRECTORY_SEPARATOR );


		/**
		 * Plugin save path
		 */
		define( 'MEOW_CASTER_SAVE_PATH', realpath( MEOW_CASTER_PATH . 'save' ) . DIRECTORY_SEPARATOR );

		/**
		 * Plugin assets path
		 */
		define( 'MEOW_CASTER_ASSETS_PATH', realpath( MEOW_CASTER_PATH . 'assets' ) . DIRECTORY_SEPARATOR );

		// Plugin web constant

		/**
		 * Plugin main file URL
		 */
		define( 'MEOW_CASTER_URL', plugin_dir_url( MEOW_CASTER_FILE ) );

		/**
		 * Plugin assets URL
		 */
		define( 'MEOW_CASTER_ASSETS_URL', MEOW_CASTER_URL . 'assets/' );

		/**
		 * Plugin Vendor PAth
		 */
		define( 'MEOW_CASTER_VENDOR_PATH', MEOW_CASTER_PATH . 'vendor/' );

		/**
		 * Plugin Config path
		 */
		define( 'MEOW_CASTER_CONFIG_PATH', realpath( MEOW_CASTER_PATH . 'config' ) . DIRECTORY_SEPARATOR );

		return $this;
	}

	private function add_cap() {
		global $wp_roles;
		$roles = wp_roles()->roles;

		foreach ( $roles as $key => $array_role ) {
			$role = get_role( $key );

			foreach ( self::$custom_cap as $cap => $min_cap ) {
				if ( $role->has_cap( $min_cap ) ) {
					$role->add_cap( $cap );
				}
			}
		}
	}

	/**
	 * Plugin activation function
	 *
	 * basic initial set options in database
	 *
	 * @return void
	 */
	function activate() {


		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		foreach ( MeowCasterFree::getOptions() as $option => $defaultvalue ) {
			// Create Options
			if ( $option === MEOW_CASTER_SETTINGS . '_cpt_load' ) {
				add_site_option( $option, $defaultvalue, '', true );
			} else {
				add_site_option( $option, $defaultvalue, '', false );
			}
		}

		flush_rewrite_rules();
	}

	/**
	 * Plugin desactivate function
	 *
	 * remove all option in the database
	 *
	 * @return void
	 */
	function desactivate() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		foreach ( MeowCasterFree::getOptions() as $option => $defaultvalue ) {
			// Clean only transient because they are weight
			apply_filters('console', $option);
			delete_site_option( $option );
		}

		// Some widget option
		delete_site_option('widget_meow_caster_youtube_widget');

		flush_rewrite_rules();

	}

}

if ( class_exists( 'MeowCaster\MeowCasterInit' ) ) {
	$MeowPlugin = MeowCasterInit::init();
	add_action( 'plugins_loaded', array( $MeowPlugin, 'load' ) );

}
