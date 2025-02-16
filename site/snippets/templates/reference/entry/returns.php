<?php if ($page->returns()?->isVoid() === false): ?>
	<h2 id="returns"><a href="#returns">Return type</a></h2>
	<p><?= $page->returns()->toHtml() ?></p>

	<?php if ($page->reflection()->isStatic() === false): ?>
		<?php if ($page->reflection()->isImmutable()): ?>
		<p>This method does not modify the existing <code>$<?= strtolower($page->class(true)) ?></code> object but returns a new object with the changes applied. <a href="/docs/guide/templates/php-api#immutable-objects">Learn more &rarr;</a></p>
		<?php elseif ($page->reflection()->isMutable()): ?>
		<p>This method modifies the existing <code>$<?= strtolower($page->class(true)) ?></code> object it is applied to and returns it again.</p>
		<?php endif ?>
	<?php endif ?>
<?php endif ?>
