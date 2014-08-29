<?php foreach( $hotels as $item ) { ?>
	<div class="row hotelList" >
		<div class="col-xs-2">
 			<?= $this->Thumbnail->render($item['Hotel']['imageUrl']    , 
				array(
						'width' => '250',
						'height' => '250' ,
						'shadow' => true ,
						'resize' => 'crop',
						'quality' => '80',

					), 
					array(  
						'class' => 'img-responsive' ,  
						'alt' =>  $item['Hotel']['name'] )
					) 
			?> 
		</div>
		<div class="col-xs-10">
			<div class="stars">
			<?php for( $i =0; $i < $item['Hotel']['stars'] ; $i++) { ?>
				<i class="glyphicon glyphicon-star"></i>
			<?php } ?>
			 
		</div>
		<div class="name"><?= $item['Hotel']['name'] ?></div>
		<div class="location"><?= $item['Hotel']['location'] ?></div>
		<div class="description"><?= $item['Hotel']['description'] ?></div>
		</div>
	</div>
<?php } ?>

