<?php

use Kirby\Reference\ReferencePage;
use Kirby\Reference\Reflectable\ReflectableCoreComponent;

class ReferenceComponentPage extends ReferencePage
{
	public function metadata(): array
	{
		return array_replace_recursive(parent::metadata(), [
			'thumbnail' => [
				'lead'  => 'Reference / Core component'
			]
		]);
	}

	public function name(): string
	{
		return $this->content()->get('name')->or($this->slug());
	}

	protected function reflection(): ReflectableCoreComponent
	{
		return new ReflectableCoreComponent(name: $this->name());
	}
}
