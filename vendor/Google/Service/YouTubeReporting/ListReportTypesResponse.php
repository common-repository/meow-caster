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

class Google_Service_YouTubeReporting_ListReportTypesResponse extends Google_Collection {
	public $nextPageToken;
	protected $collection_key = 'reportTypes';
	protected $reportTypesType = 'Google_Service_YouTubeReporting_ReportType';
	protected $reportTypesDataType = 'array';

	public function getNextPageToken() {
		return $this->nextPageToken;
	}

	public function setNextPageToken( $nextPageToken ) {
		$this->nextPageToken = $nextPageToken;
	}

	/**
	 * @param Google_Service_YouTubeReporting_ReportType
	 */
	public function setReportTypes( $reportTypes ) {
		$this->reportTypes = $reportTypes;
	}

	/**
	 * @return Google_Service_YouTubeReporting_ReportType
	 */
	public function getReportTypes() {
		return $this->reportTypes;
	}
}
