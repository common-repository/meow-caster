<?php
/**
 * Autoload For Vendor
 */

if ( ! function_exists( 'meow_caster_update_classmap' ) ) {
	function meow_caster_update_classmap( $classmap_json ) {
		$classmap_file = MEOW_CASTER_PATH . 'vendor/classmap.json';
		ksort( $classmap_json );
		file_put_contents( $classmap_file, json_encode( $classmap_json, JSON_PRETTY_PRINT ) );
	}
}
spl_autoload_register( function ( $class ) {

	// project-specific namespace prefix
	$prefix = 'MeowCaster_Vendor\\';
	// base directory for the namespace prefix
	$base_dir = __DIR__ . DIRECTORY_SEPARATOR;
	// does the class use the namespace prefix?
	$len = strlen( $prefix );
	if ( strncmp( $prefix, $class, $len ) !== 0 ) {
		// no, move to the next registered autoloader
		return;
	}

	// Check if use in the plugin way to not override other
	/*$backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
	if( ! strpos($class ,'JWT') ) {
		// JWT buggy with the autoload
		if ( ! strpos( $backtrace[1]['file'], DIRECTORY_SEPARATOR . 'meow-caster' . DIRECTORY_SEPARATOR ) ) {
			// no, move to the next registered autoloader
			return;
		}
	}*/
	$classmap_file = MEOW_CASTER_PATH . 'vendor/classmap.json';
	$classmap_json = json_decode( file_get_contents( $classmap_file ), true );

	if ( strpos( $class, 'Google' )
	     || strpos( $class, 'Guzzle' )
	     || strpos( $class, 'Psr' ) ) {
		require_once MEOW_CASTER_VENDOR_PATH . 'Guzzle/Psr7/functions_include.php';
		require_once MEOW_CASTER_VENDOR_PATH . 'Guzzle/Promise/functions_include.php';
		require_once MEOW_CASTER_VENDOR_PATH . 'Guzzle/functions_include.php';
		require_once MEOW_CASTER_VENDOR_PATH . 'phpseclib/bootstrap.php';
	}
	//classmap resolve
	if ( array_key_exists( $class, $classmap_json ) && substr( $classmap_json[ $class ], 0, 1 ) !== '?' ) {
		if ( file_exists( $base_dir . $classmap_json[ $class ] ) ) {
			meow_caster_update_classmap( $classmap_json );
			require $base_dir . $classmap_json[ $class ];
		} else {
			$path                    = '?' . $classmap_json[ $class ];
			$classmap_json[ $class ] = $path;
			meow_caster_update_classmap( $classmap_json );
			throw new Exception( 'Class file not found : ' . substr( $classmap_json[ $class ], 1 ) );
		}
	} else {
		// get the relative class name
		$relative_class = substr( $class, $len );


		if ( substr( $relative_class, 0, 6 ) == 'Google' ) {
			//$relative_class = substr($relative_class,7);
			$relative_class = str_replace( 'Google_', '', $relative_class );
			//Replace Google
			$file = $base_dir . str_replace( [ '\\', '_' ], [
					DIRECTORY_SEPARATOR,
					DIRECTORY_SEPARATOR
				], $relative_class ) . '.php';

		} elseif ( substr( $relative_class, 0, 10 ) == 'GuzzleHttp' ) {
			$relative_class = substr( $relative_class, 10 );
			if ( ! strpos( $relative_class, 'GuzzleHttp\\' ) ) {
				$relative_class = 'Guzzle\\' . $relative_class;
			}
			//Replace Guzzle
			$file = $base_dir . str_replace( [ '\\', '_' ], [ DIRECTORY_SEPARATOR, '-' ], $relative_class ) . '.php';
		} elseif ( substr( $relative_class, 0, 3 ) == 'Psr' ) {
			if ( strpos( $relative_class, '\\Http\\Message' ) ) {
				$relative_class = str_replace( '\\Http\\Message', '\\Http_Message', $relative_class );
			}
			//Replace PSR
			$file = $base_dir . str_replace( [ '\\', '_' ], [ DIRECTORY_SEPARATOR, '-' ], $relative_class ) . '.php';
		} elseif ( substr( $relative_class, 0, 3 ) == 'JWT' ) {
			$relative_class = 'php-jwt\\' . substr( $relative_class, 4 );
			//Replace JWT
			$file = $base_dir . str_replace( [ '\\', '_' ], [ DIRECTORY_SEPARATOR, '-' ], $relative_class ) . '.php';
		} else {
			//Replace std
			$file = $base_dir . str_replace( [ '\\', '_' ], [ DIRECTORY_SEPARATOR, '-' ], $relative_class ) . '.php';
		}
		// if the file exists, require it
		if ( file_exists( $file ) ) {
			$path                    = substr( $file, strlen( __DIR__ ) );
			$classmap_json[ $class ] = $path;
			meow_caster_update_classmap( $classmap_json );
			require $file;
		} else {
			$path                    = '?' . substr( $file, strlen( __DIR__ ) );
			$classmap_json[ $class ] = $path;
			meow_caster_update_classmap( $classmap_json );
			throw new Exception( 'Class file not found : ' . $file );
		}

	}

} );
