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

class Google_Service_YouTube_LiveChatPollOpenedDetails extends Google_Collection {
	public $id;
	public $prompt;
	protected $collection_key = 'items';
	protected $itemsType = 'Google_Service_YouTube_LiveChatPollItem';
	protected $itemsDataType = 'array';

	public function getId() {
		return $this->id;
	}

	public function setId( $id ) {
		$this->id = $id;
	}

	/**
	 * @param Google_Service_YouTube_LiveChatPollItem
	 */
	public function setItems( $items ) {
		$this->items = $items;
	}

	/**
	 * @return Google_Service_YouTube_LiveChatPollItem
	 */
	public function getItems() {
		return $this->items;
	}

	public function getPrompt() {
		return $this->prompt;
	}

	public function setPrompt( $prompt ) {
		$this->prompt = $prompt;
	}
}
