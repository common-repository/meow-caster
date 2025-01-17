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

class Google_Service_Analytics_Upload extends Google_Collection {
	public $accountId;
	public $customDataSourceId;
	public $errors;
	public $id;
	public $kind;
	public $status;
	public $uploadTime;
	protected $collection_key = 'errors';

	public function getAccountId() {
		return $this->accountId;
	}

	public function setAccountId( $accountId ) {
		$this->accountId = $accountId;
	}

	public function getCustomDataSourceId() {
		return $this->customDataSourceId;
	}

	public function setCustomDataSourceId( $customDataSourceId ) {
		$this->customDataSourceId = $customDataSourceId;
	}

	public function getErrors() {
		return $this->errors;
	}

	public function setErrors( $errors ) {
		$this->errors = $errors;
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

	public function getStatus() {
		return $this->status;
	}

	public function setStatus( $status ) {
		$this->status = $status;
	}

	public function getUploadTime() {
		return $this->uploadTime;
	}

	public function setUploadTime( $uploadTime ) {
		$this->uploadTime = $uploadTime;
	}
}
