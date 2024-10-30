<?php

/**
 * Generic autoload or namespace
 *
 * @require PHP > 5.2
 *
 * @param string $class The fully-qualified class name.
 *
 * @return void
 */
spl_autoload_register( function ( $class ) {

	// project-specific namespace prefix
	$prefix = 'MeowCaster\\';

	// base directory for the namespace prefix
	$base_dir = __DIR__ . '/classes/';
	// does the class use the namespace prefix?
	$len = strlen( $prefix );
	if ( strncmp( $prefix, $class, $len ) !== 0 ) {
		// no, move to the next registered autoloader
		return;
	}

	// get the relative class name
	$relative_class = substr( strtolower( $class ), $len );

	// replace the namespace prefix with the base directory, replace namespace
	// separators with directory separators in the relative class name, append
	// with .php
	$file = $base_dir . str_replace( [ '\\', '_' ], [ '/', '-' ], $relative_class ) . '.php';
	// if the file exists, require it

	if ( file_exists( $file ) ) {
		require $file;
	} else {
		$relative_class = substr( $class, $len );

		// replace the namespace prefix with the base directory, replace namespace
		// separators with directory separators in the relative class name, append
		// with .php
		$file = $base_dir . str_replace( [ '\\', '_' ], [ '/', '-' ], $relative_class ) . '.php';
		// if the file exists, require it
		if ( file_exists( $file ) ) {
			require $file;
		} else {
			throw new Exception( 'Class file not found : ' . $file );
		}

	}
} );

include __DIR__ . '/vendor/_autoload.php';