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

class Google_Service_Calendar_Channel extends Google_Model {
	public $address;
	public $expiration;
	public $id;
	public $kind;
	public $params;
	public $payload;
	public $resourceId;
	public $resourceUri;
	public $token;
	public $type;

	public function getAddress() {
		return $this->address;
	}

	public function setAddress( $address ) {
		$this->address = $address;
	}

	public function getExpiration() {
		return $this->expiration;
	}

	public function setExpiration( $expiration ) {
		$this->expiration = $expiration;
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

	public function getParams() {
		return $this->params;
	}

	public function setParams( $params ) {
		$this->params = $params;
	}

	public function getPayload() {
		return $this->payload;
	}

	public function setPayload( $payload ) {
		$this->payload = $payload;
	}

	public function getResourceId() {
		return $this->resourceId;
	}

	public function setResourceId( $resourceId ) {
		$this->resourceId = $resourceId;
	}

	public function getResourceUri() {
		return $this->resourceUri;
	}

	public function setResourceUri( $resourceUri ) {
		$this->resourceUri = $resourceUri;
	}

	public function getToken() {
		return $this->token;
	}

	public function setToken( $token ) {
		$this->token = $token;
	}

	public function getType() {
		return $this->type;
	}

	public function setType( $type ) {
		$this->type = $type;
	}
}
