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

class Google_Service_YouTube_ActivityContentDetailsPromotedItem extends Google_Collection {
	public $adTag;
	public $clickTrackingUrl;
	public $creativeViewUrl;
	public $ctaType;
	public $customCtaButtonText;
	public $descriptionText;
	public $destinationUrl;
	public $forecastingUrl;
	public $impressionUrl;
	public $videoId;
	protected $collection_key = 'impressionUrl';

	public function getAdTag() {
		return $this->adTag;
	}

	public function setAdTag( $adTag ) {
		$this->adTag = $adTag;
	}

	public function getClickTrackingUrl() {
		return $this->clickTrackingUrl;
	}

	public function setClickTrackingUrl( $clickTrackingUrl ) {
		$this->clickTrackingUrl = $clickTrackingUrl;
	}

	public function getCreativeViewUrl() {
		return $this->creativeViewUrl;
	}

	public function setCreativeViewUrl( $creativeViewUrl ) {
		$this->creativeViewUrl = $creativeViewUrl;
	}

	public function getCtaType() {
		return $this->ctaType;
	}

	public function setCtaType( $ctaType ) {
		$this->ctaType = $ctaType;
	}

	public function getCustomCtaButtonText() {
		return $this->customCtaButtonText;
	}

	public function setCustomCtaButtonText( $customCtaButtonText ) {
		$this->customCtaButtonText = $customCtaButtonText;
	}

	public function getDescriptionText() {
		return $this->descriptionText;
	}

	public function setDescriptionText( $descriptionText ) {
		$this->descriptionText = $descriptionText;
	}

	public function getDestinationUrl() {
		return $this->destinationUrl;
	}

	public function setDestinationUrl( $destinationUrl ) {
		$this->destinationUrl = $destinationUrl;
	}

	public function getForecastingUrl() {
		return $this->forecastingUrl;
	}

	public function setForecastingUrl( $forecastingUrl ) {
		$this->forecastingUrl = $forecastingUrl;
	}

	public function getImpressionUrl() {
		return $this->impressionUrl;
	}

	public function setImpressionUrl( $impressionUrl ) {
		$this->impressionUrl = $impressionUrl;
	}

	public function getVideoId() {
		return $this->videoId;
	}

	public function setVideoId( $videoId ) {
		$this->videoId = $videoId;
	}
}
