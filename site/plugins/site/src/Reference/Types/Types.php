<?php

namespace Kirby\Reference\Types;

use Kirby\Toolkit\A;
use phpDocumentor\Reflection\Type as DocumentorType;
use phpDocumentor\Reflection\Types\AggregatedType;
use ReflectionType;
use ReflectionUnionType;

class Types
{
	/**
	 * @param array<Type> $types
	 */
	public function __construct(
		public array $types
	) {
	}

	public function add(string $type): void
	{
		$this->types[] = Type::factory($type);
	}

	public static function factory(
		ReflectionType|DocumentorType|null $types = null
	): static {
		if ($types === null) {
			return new static([]);
		}

		if ($types instanceof ReflectionUnionType) {
			$types = $types->getTypes();

			// if (count(array_filter($types, fn ($type) => $type->allowsNull())) > 0) {
			// 	$types[] = 'null';
			// }
		}

		if ($types instanceof AggregatedType) {
			$types = iterator_to_array($types->getIterator());
		}

		$types = A::wrap($types);
		$types = A::map($types, fn ($type) => Type::factory($type));

		return new static($types);
	}

	public function has(string $type): bool
	{
		return strpos($this->toString(), $type) !== false;
	}

	public function toHtml(): string
	{
		$types = A::map($this->types, fn (Type $type) => $type->toHtml());
		$types = array_unique($types);
		return implode('<span class="px-1">|</span>', $types);
	}

	public function toString(): string
	{
		$types = A::map($this->types, fn (Type $type) => $type->toString());
		$types = array_unique($types);
		return implode('|', $types);
	}
}
