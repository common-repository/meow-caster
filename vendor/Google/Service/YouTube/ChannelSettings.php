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

class Google_Service_YouTube_ChannelSettings extends Google_Collection {
	public $country;
	public $defaultLanguage;
	public $defaultTab;
	public $description;
	public $featuredChannelsTitle;
	public $featuredChannelsUrls;
	public $keywords;
	public $moderateComments;
	public $profileColor;
	public $showBrowseView;
	public $showRelatedChannels;
	public $title;
	public $trackingAnalyticsAccountId;
	public $unsubscribedTrailer;
	protected $collection_key = 'featuredChannelsUrls';

	public function getCountry() {
		return $this->country;
	}

	public function setCountry( $country ) {
		$this->country = $country;
	}

	public function getDefaultLanguage() {
		return $this->defaultLanguage;
	}

	public function setDefaultLanguage( $defaultLanguage ) {
		$this->defaultLanguage = $defaultLanguage;
	}

	public function getDefaultTab() {
		return $this->defaultTab;
	}

	public function setDefaultTab( $defaultTab ) {
		$this->defaultTab = $defaultTab;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setDescription( $description ) {
		$this->description = $description;
	}

	public function getFeaturedChannelsTitle() {
		return $this->featuredChannelsTitle;
	}

	public function setFeaturedChannelsTitle( $featuredChannelsTitle ) {
		$this->featuredChannelsTitle = $featuredChannelsTitle;
	}

	public function getFeaturedChannelsUrls() {
		return $this->featuredChannelsUrls;
	}

	public function setFeaturedChannelsUrls( $featuredChannelsUrls ) {
		$this->featuredChannelsUrls = $featuredChannelsUrls;
	}

	public function getKeywords() {
		return $this->keywords;
	}

	public function setKeywords( $keywords ) {
		$this->keywords = $keywords;
	}

	public function getModerateComments() {
		return $this->moderateComments;
	}

	public function setModerateComments( $moderateComments ) {
		$this->moderateComments = $moderateComments;
	}

	public function getProfileColor() {
		return $this->profileColor;
	}

	public function setProfileColor( $profileColor ) {
		$this->profileColor = $profileColor;
	}

	public function getShowBrowseView() {
		return $this->showBrowseView;
	}

	public function setShowBrowseView( $showBrowseView ) {
		$this->showBrowseView = $showBrowseView;
	}

	public function getShowRelatedChannels() {
		return $this->showRelatedChannels;
	}

	public function setShowRelatedChannels( $showRelatedChannels ) {
		$this->showRelatedChannels = $showRelatedChannels;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle( $title ) {
		$this->title = $title;
	}

	public function getTrackingAnalyticsAccountId() {
		return $this->trackingAnalyticsAccountId;
	}

	public function setTrackingAnalyticsAccountId( $trackingAnalyticsAccountId ) {
		$this->trackingAnalyticsAccountId = $trackingAnalyticsAccountId;
	}

	public function getUnsubscribedTrailer() {
		return $this->unsubscribedTrailer;
	}

	public function setUnsubscribedTrailer( $unsubscribedTrailer ) {
		$this->unsubscribedTrailer = $unsubscribedTrailer;
	}
}
