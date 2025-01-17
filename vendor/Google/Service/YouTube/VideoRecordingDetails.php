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

class Google_Service_YouTube_VideoRecordingDetails extends Google_Model {
	public $locationDescription;
	public $recordingDate;
	protected $locationType = 'Google_Service_YouTube_GeoPoint';
	protected $locationDataType = '';

	/**
	 * @param Google_Service_YouTube_GeoPoint
	 */
	public function setLocation( Google_Service_YouTube_GeoPoint $location ) {
		$this->location = $location;
	}

	/**
	 * @return Google_Service_YouTube_GeoPoint
	 */
	public function getLocation() {
		return $this->location;
	}

	public function getLocationDescription() {
		return $this->locationDescription;
	}

	public function setLocationDescription( $locationDescription ) {
		$this->locationDescription = $locationDescription;
	}

	public function getRecordingDate() {
		return $this->recordingDate;
	}

	public function setRecordingDate( $recordingDate ) {
		$this->recordingDate = $recordingDate;
	}
}
