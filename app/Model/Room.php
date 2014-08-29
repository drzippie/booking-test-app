<?php

App::uses('Model', 'Model');
 
/**
 * Room Model
 * @package       app.Model
 */
class Room extends Model {
 
	public $useTable = 'rooms';  

	 public $belongsTo = array(
		'Hotel' => array(
			'className' => 'Hotel',
			'foreignKey' => 'hotel_id',
			'counterCache' => array(
              	  'room_count' => array('Room.active' =>  1 )
              	  ),
 		) 
		 
	);
 

}
