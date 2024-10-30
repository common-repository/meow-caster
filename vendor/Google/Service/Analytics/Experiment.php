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

class Google_Service_Analytics_Experiment extends Google_Collection {
	public $accountId;
	public $created;
	public $description;
	public $editableInGaUi;
	public $endTime;
	public $equalWeighting;
	public $id;
	public $internalWebPropertyId;
	public $kind;
	public $minimumExperimentLengthInDays;
	public $name;
	public $objectiveMetric;
	public $optimizationType;
	public $profileId;
	public $reasonExperimentEnded;
	public $rewriteVariationUrlsAsOriginal;
	public $selfLink;
	public $servingFramework;
	public $snippet;
	public $startTime;
	public $status;
	public $trafficCoverage;
	public $updated;
	public $webPropertyId;
	public $winnerConfidenceLevel;
	public $winnerFound;
	protected $collection_key = 'variations';
	protected $parentLinkType = 'Google_Service_Analytics_ExperimentParentLink';
	protected $parentLinkDataType = '';
	protected $variationsType = 'Google_Service_Analytics_ExperimentVariations';
	protected $variationsDataType = 'array';

	public function getAccountId() {
		return $this->accountId;
	}

	public function setAccountId( $accountId ) {
		$this->accountId = $accountId;
	}

	public function getCreated() {
		return $this->created;
	}

	public function setCreated( $created ) {
		$this->created = $created;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setDescription( $description ) {
		$this->description = $description;
	}

	public function getEditableInGaUi() {
		return $this->editableInGaUi;
	}

	public function setEditableInGaUi( $editableInGaUi ) {
		$this->editableInGaUi = $editableInGaUi;
	}

	public function getEndTime() {
		return $this->endTime;
	}

	public function setEndTime( $endTime ) {
		$this->endTime = $endTime;
	}

	public function getEqualWeighting() {
		return $this->equalWeighting;
	}

	public function setEqualWeighting( $equalWeighting ) {
		$this->equalWeighting = $equalWeighting;
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

	public function getMinimumExperimentLengthInDays() {
		return $this->minimumExperimentLengthInDays;
	}

	public function setMinimumExperimentLengthInDays( $minimumExperimentLengthInDays ) {
		$this->minimumExperimentLengthInDays = $minimumExperimentLengthInDays;
	}

	public function getName() {
		return $this->name;
	}

	public function setName( $name ) {
		$this->name = $name;
	}

	public function getObjectiveMetric() {
		return $this->objectiveMetric;
	}

	public function setObjectiveMetric( $objectiveMetric ) {
		$this->objectiveMetric = $objectiveMetric;
	}

	public function getOptimizationType() {
		return $this->optimizationType;
	}

	public function setOptimizationType( $optimizationType ) {
		$this->optimizationType = $optimizationType;
	}

	/**
	 * @param Google_Service_Analytics_ExperimentParentLink
	 */
	public function setParentLink( Google_Service_Analytics_ExperimentParentLink $parentLink ) {
		$this->parentLink = $parentLink;
	}

	/**
	 * @return Google_Service_Analytics_ExperimentParentLink
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

	public function getReasonExperimentEnded() {
		return $this->reasonExperimentEnded;
	}

	public function setReasonExperimentEnded( $reasonExperimentEnded ) {
		$this->reasonExperimentEnded = $reasonExperimentEnded;
	}

	public function getRewriteVariationUrlsAsOriginal() {
		return $this->rewriteVariationUrlsAsOriginal;
	}

	public function setRewriteVariationUrlsAsOriginal( $rewriteVariationUrlsAsOriginal ) {
		$this->rewriteVariationUrlsAsOriginal = $rewriteVariationUrlsAsOriginal;
	}

	public function getSelfLink() {
		return $this->selfLink;
	}

	public function setSelfLink( $selfLink ) {
		$this->selfLink = $selfLink;
	}

	public function getServingFramework() {
		return $this->servingFramework;
	}

	public function setServingFramework( $servingFramework ) {
		$this->servingFramework = $servingFramework;
	}

	public function getSnippet() {
		return $this->snippet;
	}

	public function setSnippet( $snippet ) {
		$this->snippet = $snippet;
	}

	public function getStartTime() {
		return $this->startTime;
	}

	public function setStartTime( $startTime ) {
		$this->startTime = $startTime;
	}

	public function getStatus() {
		return $this->status;
	}

	public function setStatus( $status ) {
		$this->status = $status;
	}

	public function getTrafficCoverage() {
		return $this->trafficCoverage;
	}

	public function setTrafficCoverage( $trafficCoverage ) {
		$this->trafficCoverage = $trafficCoverage;
	}

	public function getUpdated() {
		return $this->updated;
	}

	public function setUpdated( $updated ) {
		$this->updated = $updated;
	}

	/**
	 * @param Google_Service_Analytics_ExperimentVariations
	 */
	public function setVariations( $variations ) {
		$this->variations = $variations;
	}

	/**
	 * @return Google_Service_Analytics_ExperimentVariations
	 */
	public function getVariations() {
		return $this->variations;
	}

	public function getWebPropertyId() {
		return $this->webPropertyId;
	}

	public function setWebPropertyId( $webPropertyId ) {
		$this->webPropertyId = $webPropertyId;
	}

	public function getWinnerConfidenceLevel() {
		return $this->winnerConfidenceLevel;
	}

	public function setWinnerConfidenceLevel( $winnerConfidenceLevel ) {
		$this->winnerConfidenceLevel = $winnerConfidenceLevel;
	}

	public function getWinnerFound() {
		return $this->winnerFound;
	}

	public function setWinnerFound( $winnerFound ) {
		$this->winnerFound = $winnerFound;
	}
}
