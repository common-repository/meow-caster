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

class Google_Service_Oauth2_Tokeninfo extends Google_Model {
	public $accessType;
	public $audience;
	public $email;
	public $expiresIn;
	public $issuedTo;
	public $scope;
	public $tokenHandle;
	public $userId;
	public $verifiedEmail;
	protected $internal_gapi_mappings = array(
		"accessType"    => "access_type",
		"expiresIn"     => "expires_in",
		"issuedTo"      => "issued_to",
		"tokenHandle"   => "token_handle",
		"userId"        => "user_id",
		"verifiedEmail" => "verified_email",
	);

	public function getAccessType() {
		return $this->accessType;
	}

	public function setAccessType( $accessType ) {
		$this->accessType = $accessType;
	}

	public function getAudience() {
		return $this->audience;
	}

	public function setAudience( $audience ) {
		$this->audience = $audience;
	}

	public function getEmail() {
		return $this->email;
	}

	public function setEmail( $email ) {
		$this->email = $email;
	}

	public function getExpiresIn() {
		return $this->expiresIn;
	}

	public function setExpiresIn( $expiresIn ) {
		$this->expiresIn = $expiresIn;
	}

	public function getIssuedTo() {
		return $this->issuedTo;
	}

	public function setIssuedTo( $issuedTo ) {
		$this->issuedTo = $issuedTo;
	}

	public function getScope() {
		return $this->scope;
	}

	public function setScope( $scope ) {
		$this->scope = $scope;
	}

	public function getTokenHandle() {
		return $this->tokenHandle;
	}

	public function setTokenHandle( $tokenHandle ) {
		$this->tokenHandle = $tokenHandle;
	}

	public function getUserId() {
		return $this->userId;
	}

	public function setUserId( $userId ) {
		$this->userId = $userId;
	}

	public function getVerifiedEmail() {
		return $this->verifiedEmail;
	}

	public function setVerifiedEmail( $verifiedEmail ) {
		$this->verifiedEmail = $verifiedEmail;
	}
}
