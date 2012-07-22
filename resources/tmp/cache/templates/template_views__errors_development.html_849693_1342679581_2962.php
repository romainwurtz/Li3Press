<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

use lithium\analysis\Debugger;
use lithium\analysis\Inspector;

$exception = $info['exception'];
$replace = array('&lt;?php', '?&gt;', '<code>', '</code>', "\n");
$context = 5;

/**
 * Set Lithium-esque colors for syntax highlighing.
 */
ini_set('highlight.string', '#4DDB4A');
ini_set('highlight.comment', '#D42AAE');
ini_set('highlight.keyword', '#D42AAE');
ini_set('highlight.default', '#3C96FF');
ini_set('highlight.htm', '#FFFFFF');

$stack = Debugger::trace(array('format' => 'array', 'trace' => $exception->getTrace()));

array_unshift($stack, array(
	'functionRef' => '[exception]',
	'file' => $exception->getFile(),
	'line' => $exception->getLine()
));

?>
<h3>Exception</h3>

<div class="lithium-exception-class">
	<?php echo $h(get_class($exception)); ?>

	<?php if ($code = $exception->getCode()): ?>
		<span class="code">(code <?php echo $h($code); ?>)</span>
	<?php endif ?>
</div>

<div class="lithium-exception-message"><?php echo $h($exception->getMessage()); ?></div>

<h3 id="source">Source</h3>

<div id="sourceCode"></div>

<h3>Stack Trace</h3>

<div class="lithium-stack-trace">
	<ol>
		<?php foreach ($stack as $id => $frame): ?>
			<?php
				$location = "{$frame['file']}: {$frame['line']}";
				$lines = range($frame['line'] - $context, $frame['line'] + $context);
				$code = Inspector::lines($frame['file'], $lines);
			?>
			<li>
				<tt><a href="#source" id="<?php echo $h($id); ?>" class="display-source-excerpt">
					<?php echo $h($frame['functionRef']); ?>
				</a></tt>
				<div id="sourceCode<?php echo $h($id); ?>" style="display: none;">

					<div class="lithium-exception-location">
						<?php echo $h($location); ?>
					</div>

					<div class="lithium-code-dump">
						<pre><code><?php
							foreach ($code as $num => $content):
								$numPad = str_pad($num, 3, ' ');
								$content = str_ireplace(array('<?php', '?>'), '', $content);
								$content = highlight_string("<?php {$numPad}{$content} ?>", true);
								$content = str_replace($replace, '', $content);

								if ($frame['line'] === $num):
									?><span class="code-highlight"><?php
								endif;?><?php echo "{$content}\n"; ?><?php
								if ($frame['line'] === $num):
									?></span><?php
								endif;

							endforeach;
						?></code></pre>
					</div>
				</div>
			</li>
		<?php endforeach; ?>
	</ol>
</div>

<script type="text/javascript">
	window.onload = function() {
		var $ = function() { return document.getElementById.apply(document, arguments); };
		var links = document.getElementsByTagName('a');

		for (i = 0; i < links.length; i++) {
			if (links[i].className.indexOf('display-source-excerpt') >= 0) {
				links[i].onclick = function() {
					$('sourceCode').innerHTML = $('sourceCode' + this.id).innerHTML;
				}
			}
		}
		$('sourceCode').innerHTML = $('sourceCode0').innerHTML;
	}
</script>