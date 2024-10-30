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

class Google_Service_Analytics_Profile extends Google_Model {
	public $accountId;
	public $botFilteringEnabled;
	public $created;
	public $currency;
	public $defaultPage;
	public $eCommerceTracking;
	public $enhancedECommerceTracking;
	public $excludeQueryParameters;
	public $id;
	public $internalWebPropertyId;
	public $kind;
	public $name;
	public $selfLink;
	public $siteSearchCategoryParameters;
	public $siteSearchQueryParameters;
	public $starred;
	public $stripSiteSearchCategoryParameters;
	public $stripSiteSearchQueryParameters;
	public $timezone;
	public $type;
	public $updated;
	public $webPropertyId;
	public $websiteUrl;
	protected $childLinkType = 'Google_Service_Analytics_ProfileChildLink';
	protected $childLinkDataType = '';
	protected $parentLinkType = 'Google_Service_Analytics_ProfileParentLink';
	protected $parentLinkDataType = '';
	protected $permissionsType = 'Google_Service_Analytics_ProfilePermissions';
	protected $permissionsDataType = '';

	public function getAccountId() {
		return $this->accountId;
	}

	public function setAccountId( $accountId ) {
		$this->accountId = $accountId;
	}

	public function getBotFilteringEnabled() {
		return $this->botFilteringEnabled;
	}

	public function setBotFilteringEnabled( $botFilteringEnabled ) {
		$this->botFilteringEnabled = $botFilteringEnabled;
	}

	/**
	 * @param Google_Service_Analytics_ProfileChildLink
	 */
	public function setChildLink( Google_Service_Analytics_ProfileChildLink $childLink ) {
		$this->childLink = $childLink;
	}

	/**
	 * @return Google_Service_Analytics_ProfileChildLink
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

	public function getCurrency() {
		return $this->currency;
	}

	public function setCurrency( $currency ) {
		$this->currency = $currency;
	}

	public function getDefaultPage() {
		return $this->defaultPage;
	}

	public function setDefaultPage( $defaultPage ) {
		$this->defaultPage = $defaultPage;
	}

	public function getECommerceTracking() {
		return $this->eCommerceTracking;
	}

	public function setECommerceTracking( $eCommerceTracking ) {
		$this->eCommerceTracking = $eCommerceTracking;
	}

	public function getEnhancedECommerceTracking() {
		return $this->enhancedECommerceTracking;
	}

	public function setEnhancedECommerceTracking( $enhancedECommerceTracking ) {
		$this->enhancedECommerceTracking = $enhancedECommerceTracking;
	}

	public function getExcludeQueryParameters() {
		return $this->excludeQueryParameters;
	}

	public function setExcludeQueryParameters( $excludeQueryParameters ) {
		$this->excludeQueryParameters = $excludeQueryParameters;
	}

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

	public function getName() {
		return $this->name;
	}

	public function setName( $name ) {
		$this->name = $name;
	}

	/**
	 * @param Google_Service_Analytics_ProfileParentLink
	 */
	public function setParentLink( Google_Service_Analytics_ProfileParentLink $parentLink ) {
		$this->parentLink = $parentLink;
	}

	/**
	 * @return Google_Service_Analytics_ProfileParentLink
	 */
	public function getParentLink() {
		return $this->parentLink;
	}

	/**
	 * @param Google_Service_Analytics_ProfilePermissions
	 */
	public function setPermissions( Google_Service_Analytics_ProfilePermissions $permissions ) {
		$this->permissions = $permissions;
	}

	/**
	 * @return Google_Service_Analytics_ProfilePermissions
	 */
	public function getPermissions() {
		return $this->permissions;
	}

	public function getSelfLink() {
		return $this->selfLink;
	}

	public function setSelfLink( $selfLink ) {
		$this->selfLink = $selfLink;
	}

	public function getSiteSearchCategoryParameters() {
		return $this->siteSearchCategoryParameters;
	}

	public function setSiteSearchCategoryParameters( $siteSearchCategoryParameters ) {
		$this->siteSearchCategoryParameters = $siteSearchCategoryParameters;
	}

	public function getSiteSearchQueryParameters() {
		return $this->siteSearchQueryParameters;
	}

	public function setSiteSearchQueryParameters( $siteSearchQueryParameters ) {
		$this->siteSearchQueryParameters = $siteSearchQueryParameters;
	}

	public function getStarred() {
		return $this->starred;
	}

	public function setStarred( $starred ) {
		$this->starred = $starred;
	}

	public function getStripSiteSearchCategoryParameters() {
		return $this->stripSiteSearchCategoryParameters;
	}

	public function setStripSiteSearchCategoryParameters( $stripSiteSearchCategoryParameters ) {
		$this->stripSiteSearchCategoryParameters = $stripSiteSearchCategoryParameters;
	}

	public function getStripSiteSearchQueryParameters() {
		return $this->stripSiteSearchQueryParameters;
	}

	public function setStripSiteSearchQueryParameters( $stripSiteSearchQueryParameters ) {
		$this->stripSiteSearchQueryParameters = $stripSiteSearchQueryParameters;
	}

	public function getTimezone() {
		return $this->timezone;
	}

	public function setTimezone( $timezone ) {
		$this->timezone = $timezone;
	}

	public function getType() {
		return $this->type;
	}

	public function setType( $type ) {
		$this->type = $type;
	}

	public function getUpdated() {
		return $this->updated;
	}

	public function setUpdated( $updated ) {
		$this->updated = $updated;
	}

	public function getWebPropertyId() {
		return $this->webPropertyId;
	}

	public function setWebPropertyId( $webPropertyId ) {
		$this->webPropertyId = $webPropertyId;
	}

	public function getWebsiteUrl() {
		return $this->websiteUrl;
	}

	public function setWebsiteUrl( $websiteUrl ) {
		$this->websiteUrl = $websiteUrl;
	}
}
