
<div class="row-fluid">
	<div class="span3">
	  	</div>
	<div class="span9">
		<div class="row-fluid" style="margin-top: 10px; margin-bottom: 10px;">
			
		<?=
   AuthComponent::password( 'alex' ) ?>
 	</div>


<div class="row-fluid">
	<div class="span2">
		
	</div>
	<div class="span8 form ">
		<h1 class="tituloPropiedad"><?= __( 'Login') ?></h1>
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User'); ?>
          <?php echo $this->Form->input('email', array( 'label' => __('Email') , 'id' => 'frmemail' ));
        echo $this->Form->input('password', array( 'label' => __('Password') ));
    ?>

<div class="row-fluid">
  			<div class="span12">
 				<div id="rememberText">
 					
 				</div>
 				<a href="#" id="rememberpassword"><?php echo __('Recordar Contraseña') ?></a>
		 
 			</div>
 		 

 	</div> 

 
<button type="submit" class="btn   btn-primary">
  			  <?php  echo __('Entrar' ) ;?>
		</button>

<?php echo $this->Form->end( ); ?>
</div>
<div class="span2">
	
</div>

 


</div>


 			</div>

</div>



<?php
$__="__";

$this->Html->scriptBlock( <<<EOF
	
$( document ).ready(function() {
	 $('#rememberpassword').bind( 'click', function( e ) {
		e.preventDefault();
		var mail = $('#frmemail').val() ;
		if ( mail == '') {
		  $('#rememberText' ).html( '{$__('Debe indicar un correo electrónico válido')}' ) ;
		  return ;
		} else {
			$.ajax({
				type: "POST",
				url: '/users/remember.json',
				data: { 'mail':  mail },
				success: function( e ) {
					$('#rememberText' ).html( e.message  ) ;


				},
				dataType: 'json'
				});

 		}

	 });
});
EOF
,array('inline'=>false));

?>
