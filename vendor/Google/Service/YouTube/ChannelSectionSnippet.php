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

class Google_Service_YouTube_ChannelSectionSnippet extends Google_Model {
	public $channelId;
	public $defaultLanguage;
	public $position;
	public $style;
	public $title;
	public $type;
	protected $localizedType = 'Google_Service_YouTube_ChannelSectionLocalization';
	protected $localizedDataType = '';

	public function getChannelId() {
		return $this->channelId;
	}

	public function setChannelId( $channelId ) {
		$this->channelId = $channelId;
	}

	public function getDefaultLanguage() {
		return $this->defaultLanguage;
	}

	public function setDefaultLanguage( $defaultLanguage ) {
		$this->defaultLanguage = $defaultLanguage;
	}

	/**
	 * @param Google_Service_YouTube_ChannelSectionLocalization
	 */
	public function setLocalized( Google_Service_YouTube_ChannelSectionLocalization $localized ) {
		$this->localized = $localized;
	}

	/**
	 * @return Google_Service_YouTube_ChannelSectionLocalization
	 */
	public function getLocalized() {
		return $this->localized;
	}

	public function getPosition() {
		return $this->position;
	}

	public function setPosition( $position ) {
		$this->position = $position;
	}

	public function getStyle() {
		return $this->style;
	}

	public function setStyle( $style ) {
		$this->style = $style;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle( $title ) {
		$this->title = $title;
	}

	public function getType() {
		return $this->type;
	}

	public function setType( $type ) {
		$this->type = $type;
	}
}
