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

class Google_Service_YouTube_VideoAbuseReport extends Google_Model {
	public $comments;
	public $language;
	public $reasonId;
	public $secondaryReasonId;
	public $videoId;

	public function getComments() {
		return $this->comments;
	}

	public function setComments( $comments ) {
		$this->comments = $comments;
	}

	public function getLanguage() {
		return $this->language;
	}

	public function setLanguage( $language ) {
		$this->language = $language;
	}

	public function getReasonId() {
		return $this->reasonId;
	}

	public function setReasonId( $reasonId ) {
		$this->reasonId = $reasonId;
	}

	public function getSecondaryReasonId() {
		return $this->secondaryReasonId;
	}

	public function setSecondaryReasonId( $secondaryReasonId ) {
		$this->secondaryReasonId = $secondaryReasonId;
	}

	public function getVideoId() {
		return $this->videoId;
	}

	public function setVideoId( $videoId ) {
		$this->videoId = $videoId;
	}
}
