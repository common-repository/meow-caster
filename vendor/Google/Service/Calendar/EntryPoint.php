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

class Google_Service_Calendar_EntryPoint extends Google_Model {
	public $accessCode;
	public $entryPointType;
	public $label;
	public $meetingCode;
	public $passcode;
	public $password;
	public $pin;
	public $uri;

	public function getAccessCode() {
		return $this->accessCode;
	}

	public function setAccessCode( $accessCode ) {
		$this->accessCode = $accessCode;
	}

	public function getEntryPointType() {
		return $this->entryPointType;
	}

	public function setEntryPointType( $entryPointType ) {
		$this->entryPointType = $entryPointType;
	}

	public function getLabel() {
		return $this->label;
	}

	public function setLabel( $label ) {
		$this->label = $label;
	}

	public function getMeetingCode() {
		return $this->meetingCode;
	}

	public function setMeetingCode( $meetingCode ) {
		$this->meetingCode = $meetingCode;
	}

	public function getPasscode() {
		return $this->passcode;
	}

	public function setPasscode( $passcode ) {
		$this->passcode = $passcode;
	}

	public function getPassword() {
		return $this->password;
	}

	public function setPassword( $password ) {
		$this->password = $password;
	}

	public function getPin() {
		return $this->pin;
	}

	public function setPin( $pin ) {
		$this->pin = $pin;
	}

	public function getUri() {
		return $this->uri;
	}

	public function setUri( $uri ) {
		$this->uri = $uri;
	}
}
