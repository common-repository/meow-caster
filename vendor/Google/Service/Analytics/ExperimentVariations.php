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

class Google_Service_Analytics_ExperimentVariations extends Google_Model {
	public $name;
	public $status;
	public $url;
	public $weight;
	public $won;

	public function getName() {
		return $this->name;
	}

	public function setName( $name ) {
		$this->name = $name;
	}

	public function getStatus() {
		return $this->status;
	}

	public function setStatus( $status ) {
		$this->status = $status;
	}

	public function getUrl() {
		return $this->url;
	}

	public function setUrl( $url ) {
		$this->url = $url;
	}

	public function getWeight() {
		return $this->weight;
	}

	public function setWeight( $weight ) {
		$this->weight = $weight;
	}

	public function getWon() {
		return $this->won;
	}

	public function setWon( $won ) {
		$this->won = $won;
	}
}
