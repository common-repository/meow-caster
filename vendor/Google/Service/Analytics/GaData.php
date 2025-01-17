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

class Google_Service_Analytics_GaData extends Google_Collection {
	public $containsSampledData;
	public $dataLastRefreshed;
	public $id;
	public $itemsPerPage;
	public $kind;
	public $nextLink;
	public $previousLink;
	public $rows;
	public $sampleSize;
	public $sampleSpace;
	public $selfLink;
	public $totalResults;
	public $totalsForAllResults;
	protected $collection_key = 'rows';
	protected $columnHeadersType = 'Google_Service_Analytics_GaDataColumnHeaders';
	protected $columnHeadersDataType = 'array';
	protected $dataTableType = 'Google_Service_Analytics_GaDataDataTable';
	protected $dataTableDataType = '';
	protected $profileInfoType = 'Google_Service_Analytics_GaDataProfileInfo';
	protected $profileInfoDataType = '';
	protected $queryType = 'Google_Service_Analytics_GaDataQuery';
	protected $queryDataType = '';

	/**
	 * @param Google_Service_Analytics_GaDataColumnHeaders
	 */
	public function setColumnHeaders( $columnHeaders ) {
		$this->columnHeaders = $columnHeaders;
	}

	/**
	 * @return Google_Service_Analytics_GaDataColumnHeaders
	 */
	public function getColumnHeaders() {
		return $this->columnHeaders;
	}

	public function getContainsSampledData() {
		return $this->containsSampledData;
	}

	public function setContainsSampledData( $containsSampledData ) {
		$this->containsSampledData = $containsSampledData;
	}

	public function getDataLastRefreshed() {
		return $this->dataLastRefreshed;
	}

	public function setDataLastRefreshed( $dataLastRefreshed ) {
		$this->dataLastRefreshed = $dataLastRefreshed;
	}

	/**
	 * @param Google_Service_Analytics_GaDataDataTable
	 */
	public function setDataTable( Google_Service_Analytics_GaDataDataTable $dataTable ) {
		$this->dataTable = $dataTable;
	}

	/**
	 * @return Google_Service_Analytics_GaDataDataTable
	 */
	public function getDataTable() {
		return $this->dataTable;
	}

	public function getId() {
		return $this->id;
	}

	public function setId( $id ) {
		$this->id = $id;
	}

	public function getItemsPerPage() {
		return $this->itemsPerPage;
	}

	public function setItemsPerPage( $itemsPerPage ) {
		$this->itemsPerPage = $itemsPerPage;
	}

	public function getKind() {
		return $this->kind;
	}

	public function setKind( $kind ) {
		$this->kind = $kind;
	}

	public function getNextLink() {
		return $this->nextLink;
	}

	public function setNextLink( $nextLink ) {
		$this->nextLink = $nextLink;
	}

	public function getPreviousLink() {
		return $this->previousLink;
	}

	public function setPreviousLink( $previousLink ) {
		$this->previousLink = $previousLink;
	}

	/**
	 * @param Google_Service_Analytics_GaDataProfileInfo
	 */
	public function setProfileInfo( Google_Service_Analytics_GaDataProfileInfo $profileInfo ) {
		$this->profileInfo = $profileInfo;
	}

	/**
	 * @return Google_Service_Analytics_GaDataProfileInfo
	 */
	public function getProfileInfo() {
		return $this->profileInfo;
	}

	/**
	 * @param Google_Service_Analytics_GaDataQuery
	 */
	public function setQuery( Google_Service_Analytics_GaDataQuery $query ) {
		$this->query = $query;
	}

	/**
	 * @return Google_Service_Analytics_GaDataQuery
	 */
	public function getQuery() {
		return $this->query;
	}

	public function getRows() {
		return $this->rows;
	}

	public function setRows( $rows ) {
		$this->rows = $rows;
	}

	public function getSampleSize() {
		return $this->sampleSize;
	}

	public function setSampleSize( $sampleSize ) {
		$this->sampleSize = $sampleSize;
	}

	public function getSampleSpace() {
		return $this->sampleSpace;
	}

	public function setSampleSpace( $sampleSpace ) {
		$this->sampleSpace = $sampleSpace;
	}

	public function getSelfLink() {
		return $this->selfLink;
	}

	public function setSelfLink( $selfLink ) {
		$this->selfLink = $selfLink;
	}

	public function getTotalResults() {
		return $this->totalResults;
	}

	public function setTotalResults( $totalResults ) {
		$this->totalResults = $totalResults;
	}

	public function getTotalsForAllResults() {
		return $this->totalsForAllResults;
	}

	public function setTotalsForAllResults( $totalsForAllResults ) {
		$this->totalsForAllResults = $totalsForAllResults;
	}
}
