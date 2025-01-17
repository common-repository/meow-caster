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

class Google_Service_Calendar_FreeBusyResponse extends Google_Model {
	public $kind;
	public $timeMax;
	public $timeMin;
	protected $calendarsType = 'Google_Service_Calendar_FreeBusyCalendar';
	protected $calendarsDataType = 'map';
	protected $groupsType = 'Google_Service_Calendar_FreeBusyGroup';
	protected $groupsDataType = 'map';

	/**
	 * @param Google_Service_Calendar_FreeBusyCalendar
	 */
	public function setCalendars( $calendars ) {
		$this->calendars = $calendars;
	}

	/**
	 * @return Google_Service_Calendar_FreeBusyCalendar
	 */
	public function getCalendars() {
		return $this->calendars;
	}

	/**
	 * @param Google_Service_Calendar_FreeBusyGroup
	 */
	public function setGroups( $groups ) {
		$this->groups = $groups;
	}

	/**
	 * @return Google_Service_Calendar_FreeBusyGroup
	 */
	public function getGroups() {
		return $this->groups;
	}

	public function getKind() {
		return $this->kind;
	}

	public function setKind( $kind ) {
		$this->kind = $kind;
	}

	public function getTimeMax() {
		return $this->timeMax;
	}

	public function setTimeMax( $timeMax ) {
		$this->timeMax = $timeMax;
	}

	public function getTimeMin() {
		return $this->timeMin;
	}

	public function setTimeMin( $timeMin ) {
		$this->timeMin = $timeMin;
	}
}
