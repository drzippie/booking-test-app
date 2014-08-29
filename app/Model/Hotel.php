<?php

App::uses('Model', 'Model');

/**
 * HOTEL Model
 *
 * @package       app.Model
 */
class Hotel extends AppModel {
	public $actsAs = array(
	  'SoftDelete' => array(  ),
    ); 
	public $hasMany = array(
			'Room' => array(
				'className' => 'Room',
		        'conditions' => array( 'Room.active' => 1 ),
		        
 
			),
	);
	public $validate = array( 
		'code' => array(
			'alphaNumeric' => array(
                'rule'     => 'alphaNumeric',
                'required' => true,
                'message'  => 'Letters and numbers only'
            ),
           'unique' => array(
      			'rule' => 'isUnique',
        		'required' => true
    		),
		),
		'location' => array(
			'notEmpty' => array(
                'rule'     => 'notEmpty',
                'required' => true,
                'message'  => 'This field cannot be left blank'
            ),
     	),
		'name' => array(
			'notEmpty' => array(
                'rule'     => 'notEmpty',
                'required' => true,
                'message'  => 'This field cannot be left blank'
            ),
     	),
     	'description' => array(
			'notEmpty' => array(
                'rule'     => 'notEmpty',
                'required' => true,
                'message'  => 'This field cannot be left blank'
            ),
     	),
     	'stars' => array(
			'numeric' => array(
                'rule'     => 'numeric',
                'required' => true,
                'message'  => 'Please supply the number of stars'
            ),
            'limit' => array(
                'rule'     => array('range', 0, 6)  ,
                'required' => true,
                'message'  => 'Please supply the number of stars from 1 to 5 '
            ),
     	),
		

	);
    /**
     * Path to images
     * @return string path to images
     */
 	public function getPathImages( ) {
 		return '/img/data/hotels/'  ;
 	}
	/**
	 * Add calculated fields to Hotels, like imageUrl
	 * 
	 */

	public function afterFind( $results, $primary = false ){
        parent::afterFind( $results, $primary );
        if( $primary ){
            foreach( $results as $key => $value ){
                if( isset( $value[ $this->alias ] )){

                	if ( !empty(  $results[ $key ][ $this->alias ]['image'] )) {

                		$results[ $key ][ $this->alias ]['imageUrl'] =  $this->getPathImages() . $results[ $key ][ $this->alias ]['image'] ;
                	} else {
                		$results[ $key ][ $this->alias ]['imageUrl'] = '/img/empty.jpg' ;

                	}
                }
            }
        }
        return $results;
    }

}
