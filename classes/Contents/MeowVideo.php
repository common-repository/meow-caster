<?php
/**
 * Created by PhpStorm.
 * User: id2
 * Date: 14/05/18
 * Time: 10:48
 */

namespace MeowCaster\Contents;


use MeowCaster\Services\MeowEndpoint;
use MeowCaster\Services\MeowGoogleClient;
use MeowCaster\Services\MeowRoar;
use WP_Query;

class MeowVideo {

	/**
	 * @var \WP_Post
	 */
	public $post;
	public $postmeta;
	/**
	 * @var string
	 */
	protected $version = '0.9.0';
	protected $roar;
	protected $is_populate = false;

	// To be populate
	protected $YTID = false;
	protected $gallery_in = [];

	public function __construct( $post = null ) {
		$this->roar = MeowRoar::getInstance();
		if ( is_numeric( $post ) ) {
			$this->post = get_post( $post );
			$this->populate();
		} elseif ( is_object( $post ) && 'WP_Post' === get_class( $post ) ) {
			$this->post = $post;
			$this->populate();
		} else {
			$this->post = null;
		}

	}

	public function populate() {
		if ( $this->post == null ) {
			return false;
		}
		$this->postmeta = get_post_meta( $this->post->ID );
		foreach ( $this->postmeta as $key => $value ) {
			$this->postmeta[ $key ] = $value[0];
		}
		$datalink          = json_decode( $this->postmeta['_meow-caster-video-datalink'], true );
		$this->gallery_in  = $datalink['gallery'];
		$this->YTID        = $this->postmeta['_meow-caster-videoyt-id'];
		$this->is_populate = true;
	}

	// Register

	public static function get_all() {
		$query = new WP_Query( [ 'post_type' => 'meow-video' ] );
		$items = [];
		if ( $query->have_posts() ) {
			foreach ( $query->posts as $post ) {
				$items[] = new MeowVideo( $post );
			}
		}

		return $items;
	}

	public static function import( $param = null, $platforme = null ) {
		if ( is_null( $platforme ) || is_null( $param ) ) {
			return false;
		}
		if ( $platforme == 'youtube' ) {

			$snippet  = $param['snippet'];
			$status   = $param['status'];
			$datalink = [
				'type'          => 'youtube',
				'url'           => 'https://youtu.be/' . $param['id'],
				'title'         => $snippet['title'],
				'publishedAt'   => $snippet['publishedAt'],
				'privacyStatus' => $status['privacyStatus'],
				'embeddable'    => $status['embeddable'],
				'license'       => $status['license'],
				'channel_id'    => $snippet['channelId'],
				'gallery'       => []
			];

			$datetimeVid = new \DateTime( $snippet['publishedAt'] );

			$import_param = [
				'post_title'     => $snippet['title'],
				'post_content'   => $snippet['description'],
				'post_status'    => 'draft',
				'post_type'      => 'meow-video',
				'post_date'      => current_time( $datetimeVid->format( 'Y-m-d H:i:s' ) ),
				'comment_status' => 'closed',
				'meta_input'     => [
					'_meow-caster-videoyt-id'     => $param['id'],
					'_meow-caster-video-datalink' => json_encode( $datalink, JSON_UNESCAPED_UNICODE )
				]
			];
			$import       = wp_insert_post( $import_param );

			if ( $import !== 0 ) {
				$featuredId = media_sideload_image(
					$snippet['thumbnails']['maxres']['url'],
					$import,
					__( 'Thumbnail of ', MEOW_CASTER_SLUG ),
					'id'
				);

				set_post_thumbnail( $import, $featuredId );

				// Tag
				MeowVideo::import_tag( $snippet['tags'], $import );

			} else {
				return false;
			}


		}

		return true;
	}

	public static function import_tag( $tags, $postID ) {
		$taxo     = 'meow-video-tag';
		$termList = [];

		foreach ( $tags as $tag ) {

			$termID = term_exists( $tag, $taxo );
			if ( $termID === 0 || is_null( $termID ) ) {
				$termID = wp_insert_term( $tag, $taxo );
			}

			$termList[] = (int) $termID['term_id'];
		}

		wp_set_object_terms( $postID, $termList, $taxo );

	}

	public static function get_already_import() {
		global $wpdb;

		$queryImported   = $wpdb->get_results(
			"SELECT meta_value 
			FROM $wpdb->postmeta 
			WHERE meta_key = '_meow-caster-videoyt-id'"
		);
		$alreadyImported = [];

		foreach ( $queryImported as $elem ) {
			$alreadyImported[] = $elem->meta_value;
		}

		return $alreadyImported;
	}

// Populate

