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

class Google_Service_Analytics_CustomMetric extends Google_Model {
	public $accountId;
	public $active;
	public $created;
	public $id;
	public $index;
	public $kind;
	public $maxValue;
	public $minValue;
	public $name;
	public $scope;
	public $selfLink;
	public $type;
	public $updated;
	public $webPropertyId;
	protected $internal_gapi_mappings = array(
		"maxValue" => "max_value",
		"minValue" => "min_value",
	);
	protected $parentLinkType = 'Google_Service_Analytics_CustomMetricParentLink';
	protected $parentLinkDataType = '';

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

	public function getId() {
		return $this->id;
	}

	public function setId( $id ) {
		$this->id = $id;
	}

	public function getIndex() {
		return $this->index;
	}

	public function setIndex( $index ) {
		$this->index = $index;
	}

	public function getKind() {
		return $this->kind;
	}

	public function setKind( $kind ) {
		$this->kind = $kind;
	}

	public function getMaxValue() {
		return $this->maxValue;
	}

	public function setMaxValue( $maxValue ) {
		$this->maxValue = $maxValue;
	}

	public function getMinValue() {
		return $this->minValue;
	}

	public function setMinValue( $minValue ) {
		$this->minValue = $minValue;
	}

	public function getName() {
		return $this->name;
	}

	public function setName( $name ) {
		$this->name = $name;
	}

	/**
	 * @param Google_Service_Analytics_CustomMetricParentLink
	 */
	public function setParentLink( Google_Service_Analytics_CustomMetricParentLink $parentLink ) {
		$this->parentLink = $parentLink;
	}

	/**
	 * @return Google_Service_Analytics_CustomMetricParentLink
	 */
	public function getParentLink() {
		return $this->parentLink;
	}

	public function getScope() {
		return $this->scope;
	}

	public function setScope( $scope ) {
		$this->scope = $scope;
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

	public function getWebPropertyId() {
		return $this->webPropertyId;
	}

	public function setWebPropertyId( $webPropertyId ) {
		$this->webPropertyId = $webPropertyId;
	}
}
