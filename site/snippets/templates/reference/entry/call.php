<?php
extract([
	'call'     => $call ?? $page->call(),
	'language' => 'php'
]);
?>

<?php if ($call->isNotEmpty()): ?>
<figure class="code">
	<pre><code class="language-<?= $language ?>"><?= $call ?></code></pre>
</figure>
<?php endif ?>

<?php snippet('templates/reference/entry/parameters') ?>
<?php snippet('templates/reference/entry/returns') ?>
<?php snippet('templates/reference/entry/throws') ?>
