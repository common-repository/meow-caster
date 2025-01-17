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

class Google_Service_YouTube_GeoPoint extends Google_Model {
	public $altitude;
	public $latitude;
	public $longitude;

	public function getAltitude() {
		return $this->altitude;
	}

	public function setAltitude( $altitude ) {
		$this->altitude = $altitude;
	}

	public function getLatitude() {
		return $this->latitude;
	}

	public function setLatitude( $latitude ) {
		$this->latitude = $latitude;
	}

	public function getLongitude() {
		return $this->longitude;
	}

	public function setLongitude( $longitude ) {
		$this->longitude = $longitude;
	}
}
