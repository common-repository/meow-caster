<?php
/**
 * Created by PhpStorm.
 * User: id2
 * Date: 26/03/18
 * Time: 10:36
 */

namespace MeowCaster\Services;


defined( 'ABSPATH' ) or die( 'Doh?!' );

/**
 *
 * @since 0.7.0
 */
class MeowGut {


	/**
	 * @var
	 */
	protected static $instance;

	protected static $version = '0.7.0';


	/**
	 * @return \MeowCaster\Services\MeowGut
	 */
	public static function getInstance() {
		is_null( self::$instance ) AND self::$instance = new self;

		return self::$instance;
	}

	public function setup_action() {
		add_action( 'enqueue_block_editor_assets', [ $this, 'block_test' ] );

		//add action gutenberg block
		return $this;
	}

	public function block_test() {
		wp_enqueue_script(
			'block-test',
			MEOW_CASTER_ASSETS_URL . 'js/' . 'meow-caster-block-test.js',
			[ 'wp-blocks', 'wp-i18n', 'wp-element' ],
			filemtime( MEOW_CASTER_ASSETS_PATH . 'js/' . 'meow-caster-block-test.js' )
		);
	}

}