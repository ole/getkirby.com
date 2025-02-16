<?php

namespace Kirby\Reference\Reflectable\Tags;

use Kirby\Reference\Types\Types;
use phpDocumentor\Reflection\DocBlock\Tags\Param;
use phpDocumentor\Reflection\Types\Mixed_;
use ReflectionParameter;

class Parameter
{
	public function __construct(
		public string $name,
		public Types $types,
		public string|null $default = null,
		public string|null $description = null,
		public bool $isRequired = false,
		public bool $isVariadic = false
	) {
	}

	public static function factory(
		ReflectionParameter $parameter,
		Param|null $doc = null
	): static
	{
		$name    = $parameter->getName();
		$types   = $parameter->getType();
		$types ??= $doc?->getType();
		$types   = Types::factory($types);

		if ($parameter->isOptional() === true) {
			if ($parameter->isDefaultValueAvailable()) {
				$default = $parameter->getDefaultValue();
				$default = var_export($default, true);
				$default = str_replace('NULL', 'null', $default);
				$default = str_replace('array (' . PHP_EOL . ')', '[ ]', $default);
			}

			$default ??= 'null';
		}

		return new static(
			name:        $name,
			types:       $types,
			default:     $default ?? null,
			description: $doc?->getDescription()?->getBodyTemplate(),
			isRequired:  $parameter->isOptional() === false,
			isVariadic:  $parameter->isVariadic()
		);
	}

	public function hasDescription(): bool
	{
		return $this->description !== null;
	}

	public function name(): string
	{
		return '$' . $this->name;
	}

	public function toString(): string
	{
		$string = $this->name();

		if ($this->isVariadic === true) {
			$string = '...' . $string;
		}

		$string = trim($this->types->toString() . ' ' . $string);

		if ($this->default !== null) {
			$string .= ' = ' . $this->default;
		}

		return $string;
	}
}
