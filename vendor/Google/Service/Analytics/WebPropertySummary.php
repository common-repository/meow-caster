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

class Google_Service_Analytics_WebPropertySummary extends Google_Collection {
	public $id;
	public $internalWebPropertyId;
	public $kind;
	public $level;
	public $name;
	public $starred;
	public $websiteUrl;
	protected $collection_key = 'profiles';
	protected $profilesType = 'Google_Service_Analytics_ProfileSummary';
	protected $profilesDataType = 'array';

	public function getId() {
		return $this->id;
	}

	public function setId( $id ) {
		$this->id = $id;
	}

	public function getInternalWebPropertyId() {
		return $this->internalWebPropertyId;
	}

	public function setInternalWebPropertyId( $internalWebPropertyId ) {
		$this->internalWebPropertyId = $internalWebPropertyId;
	}

	public function getKind() {
		return $this->kind;
	}

	public function setKind( $kind ) {
		$this->kind = $kind;
	}

	public function getLevel() {
		return $this->level;
	}

	public function setLevel( $level ) {
		$this->level = $level;
	}

	public function getName() {
		return $this->name;
	}

	public function setName( $name ) {
		$this->name = $name;
	}

	/**
	 * @param Google_Service_Analytics_ProfileSummary
	 */
	public function setProfiles( $profiles ) {
		$this->profiles = $profiles;
	}

	/**
	 * @return Google_Service_Analytics_ProfileSummary
	 */
	public function getProfiles() {
		return $this->profiles;
	}

	public function getStarred() {
		return $this->starred;
	}

	public function setStarred( $starred ) {
		$this->starred = $starred;
	}

	public function getWebsiteUrl() {
		return $this->websiteUrl;
	}

	public function setWebsiteUrl( $websiteUrl ) {
		$this->websiteUrl = $websiteUrl;
	}
}
