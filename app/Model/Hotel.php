<?php

App::uses('Model', 'Model');

/**
 * HOTEL Model
 *
 * @package       app.Model
 */
class Hotel extends AppModel {
	/*
    public $hasMany = array(
            'Sitio' => array(
                'className' => 'Sitio',
				'foreignKey' => 'clasesitio_id'
             )
        );
	 public $actsAs = array('Tools.Slugged' => array(
       'label' => array( 'name' ) ,
        'overwrite' => false,
        ),
	 );
	 */

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

                		$results[ $key ][ $this->alias ]['imageUrl'] = '/img/data/hotels/' . $results[ $key ][ $this->alias ]['image'] ;
                	} else {
                		$results[ $key ][ $this->alias ]['imageUrl'] = '/img/empty.jpg' ;

                	}
                }
            }
        }
        return $results;
    }

}