	public function _register_action() {
		add_action( 'init', [ $this, '_register_cpt' ], 0 );

		//add_filter( 'dashboard_glance_items', [ $this, 'add_glance_count'], 10, 1 );

		// add action on the change of state ( Update, Sync, Import, Delete )
		add_action( 'post_updated', [ $this, '_on_update' ], 10, 3 );
		add_action( 'wp_trash_post', [ $this, '_on_trash' ] );
		add_action( 'meow-caster-after-sync', [ $this, '_on_sync' ] );
	}

	public function _register_cpt() {

		// CPT meow-video
		$labels       = [
			'name'                  => _x( 'Meow Videos', 'Post Type General Name', 'MEOW_CASTER_SLUG' ),
			'singular_name'         => _x( 'Meow Video', 'Post Type Singular Name', 'MEOW_CASTER_SLUG' ),
			'menu_name'             => __( 'Meow Video', 'MEOW_CASTER_SLUG' ),
			'name_admin_bar'        => __( 'Meow Video', 'MEOW_CASTER_SLUG' ),
			'archives'              => __( 'Item Archives', 'MEOW_CASTER_SLUG' ),
			'attributes'            => __( 'Item Attributes', 'MEOW_CASTER_SLUG' ),
			'parent_item_colon'     => __( 'Parent Item:', 'MEOW_CASTER_SLUG' ),
			'all_items'             => __( 'All Videos', 'MEOW_CASTER_SLUG' ),
			'add_new_item'          => __( 'Add New Video', 'MEOW_CASTER_SLUG' ),
			'add_new'               => __( 'Add Video', 'MEOW_CASTER_SLUG' ),
			'new_item'              => __( 'New Video', 'MEOW_CASTER_SLUG' ),
			'edit_item'             => __( 'Edit Video', 'MEOW_CASTER_SLUG' ),
			'update_item'           => __( 'Update Video', 'MEOW_CASTER_SLUG' ),
			'view_item'             => __( 'View Video', 'MEOW_CASTER_SLUG' ),
			'view_items'            => __( 'View Videos', 'MEOW_CASTER_SLUG' ),
			'search_items'          => __( 'Search Item', 'MEOW_CASTER_SLUG' ),
			'not_found'             => __( 'Not found', 'MEOW_CASTER_SLUG' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'MEOW_CASTER_SLUG' ),
			'featured_image'        => __( 'Featured Image', 'MEOW_CASTER_SLUG' ),
			'set_featured_image'    => __( 'Set featured image', 'MEOW_CASTER_SLUG' ),
			'remove_featured_image' => __( 'Remove featured image', 'MEOW_CASTER_SLUG' ),
			'use_featured_image'    => __( 'Use as featured image', 'MEOW_CASTER_SLUG' ),
			'insert_into_item'      => __( 'Insert into item', 'MEOW_CASTER_SLUG' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'MEOW_CASTER_SLUG' ),
			'items_list'            => __( 'Items list', 'MEOW_CASTER_SLUG' ),
			'items_list_navigation' => __( 'Items list navigation', 'MEOW_CASTER_SLUG' ),
			'filter_items_list'     => __( 'Filter items list', 'MEOW_CASTER_SLUG' ),
		];
		$capabilities = [
			'create_posts'           => false,
			'edit_posts'             => 'edit_meow_caster_videos',
			'edit_published_posts'   => 'edit_meow_caster_videos',
			'edit_private_posts'     => 'edit_meow_caster_videos',
			'edit_others_posts'      => 'edit_meow_caster_videos',
			'delete_posts'           => 'delete_meow_caster_videos',
			'delete_others_posts'    => 'delete_meow_caster_videos',
			'delete_published_posts' => 'delete_meow_caster_videos',
			'delete_private_posts'   => 'delete_meow_caster_videos',
			'publish_posts'          => 'publish_meow_caster_videos',
			'read_private_posts'     => 'read_private_meow_caster_videos',
		];
		$args         = [
			'label'               => __( 'Meow Video', MEOW_CASTER_SLUG ),
			'description'         => __( 'Video extract or add by meow-codes plugins', MEOW_CASTER_SLUG ),
			'labels'              => $labels,
			'supports'            => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
			'taxonomies'          => [ 'meow-video-tag' ],
			'hierarchical'        => false,
			'public'              => false,
			'publicly_queryable'  => false,
			'query_var'           => false,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'menu_position'       => 10,
			'menu_icon'           => 'dashicons-video-alt3',
			'show_in_admin_bar'   => false,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			//'capability_type'     => ['meow_caster_video','meow_caster_videos'],
			'capabilities'        => $capabilities,
			'map_meta_cap'        => true,
			'show_in_rest'        => false,

		];
		register_post_type( 'meow-video', $args );

		$this->_register_taxonomie();

		MeowEndpoint::flush_request();
	}

