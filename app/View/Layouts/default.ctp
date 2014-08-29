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

				<?php echo $this->Html->image('logo.jpg', array('alt' => 'Geek Hotels', 'class' => 'img-responsive')); ?>

			</div>
			<div class="col-xs-10">
				 <em>Top menu</em>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-2">
				<h5>Main</h5>
				<ul class="nav nav-pills nav-stacked">

				<li><?php echo $this->Html->link( __('Home')  , array( 
						 	'controller' => 'main' ,
						 	'action' => 'home',
						 	'admin' => false ), array( 'class' =>  '' )); ?></li>


				<?php
				/**
				 *  @todo Create a custom sidebar for users
				 */
				?>
				<?php 
					if ( !empty( $user ) ) {
				?>

					<li><?php echo $this->Html->link( __('Hotels')  , array( 
						 	'controller' => 'hotels' ,
						 	'action' => 'index',
						 	'admin' => true ), array( 'class' =>  '' )); ?></li>
					<li><?php echo $this->Html->link( __('Logout') , array( 
						 	'controller' => 'users' ,
						 	'action' => 'logout',
						 	'admin' => false ), array( 'class' =>  '' )); ?></li>  


				<?php
				} else {
				?>
 					<li><?php echo $this->Html->link( __('Login') , array( 
						 	'controller' => 'users' ,
						 	'action' => 'login',
						 	'admin' => false ), array( 'class' =>  '' )); ?></li> 
				<?php
					}
	 			?>

				</ul>

			</div>
			<div class="col-xs-10">
			<?php $flash = $this->Session->flash() ; 
				if (!empty( $flash )) {
				?>
				<div class="alert alert-warning" role="alert"><?= $flash ?></div>
				<?php
				} ?>

			<?php echo $this->fetch('content'); ?>
			</div>
		</div>

 
		<div id="footer">
		 	<em>Footer</em>
		</div>
	</div>

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
   <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<?= $this->Html->script('jsRender'); ?>

	<?= $this->Html->script('functions'); ?>


</body>
</html>
