<?php
/**
 * Created by PhpStorm.
 * User: id2
 * Date: 12/02/18
 * Time: 10:25
 */

namespace MeowCaster\Services;


defined( 'ABSPATH' ) or die( 'Doh?!' );

class MeowVimeoClient extends MeowClientProvider {

	/**
	 * @var \MeowCaster\Services\MeowVimeoClient
	 */
	protected static $instance;
	/**
	 * @var string
	 */
	protected static $version = '0.1.0';
	/**
	 * @var \MeowCaster_Vendor\Vimeo\Vimeo
	 */
	protected $client;
	/**
	 * @var array
	 */
	protected $scopes = array(
		'private',
		'public',
		'purchased',
		'purchase',
		'create',
		'edit',
		'delete',
		'upload',
		'promo_codes',
		'video_files'
	);
	/**
	 * @var string
	 */
	private $config_path = MEOW_CASTER_CONFIG_PATH . 'vcli.json';
	/**
	 * @var string
	 */
	private $endpoint = 'auth/vimeoCallback';
	private $roar = null;

	/**
	 * MeowVimeoClient constructor.
	 */
	protected function __construct() {

		parent::__construct();

		$this->roar = MeowRoar::getInstance();
		/*
		try {
			$this->init();
		} catch ( VimeoRequestException $e ) {

		}
		*/
	}

	/**
	 *
	 */
	public function init() {

		//$this->client = new Vimeo();

	}

	/**
	 * @return \MeowCaster\Services\MeowVimeoClient
	 */
	public static function getInstance() {
		is_null( self::$instance ) AND self::$instance = new self;

		return self::$instance;
	}


}