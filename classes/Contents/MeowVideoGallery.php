<?php

namespace MeowCaster\Contents;

use MeowCaster\Services\MeowEndpoint;
use MeowCaster\Services\MeowRoar;
use WP_Query;

class MeowVideoGallery {

	/**
	 * @var \WP_Post Post WordPress for Meow Video Gallery
	 */
	public $post;
	public $postmeta;
	/**
	 * @var string
	 */
	protected $version = '0.9.0';
	protected $roar;

	// To be populate
	protected $is_populate = false;
	protected $display = [
		'col'   => 3,
		'title' => 'on'
	];

	protected $items = [];

	protected $post_inside = [];

	/**
	 * MeowVideoGallery constructor.
	 *
	 * @param \WP_Post | ID $post
	 */
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

		return $this;
	}

	// Get

	public function populate() {
		if ( $this->post === null ) {
			return false;
		}
		$this->postmeta = get_post_meta( $this->post->ID );

		foreach ( $this->postmeta as $key => $value ) {
			$this->postmeta[ $key ] = $value[0];
		}
		apply_filters('console',$this->postmeta);

		$this->postmeta['_meow-caster-video-gallery-list'] = $this->postmeta['_meow-caster-video-gallery-list'];
		$vgl                                               = $this->postmeta['_meow-caster-video-gallery-list'];
		foreach ( $vgl['items'] as $key => $item ) {

			$this->items[ $key ] = json_decode( $item, true );
			if ( isset( $this->items[ $key ]['post'] ) && $this->items[ $key ]['post'] !== null ) {

				$this->post_inside[] = $this->items[ $key ]['post'];
			}
		}
		$this->display['col']   = $vgl['col'];
		$this->display['title'] = ( isset( $vgl['title'] ) ) ? 'on' : false;
		$this->is_populate      = true;
	}

	public static function _get_all() {
		$query = new WP_Query( [ 'post_type' => 'meow-video-gallery' ] );
		$items = [];
		if ( $query->have_posts() ) {
			foreach ( $query->posts as $post ) {
				$items[] = new MeowVideoGallery( $post );
			}
		}

		return $items;
	}

	// Register

	public function count() {
		return count( $this->items );
	}

	public function _register_action() {
		add_action( 'init', [ $this, '_register_cpt' ], 0 );
		add_action( 'wp_trash_post', [ $this, '_on_trash' ] );
		add_action( 'untrashed_post', [ $this, '_on_untrash' ] );
		add_action( 'before_delete_post', [ $this, '_on_delete' ] );
	}

	// Populate

	public function _register_cpt() {

		// CPT meow-video-gallery
		$labels       = [
			'name'                  => _x( 'Meow Video galleries', 'Post Type General Name', 'MEOW_CASTER_SLUG' ),
			'singular_name'         => _x( 'Meow Video Gallery', 'Post Type Singular Name', 'MEOW_CASTER_SLUG' ),
			'menu_name'             => __( 'Meow Video Gallery', 'MEOW_CASTER_SLUG' ),
			'name_admin_bar'        => __( 'Meow Video Gallery', 'MEOW_CASTER_SLUG' ),
			'archives'              => __( 'Item Archives', 'MEOW_CASTER_SLUG' ),
			'attributes'            => __( 'Item Attributes', 'MEOW_CASTER_SLUG' ),
			'parent_item_colon'     => __( 'Parent Item:', 'MEOW_CASTER_SLUG' ),
			'all_items'             => __( 'All Galleries', 'MEOW_CASTER_SLUG' ),
			'add_new_item'          => __( 'Add New Gallery', 'MEOW_CASTER_SLUG' ),
			'add_new'               => __( 'Add Gallery', 'MEOW_CASTER_SLUG' ),
			'new_item'              => __( 'New Gallery', 'MEOW_CASTER_SLUG' ),
			'edit_item'             => __( 'Edit Gallery', 'MEOW_CASTER_SLUG' ),
			'update_item'           => __( 'Update Gallery', 'MEOW_CASTER_SLUG' ),
			'view_item'             => __( 'View Gallery', 'MEOW_CASTER_SLUG' ),
			'view_items'            => __( 'View Galleries', 'MEOW_CASTER_SLUG' ),
			'search_items'          => __( 'Search Video Gallery', 'MEOW_CASTER_SLUG' ),
			'not_found'             => __( 'Not found', 'MEOW_CASTER_SLUG' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'MEOW_CASTER_SLUG' ),
			'featured_image'        => __( 'Preview image', 'MEOW_CASTER_SLUG' ),
			'set_featured_image'    => __( 'Set preview image', 'MEOW_CASTER_SLUG' ),
			'remove_featured_image' => __( 'Remove preview image', 'MEOW_CASTER_SLUG' ),
			'use_featured_image'    => __( 'Use as preview image', 'MEOW_CASTER_SLUG' ),
			'insert_into_item'      => __( 'Insert into gallery', 'MEOW_CASTER_SLUG' ),
			'uploaded_to_this_item' => __( 'Uploaded to this gallery', 'MEOW_CASTER_SLUG' ),
			'items_list'            => __( 'Galleries list', 'MEOW_CASTER_SLUG' ),
			'items_list_navigation' => __( 'Galleries list navigation', 'MEOW_CASTER_SLUG' ),
			'filter_items_list'     => __( 'Filter Galleries list', 'MEOW_CASTER_SLUG' ),
		];
		$capabilities = [
			'edit_posts'             => 'edit_meow_caster_galleries',
			'edit_published_posts'   => 'edit_meow_caster_galleries',
			'edit_private_posts'     => 'edit_meow_caster_galleries',
			'edit_others_posts'      => 'edit_meow_caster_galleries',
			'delete_posts'           => 'delete_meow_caster_galleries',
			'delete_others_posts'    => 'delete_meow_caster_galleries',
			'delete_published_posts' => 'delete_meow_caster_galleries',
			'delete_private_posts'   => 'delete_meow_caster_galleries',
			'publish_posts'          => 'publish_meow_caster_galleries',
			'read_private_posts'     => 'read_private_meow_caster_galleries',
		];
		$args         = [
			'label'               => __( 'Meow Video Gallery', MEOW_CASTER_SLUG ),
			'description'         => __( 'Gallery create with Meow plugins', MEOW_CASTER_SLUG ),
			'labels'              => $labels,
			'supports'            => [ 'title', 'editor', 'thumbnail' ],
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
			//'capability_type'     => ['meow_caster_gallerie','meow_caster_galleries'],
			'capabilities'        => $capabilities,
			'map_meta_cap'    => true,
			'show_in_rest'        => false,

		];

		register_post_type( 'meow-video-gallery', $args );

		MeowEndpoint::flush_request();
	}

	public function _on_video_go_trash( $ID ) {

		if ( ! in_array( $ID, $this->post_inside ) ) {
			return false;
		}

		$new_items_list = [];
		foreach ( $this->items as $key => $item ) {
			if ( ! isset( $item['post'] ) || $item['post'] !== $ID ) {
				$new_items_list[] = $item;
			}
		}
		$this->items = $new_items_list;

		$new_post_inside = [];

		foreach ( $this->post_inside as $key => $postid ) {
			if ( $postid !== $ID ) {
				$new_post_inside[] = $postid;
			}
		}

		$this->post_inside = $new_post_inside;

		//meow_look($this, true, true , true);
		$this->update_postmeta();
	}

	protected function update_postmeta() {

		// items
		$tmp_items = [];
		foreach ( $this->items as $key => $value ) {
			$tmp_items[ $key ] = json_encode( $value, JSON_UNESCAPED_UNICODE );
		}
		$this->postmeta['_meow-caster-video-gallery-list']['items'] = $tmp_items;
		$this->postmeta['_meow-caster-video-gallery-list']['col']   = $this->display['col'];
		if ( $this->display['title'] != false ) {
			$this->postmeta['_meow-caster-video-gallery-list']['title'] = $this->display['title'];
		}
		//meow_look($this, true , true , true);
		foreach ( $this->postmeta as $key => $value ) {
			update_post_meta( $this->post->ID, $key, $value );
		}
	}

	public function _update_item_content( $mvideo ) {

		if ( get_class( $mvideo ) !== 'MeowCaster\Contents\MeowVideo' ) {
			return;
		}

		$items = [];
		foreach ( $this->items as $key => $item ) {

			if ( isset( $item['post'] ) && $item['post'] == $mvideo->post->ID ) {
				$item['title'] = $mvideo->post->post_title;
			}
			$items[ $key ] = $item;
		}
		$this->items = $items;

		$this->update_postmeta();

	}

	public function add_item( $item ) {
		if ( ! is_array( $item ) ) {
			return false;
		}

		$this->items[] = $item;

		if ( isset( $item['post'] ) ) {
			$this->post_inside[] = $item['post'];
		}

	}

	// Action

	public function _on_update_video_gallery_list_metabox( $meow_caster_vgl ) {
		if ( ! is_array( $meow_caster_vgl ) ) {
			return false;
		}
		// Create an array of Meow Video ID  include in the gallery
		$postInGallery = [];

		foreach ( $meow_caster_vgl['items'] as $key => $value ) {
			$json                             = str_replace( [ '\"', "\'" ], [ '"', "'" ], $value );
			$meow_caster_vgl['items'][ $key ] = $json;

			$json = json_decode( $json, true );
			if ( isset( $json['post'] ) && $json['post'] !== null ) {
				$postInGallery[] = $json['post'];
			}
			$this->items[ $key ] = $json;
		}
		$this->items = array_slice( $this->items, 0, count( $meow_caster_vgl['items'] ) );

		// Trigger some action on Meow Video link when add or remove
		$this->_gallery_metabox_change( $postInGallery );

		$this->display['col'] = $meow_caster_vgl['col'];
		if ( isset( $meow_caster_vgl['title'] ) ) {
			$this->display['title'] = $meow_caster_vgl['title'];
		}
		$this->update_postmeta();
	}

	public function _gallery_metabox_change( $postInGallery ) {
		if ( ! is_array( $postInGallery ) || $this->post === null ) {
			return false;
		}

		// get new
		foreach ( $postInGallery as $id ) {
			if ( ! in_array( $id, $this->post_inside ) ) {
				$this->add_meow_video( $id );

			}
		}

		// get deleted
		foreach ( $this->post_inside as $id ) {
			if ( ! in_array( $id, $postInGallery ) ) {
				$this->remove_meow_video( $id );
			}
		}

		$this->post_inside = $postInGallery;
	}

	public function add_meow_video( $postid ) {

		$meow_video = new MeowVideo( $postid );
		if ( ! $meow_video->_on_gallery_add( $this->post->ID ) ) {
			return false;
		};

		return $meow_video;
	}

	// Status

	// Event trigerred actions

	public function remove_meow_video( $postid ) {

		$meow_video = new MeowVideo( $postid );
		if ( ! $meow_video->_on_gallery_del( $this->post->ID ) ) {
			return false;
		};

		return $meow_video;
	}

	public function _on_update( $post_id ) {
		return true;
	}

	public function _on_sync() {

	}

	public function _on_trash( $post_id ) {
		$meow_gallery = new MeowVideoGallery( $post_id );

		foreach ( $meow_gallery->post_inside as $meow_video_id ) {
			$meow_gallery->remove_meow_video( $meow_video_id );
		}
	}

	public function _on_untrash( $post_id ) {
		$meow_gallery = new MeowVideoGallery( $post_id );

		foreach ( $meow_gallery->items as $key => $item ) {

			if ( isset( $item['post'] ) && is_numeric( $item['post'] ) ) {
				$meow_video = $meow_gallery->add_meow_video( $item['post'] );

				if ( $meow_video !== false && $meow_video->post->post_status !== 'Trash' ) {
					$meow_gallery->items[ $key ]['title'] = $meow_video->post->post_title;
				}
			}
		}
	}

	public function _on_delete( $post_id ) {
		$meow_gallery = new MeowVideoGallery( $post_id );
		foreach ( $meow_gallery->post_inside as $meow_video_id ) {
			if ( $meow_gallery->check_link_meow_video( $meow_video_id ) ) {
				$meow_gallery->remove_meow_video( $meow_video_id );
			}
		}
	}

	protected function check_link_meow_video( $post_id ) {
		$meow_video = new MeowVideo( $post_id );

		return $meow_video->is_link_to_gallery( $this->post->ID );
	}

	public function _request_save() {

		$this->update_postmeta();
	}

	protected function populate_request() {
		if ( ! $this->is_populate ) {
			$this->populate();
		}
	}
}