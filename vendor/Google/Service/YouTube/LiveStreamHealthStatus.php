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

class Google_Service_YouTube_LiveStreamHealthStatus extends Google_Collection {
	public $lastUpdateTimeSeconds;
	public $status;
	protected $collection_key = 'configurationIssues';
	protected $configurationIssuesType = 'Google_Service_YouTube_LiveStreamConfigurationIssue';
	protected $configurationIssuesDataType = 'array';

	/**
	 * @param Google_Service_YouTube_LiveStreamConfigurationIssue
	 */
	public function setConfigurationIssues( $configurationIssues ) {
		$this->configurationIssues = $configurationIssues;
	}

	/**
	 * @return Google_Service_YouTube_LiveStreamConfigurationIssue
	 */
	public function getConfigurationIssues() {
		return $this->configurationIssues;
	}

	public function getLastUpdateTimeSeconds() {
		return $this->lastUpdateTimeSeconds;
	}

	public function setLastUpdateTimeSeconds( $lastUpdateTimeSeconds ) {
		$this->lastUpdateTimeSeconds = $lastUpdateTimeSeconds;
	}

	public function getStatus() {
		return $this->status;
	}

	public function setStatus( $status ) {
		$this->status = $status;
	}
}
