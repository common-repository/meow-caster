<?php

namespace MeowCaster\Services;

defined( 'ABSPATH' ) or die( 'Doh?!' );
/**
 * Class MeowRoar
 *
 * Notification and Error Handler for Meow Plugins
 *
 * Need to be a singleton
 *
 * @package MeowCaster\Services
 */
class MeowRoar {

	/**
	 * @var bool
	 */
	public static $error_populate = false;
	/**
	 * @var instance of this singleton
	 */
	protected static $instance;
	/**
	 * @var string
	 */
	protected static $version = '0.6.0';
	/**
	 * @var array
	 */
	protected $error = array();
	/**
	 * @var array
	 */
	protected $notification = array();
	/**
	 * All errors codes
	 *
	 * For keep clean, all error have a code like '6x01'.
	 * First number is for the type of error, it have to be greater than 5 for don't be assimilate to HTTP response
	 * code. Second number is for the ID of the error.
	 *
	 * @var array
	 */
	protected $error_codes = array();

	/**
	 * @return \MeowCaster\Services\MeowRoar
	 */
	public static function getInstance() {
		is_null( self::$instance ) AND self::$instance = new self;

		return self::$instance;
	}

	/**
	 * @return bool
	 */
	public function hasError( $code = null ) {
		$err = true;
		if ( sizeof( $this->error ) == 0 ) {
			$err = false;
		} else {
			if ( is_null( $code ) || in_array( $code, $this->error ) ) {
				$err = true;
			}
		}

		return $err;
	}


	/**
	 * @return array
	 */
	public function getError() {
		return $this->error;
	}

	public function addError( $code = '10x0', $param = null ) {
		// Check if the error code are a populate array
		if ( ! $this::$error_populate ) {
			$this->populateErrorCodes();
		}
		if ( array_key_exists( $code, $this->error_codes ) ) {
			$newError = $this->error_codes[ $code ];
		} else {
			$newError = array(
				'code'    => '10x1',
				'type'    => 'misdefined',
				'message' => __( "Error code %s not found. Don't worry, just contact meow codes team for fix it.", MEOW_CASTER_SLUG )
			);
			$param    = array( $code );
		}

		if ( ! is_null( $param ) ) {
			$newError['message'] = vsprintf( $newError['message'], $param );
		}

		// Simply add the message to the array
		$this->error[ $newError['code'] ] = $newError;

		return $this;
	}

	/**
	 * @return \MeowCaster\Services\MeowRoar
	 */
	public function populateErrorCodes() {

		/*
		 * Keep in mind this :
		 *
		 * For keep clean, all error have a code like '6x01'.
	     * First number is for the type of error, it have to be greater than 5 for don't be assimilate to HTTP response code.
         * Second number is for the ID of the error.
		 */

		/*
		 * Keep in mind this :
		 *
		 * For keep clean, all error have a code like '6x01'.
	     * First number is for the type of error, it have to be greater than 5 for don't be assimilate to HTTP response code.
         * Second number is for the ID of the error.
		 */

		$this->error_codes = array(
			// template
			// '10x0' => array ( 'code'=> '10x0', 'type' => 'undefined' , 'message' => __('Undefined error have been triggerred', MEOW_CASTER_SLUG ) ),
			// 6x Form error
			'6x0'  => array(
				'code'    => '6x0',
				'type'    => 'form',
				'message' => __( "Something went wrong when saving the credentials file. Please try again.", MEOW_CASTER_SLUG )
			),
			'6x1'  => array(
				'code'    => '6x1',
				'type'    => 'fail',
				'message' => __( "Invalid form's nonce <div><p>in method : <b>%s()</b></p><p> in file : <b>%s</b></p></div>", MEOW_CASTER_SLUG )
			),
			'6x2'  => array(
				'code'    => '6x2',
				'type'    => 'fail',
				'message' => __( "Invalid Google Token. Please retry.", MEOW_CASTER_SLUG )
			),
			'6x3'  => array(
				'code'    => '6x3',
				'type'    => 'fail',
				'message' => __( "Invalid file type. Please retry with JSON file.", MEOW_CASTER_SLUG )
			),
			'6x4'  => array(
				'code'    => '6x4',
				'type'    => 'fail',
				'message' => __( "Invalid credential type. Please retry with an installed credential by using \"Other\" option on YouTube Console.", MEOW_CASTER_SLUG )
			),
			// 7x Process error have been triggerred

			// 8x Google error
			'8x1'  => array(
				'code'    => '8x1',
				'type'    => 'fail',
				'message' => __( "Google Token isn't revoked. Please retry.", MEOW_CASTER_SLUG )
			),

			// 9x Others error

			// 10x Undefined
			'10x0' => array(
				'code'    => '10x0',
				'type'    => 'undefined',
				'message' => __( 'Undefined error has been triggerred', MEOW_CASTER_SLUG )
			),
			// 10x1 is for the misdefined or not already defined  and it's dynamical
			'10x2' => array(
				'code'    => '10x2',
				'type'    => 'fail',
				'message' => __( 'Too soon, this feature isn\'t fully implemented.', MEOW_CASTER_SLUG )
			),
			// 11x Test for styleguide
			'11x0' => array(
				'code'    => '11x0',
				'type'    => 'undefined',
				'message' => __( 'Test : Undefined error has been triggerred', MEOW_CASTER_SLUG )
			),
			'11x1' => array(
				'code'    => '11x1',
				'type'    => 'fail',
				'message' => __( 'Test : Fail error has been triggerred', MEOW_CASTER_SLUG )
			),
			'11x2' => array(
				'code'    => '11x2',
				'type'    => 'critical',
				'message' => __( 'Test : Critical error has been triggerred <div><p>in method : <b>%s()</b></p><p> in file : <b>%s</b></p></div>', MEOW_CASTER_SLUG )
			),
		);


		$this::$error_populate = true;

		return $this;
	}

	/**
	 * @param string $type
	 * @param null   $message
	 *
	 * @return \MeowCaster\Services\MeowRoar
	 */
	public function addNotification( $type = 'undefined', $message = null ) {
		if ( $type == 'undefined' && is_null( $message ) ) {
			$message = __( 'Undefined notification have been triggerred', MEOW_CASTER_SLUG );

		}

		// Simply add the message to the array
		array_push( $this->notification, array( 'type' => $type, 'message' => $message ) );

		return $this;
	}

	/**
	 * @return bool
	 */
	public function hasNotification() {
		if ( sizeof( $this->notification ) == 0 ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * @return array
	 */
	public function getNotification() {
		return $this->notification;
	}

}