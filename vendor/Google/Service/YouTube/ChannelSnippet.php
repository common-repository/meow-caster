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

class Google_Service_YouTube_ChannelSnippet extends Google_Model {
	public $country;
	public $customUrl;
	public $defaultLanguage;
	public $description;
	public $publishedAt;
	public $title;
	protected $localizedType = 'Google_Service_YouTube_ChannelLocalization';
	protected $localizedDataType = '';
	protected $thumbnailsType = 'Google_Service_YouTube_ThumbnailDetails';
	protected $thumbnailsDataType = '';

	public function getCountry() {
		return $this->country;
	}

	public function setCountry( $country ) {
		$this->country = $country;
	}

	public function getCustomUrl() {
		return $this->customUrl;
	}

	public function setCustomUrl( $customUrl ) {
		$this->customUrl = $customUrl;
	}

	public function getDefaultLanguage() {
		return $this->defaultLanguage;
	}

	public function setDefaultLanguage( $defaultLanguage ) {
		$this->defaultLanguage = $defaultLanguage;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setDescription( $description ) {
		$this->description = $description;
	}

	/**
	 * @param Google_Service_YouTube_ChannelLocalization
	 */
	public function setLocalized( Google_Service_YouTube_ChannelLocalization $localized ) {
		$this->localized = $localized;
	}

	/**
	 * @return Google_Service_YouTube_ChannelLocalization
	 */
	public function getLocalized() {
		return $this->localized;
	}

	public function getPublishedAt() {
		return $this->publishedAt;
	}

	public function setPublishedAt( $publishedAt ) {
		$this->publishedAt = $publishedAt;
	}

	/**
	 * @param Google_Service_YouTube_ThumbnailDetails
	 */
	public function setThumbnails( Google_Service_YouTube_ThumbnailDetails $thumbnails ) {
		$this->thumbnails = $thumbnails;
	}

	/**
	 * @return Google_Service_YouTube_ThumbnailDetails
	 */
	public function getThumbnails() {
		return $this->thumbnails;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle( $title ) {
		$this->title = $title;
	}
}
