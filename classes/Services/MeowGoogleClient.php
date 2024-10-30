<?php
/**
 * Created by PhpStorm.
 * User: id2
 * Date: 12/02/18
 * Time: 10:25
 */

namespace MeowCaster\Services;


use MeowCaster_Vendor\Google\Google_Client;
use MeowCaster_Vendor\Google\Google_Exception;
use MeowCaster_Vendor\Google\Google_Service_YouTube;

defined( 'ABSPATH' ) or die( 'Doh?!' );

/**
 * Class MeowGoogleClient
 *
 * @package MeowCaster\Services
 *
 * @since   0.7.0
 */
class MeowGoogleClient extends MeowClientProvider {

	/**
	 * @var \MeowCaster\Services\MeowGoogleClient
	 */
	protected static $instance;
	/**
	 * @var string
	 */
	protected static $version = '0.9.0';
	/**
	 * @var \MeowCaster_Vendor\Google\Google_Client
	 */
	protected $client;
	/**
	 * @var array
	 */
	private $scopes = array(
		Google_Service_YouTube::YOUTUBE_READONLY
	);
	/**
	 * @var string
	 */
	private $redirect_uri = 'urn:ietf:wg:oauth:2.0:oob';
	/**
	 * @var string
	 */
	private $creds;
	/**
	 * @var mixed|void
	 */
	private $token;

	//private $endpoint = 'auth/googleCallback';
	/**
	 * @var \MeowCaster\Services\MeowRoar|null
	 */
	private $roar = null;
	/**
	 * MeowGoogleClient constructor.
	 */
	protected function __construct() {

		parent::__construct();

		$this->roar  = MeowRoar::getInstance();
		$this->token = get_option( MEOW_CASTER_SETTINGS . '_youtube_token', 'miaou' );
		$this->creds = get_option( MEOW_CASTER_SETTINGS . '_youtube_creds', 'miaou' );
		$this->token = ( $this->token === '' ) ? 'miaou' : $this->token;
		$this->creds = ( $this->creds === '' ) ? 'miaou' : $this->creds;
		try {
			if ( false === $this->init() ) {
				return false;
			}
		} catch ( Google_Exception $e ) {
			$this->roar->addError();
		}

	}

	/**
	 * @return \MeowCaster\Services\MeowGoogleClient
	 */
	public static function getInstance() {
		is_null( self::$instance ) AND self::$instance = new self;

		return self::$instance;
	}

	public function add_video_status( $pagesItems ) {

		$videoIds      = [];
		$arrayStatus   = [];
		$AllItems      = [];
		$newPagesItems = [];
		// first loop for getting videoIDs
		foreach ( $pagesItems as $items ) {
			foreach ( $items as $item ) {

				$videoIds[] = $item['id']['videoId'];
			}
		}

		// Request to array videoID => status
		$YtCli = $this->getYoutubeService();

		// second loop
		for ( $i = 0; $i * 50 < sizeof( $videoIds ); $i ++ ) {
			$param = [ 'id' => implode( ',', array_slice( $videoIds, $i * 50, 50 ) ) ];

			$reqData    = $YtCli->videos->listVideos( 'status', $param );
			$AllItems[] = $reqData->getItems();
		}
		foreach ( $AllItems as $items ) {
			foreach ( $items as $item ) {

				$arrayStatus[ $item['id'] ] = $item['status'];
			}
		}
		// third loop for adding status to pagesItems
		$counter = 0;
		foreach ( $pagesItems as $items ) {
			foreach ( $items as $item ) {
				if (in_array(
					$arrayStatus[ $item['id']['videoId'] ]['privacyStatus'],
					['private','unlisted'] ) ) {
					continue;
				}

				$item['status']              = $arrayStatus[ $item['id']['videoId'] ];
				$newPagesItems[ $counter ][] = $item;
			}
			$counter ++;
		}

		return $newPagesItems;
	}


	/**
	 * @return \MeowCaster_Vendor\Google\Google_Client
	 */
	public function getClient() {
		return $this->client;
	}

	/**
	 * @throws \MeowCaster_Vendor\Google\Google_Exception
	 */
	public function init() {

		$this->client = new Google_Client();
		if ( $this->creds !== 'miaou' && ! is_null( $this->creds ) ) {
			$this->client->setAuthConfig( $this->creds  );
			$this->client->addScope( $this->scopes );
			$this->client->setRedirectUri( $this->redirect_uri );
			$this->client->setAccessType( 'offline' ); // offline access
			if ( $this->token !== 'miaou' && ! is_null( $this->token ) ) {
				$this->client->setAccessToken( $this->token );
				$this->getRefreshToken();
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	/**
	 * @return mixed
	 */
	public function createAuthUrl() {

		return $this->client->createAuthUrl();
	}

	/**
	 * @param null $sanitize_token
	 *
	 * @return bool
	 * @throws \LogicException
	 */
	public function checkToken( $sanitize_token = null ) {
		$response = false;
		if ( ! is_null( $sanitize_token ) ) {

			$AccessToken = $this->client->fetchAccessTokenWithAuthCode( $sanitize_token );
			//var_dump( $AccessToken );
			if ( array_key_exists( 'error', $AccessToken ) ) {
				$this->roar->addError( '6x2' );

				return false;
			} else {
				$this->client->setAccessToken( $AccessToken );
				update_option( MEOW_CASTER_SETTINGS . '_youtube_token', json_encode( $AccessToken ) );
				$response = true;
			}
		}

		return $response;
	}

	/**
	 * @return bool
	 * @throws \InvalidArgumentException
	 */
	public function revokeToken() {
		$response = false;
		$token    = get_option( MEOW_CASTER_SETTINGS . '_youtube_token', 'miaou' );
		if ( $token !== 'miaou' && ! is_null( $token ) ) {
			try {
				$this->client->setAccessToken( $token );
				$this->client->revokeToken();

			} catch ( \Exception $e ) {
				$this->roar->addError( '8x1' );
			}
			if ( ! $this->roar->hasError( '8x1' ) ) {
				update_option( MEOW_CASTER_SETTINGS . '_youtube_token', '' );
				$response = true;
			}
		}

		return $response;

	}

	public function getRefreshToken() {
		if ( $this->client->isAccessTokenExpired() ) {
			$this->client->fetchAccessTokenWithRefreshToken( $this->client->getRefreshToken() );
			update_option( MEOW_CASTER_SETTINGS . '_youtube_token', json_encode( $this->client->getAccessToken() ) );
		}
	}

	public function getYoutubeService() {
		return new Google_Service_YouTube( $this->client );
	}

	public function is_set( $param = null ) {

		switch ( $param ) {
			case 'config':
				$res = ( ! is_null( $this->creds ) && $this->creds !== 'miaou' ) ? true : false;
				break;
			default:
				$res = false;
		}

		return $res;
	}

	public static function ready() {
		$token = get_option( MEOW_CASTER_SETTINGS . '_youtube_token', 'miaou' );
		$creds = get_option( MEOW_CASTER_SETTINGS . '_youtube_creds', 'miaou' );

		if ( $token !== 'miaou' && ! is_null( $token ) && $token !== ''
		     && $creds !== 'miaou' && ! is_null( $creds ) && $creds !== '' ) {
			return true;
		} else {
			return false;
		}

	}

}