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

class Google_Service_Analytics_RealtimeData extends Google_Collection {
	public $id;
	public $kind;
	public $rows;
	public $selfLink;
	public $totalResults;
	public $totalsForAllResults;
	protected $collection_key = 'rows';
	protected $columnHeadersType = 'Google_Service_Analytics_RealtimeDataColumnHeaders';
	protected $columnHeadersDataType = 'array';
	protected $profileInfoType = 'Google_Service_Analytics_RealtimeDataProfileInfo';
	protected $profileInfoDataType = '';
	protected $queryType = 'Google_Service_Analytics_RealtimeDataQuery';
	protected $queryDataType = '';

	/**
	 * @param Google_Service_Analytics_RealtimeDataColumnHeaders
	 */
	public function setColumnHeaders( $columnHeaders ) {
		$this->columnHeaders = $columnHeaders;
	}

	/**
	 * @return Google_Service_Analytics_RealtimeDataColumnHeaders
	 */
	public function getColumnHeaders() {
		return $this->columnHeaders;
	}

	public function getId() {
		return $this->id;
	}

	public function setId( $id ) {
		$this->id = $id;
	}

	public function getKind() {
		return $this->kind;
	}

	public function setKind( $kind ) {
		$this->kind = $kind;
	}

	/**
	 * @param Google_Service_Analytics_RealtimeDataProfileInfo
	 */
	public function setProfileInfo( Google_Service_Analytics_RealtimeDataProfileInfo $profileInfo ) {
		$this->profileInfo = $profileInfo;
	}

	/**
	 * @return Google_Service_Analytics_RealtimeDataProfileInfo
	 */
	public function getProfileInfo() {
		return $this->profileInfo;
	}

	/**
	 * @param Google_Service_Analytics_RealtimeDataQuery
	 */
	public function setQuery( Google_Service_Analytics_RealtimeDataQuery $query ) {
		$this->query = $query;
	}

	/**
	 * @return Google_Service_Analytics_RealtimeDataQuery
	 */
	public function getQuery() {
		return $this->query;
	}

	public function getRows() {
		return $this->rows;
	}

	public function setRows( $rows ) {
		$this->rows = $rows;
	}

	public function getSelfLink() {
		return $this->selfLink;
	}

	public function setSelfLink( $selfLink ) {
		$this->selfLink = $selfLink;
	}

	public function getTotalResults() {
		return $this->totalResults;
	}

	public function setTotalResults( $totalResults ) {
		$this->totalResults = $totalResults;
	}

	public function getTotalsForAllResults() {
		return $this->totalsForAllResults;
	}

	public function setTotalsForAllResults( $totalsForAllResults ) {
		$this->totalsForAllResults = $totalsForAllResults;
	}
}
