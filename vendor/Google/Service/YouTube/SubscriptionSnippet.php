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

class Google_Service_YouTube_SubscriptionSnippet extends Google_Model {
	public $channelId;
	public $channelTitle;
	public $description;
	public $publishedAt;
	public $title;
	protected $resourceIdType = 'Google_Service_YouTube_ResourceId';
	protected $resourceIdDataType = '';
	protected $thumbnailsType = 'Google_Service_YouTube_ThumbnailDetails';
	protected $thumbnailsDataType = '';

	public function getChannelId() {
		return $this->channelId;
	}

	public function setChannelId( $channelId ) {
		$this->channelId = $channelId;
	}

	public function getChannelTitle() {
		return $this->channelTitle;
	}

	public function setChannelTitle( $channelTitle ) {
		$this->channelTitle = $channelTitle;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setDescription( $description ) {
		$this->description = $description;
	}

	public function getPublishedAt() {
		return $this->publishedAt;
	}

	public function setPublishedAt( $publishedAt ) {
		$this->publishedAt = $publishedAt;
	}

	/**
	 * @param Google_Service_YouTube_ResourceId
	 */
	public function setResourceId( Google_Service_YouTube_ResourceId $resourceId ) {
		$this->resourceId = $resourceId;
	}

	/**
	 * @return Google_Service_YouTube_ResourceId
	 */
	public function getResourceId() {
		return $this->resourceId;
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
