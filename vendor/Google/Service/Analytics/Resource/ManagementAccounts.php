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
 * The "accounts" collection of methods.
 * Typical usage is:
 *  <code>
 *   $analyticsService = new Google_Service_Analytics(...);
 *   $accounts = $analyticsService->accounts;
 *  </code>
 */
class Google_Service_Analytics_Resource_ManagementAccounts extends Google_Service_Resource {
	/**
	 * Lists all accounts to which the user has access.
	 * (accounts.listManagementAccounts)
	 *
	 * @param array $optParams Optional parameters.
	 *
	 * @opt_param int max-results The maximum number of accounts to include in this
	 * response.
	 * @opt_param int start-index An index of the first account to retrieve. Use
	 * this parameter as a pagination mechanism along with the max-results
	 * parameter.
	 * @return Google_Service_Analytics_Accounts
	 */
	public function listManagementAccounts( $optParams = array() ) {
		$params = array();
		$params = array_merge( $params, $optParams );

		return $this->call( 'list', array( $params ), "Google_Service_Analytics_Accounts" );
	}
}
