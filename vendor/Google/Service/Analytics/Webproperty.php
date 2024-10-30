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

class Google_Service_Analytics_Webproperty extends Google_Model {
	public $accountId;
	public $created;
	public $defaultProfileId;
	public $id;
	public $industryVertical;
	public $internalWebPropertyId;
	public $kind;
	public $level;
	public $name;
	public $profileCount;
	public $selfLink;
	public $starred;
	public $updated;
	public $websiteUrl;
	protected $childLinkType = 'Google_Service_Analytics_WebpropertyChildLink';
	protected $childLinkDataType = '';
	protected $parentLinkType = 'Google_Service_Analytics_WebpropertyParentLink';
	protected $parentLinkDataType = '';
	protected $permissionsType = 'Google_Service_Analytics_WebpropertyPermissions';
	protected $permissionsDataType = '';

	public function getAccountId() {
		return $this->accountId;
	}

	public function setAccountId( $accountId ) {
		$this->accountId = $accountId;
	}

	/**
	 * @param Google_Service_Analytics_WebpropertyChildLink
	 */
	public function setChildLink( Google_Service_Analytics_WebpropertyChildLink $childLink ) {
		$this->childLink = $childLink;
	}

	/**
	 * @return Google_Service_Analytics_WebpropertyChildLink
	 */
	public function getChildLink() {
		return $this->childLink;
	}

	public function getCreated() {
		return $this->created;
	}

	public function setCreated( $created ) {
		$this->created = $created;
	}

	public function getDefaultProfileId() {
		return $this->defaultProfileId;
	}

	public function setDefaultProfileId( $defaultProfileId ) {
		$this->defaultProfileId = $defaultProfileId;
	}

	public function getId() {
		return $this->id;
	}

	public function setId( $id ) {
		$this->id = $id;
	}

	public function getIndustryVertical() {
		return $this->industryVertical;
	}

	public function setIndustryVertical( $industryVertical ) {
		$this->industryVertical = $industryVertical;
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
	 * @param Google_Service_Analytics_WebpropertyParentLink
	 */
	public function setParentLink( Google_Service_Analytics_WebpropertyParentLink $parentLink ) {
		$this->parentLink = $parentLink;
	}

	/**
	 * @return Google_Service_Analytics_WebpropertyParentLink
	 */
	public function getParentLink() {
		return $this->parentLink;
	}

	/**
	 * @param Google_Service_Analytics_WebpropertyPermissions
	 */
	public function setPermissions( Google_Service_Analytics_WebpropertyPermissions $permissions ) {
		$this->permissions = $permissions;
	}

	/**
	 * @return Google_Service_Analytics_WebpropertyPermissions
	 */
	public function getPermissions() {
		return $this->permissions;
	}

	public function getProfileCount() {
		return $this->profileCount;
	}

	public function setProfileCount( $profileCount ) {
		$this->profileCount = $profileCount;
	}

	public function getSelfLink() {
		return $this->selfLink;
	}

	public function setSelfLink( $selfLink ) {
		$this->selfLink = $selfLink;
	}

	public function getStarred() {
		return $this->starred;
	}

	public function setStarred( $starred ) {
		$this->starred = $starred;
	}

	public function getUpdated() {
		return $this->updated;
	}

	public function setUpdated( $updated ) {
		$this->updated = $updated;
	}

	public function getWebsiteUrl() {
		return $this->websiteUrl;
	}

	public function setWebsiteUrl( $websiteUrl ) {
		$this->websiteUrl = $websiteUrl;
	}
}
