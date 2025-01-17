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

class Google_Service_Analytics_Goal extends Google_Model {
	public $accountId;
	public $active;
	public $created;
	public $id;
	public $internalWebPropertyId;
	public $kind;
	public $name;
	public $profileId;
	public $selfLink;
	public $type;
	public $updated;
	public $value;
	public $webPropertyId;
	protected $eventDetailsType = 'Google_Service_Analytics_GoalEventDetails';
	protected $eventDetailsDataType = '';
	protected $parentLinkType = 'Google_Service_Analytics_GoalParentLink';
	protected $parentLinkDataType = '';
	protected $urlDestinationDetailsType = 'Google_Service_Analytics_GoalUrlDestinationDetails';
	protected $urlDestinationDetailsDataType = '';
	protected $visitNumPagesDetailsType = 'Google_Service_Analytics_GoalVisitNumPagesDetails';
	protected $visitNumPagesDetailsDataType = '';
	protected $visitTimeOnSiteDetailsType = 'Google_Service_Analytics_GoalVisitTimeOnSiteDetails';
	protected $visitTimeOnSiteDetailsDataType = '';

	public function getAccountId() {
		return $this->accountId;
	}

	public function setAccountId( $accountId ) {
		$this->accountId = $accountId;
	}

	public function getActive() {
		return $this->active;
	}

	public function setActive( $active ) {
		$this->active = $active;
	}

	public function getCreated() {
		return $this->created;
	}

	public function setCreated( $created ) {
		$this->created = $created;
	}

	/**
	 * @param Google_Service_Analytics_GoalEventDetails
	 */
	public function setEventDetails( Google_Service_Analytics_GoalEventDetails $eventDetails ) {
		$this->eventDetails = $eventDetails;
	}

	/**
	 * @return Google_Service_Analytics_GoalEventDetails
	 */
	public function getEventDetails() {
		return $this->eventDetails;
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
	 * @param Google_Service_Analytics_GoalParentLink
	 */
	public function setParentLink( Google_Service_Analytics_GoalParentLink $parentLink ) {
		$this->parentLink = $parentLink;
	}

	/**
	 * @return Google_Service_Analytics_GoalParentLink
	 */
	public function getParentLink() {
		return $this->parentLink;
	}

	public function getProfileId() {
		return $this->profileId;
	}

	public function setProfileId( $profileId ) {
		$this->profileId = $profileId;
	}

	public function getSelfLink() {
		return $this->selfLink;
	}

	public function setSelfLink( $selfLink ) {
		$this->selfLink = $selfLink;
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

	/**
	 * @param Google_Service_Analytics_GoalUrlDestinationDetails
	 */
	public function setUrlDestinationDetails( Google_Service_Analytics_GoalUrlDestinationDetails $urlDestinationDetails ) {
		$this->urlDestinationDetails = $urlDestinationDetails;
	}

	/**
	 * @return Google_Service_Analytics_GoalUrlDestinationDetails
	 */
	public function getUrlDestinationDetails() {
		return $this->urlDestinationDetails;
	}

	public function getValue() {
		return $this->value;
	}

	public function setValue( $value ) {
		$this->value = $value;
	}

	/**
	 * @param Google_Service_Analytics_GoalVisitNumPagesDetails
	 */
	public function setVisitNumPagesDetails( Google_Service_Analytics_GoalVisitNumPagesDetails $visitNumPagesDetails ) {
		$this->visitNumPagesDetails = $visitNumPagesDetails;
	}

	/**
	 * @return Google_Service_Analytics_GoalVisitNumPagesDetails
	 */
	public function getVisitNumPagesDetails() {
		return $this->visitNumPagesDetails;
	}

	/**
	 * @param Google_Service_Analytics_GoalVisitTimeOnSiteDetails
	 */
	public function setVisitTimeOnSiteDetails( Google_Service_Analytics_GoalVisitTimeOnSiteDetails $visitTimeOnSiteDetails ) {
		$this->visitTimeOnSiteDetails = $visitTimeOnSiteDetails;
	}

	/**
	 * @return Google_Service_Analytics_GoalVisitTimeOnSiteDetails
	 */
	public function getVisitTimeOnSiteDetails() {
		return $this->visitTimeOnSiteDetails;
	}

	public function getWebPropertyId() {
		return $this->webPropertyId;
	}

	public function setWebPropertyId( $webPropertyId ) {
		$this->webPropertyId = $webPropertyId;
	}
}
