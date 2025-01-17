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

class Google_Service_YouTube_LiveBroadcastContentDetails extends Google_Model {
	public $boundStreamId;
	public $boundStreamLastUpdateTimeMs;
	public $closedCaptionsType;
	public $enableAutoStart;
	public $enableClosedCaptions;
	public $enableContentEncryption;
	public $enableDvr;
	public $enableEmbed;
	public $enableLowLatency;
	public $latencyPreference;
	public $mesh;
	public $projection;
	public $recordFromStart;
	public $startWithSlate;
	protected $monitorStreamType = 'Google_Service_YouTube_MonitorStreamInfo';
	protected $monitorStreamDataType = '';

	public function getBoundStreamId() {
		return $this->boundStreamId;
	}

	public function setBoundStreamId( $boundStreamId ) {
		$this->boundStreamId = $boundStreamId;
	}

	public function getBoundStreamLastUpdateTimeMs() {
		return $this->boundStreamLastUpdateTimeMs;
	}

	public function setBoundStreamLastUpdateTimeMs( $boundStreamLastUpdateTimeMs ) {
		$this->boundStreamLastUpdateTimeMs = $boundStreamLastUpdateTimeMs;
	}

	public function getClosedCaptionsType() {
		return $this->closedCaptionsType;
	}

	public function setClosedCaptionsType( $closedCaptionsType ) {
		$this->closedCaptionsType = $closedCaptionsType;
	}

	public function getEnableAutoStart() {
		return $this->enableAutoStart;
	}

	public function setEnableAutoStart( $enableAutoStart ) {
		$this->enableAutoStart = $enableAutoStart;
	}

	public function getEnableClosedCaptions() {
		return $this->enableClosedCaptions;
	}

	public function setEnableClosedCaptions( $enableClosedCaptions ) {
		$this->enableClosedCaptions = $enableClosedCaptions;
	}

	public function getEnableContentEncryption() {
		return $this->enableContentEncryption;
	}

	public function setEnableContentEncryption( $enableContentEncryption ) {
		$this->enableContentEncryption = $enableContentEncryption;
	}

	public function getEnableDvr() {
		return $this->enableDvr;
	}

	public function setEnableDvr( $enableDvr ) {
		$this->enableDvr = $enableDvr;
	}

	public function getEnableEmbed() {
		return $this->enableEmbed;
	}

	public function setEnableEmbed( $enableEmbed ) {
		$this->enableEmbed = $enableEmbed;
	}

	public function getEnableLowLatency() {
		return $this->enableLowLatency;
	}

	public function setEnableLowLatency( $enableLowLatency ) {
		$this->enableLowLatency = $enableLowLatency;
	}

	public function getLatencyPreference() {
		return $this->latencyPreference;
	}

	public function setLatencyPreference( $latencyPreference ) {
		$this->latencyPreference = $latencyPreference;
	}

	public function getMesh() {
		return $this->mesh;
	}

	public function setMesh( $mesh ) {
		$this->mesh = $mesh;
	}

	/**
	 * @param Google_Service_YouTube_MonitorStreamInfo
	 */
	public function setMonitorStream( Google_Service_YouTube_MonitorStreamInfo $monitorStream ) {
		$this->monitorStream = $monitorStream;
	}

	/**
	 * @return Google_Service_YouTube_MonitorStreamInfo
	 */
	public function getMonitorStream() {
		return $this->monitorStream;
	}

	public function getProjection() {
		return $this->projection;
	}

	public function setProjection( $projection ) {
		$this->projection = $projection;
	}

	public function getRecordFromStart() {
		return $this->recordFromStart;
	}

	public function setRecordFromStart( $recordFromStart ) {
		$this->recordFromStart = $recordFromStart;
	}

	public function getStartWithSlate() {
		return $this->startWithSlate;
	}

	public function setStartWithSlate( $startWithSlate ) {
		$this->startWithSlate = $startWithSlate;
	}
}
