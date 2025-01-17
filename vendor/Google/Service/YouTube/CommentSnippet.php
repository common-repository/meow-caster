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

class Google_Service_YouTube_CommentSnippet extends Google_Model {
	public $authorChannelId;
	public $authorChannelUrl;
	public $authorDisplayName;
	public $authorProfileImageUrl;
	public $canRate;
	public $channelId;
	public $likeCount;
	public $moderationStatus;
	public $parentId;
	public $publishedAt;
	public $textDisplay;
	public $textOriginal;
	public $updatedAt;
	public $videoId;
	public $viewerRating;

	public function getAuthorChannelId() {
		return $this->authorChannelId;
	}

	public function setAuthorChannelId( $authorChannelId ) {
		$this->authorChannelId = $authorChannelId;
	}

	public function getAuthorChannelUrl() {
		return $this->authorChannelUrl;
	}

	public function setAuthorChannelUrl( $authorChannelUrl ) {
		$this->authorChannelUrl = $authorChannelUrl;
	}

	public function getAuthorDisplayName() {
		return $this->authorDisplayName;
	}

	public function setAuthorDisplayName( $authorDisplayName ) {
		$this->authorDisplayName = $authorDisplayName;
	}

	public function getAuthorProfileImageUrl() {
		return $this->authorProfileImageUrl;
	}

	public function setAuthorProfileImageUrl( $authorProfileImageUrl ) {
		$this->authorProfileImageUrl = $authorProfileImageUrl;
	}

	public function getCanRate() {
		return $this->canRate;
	}

	public function setCanRate( $canRate ) {
		$this->canRate = $canRate;
	}

	public function getChannelId() {
		return $this->channelId;
	}

	public function setChannelId( $channelId ) {
		$this->channelId = $channelId;
	}

	public function getLikeCount() {
		return $this->likeCount;
	}

	public function setLikeCount( $likeCount ) {
		$this->likeCount = $likeCount;
	}

	public function getModerationStatus() {
		return $this->moderationStatus;
	}

	public function setModerationStatus( $moderationStatus ) {
		$this->moderationStatus = $moderationStatus;
	}

	public function getParentId() {
		return $this->parentId;
	}

	public function setParentId( $parentId ) {
		$this->parentId = $parentId;
	}

	public function getPublishedAt() {
		return $this->publishedAt;
	}

	public function setPublishedAt( $publishedAt ) {
		$this->publishedAt = $publishedAt;
	}

	public function getTextDisplay() {
		return $this->textDisplay;
	}

	public function setTextDisplay( $textDisplay ) {
		$this->textDisplay = $textDisplay;
	}

	public function getTextOriginal() {
		return $this->textOriginal;
	}

	public function setTextOriginal( $textOriginal ) {
		$this->textOriginal = $textOriginal;
	}

	public function getUpdatedAt() {
		return $this->updatedAt;
	}

	public function setUpdatedAt( $updatedAt ) {
		$this->updatedAt = $updatedAt;
	}

	public function getVideoId() {
		return $this->videoId;
	}

	public function setVideoId( $videoId ) {
		$this->videoId = $videoId;
	}

	public function getViewerRating() {
		return $this->viewerRating;
	}

	public function setViewerRating( $viewerRating ) {
		$this->viewerRating = $viewerRating;
	}
}
