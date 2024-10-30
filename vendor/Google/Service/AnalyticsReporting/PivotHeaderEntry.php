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

class Google_Service_AnalyticsReporting_PivotHeaderEntry extends Google_Collection {
	public $dimensionNames;
	public $dimensionValues;
	protected $collection_key = 'dimensionValues';
	protected $metricType = 'Google_Service_AnalyticsReporting_MetricHeaderEntry';
	protected $metricDataType = '';

	public function getDimensionNames() {
		return $this->dimensionNames;
	}

	public function setDimensionNames( $dimensionNames ) {
		$this->dimensionNames = $dimensionNames;
	}

	public function getDimensionValues() {
		return $this->dimensionValues;
	}

	public function setDimensionValues( $dimensionValues ) {
		$this->dimensionValues = $dimensionValues;
	}

	/**
	 * @param Google_Service_AnalyticsReporting_MetricHeaderEntry
	 */
	public function setMetric( Google_Service_AnalyticsReporting_MetricHeaderEntry $metric ) {
		$this->metric = $metric;
	}

	/**
	 * @return Google_Service_AnalyticsReporting_MetricHeaderEntry
	 */
	public function getMetric() {
		return $this->metric;
	}
}
