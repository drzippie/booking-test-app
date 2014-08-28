<?php

?>

 

<?php foreach( $hotels as $item ) { ?>

	<div class="row">
		<div class="col-xs-2">
			<img src="<?= $item['Hotel']['imageUrl'] ?>" alt="" class="img-responsive"> 
		</div>
		<div class="col-xs-10">
			<?= $item['Hotel']['name'] ?>: 
			<?= $item['Hotel']['stars'] ?>
			<div><?= $item['Hotel']['location'] ?></div>
		</div>
	</div>

<?php } ?>

