<?php

namespace MeowCaster_Vendor\GuzzleHttp\Psr7;

use MeowCaster_Vendor\Psr\Http\Message\StreamInterface;

/**
 * Stream decorator that prevents a stream from being seeked
 */
class NoSeekStream implements StreamInterface {
	use StreamDecoratorTrait;

	public function seek( $offset, $whence = SEEK_SET ) {
		throw new \RuntimeException( 'Cannot seek a NoSeekStream' );
	}

	public function isSeekable() {
		return false;
	}
}
