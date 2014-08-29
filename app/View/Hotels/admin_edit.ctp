<?php 
$this->start('headermain'); 

	// echo $this->element('menuAdmin', array(), array( ));

$this->end( 'headermain');
?>

<?php
    echo $this->Form->create('Hotel', array('type' => 'file'));
    echo $this->Form->input('id', array('type' => 'hidden'));
?>
<input type="submit" class="btn btn-primary btn-radius" value="<?= __( 'Save') ?>" style="float: right;">
<h1><?= __( 'Edit Hotel') ?></h1>
 

<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<?php
			    echo $this->Form->input('name', array( 
                    'label' => __('Name') ,
                    'class' => 'form-control' ));
			?>
		</div>
		
	</div>
</div>
<div class="row">
	<div class="col-xs-2">
		<div class="form-group">
			<?php
			    echo $this->Form->input('code', array( 'label' => __('Code'),
			                            'class' => 'form-control' ));
			?>
		</div>
	</div>
 
	<div class="col-xs-4">
		<div class="form-group">
			<?php
    	echo $this->Form->input('location', array( 'label' => __( 'Location' ),
		                            'class' => 'form-control' ,
		                            'type' => 'text'));
		?>
		</div>

	 
	</div>
	<div class="col-xs-2">
		<div class="form-group">
			<label for=""><?= __( 'Active') ?></label>
				<?php
				    echo $this->Form->input('active', array( 'label' => false ,
				    	'type' => 'checkbox',
				                            'class' => '' ));
				?>
		</div>
	</div>
	<div class="col-xs-2">
		<div class="form-group">
			<?php
   	 	echo $this->Form->input('stars', array( 'label' => __( 'Stars' ),
		                            'class' => 'form-control' ,
		                            'type' => 'number'));
		?>
		</div>

	 
	</div>
</div>
 

<div class="row">
 
	<div class="col-xs-12">
		<div class="form-group">
			<?php
 
		    echo $this->Form->input('description', array( 
		                            'label' => __( 'Description' ),
		                            'class' => 'form-control' ));
			?>
		</div>
		
	</div>
	 
</div>
 
  
	<div class="row">
		<div class="col-xs-2">
			<div class="well"><?= __( 'Image') ?>
 				<div class="row">
					<div class="col-xs-12">
						<?php 
						if ( isset(  $this->data[ 'Hotel' ]['imageUrl'] )) {
								echo $this->Thumbnail->render( $this->data[ 'Hotel' ]['imageUrl'] , array(
         'width' => '135',
         'height' => '90' ,
         'resize' => 'auto',
        'quality' => '80',
        'crop' => true ,

            ), array(  'alt' => ' ', 'class' => 'img-responsive'));

 
						}

					?>
					</div>
				</div>

			</div>
	 
		</div>
		<div class="col-xs-10 last">
			<label for=""><?= __( 'New Image') ?></label>
			<?php

			echo $this->Form->input('file.imgbase', array( 'label' => '' , 'type' => 'file' , ));
			?>
		</div>

			 
	</div>
  	
<?php if ( isset( $this->data['Room'])) { ?>

  	<div class="row">

  		<div class="col-xs-12">
 			<div class="panel">
 			
		   		<div class="row">
		  			<table class="table table-compress table-bordered" id="tablaTarifas">
		  				<thead>
		  					<tr>
			  					<th class="col-xs-4">
			  						<?= __( 'Name') ?>
			  					</th>
			  					<th class="col-xs-2">
			  						<?= __( 'Max Person') ?>
			  					</th>
			  					<th class="col-xs-2">
			  						<?= __( 'Price') ?>
			  					</th>
			  					<th class="col-xs-1">
			  						<?= __( 'Total Rooms') ?>
			  					</th>
			  				 
			  					<th class="col-xs-2">
			  						<a href="#" id="addTr" class="btn btn-primary btn-small"> <?= __( 'New Room') ?> </a>
			  					</th>
		  					</tr>
		  					
		  				</thead>
		  				<tbody>
		  					<?php 
 		  						foreach( $this->data['Room'] as $item ) {
		  						//	print_R( $item ) ;
		  					?>
		  					
		  				
		<tr>
			<td>
				<input type="hidden" name="rooms[id][]" value="<?php echo  $item['id'] ?>">
				<input type="text" class="col-xs-12" name="rooms[name][]" value="<?php echo  $item['name'] ?>">
			</td>
			
		 
			<td>
				<input type="number" class="col-xs-12 fromDate" name="rooms[capacity][]" value="<?php echo  $item['capacity'] ?>">
			</td>
			
		 
			<td>
				<input type="text" class="col-xs-12 toDate" name="rooms[price][]" value="<?php echo  $item['price'] ?>">
			</td>
		 
			<td>
				<input type="number" class="col-xs-12" name="rooms[num_available][]" value="<?php echo  $item['num_available'] ?>">
			</td>

			<td>
				<a href="#" class="btn btn-small deleteTrRoom"><?= __( 'Delete') ?></a> 
			</td>
			
		</tr>
		 					<?php
		 						}

		 					?>
		  				</tbody>
		  			</table>
		<?php 
 
		?>


		 
		  </div>


 		</div>


 	</div>
 </div>
 
 <?php
} // End if data.rooms exists
?>



<script id="trRoom" type="text/x-jsrender">
  				
		<tr>
			<td>
				<input type="hidden" name="rooms[id][]" value="-1">
				<input type="text" class="col-xs-12" name="rooms[name][]" value="">
			</td>
			<td>
				<input type="number" class="col-xs-12 " name="rooms[capacity][]" value="2">
			</td>
			<td>
				<input type="text" class="col-xs-12 " name="rooms[price][]" value="">
			</td>
			<td>
				<input type="number" class="col-xs-12" name="rooms[num_available][]" value="1>">
			</td>
			<td>
				<a href="#" class="btn btn-small deleteTrRoom"><?= __( 'Delete') ?></a> 
			</td>
			
		</tr>
</script>
  <?php
  //  echo $this->Form->input('body', array('rows' => '3'));
    echo $this->Form->end(  );