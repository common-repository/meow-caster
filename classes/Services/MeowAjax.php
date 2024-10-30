<?php
/**
 * Created by PhpStorm.
 * User: id2
 * Date: 26/03/18
 * Time: 10:36
 */

namespace MeowCaster\Services;


use MeowCaster\Contents\MeowVideo;
use MeowCaster\Contents\MeowVideoGallery;
use function MeowCaster\curl_simple;
use function MeowCaster\get_view;

defined( 'ABSPATH' ) or die( 'Doh?!' );

class MeowAjax {


	/**
	 * @var
	 */
	protected static $instance;

	/**
	 * @since 0.6.0
	 */
	protected static $version = '1.1.0';

	protected $yt_oembed = 'https://www.youtube.com/oembed?url=';

	/**
	 * @return \MeowCaster\Services\MeowAjax
	 */
	public static function getInstance() {
		is_null( self::$instance ) AND self::$instance = new self;

		return self::$instance;
	}

	public function output( $var, $format = 'json' ) {
		if ( $format === 'json' ) {
			echo json_encode( $var );
		}
		wp_die();
	}

	public function setup_action() {

		add_action( 'wp_ajax_meow_caster_yt_oembed', array( $this, 'yt_oembed_call' ) );
		add_action( 'wp_ajax_meow_caster_yt_import', array( $this, 'yt_import' ) );
		add_action( 'wp_ajax_meow_caster_sync', array( $this, 'meow_video_sync' ) );
		add_action( 'wp_ajax_meow_caster_yt_listing_videos', array( $this, 'yt_listing_videos' ) );
		add_action( 'wp_ajax_meow_caster_add_to_gallery', array( $this, 'add_to_gallery' ) );
		add_action( 'wp_ajax_meow_caster_gallery_list', array( $this, 'gallery_list' ) );

		return $this;
	}

	public function gallery_list() {
		//Output
		/*
		 * {
		 *  'tmpId' : XX ,
		 *  'error': Object
		 * }
		 */
		if ( $_POST['action'] !== 'meow_caster_gallery_list' ) {
			return false;
		}
		$max    = ( isset( $_POST['limit'] ) ) ? $_POST['limit'] : 10;
		$offset = ( isset( $_POST['offset'] ) ) ? $_POST['offset'] : 0;

		$args       = array(
			'post_type'      => 'meow-video-gallery',
			'posts_per_page' => $max,
			'offset'         => $offset
		);
		$query      = query_posts( $args );
		$array_post = [];
		if ( $query->have_posts() ) :
			while ( $query->have_posts() ) : $query->the_post();
				$tmp_array['id']    = get_the_ID();
				$tmp_array['title'] = get_the_title();
				// get number of items in the gallery
				$postmeta           = get_post_meta();
				$postmeta           = $postmeta['meow-caster-video-gallery-list'][0] ;
				$tmp_array['count'] = sizeof( $postmeta['items'] );

				array_push( $array_post, $tmp_array );
			endwhile;
		endif;

		echo json_encode( $array_post );
		wp_die();
	}

	public function yt_oembed_call() {
		//Output
		/*
		 * {
		 *  'tmpId' : XX ,
		 *  'imported' : bool ,
		 *  'data': Object ,
		 *  'id' : XX ,
		 *  'list' : XX ,
		 *
		 * }
		 */
		if ( $_POST['action'] !== 'meow_caster_yt_oembed' ) {
			return false;
		}

		// Base Variable
		$output = [];
		$url    = '';
		// extract
		$output['tmpId']    = $_POST['tmpId'];
		$output['imported'] = false;
		$id                 = ( isset( $_POST['id'] ) ) ? $_POST['id'] : 'false';
		$list               = ( isset( $_POST['list'] ) ) ? $_POST['list'] : 'false';


		// video or playlist
		if ( $id != 'false' && $list == 'false' ) {
			$url = 'https://www.youtube.com/watch?v=' . $id;

			// Check if video already imported
			global $wpdb;

			$alreadyImported = $wpdb->get_results(
				"
			SELECT meta_value 
			FROM $wpdb->postmeta 
			WHERE meta_key = 'meow-caster-videoyt-id'
			AND meta_value IN ( '" . $id . "' )
			"
			);
			if ( ! empty( $alreadyImported ) ) {
				$output['imported'] = true;
			}

		} elseif ( $list != 'false' ) {
			$url = 'https://www.youtube.com/playlist?list=' . $_POST['list'];
		}

		if ( $url !== '' ) {
			$oembed_url     = $this->yt_oembed . urlencode( $url ) . '&format=json';
			$output['data'] = curl_simple( $oembed_url, true );

			if ( $id == 'false' ) {
				$tmp = explode( '/', $output['data']['thumbnail_url'] );
				$id  = $tmp[4];
			}
			$output['data']['id']   = $id;
			$output['data']['list'] = $list;
		} else {
			$output['data'] = false;
		}
		echo json_encode( $output );
		wp_die();
	}

