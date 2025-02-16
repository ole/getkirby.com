<?php

namespace Kirby\Reference\Reflectable\Tags;

use Kirby\Reference\Reflectable\Reflectable;
use Kirby\Toolkit\A;

class Throws
{
	/**
	 * @param array<Exception> $throws
	 */
	public function __construct(
		protected array $throws
	) {
	}

	public static function factory(Reflectable $reflection): static|null
	{
		$throws = $reflection->doc->getTagsByName('throws');
		$throws = A::map($throws, fn ($tag) => Exception::factory($tag));
		return new static($throws);
	}
}
