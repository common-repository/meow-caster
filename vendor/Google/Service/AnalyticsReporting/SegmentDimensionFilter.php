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

class Google_Service_AnalyticsReporting_SegmentDimensionFilter extends Google_Collection {
	public $caseSensitive;
	public $dimensionName;
	public $expressions;
	public $maxComparisonValue;
	public $minComparisonValue;
	public $operator;
	protected $collection_key = 'expressions';

	public function getCaseSensitive() {
		return $this->caseSensitive;
	}

	public function setCaseSensitive( $caseSensitive ) {
		$this->caseSensitive = $caseSensitive;
	}

	public function getDimensionName() {
		return $this->dimensionName;
	}

	public function setDimensionName( $dimensionName ) {
		$this->dimensionName = $dimensionName;
	}

	public function getExpressions() {
		return $this->expressions;
	}

	public function setExpressions( $expressions ) {
		$this->expressions = $expressions;
	}

	public function getMaxComparisonValue() {
		return $this->maxComparisonValue;
	}

	public function setMaxComparisonValue( $maxComparisonValue ) {
		$this->maxComparisonValue = $maxComparisonValue;
	}

	public function getMinComparisonValue() {
		return $this->minComparisonValue;
	}

	public function setMinComparisonValue( $minComparisonValue ) {
		$this->minComparisonValue = $minComparisonValue;
	}

	public function getOperator() {
		return $this->operator;
	}

	public function setOperator( $operator ) {
		$this->operator = $operator;
	}
}
