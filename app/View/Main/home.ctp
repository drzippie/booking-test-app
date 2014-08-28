<?php

?>

 

<?php foreach( $hotels as $item ) { ?>

	<div class="row">
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
			<?= $item['Hotel']['name'] ?>: 
			<?= $item['Hotel']['stars'] ?>
			<div><?= $item['Hotel']['location'] ?></div>
		</div>
	</div>

<?php } ?>

