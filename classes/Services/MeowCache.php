<?php

namespace MeowCaster\Services;


/**
 * Class MeowCache
 *
 * @package MeowCaster\Services
 *
 * @since   0.7.0
 */
class MeowCache {
	/**
	 *  version
	 */
	const VERSION_CLASS = "0.9.0";
	/**
	 * @var mixed a single instance of the class
	 */
	protected static $_instance = null;
	/**
	 *  string Where is my cache
	 */
	private $cache_dir = '';

	protected function __construct() {
		$this->cache_dir = MEOW_CASTER_PATH . 'cache' . DIRECTORY_SEPARATOR;
	}


	public static function getInstance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new MeowCache();
		}

		return self::$_instance;
	}

	/**
	 * Set cache
	 *
	 * @return string
	 */
	public function set_cache( $name = null, $value = null, $param = null, $bdd = false ) {
		if ( is_null( $name ) || is_null( $value ) ||
		     is_null( $param ) || ! is_array( $param ) ) {
			return null;
		}
		if ( $bdd ) {
			$cache = $this->set_bdd_cache( $name, $value, $param );
		} else {
			$cache = $this->set_file_cache( $name, $value, $param );
		}

		return $cache;
	}

	protected function set_bdd_cache( $name, $value, $param ) {

		$optName = '_cache_' . $name;

		switch ( $param['type'] ) {
			case "tmp":
				if ( ! isset( $param['duration'] ) ) {
					$param['duration'] = 1 * DAY_IN_SECONDS;
				}
				$cache = set_transient( $optName, $value, $param['duration'] );
				break;
			case "long":
				$cache = add_option( $optName, $value, '', false );
				break;
			default:
				$cache = null;
				break;
		}

		return $cache;

	}

	protected function set_file_cache( $name, $value, $param ) {

		$type = $param['type'];
		$file = $this->cache_dir . '._cache_' . $type . '_' . $name;

		if ( isset( $param['action'] ) ) {
			switch ( $param['action'] ) {
				default :
					// Not implement for now
					break;
			}
		}

		if ( file_exists( $file ) ) {
			if ( is_writable( $file ) ) {
				unlink( $file );
			} else {
				return false;
			}
		}

		if ( $this->writable() && ! file_exists( $file ) ) {
			return file_put_contents( $file, $value );
		} else {
			return false;
		}
	}

	/**
	 * Get writable state of htaccess file
	 *
	 * @return bool
	 */
	public function writable() {

		return is_writable( $this->cache_dir );

	}

	/**
	 * Get cache
	 *
	 * @return string
	 */
	public function get_cache( $name = null, $type = null, $bdd = false ) {
		if ( is_null( $name ) || is_null( $type ) ) {
			return null;
		}
		if ( $bdd ) {
			$cache = $this->get_bdd_cache( $name, $type );
		} else {
			$cache = $this->get_file_cache( $name, $type );
		}

		return $cache;
	}

	protected function get_bdd_cache( $name, $type ) {

		$optName = '_cache_' . $name;
		switch ( $type ) {
			case "tmp":
				$cache = get_transient( $optName );
				break;
			case "long":
				$cache = get_option( $optName );
				break;
			default:
				$cache = null;
				break;
		}

		return $cache;

	}

	protected function get_file_cache( $name, $type ) {

		$file = $this->cache_dir . '._cache_' . $type . '_' . $name;

		if ( ! file_exists( $file ) ||
		     ! is_readable( $file ) ) {
			return null;
		}

		return file_get_contents( $file );

	}


}