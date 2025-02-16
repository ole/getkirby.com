<?php

namespace Kirby\Reference;

use DefaultPage;
use Kirby\Cms\App;
use Kirby\Content\Field;
use Kirby\Template\Template;
use ReflectionClass;
use ReflectionFunctionAbstract;

abstract class ReferencePage extends DefaultPage
{
	public function intro(): Field
	{
		// prefer intro defined in content file
		if ($this->content()->has('intro')) {
			return $this->content()->get('intro');
		}

		// otherwise try to get summary from DocBlock in code
		if (method_exists($this, 'reflection')) {
			$intro = $this->reflection()->summary();

		}

		return new Field($this, 'intro', $intro ?? null);
	}

	public function metadata(): array
	{
		return [
			'description' => strip_tags($this->intro()->kirbytags()),
			'thumbnail' => [
				'lead'  => $this->metaLead(page('docs/reference'), 'Reference')
			]
		];
	}

	public function name(): string
	{
		return preg_replace_callback(
			'!-([a-z])!',
			fn ($matches) => strtoupper($matches[1]),
			$this->slug()
		);
	}

	/**
	 * If a dedicated template exist, use it.
	 * Otherwise fall back to `reference-article` template.
	 */
	public function template(): Template
	{
		// If template exists, use it
		if ($this->intendedTemplate() === parent::template()) {
			return parent::template();
		}

		return $this->kirby()->template('reference-article');
	}
}
