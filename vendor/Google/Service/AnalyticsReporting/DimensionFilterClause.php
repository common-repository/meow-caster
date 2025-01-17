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

class Google_Service_AnalyticsReporting_DimensionFilterClause extends Google_Collection {
	public $operator;
	protected $collection_key = 'filters';
	protected $filtersType = 'Google_Service_AnalyticsReporting_DimensionFilter';
	protected $filtersDataType = 'array';

	/**
	 * @param Google_Service_AnalyticsReporting_DimensionFilter
	 */
	public function setFilters( $filters ) {
		$this->filters = $filters;
	}

	/**
	 * @return Google_Service_AnalyticsReporting_DimensionFilter
	 */
	public function getFilters() {
		return $this->filters;
	}

	public function getOperator() {
		return $this->operator;
	}

	public function setOperator( $operator ) {
		$this->operator = $operator;
	}
}
