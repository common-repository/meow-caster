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

class Google_Service_Analytics_GoalUrlDestinationDetails extends Google_Collection {
	public $caseSensitive;
	public $firstStepRequired;
	public $matchType;
	public $url;
	protected $collection_key = 'steps';
	protected $stepsType = 'Google_Service_Analytics_GoalUrlDestinationDetailsSteps';
	protected $stepsDataType = 'array';

	public function getCaseSensitive() {
		return $this->caseSensitive;
	}

	public function setCaseSensitive( $caseSensitive ) {
		$this->caseSensitive = $caseSensitive;
	}

	public function getFirstStepRequired() {
		return $this->firstStepRequired;
	}

	public function setFirstStepRequired( $firstStepRequired ) {
		$this->firstStepRequired = $firstStepRequired;
	}

	public function getMatchType() {
		return $this->matchType;
	}

	public function setMatchType( $matchType ) {
		$this->matchType = $matchType;
	}

	/**
	 * @param Google_Service_Analytics_GoalUrlDestinationDetailsSteps
	 */
	public function setSteps( $steps ) {
		$this->steps = $steps;
	}

	/**
	 * @return Google_Service_Analytics_GoalUrlDestinationDetailsSteps
	 */
	public function getSteps() {
		return $this->steps;
	}

	public function getUrl() {
		return $this->url;
	}

	public function setUrl( $url ) {
		$this->url = $url;
	}
}
