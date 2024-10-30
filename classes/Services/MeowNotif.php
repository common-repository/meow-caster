<?php

namespace MeowCaster\Services;

defined( 'ABSPATH' ) or die( 'Doh?!' );

/**
 * Class MeowNotif
 *
 * Notification Handler for Meow Plugins
 *
 * Need to be a singleton
 *
 * @package MeowCaster\Services
 * @since   1.1.0
 */
class MeowNotif {

	/**
	 * Notif object pattern
	 *
	 * {
	 *      "msg"   : string //message to print
	 *      "type"  : "now" | "scheduled" | "trigerred" //type of
	 *      "param" : [
	 *              "dismiss" : true | false | "ajax" // dismiss button with or without ajax action
	 *              "type" : "notice-error" | "notice-warning" | "notice-success" | "notice-info"
	 *                       "meow-error" | "meow-warning" | "meow-success"  | "meow-info"
	 *              // type for html class decision
	 *              "template" : "template-name" | false // choose specific template or default template
	 *              ]
	 *
	 * }
	 */

	/**
	 * @var instance of this singleton
	 */
	protected static $instance;
	/**
	 * @var string
	 */
	protected static $version = '1.1.0';

	protected $notifs = [];

	protected $defaultTemplate = [
		"notice"         => 'notice-basic',
		"notice-error"   => 'notice-basic',
		"notice-warning" => 'notice-basic',
		"notice-success" => 'notice-basic',
		"notice-info"    => 'notice-basic',
		"meow"           => 'notice-meow',
		"meow-error"     => 'notice-meow',
		"meow-warning"   => 'notice-meow',
		"meow-success"   => 'notice-meow',
		"meow-info"      => 'notice-meow'
	];

	/**
	 * @return \MeowCaster\Services\MeowNotif
	 */
	public static function getInstance() {
		is_null( self::$instance ) AND self::$instance = new self;

		return self::$instance;
	}

	public function setup_action() {
		add_action( 'admin_notices', [ $this, 'printAllNotifs' ] );
	}

	/**
	 * @param string $type
	 * @param null   $message
	 *
	 * @return \MeowCaster\Services\MeowNotif
	 */
	public function addNotif( $type = null, $message = null, $param = [] ) {
		if ( is_null( $type ) || is_null( $message ) ) {
			return false;
		}
		if( $type == 'now' ) {
			// Simply add the message to the array
			$this->notifs[get_current_user_id()][$type][]= [ 'type' => $type, 'msg' => $message , 'param' => $param ] ;
		}
		return $this;
	}

	/**
	 * @return bool
	 */
	public function hasNotif() {
		if ( sizeof( $this->notifications ) == 0 ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * @return array
	 */
	public function getNotifs() {
		return $this->notifs;
	}

	public function printAllNotifs() {
		if ( ! is_admin() ) {
			return null;
		}

		$notif_to_show = $this->getNotifFiltered();

		foreach ( $notif_to_show as $notif ) {
			$this->printNotif( $notif['msg'], $notif['type'], $notif['param'] );
		}

	}

	private function getNotifFiltered() {
		$user_id = get_current_user_id();
		if( ! isset($this->notifs[$user_id]) ){
			return [];
		}
		$n = $this->notifs[$user_id]['now'];
		// @TODO Add Notice from
		return $n;
	}

	private function printNotif( $message, $type, $param ) {
		$class    = $this->getNotifClass( $type, $param );
		$template = $this->getNotifTemplate( $type, $param );

		return printf( $template, esc_attr( $class ), esc_html( $message ) );
	}

	private function getNotifClass( $type = null, $param = [] ) {
		if ( is_null( $type ) || ! is_array( $param ) || ! isset( $param['type'] ) ) {
			return false;
		}
		$class = '';
		if ( strpos( $param['type'], 'meow' ) > 0 ) {
			$class .= 'mcss-notice ' . $param['type'] . ' ';
		} else {
			$class .= 'notice ' . $param['type'] . ' ';
		}

		return $class;
	}

	private function getNotifTemplate( $type = null, $param = [] ) {
		if ( is_null( $type ) || ! is_array( $param ) ) {
			return false;
		}
		$tpl = $this->defaultTemplate[ $param['type'] ];
		if ( isset($param['template']) && $param['template'] !== false && is_string( $param['template'] ) ) {
			$tpl = $param['template'];
		}

		return $this->get_view( $tpl, true, $param );

	}

	function get_view( $page = null, $ob = true, $imported_var = [] ) {
		if ( is_null( $page ) ) {
			die ( '?!' );
		}

		extract( $imported_var, EXTR_REFS );
		if ( $ob ) {
			ob_start();
			// get view
			include( MEOW_CASTER_VIEWS_ADMIN_PATH . 'notice' . DIRECTORY_SEPARATOR . $page . '.php' );
			$html = ob_get_clean();

			// process
			return $html;
		} else {
			return include( MEOW_CASTER_VIEWS_ADMIN_PATH . 'notice' . DIRECTORY_SEPARATOR . $page . '.php' );
		}
	}

	public function dismissNotif( $id = null ) {
		if ( is_null( $id ) ) {
			return false;
		}


	}
}