	protected function _register_taxonomie() {

		// Register Custom Taxonomy  meow_video_category
		$labels       = [
			'name'                       => _x( 'Meow tags', 'Taxonomy General Name', 'MEOW_CASTER_SLUG' ),
			'singular_name'              => _x( 'Meow tag', 'Taxonomy Singular Name', 'MEOW_CASTER_SLUG' ),
			'menu_name'                  => __( 'Meow Tags', 'MEOW_CASTER_SLUG' ),
			'all_items'                  => __( 'All meow tags', 'MEOW_CASTER_SLUG' ),
			'new_item_name'              => __( 'New Tag', 'MEOW_CASTER_SLUG' ),
			'add_new_item'               => __( 'Add tag', 'MEOW_CASTER_SLUG' ),
			'edit_item'                  => __( 'Edit tag', 'MEOW_CASTER_SLUG' ),
			'update_item'                => __( 'Update tag', 'MEOW_CASTER_SLUG' ),
			'view_item'                  => __( 'View tag', 'MEOW_CASTER_SLUG' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'MEOW_CASTER_SLUG' ),
			'add_or_remove_items'        => __( 'Add or remove tag', 'MEOW_CASTER_SLUG' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'MEOW_CASTER_SLUG' ),
			'popular_items'              => __( 'Popular tags', 'MEOW_CASTER_SLUG' ),
			'search_items'               => __( 'Search meow tags', 'MEOW_CASTER_SLUG' ),
			'not_found'                  => __( 'Not Found', 'MEOW_CASTER_SLUG' ),
			'no_terms'                   => __( 'No video tag', 'MEOW_CASTER_SLUG' ),
			'items_list'                 => __( 'Video tags list', 'MEOW_CASTER_SLUG' ),
			'items_list_navigation'      => __( 'Video tags list navigation', 'MEOW_CASTER_SLUG' ),
		];
		$capabilities = [
			'manage_terms' => 'manage_meow_caster_taxonomy',
			'edit_terms'   => 'manage_meow_caster_taxonomy',
			'delete_terms' => 'manage_meow_caster_taxonomy',
			'assign_terms' => 'edit_meow_caster_content',
		];
		$args         = [
			'labels'            => $labels,
			'hierarchical'      => false,
			'public'            => false,
			'show_ui'           => true,
			'show_in_menu'      => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud'     => false,
			'show_in_rest'      => true,
			'capabilities'      => $capabilities,
		];
		register_taxonomy( 'meow-video-tag', [ 'meow-video', 'meow-video-gallery' ], $args );

	}

// Action

	public function sync(
		$sync_type, $param
	) {
		/*
		 * 'yt' => from YT to WP
		 * 'wp' => from WP to YT
		 * 'tw' => Two Way like a diff
		 */
		if ( $sync_type != 'yt' ) {
			return false;
		}

		do_action( 'meow-caster-before-sync', $this );
		$res = $this->sync_from_yt( apply_filters( 'meow-caster-param-sync', $param ) );
		do_action( 'meow-caster-after-sync', $this );

		return $res;
	}

