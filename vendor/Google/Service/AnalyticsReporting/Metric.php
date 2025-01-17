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

class Google_Service_AnalyticsReporting_Metric extends Google_Model {
	public $alias;
	public $expression;
	public $formattingType;

	public function getAlias() {
		return $this->alias;
	}

	public function setAlias( $alias ) {
		$this->alias = $alias;
	}

	public function getExpression() {
		return $this->expression;
	}

	public function setExpression( $expression ) {
		$this->expression = $expression;
	}

	public function getFormattingType() {
		return $this->formattingType;
	}

	public function setFormattingType( $formattingType ) {
		$this->formattingType = $formattingType;
	}
}
