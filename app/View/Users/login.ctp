<div class="row">
	<div class="col-xs-6 form ">
		<h1 ><?= __( 'Login') ?></h1>
		<?php echo $this->Session->flash('auth'); ?>
		<?php echo $this->Form->create('User'); ?>
		<div class="form-group">
		    <?php echo $this->Form->input('email', array( 'label' => __('Email') , 'id' => 'frmemail', 'class' => 'form-control' )); ?>

		</div>
		<div class="form-group">
			<?php  echo $this->Form->input('password', array( 'label' => __('Password') ,'class' => 'form-control')); ?>
		</div>

		<div class="row">
  			<div class="col-xs-12">
 				<div id="rememberText">
 					User: admin@booking.besbello.com <br>
 					Password: admin
 				</div>
 		 
 			</div>
	 	</div> 
		<button type="submit" class="btn   btn-primary">
  			  <?php  echo __('Login' ) ;?>
		</button>
		<?php echo $this->Form->end( ); ?>
	</div>
</div>
