<?php
/**
 * Functions / Controller on the admin side of the force
 */

namespace MeowCaster\Admin;

use MeowCaster\Services\MeowAjax;
use MeowCaster\Services\MeowMetabox;
use MeowCaster\Services\MeowNotif;

defined( 'ABSPATH' ) or die( 'Doh?' );


Class Admin {


	/**
	 * Register and enqueue script for backOffice
	 */
	function setup_register() {
		//get CSS
		wp_register_style( MEOW_CASTER_PREFIX . 'admin', MEOW_CASTER_ASSETS_URL . 'css/' . MEOW_CASTER_PREFIX . 'admin.min.css' );
		wp_register_style( MEOW_CASTER_PREFIX . 'popin', MEOW_CASTER_ASSETS_URL . 'css/' . MEOW_CASTER_PREFIX . 'popin-reset.min.css' );
		wp_register_style( MEOW_CASTER_PREFIX . 'popin-host', MEOW_CASTER_ASSETS_URL . 'css/' . MEOW_CASTER_PREFIX . 'popin-host.min.css' );
		//get JS
		wp_register_script( MEOW_CASTER_PREFIX . 'admin', MEOW_CASTER_ASSETS_URL . 'js/' . MEOW_CASTER_PREFIX . 'app.min.js', [ 'jquery' ], true );
		wp_register_script( MEOW_CASTER_PREFIX . 'popin-host', MEOW_CASTER_ASSETS_URL . 'js/' . MEOW_CASTER_PREFIX . 'pop-host.min.js', [ 'jquery' ], true );
		wp_register_script( MEOW_CASTER_PREFIX . 'popin-child', MEOW_CASTER_ASSETS_URL . 'js/' . MEOW_CASTER_PREFIX . 'pop-child.min.js', [ 'jquery' ], true );

		$this->setup_enqueue();

		return $this;
	}

	/**
	 *  Enqueue style and script for dashicon and script base on alert or other
	 */
	function setup_enqueue() {

		wp_enqueue_style( MEOW_CASTER_PREFIX . 'admin' );
		wp_enqueue_script( MEOW_CASTER_PREFIX . 'admin' );
	}

	public function run() {
		require MEOW_CASTER_FUNCTIONS_ADMIN_PATH . 'common.php';

		$this->setup_action();

		return $this;
	}

	public function setup_action() {

		add_action( 'admin_init', array( $this, 'setup_register' ) );

		//Metabox actions
		$mcMeta = MeowMetabox::getInstance();
		$mcMeta->setup_action();

		// Ajax action
		$mcAjax = MeowAjax::getInstance();
		$mcAjax->setup_action();

		//Notification action
		$mcNotif = MeowNotif::getInstance();
		$mcNotif->setup_action();

		// Gutenberg action @TODO
		/*
		$mcGut = MeowGut::getInstance();
		$mcGut->setup_action();
		*/

		return $this;
	}
}

