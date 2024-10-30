<?php

namespace MeowCaster\Services;


use MeowCaster\Contents\MeowVideoGallery;

defined( 'ABSPATH' ) or die( 'Doh?!' );

/**
 * Class MeowMetabox
 *
 * Metabox
 *
 * @since   0.6.0
 *
 * @package MeowCaster\Services
 */
class MeowMetabox {

	protected static $instance;

	/**
	 * @var string
	 */
	protected static $version = '0.9.0';

	protected $roar;

	protected $box_ids = [
		'_meow-caster-yt-post-settings'   => 'yt_config_posts',
		'_meow-caster-video-datalink'     => 'video_datalink',
		'_meow-caster-video-gallery-list' => 'video_gallery_list'
	];

	protected function __construct() {

		$this->roar = MeowRoar::getInstance();
	}

	/**
	 * @return \MeowCaster\Services\MeowMetabox
	 */
	public static function getInstance() {
		is_null( self::$instance ) AND self::$instance = new self;

		return self::$instance;
	}

	public function setup_action() {


		add_action( 'add_meta_boxes', [ $this, 'register' ] );
		add_action( 'save_post', [ $this, 'save' ] );
		add_action( 'media_buttons', [ $this, 'media_button_tunnel' ], 11 );

	}

	public function register() {

		// side box for custom config for youtube player
		add_meta_box(
			'_meow-caster-yt-post-settings',                // Unique ID
			__( 'Youtube Player Config', MEOW_CASTER_SLUG ), // Box title
			[ $this, 'yt_config_posts' ],            // Content callback, must be of type callable
			'post',                                         // Post type
			'side'
		);

		add_meta_box(
			'_meow-caster-video-sync',                // Unique ID
			__( 'Meow Sync', MEOW_CASTER_SLUG ), // Box title
			[ $this, 'video_sync' ],            // Content callback, must be of type callable
			'meow-video',                                         // Post type
			'side',
			'high'
		);
		add_meta_box(
			'_meow-caster-video-datalink',                // Unique ID
			__( 'Meow video information', MEOW_CASTER_SLUG ), // Box title
			[ $this, 'video_datalink' ],            // Content callback, must be of type callable
			'meow-video',                                         // Post type
			'side'
		);
		add_meta_box(
			'_meow-caster-video-gallery-list',              // Unique ID
			__( 'Meow Video selector', MEOW_CASTER_SLUG ),   // Box title
			[ $this, 'video_gallery_list' ],         // Content callback, must be of type callable
			'meow-video-gallery',                           // Post type
			'normal'
		);
	}

	public function save( $post_id ) {
		foreach ( $this->box_ids as $id => $value ) {
			if ( array_key_exists( $id, $_POST ) ) {
				$method = $value . '_save';
				if ( method_exists( $this, $method ) ) {
					$this->$method( $post_id );
				}
			}
		}
	}

	// YouTube Config on post
	public function yt_config_posts( $post = null ) {
		if ( file_exists( MEOW_CASTER_VIEWS_ADMIN_PATH . 'metabox' . DIRECTORY_SEPARATOR . 'yt_config_posts.php' ) ) {
			$value = get_post_meta( $post->ID, '_meow-caster-yt-post-settings', true );
			// @TODO make default value from the plugin settings
			include MEOW_CASTER_VIEWS_ADMIN_PATH . 'metabox' . DIRECTORY_SEPARATOR . 'yt_config_posts.php';
		}
	}

	public function yt_config_posts_save( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
		$keyname = '_meow-caster-yt-post-settings';
		if ( ! array_key_exists( $keyname, $_POST ) ) {
			return;
		}
		if ( ! add_post_meta( $post_id, $keyname, $_POST[ $keyname ], true ) ) {
			update_post_meta( $post_id, $keyname, $_POST[ $keyname ] );
		}

	}

	// Video Data

	public function video_datalink( $post = null ) {
		$tpl_file = MEOW_CASTER_VIEWS_ADMIN_PATH . 'metabox' . DIRECTORY_SEPARATOR . 'video-datalink.php';
		if ( file_exists( $tpl_file ) ) {
			$datalink = json_decode( get_post_meta( $post->ID, '_meow-caster-video-datalink', true ), true );
			include $tpl_file;
		}
	}

	public function video_datalink_save( $post = null ) {
		// just information no save
	}

	// Sync data
	public function video_sync( $post = null ) {
		$tpl_file = MEOW_CASTER_VIEWS_ADMIN_PATH . 'metabox' . DIRECTORY_SEPARATOR . 'video-sync.php';
		if ( file_exists( $tpl_file ) ) {
			$ytid = $post->ID;
			include $tpl_file;
		}
	}

	public function video_sync_save( $post = null ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
		$keyname = '_meow-caster-sync-settings';
		if ( ! array_key_exists( $keyname, $_POST ) ) {
			return;
		}
		if ( ! add_post_meta( $post_id, $keyname, $_POST[ $keyname ], true ) ) {
			update_post_meta( $post_id, $keyname, $_POST[ $keyname ] );
		}
	}

	// Video Gallery list
	public function video_gallery_list( $post = null ) {
		if ( file_exists( MEOW_CASTER_VIEWS_ADMIN_PATH . 'metabox' . DIRECTORY_SEPARATOR . 'video-gallery-list.php' ) ) {

			wp_enqueue_script( MEOW_CASTER_PREFIX . 'popin-host' );
			wp_enqueue_style( MEOW_CASTER_PREFIX . 'popin-host', 'thickbox' );
			add_thickbox();

			$wizhref = admin_url( 'admin.php?page=meow-caster-video-listing' ) .
			           '&random=' . rand( 1, 1000 ) . '&TB_iframe=true';

			$value = get_post_meta( $post->ID, '_meow-caster-video-gallery-list', true );

			include MEOW_CASTER_VIEWS_ADMIN_PATH . 'metabox' . DIRECTORY_SEPARATOR . 'video-gallery-list.php';
		}
	}

	public function video_gallery_list_save( $post_id ) {
		if ( ! array_key_exists( '_meow-caster-video-gallery-list', $_POST ) ) {
			return;
		}
		$meow_caster_vgl = $_POST['_meow-caster-video-gallery-list'];
		$meow_gallery    = new MeowVideoGallery( $post_id );

		$meow_gallery->_on_update_video_gallery_list_metabox( $meow_caster_vgl );

	}

	public function media_button_tunnel() {
		$curr_user = wp_get_current_user();
		if ( ! $curr_user->ID || in_array( get_post_type(), array( 'meow-video', 'meow-video-gallery' ) ) ) {
			return;
		}

		wp_enqueue_script( MEOW_CASTER_PREFIX . 'popin-host' );
		wp_enqueue_style( MEOW_CASTER_PREFIX . 'popin-host', 'thickbox' );
		add_thickbox();

		$wizhref = admin_url( 'admin.php?page=meow-caster-embed-tunnel' ) .
		           '&random=' . rand( 1, 1000 ) . '&TB_iframe=true&width=800&height=800';


		?>
        <a href="<?php echo esc_attr( $wizhref ); ?>" class="thickbox button mcss-media-button mcjs-tb-button"
           id="meow-caster-media-button" data-meow-action="meow-shortcode"
           title="<?php _e( 'Easy YouTube embedding', MEOW_CASTER_SLUG ); ?>">
            <img src="<?php echo MEOW_CASTER_ASSETS_URL; ?>icon/meow-caster-logo.svg"
                 width="15" alt="">
			<?php _e( 'Add YouTube', MEOW_CASTER_SLUG ); ?>
        </a>
		<?php
	}

}