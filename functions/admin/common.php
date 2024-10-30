<?php

namespace MeowCaster;
/**
 * Common function for Admin
 */


use MeowCaster\Services\MeowGoogleClient;

if ( ! function_exists( 'inside_call' ) ) {

	function inside_call() {

		// Don't try to call outside of the plugin
		$backtrace = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 2 );

		if ( ! strpos( $backtrace[1]['file'], MEOW_CASTER_PATH )
		     && ! strpos( $backtrace[1]['file'], DIRECTORY_SEPARATOR . 'meow-caster' . DIRECTORY_SEPARATOR . 'classes' )
		     && ! strpos( $backtrace[1]['file'], DIRECTORY_SEPARATOR . 'meow-caster' . DIRECTORY_SEPARATOR . 'functions' )
		     && ! strpos( $backtrace[1]['file'], DIRECTORY_SEPARATOR . 'meow-caster' . DIRECTORY_SEPARATOR . 'views' )
		     && ! strpos( $backtrace[1]['file'], DIRECTORY_SEPARATOR . 'meow-caster' . DIRECTORY_SEPARATOR . 'tests' )
		     && ! strpos( $backtrace[1]['file'], DIRECTORY_SEPARATOR . 'meow-caster' . DIRECTORY_SEPARATOR . 'vendor' ) ) {
			// no, move to the next registered autoloader
			return false;
		} else {
			return true;
		}

	}

}
if ( ! function_exists( 'get_view' ) ) {
	function get_view( $page = null, $ob = true, $imported_var = array() ) {
		if ( is_null( $page ) ) {
			die ( '?!' );
		}

		extract( $imported_var, EXTR_REFS );

		if ( $ob ) {
			ob_start();
			// get view
			include( MEOW_CASTER_VIEWS_PATH . $page . '.php' );
			$html = ob_get_clean();

			// process
			return $html;
		} else {
			include( MEOW_CASTER_VIEWS_PATH . $page . '.php' );
		}
	}

}


if ( ! function_exists( 'get_the_yt_channel_banner' ) ) {

	function get_the_yt_channel_banner() {

		$viewP = get_transient( MEOW_CASTER_SETTINGS . '_youtube_banner_data' );
		if ( $viewP === false ) {

			// Get channel info
			$YTService   = MeowGoogleClient::getInstance()->getYoutubeService();
			$part        = 'snippet,statistics';
			$param       = [ 'mine' => true ];
			$channelData = $YTService->channels->listChannels( $part, $param );

			if ( $channelData === false ) {
				return;
			}

			$channelData = $channelData['items'][0];

			$viewP = [
				'id'     => $channelData['id'],
				'name'   => $channelData['snippet']['title'],
				'url'    => 'https://www.youtube.com/channel/' . $channelData['id'],
				'thumb'  => $channelData['snippet']['thumbnails']['default']['url'],
				'views'  => $channelData['statistics']['viewCount'],
				'videos' => $channelData['statistics']['videoCount'],
				'subs'   => $channelData['statistics']['subscriberCount']
			];

			// Save Channel ID
			if ( get_option( MEOW_CASTER_SETTINGS . '_youtube_channel_id', 'miaou' ) === 'miaou' ) {
				add_option( MEOW_CASTER_SETTINGS . '_youtube_channel_id', $channelData['id'], true );
			} else {
				update_option(MEOW_CASTER_SETTINGS . '_youtube_channel_id', $channelData['id'], true );
			}

			// Cache it
			set_transient( MEOW_CASTER_SETTINGS . '_youtube_banner_data', $viewP, 12 * HOUR_IN_SECONDS );

		}
		// get the view
		$banner = get_view( '/admin/youtube-channel-banner', true, $viewP );

		// display
		return $banner;
	}

}

if ( ! function_exists( 'meow_minimize_post' ) ) {
	function meow_minimize_post( \WP_Post $post, $content = false ) {
		unset( $post->post_author );
		unset( $post->comment_status );
		unset( $post->ping_status );
		unset( $post->post_password );
		unset( $post->post_name );
		unset( $post->to_ping );
		unset( $post->pinged );
		unset( $post->post_parent );
		unset( $post->guid );
		unset( $post->menu_order );
		unset( $post->post_mime_type );
		unset( $post->filter );
		unset( $post->comment_count );
		if ( ! $content ) {
			unset( $post->post_content );
			unset( $post->post_content_filtered );
			unset( $post->post_excerpt );
		}

		return $post;
	}
}
