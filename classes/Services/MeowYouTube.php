<?php
/**
 * Created by PhpStorm.
 * User: id2
 * Date: 05/09/18
 * Time: 16:36
 */

namespace MeowCaster\Services;

use function MeowCaster\meow_look;

defined( 'ABSPATH' ) or die( 'Doh?!' );

class MeowYouTube {

	protected $googleClient = null;
	protected $youtubeClient = null;
	protected $cache = null;

	public function __construct( MeowGoogleClient $Gcli = null ) {
		if ( is_null( $Gcli ) ) {
			$this->googleClient = MeowGoogleClient::getInstance();
		} else {
			$this->googleClient = $Gcli;
		}
		$this->youtubeClient = $this->googleClient->getYoutubeService();
		// Prepare cache class
		$this->cache = MeowCache::getInstance();

		return $this;
	}

	public function isLive( $channelId = null ) {
		if ( is_null( $channelId ) ) {
			$channelId = get_option( MEOW_CASTER_SETTINGS . '_youtube_channel_id', false );
			$mine = true;
		} else {
			$mine = false;
		}

		$searchParam   = [
			'part'      => 'snippet,id',
			'channelId' => $channelId,
			'eventType' => 'live',
			'type'      => 'video'
		];
		$functionParam = [
			'action'            => 'raw',
			'rawReq'            => true,
			'cache'             => 25,
			'cache_name_suffix' => 'live-'
		];
		//resquest search
		$data = $this->search( $searchParam, $functionParam );
		$firstItems = ( isset($data[0]) )? $data[0] : false ;

		// return true if one live is on
		if ( isset( $firstItems['snippet']['liveBroadcastContent'] ) &&
		     $firstItems['snippet']['liveBroadcastContent'] === 'live' ) {
			$is_live = true;
		} else {
			$is_live = false;
		}
		if( $mine ) {
			$searchParam = [
				'part' => 'snippet,statistics',
				'mine' => true,
			];
		} else {
			$searchParam = [
				'part' => 'snippet,statistics',
				'id' => $channelId,
			];
		}
		$functionParam = [
			'action'            => 'raw',
			'cache'             => 10,
			'cache_name_suffix' => 'channel-' . $channelId
		];

		//resquest search
		$channelInfo = $this->getChannel( $searchParam, $functionParam );
		return [
			'isLive'=> [
				'status'=>$is_live ,
			    'id'=> ($is_live)?$firstItems['id']['videoId']: false
			],
			'channelInfo'=> $channelInfo->getItems()[0]
		];
	}

	// Extract the part

	public function search( Array $searchParam = [], Array $functionparam = [] ) {
		if ( is_null( $searchParam ) || ! isset( $searchParam['part'] ) ) {
			return false;
		}

		list( $part, $searchParam ) = $this->partExtract( $searchParam );
		if ( isset( $searchParam['mine'] ) ) {
			// Prevent param mistake
			$searchParam['forMine'] = $searchParam['mine'];
			unset( $searchParam['mine'] );
		}

		$data_cache = $this->cache->get_cache( MEOW_CASTER_SLUG . '-youtube-' . $functionparam['cache_name_suffix'] . md5(serialize($searchParam)), 'tmp', true );

		if ( is_null( $data_cache ) || ! $data_cache ) {
			$data = $this->youtubeClient->search->listSearch( $part, $searchParam );


			if ( isset( $functionparam['all'] ) && $functionparam['all'] ) {
				$pageInfo   = $data->getPageInfo();
				if( isset( $functionparam['rawReq'] ) && $functionparam['rawReq'] ){
					$alldata = [ $data ];
				} else {
					$alldata = [ $data->getItems() ];
				}
				//if ( is_null($lastEtag) || $lastEtag !== $newEtag ) {
				for ( $i = 0; $i < round( $pageInfo['totalResults'] / $pageInfo['resultsPerPage'] ); $i ++ ) {
					$param['pageToken'] = $data->getNextPageToken();
					$data            = $this->youtubeClient->search->listSearch( $part, $param );
					if( isset( $functionparam['rawReq'] ) && $functionparam['rawReq'] ){
						$alldata[] =  $data ;
					} else {
						$alldata[] =$data->getItems() ;
					}
				}
				$data = $alldata;
			} else {
				if( isset( $functionparam['rawReq'] ) && $functionparam['rawReq'] ){
					 //Nothing
				} else {
					$data =  $data->getItems() ;
				}
			}
			//cache first
			if ( isset( $functionparam['cache'] ) ) {
				$cache_param = [
					'type'     => 'tmp',
					'duration' => $functionparam['cache']
				];
				$this->cache->set_cache( MEOW_CASTER_SLUG . '-youtube-' . $functionparam['cache_name_suffix'] . md5(serialize($searchParam)), $data, $cache_param, true );
			}
		} else {
			$data = $data_cache;
		}

		// return data after a process/treatment/action request
		return $this->dataProcess( $data, $functionparam );

	}

