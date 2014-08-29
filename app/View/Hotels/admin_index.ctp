<div class="row">
	<div class="col-xs-12">
		<div class="row">
			<div class="col-xs-10">
				<h1><?php echo __('Hotel Management'); ?></h1>
			</div>
			<div class="col-xs-2"> 
				<?php echo $this->Html->link('<i class="icon-plus-sign"></i>' . __('New Hotel') ,  
				array(
			 		'controller' => 'hotels',
			 	 	'action' => 'admin_add'
			 	 	) , 
				array('escape' => false, 'class' => 'btn btn-radius btn-primary')
			);

		?>
			</div>
		</div>
		

		<?php echo $this->element('admin/paginator'); ?>
 
		<table class="table table-striped table-bordered table-condensed table-admin">
			<thead>
				<tr> 
					<th></th>
					<th>
						<?php echo $this->Paginator->sort('Hotel.name',  __( 'Name' )  ); ?>
					</th>
					<th>
						<?php echo $this->Paginator->sort('Hotel.location', __( 'Location' )); ?>
					</th>
					<th>
						<?php echo $this->Paginator->sort('Hotel.stars', __( 'stars' )); ?>
					</th>
 					<th>
 						<?php echo $this->Paginator->sort('Hotel.room_count', __( 'Rooms' )); ?>
 					</th>
					<th>
						<?php echo __('Actions'); ?>
					</th>
				</tr>
			</thead>
			<?php 
			foreach( $data as $item ) {
			?>
			<tr>
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
  				</td>
				<td>
					<?php echo $item['Hotel']['location'] ?>
				</td>
				<td>
					<?php echo $item['Hotel']['stars'] ?>
				</td>
				<td>
					<?= $item['Hotel']['room_count'] ?>
				</td>
  				<td>
					<div class="btn-group">
					<?php
						echo $this->Html->link(  __( 'Edit' ),  
							array(
						 		'controller' => 'hotels',
						 	 	'action' => 'admin_edit',
						 	 	$item['Hotel']['id'] ) , 
							array('class' => 'btn btn-default radius btn-xs')
						);
						echo $this->Html->link(   __( 'Delete' ),  
							array(
								'admin'=>false, 
						 		'controller' => 'hotels', 
						 		'action' => 'del',
						 	 	$item['Hotel']['id']  , 
								'admin' => true 
								),
							array('class' => 'btn btn-default radius btn-xs'),
							__(' Are you sure ?')
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
 