	public function yt_import() {
		//Output
		/*
		 * {
		 *  'tmpId' : XX ,
		 *  'error': Object
		 * }
		 */
		// Base Variable
		$output = array(
			"tmpId" => $_POST['tmpId'],
			"error" => false
		);
		if ( $_POST['action'] !== 'meow_caster_yt_import'
		     || ! isset( $_POST['tmpId'] )
		     || is_null( $_POST['tmpId'] )
		     || ! is_numeric( $_POST['tmpId'] )
		     || ! isset( $_POST['list'] )
		     || is_null( $_POST['list'] )
		) {
			$error           = [
				'code'    => '8xA1',
				'message' => __( 'Wrong parameter', MEOW_CASTER_SLUG )
			];
			$output['error'] = $error;
			http_response_code( 403 );
			$this->output( $output );
		}


		global $wpdb;
		//Output
		/*
		 * {
		 *  'tmpId' : XX ,
		 *  'error': Object
		 * }
		 */


		// extract
		$list = json_decode( str_replace( '\\', '', $_POST['list'] ), true );


		$Gcli = MeowGoogleClient::getInstance();

		$listVideoId = [];
		foreach ( $list as $item ) {
			if ( $item['type'] !== 'video' ) {
				continue;
			}
			$listVideoId[] = $item['id'];

		}
		$properListId = "'" . implode( "','", $listVideoId ) . "'";

		// Check if already imported
		// set the meta_key to the appropriate custom field meta key

		$alreadyImported = $wpdb->get_results(
			"
			SELECT meta_value 
			FROM $wpdb->postmeta 
			WHERE meta_key = 'meow-caster-videoyt-id'
			AND meta_value IN ( $properListId )
			"
		);

		foreach ( $alreadyImported as $id ) {
			if ( ( $key = array_search( $id, $listVideoId ) ) !== false ) {
				unset( $listVideoId[ $key ] );
			}
		}

		if ( is_null( $listVideoId ) ) {
			$error           = [
				'code'    => '8xA2',
				'message' => __( 'No video not already imported', MEOW_CASTER_SLUG )
			];
			$output['error'] = $error;
			$this->output( $output );
		}

		// get what we need from API
		// With Google Token
		if ( $Gcli !== false ) {

			$YTcli = $Gcli->getYoutubeService();


			$part = 'snippet,status';
			$ids  = [ 'id' => implode( ',', $listVideoId ) ];

			$reqData = $YTcli->videos->listVideos( $part, $ids );

			if ( empty( $reqData ) ) {
				$error           = [
					'code'    => '8xA3',
					'message' => __( 'No video found on YouTube', MEOW_CASTER_SLUG )
				];
				$output['error'] = $error;
				$this->output( $output );
			}

			$items = $reqData->getItems();

			foreach ( $items as $item ) {
				MeowVideo::import( $item, 'youtube' );
			}
		} else {
			// For version lite with just oembed informations
			$error           = [
				'code'    => '10x2',
				'message' => __( 'Too soon, this feature isn\'t full implemented.', MEOW_CASTER_SLUG )
			];
			$output['error'] = $error;
			$this->output( $output );
		}

		$this->output( $output );
	}

