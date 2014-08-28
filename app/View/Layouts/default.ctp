<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $this->fetch('title'); ?>
	</title>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
	<?php
	//	echo $this->Html->meta('icon');
	 	echo $this->Html->css('styles');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div class="container">

		<div class="row">
			<div class="col-xs-2">
				[LOGO]
			</div>
			<div class="col-xs-10">
				[Menu]
			</div>
		</div>
		<div class="row">
			<div class="col-xs-2">
				SIDEBAR
			</div>
			<div class="col-xs-10">
				<h1><?php echo $this->fetch('title'); ?></h1>

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
			</div>
		</div>

 
		<div id="footer">
		 	[FOOTER]
		</div>
	</div>

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
   <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<?= $this->Html->script('functions'); ?>


</body>
</html>
