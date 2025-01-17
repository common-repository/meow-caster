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

class Google_Service_Analytics_FilterAdvancedDetails extends Google_Model {
	public $caseSensitive;
	public $extractA;
	public $extractB;
	public $fieldA;
	public $fieldAIndex;
	public $fieldARequired;
	public $fieldB;
	public $fieldBIndex;
	public $fieldBRequired;
	public $outputConstructor;
	public $outputToField;
	public $outputToFieldIndex;
	public $overrideOutputField;

	public function getCaseSensitive() {
		return $this->caseSensitive;
	}

	public function setCaseSensitive( $caseSensitive ) {
		$this->caseSensitive = $caseSensitive;
	}

	public function getExtractA() {
		return $this->extractA;
	}

	public function setExtractA( $extractA ) {
		$this->extractA = $extractA;
	}

	public function getExtractB() {
		return $this->extractB;
	}

	public function setExtractB( $extractB ) {
		$this->extractB = $extractB;
	}

	public function getFieldA() {
		return $this->fieldA;
	}

	public function setFieldA( $fieldA ) {
		$this->fieldA = $fieldA;
	}

	public function getFieldAIndex() {
		return $this->fieldAIndex;
	}

	public function setFieldAIndex( $fieldAIndex ) {
		$this->fieldAIndex = $fieldAIndex;
	}

	public function getFieldARequired() {
		return $this->fieldARequired;
	}

	public function setFieldARequired( $fieldARequired ) {
		$this->fieldARequired = $fieldARequired;
	}

	public function getFieldB() {
		return $this->fieldB;
	}

	public function setFieldB( $fieldB ) {
		$this->fieldB = $fieldB;
	}

	public function getFieldBIndex() {
		return $this->fieldBIndex;
	}

	public function setFieldBIndex( $fieldBIndex ) {
		$this->fieldBIndex = $fieldBIndex;
	}

	public function getFieldBRequired() {
		return $this->fieldBRequired;
	}

	public function setFieldBRequired( $fieldBRequired ) {
		$this->fieldBRequired = $fieldBRequired;
	}

	public function getOutputConstructor() {
		return $this->outputConstructor;
	}

	public function setOutputConstructor( $outputConstructor ) {
		$this->outputConstructor = $outputConstructor;
	}

	public function getOutputToField() {
		return $this->outputToField;
	}

	public function setOutputToField( $outputToField ) {
		$this->outputToField = $outputToField;
	}

	public function getOutputToFieldIndex() {
		return $this->outputToFieldIndex;
	}

	public function setOutputToFieldIndex( $outputToFieldIndex ) {
		$this->outputToFieldIndex = $outputToFieldIndex;
	}

	public function getOverrideOutputField() {
		return $this->overrideOutputField;
	}

	public function setOverrideOutputField( $overrideOutputField ) {
		$this->overrideOutputField = $overrideOutputField;
	}
}
