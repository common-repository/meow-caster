<?php

namespace MeowCaster_Vendor\Google;
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

class Google_Service_YouTube_CommentThreadListResponse extends Google_Collection {
	public $etag;
	public $eventId;
	public $kind;
	public $nextPageToken;
	public $visitorId;
	protected $collection_key = 'items';
	protected $itemsType = 'Google_Service_YouTube_CommentThread';
	protected $itemsDataType = 'array';
	protected $pageInfoType = 'Google_Service_YouTube_PageInfo';
	protected $pageInfoDataType = '';
	protected $tokenPaginationType = 'Google_Service_YouTube_TokenPagination';
	protected $tokenPaginationDataType = '';

	public function getEtag() {
		return $this->etag;
	}

	public function setEtag( $etag ) {
		$this->etag = $etag;
	}

	public function getEventId() {
		return $this->eventId;
	}

	public function setEventId( $eventId ) {
		$this->eventId = $eventId;
	}

	/**
	 * @param Google_Service_YouTube_CommentThread
	 */
	public function setItems( $items ) {
		$this->items = $items;
	}

	/**
	 * @return Google_Service_YouTube_CommentThread
	 */
	public function getItems() {
		return $this->items;
	}

	public function getKind() {
		return $this->kind;
	}

	public function setKind( $kind ) {
		$this->kind = $kind;
	}

	public function getNextPageToken() {
		return $this->nextPageToken;
	}

	public function setNextPageToken( $nextPageToken ) {
		$this->nextPageToken = $nextPageToken;
	}

	/**
	 * @param Google_Service_YouTube_PageInfo
	 */
	public function setPageInfo( Google_Service_YouTube_PageInfo $pageInfo ) {
		$this->pageInfo = $pageInfo;
	}

	/**
	 * @return Google_Service_YouTube_PageInfo
	 */
	public function getPageInfo() {
		return $this->pageInfo;
	}

	/**
	 * @param Google_Service_YouTube_TokenPagination
	 */
	public function setTokenPagination( Google_Service_YouTube_TokenPagination $tokenPagination ) {
		$this->tokenPagination = $tokenPagination;
	}

	/**
	 * @return Google_Service_YouTube_TokenPagination
	 */
	public function getTokenPagination() {
		return $this->tokenPagination;
	}

	public function getVisitorId() {
		return $this->visitorId;
	}

	public function setVisitorId( $visitorId ) {
		$this->visitorId = $visitorId;
	}
}
