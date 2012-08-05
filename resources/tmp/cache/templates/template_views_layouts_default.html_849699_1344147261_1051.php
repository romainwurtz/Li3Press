<?php ?>
<!doctype html>
<html>
<head>
	<?php echo $this -> html -> charset(); ?>
	<title>Application &gt; <?php echo $this -> title(); ?></title>
	<?php echo $this -> html -> style(array('bootstrap.min','debug', 'lithium')); ?>
	<?php echo $this -> scripts(); ?>
	<?php echo $this -> html -> link('Icon', null, array('type' => 'icon')); ?>
	<?php echo $this -> html -> script(array('jquery-1.7.2.min', 'jquery.ajaxQueue', 'bootstrap.min', 'jquery.backstretch.min', 'nicEdit')); ?>
	<script type="text/javascript">
	$(document).ready(function() {
	  $.backstretch("http://content.wallpapers-room.com/resolutions/1280x800/I/Wallpapers-room_com___It_s_Wood_by_niklasK_1280x800.jpg", {speed: 150});
});

	</script>
</head>
<body class="app row">
	<div id="container" class="span9 offset1">
		<div class="row">
			<div id="header" class="span9">
				<h1><a href="/" >Li3<br />Press</a></h1>
			</div>
			<span class="span9 dotted"></span>
			<div id="content" class="span9">
				<?php echo $this -> content(); ?>
			</div>
		</div>
	</div>
</body>
</html>