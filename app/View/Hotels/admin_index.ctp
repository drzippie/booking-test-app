<?php 
$this->start('headermain'); 

	echo $this->element('menuAdmin', array(), array( ));

$this->end( 'headermain');
?>


<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<div class="span10">
						<h1><?php echo __('Hotel Management'); ?></h1>

			</div>
			<div class="span2"> 
				<?php
echo $this->Html->link('<i class="icon-plus-sign"></i>' . __('Nueva') ,  
				array(
			 		'controller' => 'hotels',
			 	 	'action' => 'admin_add'
			 	 	) , 
				array('escape' => false, 'class' => 'btn btn-radius btn-primary')
			);

		?>
			</div>
		</div>
		

		<?php
	echo $this->element('admin/paginator');


?>
 
 

		<table class="table table-striped table-bordered table-condensed table-admin">
			<thead>
				<tr>
 
					<th></th>
					
					<th>
						<?php
							echo $this->Paginator->sort('Hotel.name',  __( 'Name' )  );


						?>


					</th>
					<th><?php
							echo $this->Paginator->sort('Hotel.location', __( 'Location' ));


						?></th>
					 
 					<th>

 						<?php

 						echo __('Info') ;
						//	echo $this->Paginator->sort('tarifa_count', __( 'Tarifa' ));


						?></th>
					 
					 
					  
						<th><?php echo __('Opciones'); ?></th>
				</tr>
			</thead>
			<?php 
			foreach( $data as $item ) {
?>

			<tr  >
		 
				<td>
 
<?php 
 




								echo $this->Thumbnail->render(  $item[ 'Hotel' ]['imageUrl']  , array(
         'width' => 250,
         'height' => 125,
          'resize' => 'crop',
        'quality' => '80',
        'crop' => false ,

            ), array(  'alt' => ''));

  

					?>

				</td>
				<td>
					<strong><?php echo $item['Hotel']['name'] ?></strong>
					
  					</div>
 				</td>
				<td><?php echo $item['Hotel']['location'] ?>
					
				</td>
  				<td style="width: 160px; font-size: 11px;">
					<div class="row-fluid">
						<div class="span6">
						 

						</div>
						 
					</div>


  					</td>
  				<td>
  
				</td>
				<td>
				 

 				</td>
				<td>
					<div class="btn-group">

<?php
			echo $this->Html->link(  __( 'Editar' ),  
				array(
			 		'controller' => 'properties',
			 	 	'action' => 'admin_edit',
			 	 	$item['Hotel']['id'] ) , 
				array('class' => 'btn btn-default radius btn-xs')
			);
			echo $this->Html->link(   __( 'Borrar' ),  
				array(
					'admin'=>false, 
			 		'controller' => 'properties', 
			 		'action' => 'del',
			 	 	$item['Hotel']['id']  , 
					'admin' => true 
					),
				array('class' => 'btn btn-default radius btn-xs'),
				__('¿ Desea borrar el registro ?')
			);
			echo $this->Html->link(   __( 'Ver' ),  
				array(
					'admin'=>false, 
			 		'controller' => 'ciudades', 
			 		'action' => 'verFicha',
					'slug' => $item['Hotel']['slug'] ) , 
				array('class' => 'btn btn-default radius btn-xs')
			);
	echo $this->Html->link(   __( 'Calendario' ),  
				array(
					'admin' => true ,
 			 		'controller' => 'properties', 
			 		'action' => 'calendar',
			 	 	$item['Hotel']['id']
			 	 	 ) , 
				array('class' => 'btn btn-default radius btn-xs')
			);

?>

					 
					</div>

				</td>
			</tr>



<?php


		}
		?>
		</table>

	</div>
</div>
 