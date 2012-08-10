<!doctype html>
<html>
<head>
	<?php echo $this->html->charset(); ?>
	<title>Unhandled exception</title>
	<?php echo $this->html->style(array('debug', 'lithium')); ?>
	<?php echo $this->scripts(); ?>
	<?php echo $this->html->link('Icon', null, array('type' => 'icon')); ?>
</head>
<body class="app">
<?php 
if (\lithium\core\Environment::is('production')) { ?>	
		<div style="width:100%;text-align: center;margin-top:42px"><h1>Error 404 :(</h1></div>
		<img src="http://www.ilovemeow.com/img/cats.jpg" alt="image_cat" height="336" width="500" style="position: relative; left: 50%; top: 10px; margin-left: -250px; ">
<?php } else { ?>
	<div id="container">
		<div id="header">
			<h1>An unhandled exception was thrown</h1>
		</div>
		<div id="content">
			<?php echo $this->content(); ?>
		</div>
	</div>
	<?php } ?>
	
</body>
</html>