	public function sync_from_yt( $param ) {
		$Gcli  = MeowGoogleClient::getInstance();
		$YTcli = $Gcli->getYoutubeService();

		if ( in_array( 'default', $param ) ) {
			$param = get_option( MEOW_CASTER_SETTINGS . '_sync' );
			$param = $param['youtube'];
		}

		// Check for tag import
		$data_updated = $YTcli->videos->listVideos(
			'snippet,status',
			[ 'id' => $this->YTID ]
		);

		$item = $data_updated->getItems()[0];


		$post_updated = [ 'ID' => $this->post->ID ];

		$snippet = $item['snippet'];
		$status  = $item['status'];


		$item['snippet'] = $snippet;

		// change post title
		if ( in_array( 'title', $param ) || in_array( 'all', $param ) ) {
			$post_updated['post_title'] = $item['snippet']['title'];

		}
		// change post content
		if ( in_array( 'desc', $param ) || in_array( 'all', $param ) ) {
			$post_updated['post_content'] = $item['snippet']['description'];
		}
		//change post tag
		if ( in_array( 'tag', $param ) || in_array( 'all', $param ) ) {
			self::import_tag( $item['snippet']['tags'], $this->post->ID );
		}

		// meta update

		$this->datalink['type']          = 'youtube';
		$this->datalink['title']         = $snippet['title'];
		$this->datalink['url']           = 'https://youtu.be/' . $this->YTID;
		$this->datalink['publishedAt']   = $snippet['publishedAt'];
		$this->datalink['privacyStatus'] = $status['privacyStatus'];
		$this->datalink['embeddable']    = $status['embeddable'];
		$this->datalink['license']       = $status['license'];
		$this->datalink['channel_id']    = $snippet['channelId'];


		$this->update_postmeta();

		return ( wp_update_post( $post_updated ) > 0 );

	}

	protected function update_postmeta() {
		$this->populate_request();

		// Update postmeta
		$datalink                                      = json_decode( $this->postmeta['_meow-caster-video-datalink'], true );
		$datalink['gallery']                           = $this->gallery_in;
		$this->postmeta['_meow-caster-video-datalink'] = json_encode( $datalink, JSON_UNESCAPED_UNICODE );

		foreach ( $this->postmeta as $key => $value ) {
			update_post_meta( $this->post->ID, $key, $value );
		}
	}

// Status

	protected function populate_request() {
		if ( ! $this->is_populate ) {
			$this->populate();
		}
	}

	public function add_glance_count(
		$items = array()
	) {

		$num_posts = wp_count_posts( 'meow-video' );
		$type      = 'meow-video';
		if ( $num_posts ) {

			$published = intval( $num_posts->publish );
			$post_type = get_post_type_object( $type );

			$text = _n( '%s ' . $post_type->labels->singular_name, '%s ' . $post_type->labels->name, $published, MEOW_CASTER_SLUG );
			$text = sprintf( $text, number_format_i18n( $published ) );

			if ( current_user_can( $post_type->cap->edit_posts ) ) {
				$items[] = sprintf( '<a class="%1$s-count" href="edit.php?post_type=%1$s">%2$s</a>', $type, $text ) . "\n";
			} else {
				$items[] = sprintf( '<span class="%1$s-count">%2$s</span>', $type, $text ) . "\n";
			}
		}

		return $items;

	}

	public function is_link_to_gallery(
		$meow_gallery_ID
	) {
		return in_array( $meow_gallery_ID, $this->gallery_in );
	}

// Event Triggerred actions

	public function _on_import() {

	}

	public function _on_gallery_add(
		$gallery_id = null
	) {
		if ( is_null( $gallery_id ) && ! is_numeric( $gallery_id ) ) {
			return false;
		}
		$this->populate_request();

		if ( ! in_array( $gallery_id, $this->gallery_in ) ) {

			$this->gallery_in[] = $gallery_id;
			$this->update_postmeta();
		}

	}

	public function _on_gallery_del(
		$gallery_id
	) {
		if ( is_null( $gallery_id ) || ! is_numeric( $gallery_id ) ) {
			return false;
		}

		$this->populate_request();


		if ( in_array( $gallery_id, $this->gallery_in ) ) {

			unset( $this->gallery_in[ array_search( $gallery_id, $this->gallery_in ) ] );
			$this->update_postmeta();
		}
	}

	public function _on_update(
		$post_ID, $post_after, $post_before
	) {

		if ( $post_after->post_type !== 'meow-video' ||
		     $post_after->post_title === $post_before->post_title
		) {
			return;
		}

		$mvideo = new MeowVideo( $post_ID );


		foreach ( $mvideo->gallery_in as $gallery_id ) {
			//meow_look($gallery_id, true, true );
			$mgallery = new MeowVideoGallery( $gallery_id );
			$mgallery->_update_item_content( $mvideo );
		}

	}

	public function _on_sync(
		$meow_video
	) {

	}

	public function _on_trash(
		$postid
	) {

		$mvideo = new MeowVideo( $postid );

		//meow_look($postid, true, true );
		foreach ( $mvideo->gallery_in as $gallery_id ) {
			//meow_look($gallery_id, true, true );
			$mgallery = new MeowVideoGallery( $gallery_id );
			$mgallery->_on_video_go_trash( $mvideo->post->ID );

		}
		$this->gallery_in = [];
		$this->update_postmeta();
	}


}