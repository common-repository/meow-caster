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

class Google_Service_YouTube_VideoTopicDetails extends Google_Collection {
	public $relevantTopicIds;
	public $topicCategories;
	public $topicIds;
	protected $collection_key = 'topicIds';

	public function getRelevantTopicIds() {
		return $this->relevantTopicIds;
	}

	public function setRelevantTopicIds( $relevantTopicIds ) {
		$this->relevantTopicIds = $relevantTopicIds;
	}

	public function getTopicCategories() {
		return $this->topicCategories;
	}

	public function setTopicCategories( $topicCategories ) {
		$this->topicCategories = $topicCategories;
	}

	public function getTopicIds() {
		return $this->topicIds;
	}

	public function setTopicIds( $topicIds ) {
		$this->topicIds = $topicIds;
	}
}
