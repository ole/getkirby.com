<?php

use Kirby\Reference\ReferencePage;
use Kirby\Reference\Reflection\ReflectableValidator;

class ReferenceValidatorPage extends ReferencePage
{
	public function metadata(): array
	{
		return array_replace_recursive(parent::metadata(), [
			'thumbnail' => [
				'lead'  => 'Reference / Validator'
			]
		]);
	}

	protected function reflection(): ReflectableValidator
	{
		return new ReflectableValidator(name: $this->name());
	}
}
