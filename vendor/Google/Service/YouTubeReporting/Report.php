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

class Google_Service_YouTubeReporting_Report extends Google_Model {
	public $createTime;
	public $downloadUrl;
	public $endTime;
	public $id;
	public $jobExpireTime;
	public $jobId;
	public $startTime;

	public function getCreateTime() {
		return $this->createTime;
	}

	public function setCreateTime( $createTime ) {
		$this->createTime = $createTime;
	}

	public function getDownloadUrl() {
		return $this->downloadUrl;
	}

	public function setDownloadUrl( $downloadUrl ) {
		$this->downloadUrl = $downloadUrl;
	}

	public function getEndTime() {
		return $this->endTime;
	}

	public function setEndTime( $endTime ) {
		$this->endTime = $endTime;
	}

	public function getId() {
		return $this->id;
	}

	public function setId( $id ) {
		$this->id = $id;
	}

	public function getJobExpireTime() {
		return $this->jobExpireTime;
	}

	public function setJobExpireTime( $jobExpireTime ) {
		$this->jobExpireTime = $jobExpireTime;
	}

	public function getJobId() {
		return $this->jobId;
	}

	public function setJobId( $jobId ) {
		$this->jobId = $jobId;
	}

	public function getStartTime() {
		return $this->startTime;
	}

	public function setStartTime( $startTime ) {
		$this->startTime = $startTime;
	}
}
