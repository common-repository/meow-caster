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

class Google_Service_Analytics_McfDataRows extends Google_Collection {
	public $primitiveValue;
	protected $collection_key = 'conversionPathValue';
	protected $conversionPathValueType = 'Google_Service_Analytics_McfDataRowsConversionPathValue';
	protected $conversionPathValueDataType = 'array';

	/**
	 * @param Google_Service_Analytics_McfDataRowsConversionPathValue
	 */
	public function setConversionPathValue( $conversionPathValue ) {
		$this->conversionPathValue = $conversionPathValue;
	}

	/**
	 * @return Google_Service_Analytics_McfDataRowsConversionPathValue
	 */
	public function getConversionPathValue() {
		return $this->conversionPathValue;
	}

	public function getPrimitiveValue() {
		return $this->primitiveValue;
	}

	public function setPrimitiveValue( $primitiveValue ) {
		$this->primitiveValue = $primitiveValue;
	}
}
