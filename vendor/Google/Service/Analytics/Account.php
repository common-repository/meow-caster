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

class Google_Service_Analytics_Account extends Google_Model {
	public $created;
	public $id;
	public $kind;
	public $name;
	public $selfLink;
	public $starred;
	public $updated;
	protected $childLinkType = 'Google_Service_Analytics_AccountChildLink';
	protected $childLinkDataType = '';
	protected $permissionsType = 'Google_Service_Analytics_AccountPermissions';
	protected $permissionsDataType = '';

	/**
	 * @param Google_Service_Analytics_AccountChildLink
	 */
	public function setChildLink( Google_Service_Analytics_AccountChildLink $childLink ) {
		$this->childLink = $childLink;
	}

	/**
	 * @return Google_Service_Analytics_AccountChildLink
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

	public function getId() {
		return $this->id;
	}

	public function setId( $id ) {
		$this->id = $id;
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
	 * @param Google_Service_Analytics_AccountPermissions
	 */
	public function setPermissions( Google_Service_Analytics_AccountPermissions $permissions ) {
		$this->permissions = $permissions;
	}

	/**
	 * @return Google_Service_Analytics_AccountPermissions
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
}
