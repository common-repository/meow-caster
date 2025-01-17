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

class Google_Service_Analytics_McfDataQuery extends Google_Collection {
	public $dimensions;
	public $endDate;
	public $filters;
	public $ids;
	public $maxResults;
	public $metrics;
	public $samplingLevel;
	public $segment;
	public $sort;
	public $startDate;
	public $startIndex;
	protected $collection_key = 'sort';
	protected $internal_gapi_mappings = array(
		"endDate"    => "end-date",
		"maxResults" => "max-results",
		"startDate"  => "start-date",
		"startIndex" => "start-index",
	);

	public function getDimensions() {
		return $this->dimensions;
	}

	public function setDimensions( $dimensions ) {
		$this->dimensions = $dimensions;
	}

	public function getEndDate() {
		return $this->endDate;
	}

	public function setEndDate( $endDate ) {
		$this->endDate = $endDate;
	}

	public function getFilters() {
		return $this->filters;
	}

	public function setFilters( $filters ) {
		$this->filters = $filters;
	}

	public function getIds() {
		return $this->ids;
	}

	public function setIds( $ids ) {
		$this->ids = $ids;
	}

	public function getMaxResults() {
		return $this->maxResults;
	}

	public function setMaxResults( $maxResults ) {
		$this->maxResults = $maxResults;
	}

	public function getMetrics() {
		return $this->metrics;
	}

	public function setMetrics( $metrics ) {
		$this->metrics = $metrics;
	}

	public function getSamplingLevel() {
		return $this->samplingLevel;
	}

	public function setSamplingLevel( $samplingLevel ) {
		$this->samplingLevel = $samplingLevel;
	}

	public function getSegment() {
		return $this->segment;
	}

	public function setSegment( $segment ) {
		$this->segment = $segment;
	}

	public function getSort() {
		return $this->sort;
	}

	public function setSort( $sort ) {
		$this->sort = $sort;
	}

	public function getStartDate() {
		return $this->startDate;
	}

	public function setStartDate( $startDate ) {
		$this->startDate = $startDate;
	}

	public function getStartIndex() {
		return $this->startIndex;
	}

	public function setStartIndex( $startIndex ) {
		$this->startIndex = $startIndex;
	}
}
