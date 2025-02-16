<?php

namespace Kirby\Reference\Reflectable;

use Exception;
use Kirby\Toolkit\V;

class ReflectableHelperFunction extends ReflectableFunction
{
	public function __construct(
		public string $name
	) {
		$validator = V::$validators[$name] ?? null;

		if ($validator === null) {
			throw new Exception('Validator "' . $name . '" not found');
		}

		parent::__construct($validator);
	}

	public function call(): string
	{
		return 'V::' . parent::call();
	}

	protected function sourcePath(): string
	{
		return 'config/helpers.php';
	}
}
