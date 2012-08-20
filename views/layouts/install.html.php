<?php
/**
 * Li3Press: A simple blog using Lithium framework
 *
 * @author          Romain Wurtz (http://www.t3kila.com)
 * @copyright     Copyright 2012, Romain Wurtz (http://www.t3kila.com)
 * 
 */

$title = BLOG_TITLE;
if (isset($post)) {
	$title .= " | ".$post->title;
}
?>
<!doctype html>
<html>
<head>
	<?php echo $this -> html -> charset(); ?>
	<title><?php echo $title ?></title>
	<?php echo $this -> html -> style(array('bootstrap.min','debug', 'li3Press')); ?>
	<?php echo $this -> html -> link('Icon', null, array('type' => 'icon')); ?>
	<?php echo $this -> html -> script(array('jquery-1.7.2.min', 'jquery.ajaxQueue', 'bootstrap.min', 'jquery.backstretch.min', 'nicEdit', 'li3Press')); ?>
	<script type="text/javascript">
	$(document).ready(function() {
	  $.backstretch("<?php echo BLOG_BG; ?>", {speed: 150});
});

	</script>
</head>
<body class="app row">
	<div id="container" class="span9 offset1">
		<div class="row">
			<div id="header" class="span9">
				<h1>INSTALL</h1>
			</div>
			<span class="span9 dotted"></span>
			<div id="content" class="span9">
				<?php echo $this -> content(); ?>
			</div>
		</div>
	</div>
</body>
</html>