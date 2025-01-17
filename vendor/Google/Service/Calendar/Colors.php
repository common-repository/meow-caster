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

class Google_Service_Calendar_Colors extends Google_Model {
	public $kind;
	public $updated;
	protected $calendarType = 'Google_Service_Calendar_ColorDefinition';
	protected $calendarDataType = 'map';
	protected $eventType = 'Google_Service_Calendar_ColorDefinition';
	protected $eventDataType = 'map';

	/**
	 * @param Google_Service_Calendar_ColorDefinition
	 */
	public function setCalendar( $calendar ) {
		$this->calendar = $calendar;
	}

	/**
	 * @return Google_Service_Calendar_ColorDefinition
	 */
	public function getCalendar() {
		return $this->calendar;
	}

	/**
	 * @param Google_Service_Calendar_ColorDefinition
	 */
	public function setEvent( $event ) {
		$this->event = $event;
	}

	/**
	 * @return Google_Service_Calendar_ColorDefinition
	 */
	public function getEvent() {
		return $this->event;
	}

	public function getKind() {
		return $this->kind;
	}

	public function setKind( $kind ) {
		$this->kind = $kind;
	}

	public function getUpdated() {
		return $this->updated;
	}

	public function setUpdated( $updated ) {
		$this->updated = $updated;
	}
}
