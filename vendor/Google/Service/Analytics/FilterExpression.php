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

class Google_Service_Analytics_FilterExpression extends Google_Model {
	public $caseSensitive;
	public $expressionValue;
	public $field;
	public $fieldIndex;
	public $kind;
	public $matchType;

	public function getCaseSensitive() {
		return $this->caseSensitive;
	}

	public function setCaseSensitive( $caseSensitive ) {
		$this->caseSensitive = $caseSensitive;
	}

	public function getExpressionValue() {
		return $this->expressionValue;
	}

	public function setExpressionValue( $expressionValue ) {
		$this->expressionValue = $expressionValue;
	}

	public function getField() {
		return $this->field;
	}

	public function setField( $field ) {
		$this->field = $field;
	}

	public function getFieldIndex() {
		return $this->fieldIndex;
	}

	public function setFieldIndex( $fieldIndex ) {
		$this->fieldIndex = $fieldIndex;
	}

	public function getKind() {
		return $this->kind;
	}

	public function setKind( $kind ) {
		$this->kind = $kind;
	}

	public function getMatchType() {
		return $this->matchType;
	}

	public function setMatchType( $matchType ) {
		$this->matchType = $matchType;
	}
}
