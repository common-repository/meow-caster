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

/**
 * The "provisioning" collection of methods.
 * Typical usage is:
 *  <code>
 *   $analyticsService = new Google_Service_Analytics(...);
 *   $provisioning = $analyticsService->provisioning;
 *  </code>
 */
class Google_Service_Analytics_Resource_Provisioning extends Google_Service_Resource {
	/**
	 * Creates an account ticket. (provisioning.createAccountTicket)
	 *
	 * @param Google_Service_Analytics_AccountTicket $postBody
	 * @param array                                  $optParams Optional parameters.
	 *
	 * @return Google_Service_Analytics_AccountTicket
	 */
	public function createAccountTicket( Google_Service_Analytics_AccountTicket $postBody, $optParams = array() ) {
		$params = array( 'postBody' => $postBody );
		$params = array_merge( $params, $optParams );

		return $this->call( 'createAccountTicket', array( $params ), "Google_Service_Analytics_AccountTicket" );
	}

	/**
	 * Provision account. (provisioning.createAccountTree)
	 *
	 * @param Google_Service_Analytics_AccountTreeRequest $postBody
	 * @param array                                       $optParams Optional parameters.
	 *
	 * @return Google_Service_Analytics_AccountTreeResponse
	 */
	public function createAccountTree( Google_Service_Analytics_AccountTreeRequest $postBody, $optParams = array() ) {
		$params = array( 'postBody' => $postBody );
		$params = array_merge( $params, $optParams );

		return $this->call( 'createAccountTree', array( $params ), "Google_Service_Analytics_AccountTreeResponse" );
	}
}
