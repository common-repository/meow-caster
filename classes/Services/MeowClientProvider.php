<?php


namespace MeowCaster\Services;

defined( 'ABSPATH' ) or die( 'Doh?!' );

abstract class MeowClientProvider {

	protected $client;

	/**
	 * MeowClientProvider constructor.
	 */
	protected function __construct() {
	}


	abstract public function init();


}