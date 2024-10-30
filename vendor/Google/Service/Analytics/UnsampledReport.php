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

class Google_Service_Analytics_UnsampledReport extends Google_Model {
	public $accountId;
	public $created;
	public $dimensions;
	public $downloadType;
	public $endDate;
	public $filters;
	public $id;
	public $kind;
	public $metrics;
	public $profileId;
	public $segment;
	public $selfLink;
	public $startDate;
	public $status;
	public $title;
	public $updated;
	public $webPropertyId;
	protected $internal_gapi_mappings = array(
		"endDate"   => "end-date",
		"startDate" => "start-date",
	);
	protected $cloudStorageDownloadDetailsType = 'Google_Service_Analytics_UnsampledReportCloudStorageDownloadDetails';
	protected $cloudStorageDownloadDetailsDataType = '';
	protected $driveDownloadDetailsType = 'Google_Service_Analytics_UnsampledReportDriveDownloadDetails';
	protected $driveDownloadDetailsDataType = '';

	public function getAccountId() {
		return $this->accountId;
	}

	public function setAccountId( $accountId ) {
		$this->accountId = $accountId;
	}

	/**
	 * @param Google_Service_Analytics_UnsampledReportCloudStorageDownloadDetails
	 */
	public function setCloudStorageDownloadDetails( Google_Service_Analytics_UnsampledReportCloudStorageDownloadDetails $cloudStorageDownloadDetails ) {
		$this->cloudStorageDownloadDetails = $cloudStorageDownloadDetails;
	}

	/**
	 * @return Google_Service_Analytics_UnsampledReportCloudStorageDownloadDetails
	 */
	public function getCloudStorageDownloadDetails() {
		return $this->cloudStorageDownloadDetails;
	}

	public function getCreated() {
		return $this->created;
	}

	public function setCreated( $created ) {
		$this->created = $created;
	}

	public function getDimensions() {
		return $this->dimensions;
	}

	public function setDimensions( $dimensions ) {
		$this->dimensions = $dimensions;
	}

	public function getDownloadType() {
		return $this->downloadType;
	}

	public function setDownloadType( $downloadType ) {
		$this->downloadType = $downloadType;
	}

	/**
	 * @param Google_Service_Analytics_UnsampledReportDriveDownloadDetails
	 */
	public function setDriveDownloadDetails( Google_Service_Analytics_UnsampledReportDriveDownloadDetails $driveDownloadDetails ) {
		$this->driveDownloadDetails = $driveDownloadDetails;
	}

	/**
	 * @return Google_Service_Analytics_UnsampledReportDriveDownloadDetails
	 */
	public function getDriveDownloadDetails() {
		return $this->driveDownloadDetails;
	}

	public function getEndDate() {
		return $this->endDate;
	}

	public function setEndDate( $endDate ) {
		$this->endDate = $endDate;
	}

	public function getFilters() {
		return $this->filters;
	}

	public function setFilters( $filters ) {
		$this->filters = $filters;
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

	public function getMetrics() {
		return $this->metrics;
	}

	public function setMetrics( $metrics ) {
		$this->metrics = $metrics;
	}

	public function getProfileId() {
		return $this->profileId;
	}

	public function setProfileId( $profileId ) {
		$this->profileId = $profileId;
	}

	public function getSegment() {
		return $this->segment;
	}

	public function setSegment( $segment ) {
		$this->segment = $segment;
	}

	public function getSelfLink() {
		return $this->selfLink;
	}

	public function setSelfLink( $selfLink ) {
		$this->selfLink = $selfLink;
	}

	public function getStartDate() {
		return $this->startDate;
	}

	public function setStartDate( $startDate ) {
		$this->startDate = $startDate;
	}

	public function getStatus() {
		return $this->status;
	}

	public function setStatus( $status ) {
		$this->status = $status;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle( $title ) {
		$this->title = $title;
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
