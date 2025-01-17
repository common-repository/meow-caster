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

class Google_Service_YouTube_CommentThreadSnippet extends Google_Model {
	public $canReply;
	public $channelId;
	public $isPublic;
	public $totalReplyCount;
	public $videoId;
	protected $topLevelCommentType = 'Google_Service_YouTube_Comment';
	protected $topLevelCommentDataType = '';

	public function getCanReply() {
		return $this->canReply;
	}

	public function setCanReply( $canReply ) {
		$this->canReply = $canReply;
	}

	public function getChannelId() {
		return $this->channelId;
	}

	public function setChannelId( $channelId ) {
		$this->channelId = $channelId;
	}

	public function getIsPublic() {
		return $this->isPublic;
	}

	public function setIsPublic( $isPublic ) {
		$this->isPublic = $isPublic;
	}

	/**
	 * @param Google_Service_YouTube_Comment
	 */
	public function setTopLevelComment( Google_Service_YouTube_Comment $topLevelComment ) {
		$this->topLevelComment = $topLevelComment;
	}

	/**
	 * @return Google_Service_YouTube_Comment
	 */
	public function getTopLevelComment() {
		return $this->topLevelComment;
	}

	public function getTotalReplyCount() {
		return $this->totalReplyCount;
	}

	public function setTotalReplyCount( $totalReplyCount ) {
		$this->totalReplyCount = $totalReplyCount;
	}

	public function getVideoId() {
		return $this->videoId;
	}

	public function setVideoId( $videoId ) {
		$this->videoId = $videoId;
	}
}