	private function partExtract( Array $param = [] ) {

		$part = $param['part'];
		unset( $param['part'] );

		return [ $part, $param ];
	}

	private function dataProcess( $rawdata, Array $functionparam ) {
		$data = false;
		if ( ! isset( $functionparam['action'] ) ) {
			return $data; // false indeed
		}

		switch ( $functionparam['action'] ) {
			case 'countItems':
				$data = $rawdata->getPageInfo()['totalResults'];
				break;
			case 'countTotal':
				$data = $rawdata->getPageInfo()['totalResults'];
				break;
			case 'raw':
				$data = $rawdata;
				break;
			default:
				// Do nothing
		}

		return $data;
	}

	// Channel
	public function getChannelInfo( $view = 'banner' ,$nb = 5 ) {
		$channel_id = get_option( MEOW_CASTER_SETTINGS . '_youtube_channel_id', false );

		$searchParam   = [
			'part' => 'snippet,statistics',
			'mine' => true,
		];
		$functionParam = [
			'action'            => 'raw',
			'cache'             => 10,
			'cache_name_suffix' => 'channel-' . $channel_id
		];

		//resquest search
		$channelInfo = $this->getChannel( $searchParam, $functionParam );

		if( $view !== 'banner' ) {
			$searchParam   = [
				'part'       => 'snippet',
				'mine'       => true,
				'type'       => 'video',
				'order'      => 'date',
				'maxResults' => $nb,
			];
			$functionParam = [
				'action'            => 'raw',
				'cache'             => 10,
				'cache_name_suffix' => 'channel-vids-' . $channel_id
			];
			$videos = $this->search( $searchParam, $functionParam );
		} else {
			$videos = [];
		}
		return [
			'channel' => $channelInfo,
			'videos'  => $videos
		];
	}

	// Data Getter
	public function getChannel( Array $searchParam = [], Array $functionparam = [] ) {
		if ( is_null( $searchParam ) || ! isset( $searchParam['part'] ) ) {
			return false;
		}

		list( $part, $searchParam ) = $this->partExtract( $searchParam );

		$data_cache = $this->cache->get_cache( MEOW_CASTER_SLUG . '-youtube-' . $functionparam['cache_name_suffix'], 'tmp', true );

		if ( is_null( $data_cache ) || ! $data_cache ) {
			if ( isset( $searchParam['mine'] ) && isset($searchParam['channelId'] )) {
				unset( $searchParam['channelId'] );
			}
			$data = $this->youtubeClient->channels->listChannels( $part, $searchParam );

			//cache first
			if ( isset( $functionparam['cache'] ) ) {
				$cache_param = [
					'type'     => 'tmp',
					'duration' => $functionparam['cache']
				];
				$this->cache->set_cache( MEOW_CASTER_SLUG . '-youtube-' . $functionparam['cache_name_suffix'], $data, $cache_param, true );
			}
		} else {
			$data = $data_cache;
		}

		// return data after a process/treatment/action request
		return $this->dataProcess( $data, $functionparam );

	}



}