	public function yt_listing_videos() {
		//Output
		/*
		 * {
		 *  'tmpId' : XX ,
		 *  'error': Object
		 *  'html' : String
		 *  '
		 * }
		 */
		if ( $_POST['action'] !== 'meow_caster_yt_listing_videos'
		     || ! isset( $_POST['tmpId'] )
		     || is_null( $_POST['tmpId'] )
		     || ! is_numeric( $_POST['tmpId'] )
		) {
			$error           = [
				'code'    => '8xA1',
				'message' => __( 'Wrong parameter', MEOW_CASTER_SLUG )
			];
			$output['error'] = $error;
			http_response_code( 403 );
			$this->output( $output );
		}

		// Service needed
		$MCache = MeowCache::getInstance();
		$GCli   = MeowGoogleClient::getInstance();
		$YTcli  = $GCli->getYoutubeService();
		// Check if already imported
		$alreadyImported = MeowVideo::get_already_import();


		// Base Variable
		$output = [
			"tmpId" => $_POST['tmpId'],
			"error" => false
		];
		$html   = '';
		// extract


		// get what we need from API
		$part = 'snippet';

		$param = [
			'maxResults' => 50,
			'forMine'    => true,
			'type'       => 'video',
			'order'      => 'date'
		];

		$cache_items = [];
		/*
		 *
		// @TODO No etag implement on Google PHP Classes
		$lastEtag    = get_option( 'youtube_etags' );
		$lastEtag    = $lastEtag['listing-import'];

		if ( $lastEtag !== '' ) {
			$lastReqItems = $MCache->get_cache( $lastEtag, 'listing-yt' );
		} else {
		*/
		$lastReqItems = null;
		//}

		$reqData = $YTcli->search->listSearch( $part, $param );

		if ( empty( $reqData ) ) {
			$error           = [
				'code'    => '8xA3',
				'message' => __( 'No video found on YouTube', MEOW_CASTER_SLUG )
			];
			$output['error'] = $error;
			$this->output( $output );
		}

		$newEtag    = $reqData->getEtag();
		$pageInfo   = $reqData->getPageInfo();
		$pagesItems = [ $reqData->getItems() ];

		//if ( is_null($lastEtag) || $lastEtag !== $newEtag ) {
		for ( $i = 0; $i < round( $pageInfo['totalResults'] / $pageInfo['resultsPerPage'] ); $i ++ ) {
			$param['pageToken'] = $reqData->getNextPageToken();
			$reqData            = $YTcli->search->listSearch( $part, $param );
			$pagesItems[]       = $reqData->getItems();
		}

		$pagesItems = $GCli->add_video_status( $pagesItems );
		//Make some cache
		//$MCache->set_cache( 'last', serialize( $pagesItems ), [ 'type' => 'listing-yt' ] );
		$tmpEtag                   = get_option( 'youtube_etags' );
		$tmpEtag['listing-import'] = $newEtag;
		update_option( 'youtube_etags', $tmpEtag );

		/*
		} else {
			$html .= '<div>Use Cache</div>';
		}
		*/
		foreach ( $pagesItems as $items ) {

			foreach ( $items as $item ) {
				if ( $item['status']['privacyStatus'] == 'private' ) {
					continue;
				}

				$snippet  = $item['snippet'];
				$imported = ( in_array( $item['id']['videoId'], $alreadyImported ) ) ? true : false;
				$param    = [
					'title'        => $snippet['title'],
					'channel_name' => $snippet['channelTitle'],
					'thumb'        => $snippet['thumbnails']['medium']['url'],
					'id'           => $item['id']['videoId'],
					'type'         => 'video',
					'imported'     => $imported,
					'status'       => $item['status']['privacyStatus'],
					'tags'         => $snippet['tags']
				];
				$html     .= get_view( 'admin/import-yt-preview', true, $param);
			}
		}

		$output['html'] = $html;
		$this->output( $output );
	}

	/**
	 * @return mixed
	 */
	public function meow_video_sync() {
		// Base Variable
		$output = [
			"btnId" => $_POST['btnId'],
			"error" => false
		];
		if ( $_POST['action'] !== 'meow_caster_sync'
		     || ! in_array( $_POST['sync'], [ 'yt', 'wp', 'tw' ] )
		) {
			$error           = [
				'code'    => '8xA1',
				'message' => __( 'Wrong parameter', MEOW_CASTER_SLUG )
			];
			$output['error'] = $error;
			http_response_code( 403 );
			$this->output( $output );
		}

		if ( isset( $_POST['meowVID'] ) && ! is_null( $_POST['meowVID'] ) && is_numeric( $_POST['meowVID'] ) ) {
			$meow_content = new MeowVideo( intval( $_POST['meowVID'] ) );
		} elseif ( isset( $_POST['meowGID'] ) && ! is_null( $_POST['meowGID'] ) && is_numeric( $_POST['meowGID'] ) ) {
			$meow_content = new MeowVideoGallery( intval( $_POST['meowGID'] ) );
		} else {
			$error           = [
				'code'    => '8xA1',
				'message' => __( 'Wrong parameter', MEOW_CASTER_SLUG )
			];
			$output['error'] = $error;
			http_response_code( 403 );
			$this->output( $output );
		}

		$param     = explode( '|', $_POST['syncAttr'] );
		$sync_done = $meow_content->sync( $_POST['sync'], $param );

		$output['status'] = $sync_done;

		if ( false === $sync_done ) {
			$error           = [
				'code'    => '8xA4',
				'message' => __( 'Sync Fail', MEOW_CASTER_SLUG )
			];
			$output['error'] = $error;
		}
		$this->output( $output );
	}
}