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

class Google_Service_Calendar_ConferenceData extends Google_Collection {
	public $conferenceId;
	public $notes;
	public $signature;
	protected $collection_key = 'entryPoints';
	protected $conferenceSolutionType = 'Google_Service_Calendar_ConferenceSolution';
	protected $conferenceSolutionDataType = '';
	protected $createRequestType = 'Google_Service_Calendar_CreateConferenceRequest';
	protected $createRequestDataType = '';
	protected $entryPointsType = 'Google_Service_Calendar_EntryPoint';
	protected $entryPointsDataType = 'array';

	public function getConferenceId() {
		return $this->conferenceId;
	}

	public function setConferenceId( $conferenceId ) {
		$this->conferenceId = $conferenceId;
	}

	/**
	 * @param Google_Service_Calendar_ConferenceSolution
	 */
	public function setConferenceSolution( Google_Service_Calendar_ConferenceSolution $conferenceSolution ) {
		$this->conferenceSolution = $conferenceSolution;
	}

	/**
	 * @return Google_Service_Calendar_ConferenceSolution
	 */
	public function getConferenceSolution() {
		return $this->conferenceSolution;
	}

	/**
	 * @param Google_Service_Calendar_CreateConferenceRequest
	 */
	public function setCreateRequest( Google_Service_Calendar_CreateConferenceRequest $createRequest ) {
		$this->createRequest = $createRequest;
	}

	/**
	 * @return Google_Service_Calendar_CreateConferenceRequest
	 */
	public function getCreateRequest() {
		return $this->createRequest;
	}

	/**
	 * @param Google_Service_Calendar_EntryPoint
	 */
	public function setEntryPoints( $entryPoints ) {
		$this->entryPoints = $entryPoints;
	}

	/**
	 * @return Google_Service_Calendar_EntryPoint
	 */
	public function getEntryPoints() {
		return $this->entryPoints;
	}

	public function getNotes() {
		return $this->notes;
	}

	public function setNotes( $notes ) {
		$this->notes = $notes;
	}

	public function getSignature() {
		return $this->signature;
	}

	public function setSignature( $signature ) {
		$this->signature = $signature;
	}
}
