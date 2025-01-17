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

class Google_Service_YouTube_ChannelAuditDetails extends Google_Model {
	public $communityGuidelinesGoodStanding;
	public $contentIdClaimsGoodStanding;
	public $copyrightStrikesGoodStanding;
	public $overallGoodStanding;

	public function getCommunityGuidelinesGoodStanding() {
		return $this->communityGuidelinesGoodStanding;
	}

	public function setCommunityGuidelinesGoodStanding( $communityGuidelinesGoodStanding ) {
		$this->communityGuidelinesGoodStanding = $communityGuidelinesGoodStanding;
	}

	public function getContentIdClaimsGoodStanding() {
		return $this->contentIdClaimsGoodStanding;
	}

	public function setContentIdClaimsGoodStanding( $contentIdClaimsGoodStanding ) {
		$this->contentIdClaimsGoodStanding = $contentIdClaimsGoodStanding;
	}

	public function getCopyrightStrikesGoodStanding() {
		return $this->copyrightStrikesGoodStanding;
	}

	public function setCopyrightStrikesGoodStanding( $copyrightStrikesGoodStanding ) {
		$this->copyrightStrikesGoodStanding = $copyrightStrikesGoodStanding;
	}

	public function getOverallGoodStanding() {
		return $this->overallGoodStanding;
	}

	public function setOverallGoodStanding( $overallGoodStanding ) {
		$this->overallGoodStanding = $overallGoodStanding;
	}
}
