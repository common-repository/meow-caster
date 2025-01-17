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

class Google_Service_Calendar_FreeBusyCalendar extends Google_Collection {
	protected $collection_key = 'errors';
	protected $busyType = 'Google_Service_Calendar_TimePeriod';
	protected $busyDataType = 'array';
	protected $errorsType = 'Google_Service_Calendar_Error';
	protected $errorsDataType = 'array';

	/**
	 * @param Google_Service_Calendar_TimePeriod
	 */
	public function setBusy( $busy ) {
		$this->busy = $busy;
	}

	/**
	 * @return Google_Service_Calendar_TimePeriod
	 */
	public function getBusy() {
		return $this->busy;
	}

	/**
	 * @param Google_Service_Calendar_Error
	 */
	public function setErrors( $errors ) {
		$this->errors = $errors;
	}

	/**
	 * @return Google_Service_Calendar_Error
	 */
	public function getErrors() {
		return $this->errors;
	}
}
