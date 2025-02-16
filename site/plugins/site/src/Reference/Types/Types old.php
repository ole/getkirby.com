<?php

namespace Kirby\Reference;

use Kirby\Toolkit\A;

class TypesOld
{
	public static function default(string $value = null): string
	{
		return match ($value) {
			null    => '<span>–</span>',
			default => static::format($value)
		};
	}

	public static function factory(string $string, $model): string
	{
		$types = A::map(
			explode('|', $string),
			fn ($type) => match ($type) {
				'static',
				'$this'
					=> $model->parent()->class(),
				'self'
					=> $model->inheritedFrom() ?? $model->parent()->class(),
				default
				=> substr($type, 0, 1) === '\\' ? substr($type, 1) : $type
			}
		);

		return implode('|', array_unique($types));
	}


	/**
	 * Extracts variable and type from parameter definition
	 */
	public static function parameter(string $parameter): array
	{
		$argument = explode('=', $parameter);
		$argument = explode(' ', trim($argument[0]));

		return [
			'variable' => $argument[count($argument) - 1],
			'type'     => static::format($argument[count($argument) - 2] ?? '-')
		];
	}

	/**
	 * Returns required asteriks markup if required flag is true
	 */
	public static function required(bool $required): string|null
	{
		return match ($required) {
			true    => '<span class="required-mark">*</span>',
			default => null
		};
	}
}
