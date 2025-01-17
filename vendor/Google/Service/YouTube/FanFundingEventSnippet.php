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

class Google_Service_YouTube_FanFundingEventSnippet extends Google_Model {
	public $amountMicros;
	public $channelId;
	public $commentText;
	public $createdAt;
	public $currency;
	public $displayString;
	protected $supporterDetailsType = 'Google_Service_YouTube_ChannelProfileDetails';
	protected $supporterDetailsDataType = '';

	public function getAmountMicros() {
		return $this->amountMicros;
	}

	public function setAmountMicros( $amountMicros ) {
		$this->amountMicros = $amountMicros;
	}

	public function getChannelId() {
		return $this->channelId;
	}

	public function setChannelId( $channelId ) {
		$this->channelId = $channelId;
	}

	public function getCommentText() {
		return $this->commentText;
	}

	public function setCommentText( $commentText ) {
		$this->commentText = $commentText;
	}

	public function getCreatedAt() {
		return $this->createdAt;
	}

	public function setCreatedAt( $createdAt ) {
		$this->createdAt = $createdAt;
	}

	public function getCurrency() {
		return $this->currency;
	}

	public function setCurrency( $currency ) {
		$this->currency = $currency;
	}

	public function getDisplayString() {
		return $this->displayString;
	}

	public function setDisplayString( $displayString ) {
		$this->displayString = $displayString;
	}

	/**
	 * @param Google_Service_YouTube_ChannelProfileDetails
	 */
	public function setSupporterDetails( Google_Service_YouTube_ChannelProfileDetails $supporterDetails ) {
		$this->supporterDetails = $supporterDetails;
	}

	/**
	 * @return Google_Service_YouTube_ChannelProfileDetails
	 */
	public function getSupporterDetails() {
		return $this->supporterDetails;
	}
}
