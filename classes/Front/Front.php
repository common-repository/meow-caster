<?php
/**
 * Front
 *
 * Not Now
 */

namespace MeowCaster\Front;


use MeowCaster\Services\MeowShortCode;

defined( 'ABSPATH' ) or die( 'Doh?!' );

Class Front {


	protected static $version = '0.6.0';

	/**
	 * Register and enqueue script for backOffice
	 */
	function setup_register() {
		//get CSS
		wp_register_style( MEOW_CASTER_PREFIX . 'front', MEOW_CASTER_ASSETS_URL . 'css/' . MEOW_CASTER_PREFIX . 'front.min.css' );
		//get JS
		wp_register_script( MEOW_CASTER_PREFIX . 'front', MEOW_CASTER_ASSETS_URL . 'js/' . MEOW_CASTER_PREFIX . 'front.min.js', [], '1.0', true );

		$this->setup_enqueue();

		return $this;
	}

	/**
	 *  Enqueue style and script for dashicon and script base on alert or other
	 */
	function setup_enqueue() {

		wp_enqueue_style( MEOW_CASTER_PREFIX . 'front' );
		wp_enqueue_script( MEOW_CASTER_PREFIX . 'front' );
	}

	function run() {

		$this->setup_action();

		return $this;
	}

	function setup_action() {

		add_action( 'wp_enqueue_scripts', array( $this, 'setup_register' ) );

		$mcShortCode = MeowShortCode::getInstance();
		$mcShortCode->activation()->register();

		return $this;
	}


}
