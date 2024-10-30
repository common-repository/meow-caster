<?php

namespace MeowCaster;


if ( ! function_exists( 'yt_url_to_id' ) ) {


	function yt_url_to_id( $url = null, $type = 'video' ) {
		if ( is_null( $url ) ) {
			return;
		}
		$parsed_url = parse_url( $url );
		if ( ! in_array( $parsed_url['host'], array( 'youtu.be', 'www.youtube.com' ) ) ) {
			return;
		}

		// regex version
		$regex = array(
			'video' => "/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/",

		);

		if ( $type === 'video' && preg_match( $regex[ $type ], $url, $matches ) ) {
			return $matches[1];
		}


		// @TODO make a good regex to speed up thing
		if ( $type === 'playlist' ) {
			parse_str( parse_url( $url, PHP_URL_QUERY ), $matches );

			if ( isset( $matches['v'] ) && isset( $matches['amp;list'] ) ) {
				return array( $matches['v'], $matches['amp;list'] );
			} else {
				return array( yt_list_to_id( $matches['list'] ), $matches['list'] );
			}
		}

		return false;
	}

}

if ( ! function_exists( 'curl_simple' ) ) {


	function curl_simple( $url, $json = false ) {
		$curl = curl_init( $url );


		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
		$return = curl_exec( $curl );

		curl_close( $curl );

		if ( $json ) {
			$return = json_decode( $return, true );
		}

		return $return;
	}
}

if ( ! function_exists( 'yt_list_to_id' ) ) {

	function yt_list_to_id( $playid = null ) {
		if ( is_null( $playid ) ) {
			return null;
		}
		$oembed_url = 'https://www.youtube.com/oembed?format=json&url=' . urlencode( 'https://www.youtube.com/playlist?list=' ) . $playid;
		$oembed_req = curl_simple( $oembed_url, true );

		$tmp = explode( '/', $oembed_req['thumbnail_url'] );

		return $tmp[4];
	}

}

if ( ! function_exists( 'yt_id_to_url' ) ) {
	function yt_id_to_url( $id, $list = false ) {
		$url = 'https://youtube.com/watch?v=' . $id;
		if ( $list !== false ) {
			$url .= '&list=' . $list;
		}

		return $url;
	}
}

if ( ! function_exists( 'jsonTXT_to_jsonREAL' ) ) {
	function jsonTXT_to_jsonREAL( $jsontxt ) {

		$needed     = array(
			"{'",
			"'}",
			":'",
			"':",
			",'",
			"',"
		);
		$replace_by = array(
			'{"',
			'"}',
			':"',
			'":',
			',"',
			'",'
		);

		return str_replace( $needed, $replace_by, $jsontxt );
	}

}

if ( ! function_exists( 'json_to_jsonTXT' ) ) {
	function json_to_jsonTXT( $jsontxt ) {

		$needed     = array(
			'{"',
			'"}',
			':"',
			'":',
			',"',
			'",'
		);
		$replace_by = array(
			"{'",
			"'}",
			":'",
			"':",
			",'",
			"',"
		);

		return str_replace( $needed, $replace_by, $jsontxt );
	}

}
if ( ! function_exists( 'meow_look' ) ) {
	function meow_look( $var, $pre = false, $print = false, $stop = false ) {

		if ( $pre ) {
			echo '<pre><code>';
		}

		if ( $print ) {
			echo print_r( $var, true );
		} else {
			var_dump( $var );
		}

		if ( $pre ) {
			echo '</code></pre>';
		}
		if ( $stop ) {

			$backtrace = debug_backtrace();
			wp_die( "Stop for debbugging <br> call by <b>" . $backtrace[1]['file'] . "</b> <br> in function <b>" . $backtrace[1]['function'] . "</b>  line <b>" . $backtrace[1]['line'] . '</b>' );
		}
	}

}
if ( ! function_exists( 'meow_nice_counter' ) ) {
	function meow_nice_counter( $number ) {
		$delim_number = [
			'none' => 1,
			'k'    => 1000,
			'M'    => 1000000,
			'Md'   => 1000000000,
		];
		foreach ( $delim_number as $suffix => $delim ) {
			$ratio = (int) $number / $delim;
			// get if it's this ratio or not
			if ( $ratio > 0 && $ratio < 1000 ) {
				if( $suffix === 'none'){
					return $ratio;
				}
				return round($ratio, 1) . ' ' . $suffix;
			}
		}

		return $number;

	}
}