<?php

use Kirby\Content\Field;
use Kirby\Reference\ReferencePage;
use Kirby\Reference\Reflectable\ReflectableFieldMethod;
use Kirby\Reference\Reflectable\Tags\Returns;
use Kirby\Toolkit\Str;

class ReferenceFieldMethodPage extends ReferencePage
{
	public function aliases(): array
	{
		return $this->reflection()->aliases();
	}

	public function call(): Field
	{
		return parent::call()->value($this->reflection()->call());
	}

	public static function findByName(
		string $name
	): ReferenceFieldMethodPage|null {
		$methods = page('docs/reference/templates/field-methods');
		return $methods->find(Str::kebab($name));
	}

	public function metadata(): array
	{
		return array_replace_recursive(parent::metadata(), [
			'thumbnail' => [
				'lead'  => 'Reference / Field method'
			]
		]);
	}

	protected function reflection(): ReflectableFieldMethod
	{
		return new ReflectableFieldMethod(name: $this->name());
	}

	public function returns(): Returns|null
	{
		return $this->reflection()->returns();
	}

	public function title(): Field
	{
		return parent::title()->value($this->reflection()->name() . '()');
	}
}
