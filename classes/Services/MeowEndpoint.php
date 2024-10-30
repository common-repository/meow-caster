<?php
/**
 * Unsuse for now
 */

namespace MeowCaster\Services;

defined( 'ABSPATH' ) or die( 'Doh?!' );

class MeowEndpoint {

	/**
	 * @var
	 */
	protected static $instance;
	protected static $version = '0.9.0';

	protected $roar;

	protected $custom_rewrite_rules = [];
	protected $custom_rewrite_tags = [];
	protected $flush_request = false;


	protected function __construct() {

		$this->roar = MeowRoar::getInstance();

		$this->flush_request = get_option( MEOW_CASTER_SETTINGS . '_flush_request' );


	}

	/**
	 * @return \MeowCaster\Services\MeowEndpoint
	 */
	public static function getInstance() {
		is_null( self::$instance ) AND self::$instance = new self;

		return self::$instance;
	}

	public function add_action() {
		// parse request
		add_action( 'init', [ $this, 'do_flush_if_need' ], 100 );
	}

	public static function flush_request() {
		return update_option( MEOW_CASTER_SETTINGS . '_flush_request', true );
	}

	public function do_flush_if_need() {

		if ( $this->flush_request ) {
			flush_rewrite_rules();

		}

	}

	// More to come

}