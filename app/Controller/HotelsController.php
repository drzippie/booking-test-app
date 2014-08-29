<?php
/**
 * Hotels Controller.
 *
 *
 * @package       app.Controller
 */

App::uses('AppController', 'Controller');

/**
 * Hotels Controller
 *
 *
 * @package       app.Controller
 */

class HotelsController extends AppController {

/**
 *
 * @var array
 */
	public $uses = array( 'Hotel');
    public $components = array('ImageUploader'  );

/**
 * List Hotels (Admin)
 */
	public function admin_index() {
	   $this->paginate = array(
			'limit' => 20,
			'recursive' => 1
		);
	 	$data = $this->paginate('Hotel' );
	    $this->set('data', $data); 
	}
	/**
	 * Edit Hotel
	 * @param  String $id  Hotel ID
	 */
	public function admin_edit( $id ) {
		if (!$id) {
	        throw new NotFoundException(__('ID not valid'));
	    }
	    $Item = $this->Hotel->find( 'first', 
	    	array(
	    		'conditions' => array(
    				'Hotel.id' => $id 
    			),
	    		'recursive' => 1 
	    	)
	    );
	    if (!$Item) {
	    	throw new NotFoundException(__('no válido'));
	    }
	    if ( ( $this->request->is('post') || $this->request->is('put')) ) {
			$model  = 'Hotel' ; 
			/**
			 * Mark all rooms as inactive
			 */
	    	$this->Hotel->Room->updateAll(
	    		array( 'Room.active' => 0),
	    		array( 'Room.hotel_id' => $id )
	    	);
	    	/**
	    	 * Loop Rooms: only process rooms containing all data
	    	 */
	    	if ( isset($this->request->data['rooms']  )) {
		    	foreach( $this->request->data['rooms']['name'] as $key => $item ) {
		    		if ( !empty( $item) && 
		    			!empty( $this->request->data['rooms']['capacity'][ $key ]) && 
		    			!empty( $this->request->data['rooms']['price'][ $key ]) && 
		    			!empty( $this->request->data['rooms']['num_available'][ $key ])
		    			)   

		    		    {

		    		    if ( $this->request->data['rooms']['id'][ $key ] === '-1') {
		    		    	/*
		    		    	  	New Room
		    		    	 */
		    		    	$this->Hotel->Room->id = null ;
		    		    	$this->Hotel->Room->create();
		    		    	$this->Hotel->Room->set('name',  $item  );
		    		    	$this->Hotel->Room->set( 'capacity', $this->request->data['rooms']['capacity'][ $key ] ) ;
		    		    	$this->Hotel->Room->set( 'price', $this->request->data['rooms']['price'][ $key ] ) ;
 							$this->Hotel->Room->set( 'num_available', $this->request->data['rooms']['num_available'][ $key ] ) ;
 							$this->Hotel->Room->set( 'hotel_id', $id )  ;
 							$this->Hotel->Room->set( 'active',1 )  ;
 							$this->Hotel->Room->save();
		    		    } else {
		    		    	/*
		    		    		Update and activate room
		    		    	 */
		    		    	$this->Hotel->Room->id = (int) $this->request->data['rooms']['id'][ $key ] ;
		    		    	$this->Hotel->Room->set('name',  $item  );
		    		    	$this->Hotel->Room->set( 'capacity', $this->request->data['rooms']['capacity'][ $key ] ) ;
		    		    	$this->Hotel->Room->set( 'price', $this->request->data['rooms']['price'][ $key ] ) ;
 							$this->Hotel->Room->set( 'num_available', $this->request->data['rooms']['num_available'][ $key ] ) ;
 							$this->Hotel->Room->set( 'active', 1 )  ;
 							$this->Hotel->Room->save();

		    		    }

 

		    		}

		    	}
	    	}

	        $this->Hotel->id = $id;
	        /*
	        	Save Hotel Data
	        */
	        if ($this->Hotel->save($this->request->data)) {

	        	unset( $this->request->data['rooms'] )  ;
	            $this->Session->setFlash('Hotel Updated');



	            /*
	            Save Hotel Image
	             */
	            $file = $this->request->data['file']['imgbase'];
	            $fileDestination = substr( $this->Hotel->getPathImages(), 1 )  ;
	            $thumbnailDestination = $fileDestination.'/thumbnails/';
	            $options = array(
	            	 'thumbnail'=>array(
	            	 	"max_width"=>180,
	                    "max_height"=>100, 
	                    "path"=>$thumbnailDestination),
	                   'max_width'=>700 
	            );
	            /**
	             * @todo Catch upload errors
	             */
	           	try {
	              $output = $this->ImageUploader->upload($file,$fileDestination,$options);

	            } catch (Exception $e) {
	              $output = array( ) ;
	              
	            }
	            /*
	            	Update field image in table hotels
	             */
	            if  (!empty( $output )) {
	               $filePath = str_replace( $fileDestination, '' , $output['file_path']  ) ;
	               $this->Hotel->set('image', $filePath  );
	               $this->Hotel->save();
	            }
	            /*
	              Go to Hotel list 
	             */
		        $this->redirect(array( 'controller' => 'hotels',  'action' => 'index' ));
	        } else {
	            $this->Session->setFlash('Unable to update your data.');
	        }
	    }
		if (!$this->request->data) {
	        $this->request->data = $Item;
        }
    }

    /**
	 * Add Hotel
	 */
	public function admin_add(  ) {
	    if ( ( $this->request->is('post') || $this->request->is('put')) ) {
	        $this->Hotel->id = null;
	        /*
	        	Save Hotel Data
	        */
	       	
	        if ($this->Hotel->save($this->request->data)) {
	        	$id = $this->Hotel->id ;
	        	if ( isset($this->request->data['rooms']  )) {
			    	foreach( $this->request->data['rooms']['name'] as $key => $item ) {
			    		if ( !empty( $item) && 
			    			!empty( $this->request->data['rooms']['capacity'][ $key ]) && 
			    			!empty( $this->request->data['rooms']['price'][ $key ]) && 
			    			!empty( $this->request->data['rooms']['num_available'][ $key ])
			    			)   

			    		    {

			    		    if ( $this->request->data['rooms']['id'][ $key ] === '-1') {
			    		    	/*
			    		    	  	New Room
			    		    	 */
			    		    	$this->Hotel->Room->id = null ;
			    		    	$this->Hotel->Room->create();
			    		    	$this->Hotel->Room->set('name',  $item  );
			    		    	$this->Hotel->Room->set( 'capacity', $this->request->data['rooms']['capacity'][ $key ] ) ;
			    		    	$this->Hotel->Room->set( 'price', $this->request->data['rooms']['price'][ $key ] ) ;
	 							$this->Hotel->Room->set( 'num_available', $this->request->data['rooms']['num_available'][ $key ] ) ;
	 							$this->Hotel->Room->set( 'hotel_id', $id )  ;
	 							$this->Hotel->Room->set( 'active',1 )  ;
	 							$this->Hotel->Room->save();
			    		    } else {
			    		    	/*
			    		    		Update and activate room
			    		    	 */
			    		    	$this->Hotel->Room->id = (int) $this->request->data['rooms']['id'][ $key ] ;
			    		    	$this->Hotel->Room->set('name',  $item  );
			    		    	$this->Hotel->Room->set( 'capacity', $this->request->data['rooms']['capacity'][ $key ] ) ;
			    		    	$this->Hotel->Room->set( 'price', $this->request->data['rooms']['price'][ $key ] ) ;
	 							$this->Hotel->Room->set( 'num_available', $this->request->data['rooms']['num_available'][ $key ] ) ;
	 							$this->Hotel->Room->set( 'active', 1 )  ;
	 							$this->Hotel->Room->save();

			    		    }

	 

			    		}

			    	}
		    	}
	        	unset( $this->request->data['rooms'] )  ;
	            $this->Session->setFlash('Hotel Updated');



	            /*
	            Save Hotel Image
	             */
	            $file = $this->request->data['file']['imgbase'];
	            $fileDestination = substr( $this->Hotel->getPathImages(), 1 )  ;
	            $thumbnailDestination = $fileDestination.'/thumbnails/';
	            $options = array(
	            	 'thumbnail'=>array(
	            	 	"max_width"=>180,
	                    "max_height"=>100, 
	                    "path"=>$thumbnailDestination),
	                   'max_width'=>700 
	            );
	            /**
	             * @todo Catch upload errors
	             */
	           	try {
	              $output = $this->ImageUploader->upload($file,$fileDestination,$options);

	            } catch (Exception $e) {
	              $output = array( ) ;
	              
	            }
	            /*
	            	Update field image in table hotels
	             */
	            if  (!empty( $output )) {
	               $filePath = str_replace( $fileDestination, '' , $output['file_path']  ) ;
	               $this->Hotel->set('image', $filePath  );
	               $this->Hotel->save();
	            }
	            /*
	              Go to Hotel list 
	             */
		        $this->redirect(array( 'controller' => 'hotels',  'action' => 'index' ));
	        } else {
	            $this->Session->setFlash('Unable to update your data.');
	        }
	    }
		$this->render( 'admin_edit') ;

    }
    /**
     * Delete Record
     * @param  [type] $id [description]
     */
   	public function admin_del(  $id ) {

   		/**
   		 * Use SoftDelete Behaviour, all the data remains (invisible)
   		 */
   		/**
   		 * @todo Warning: show info to user 
   		 */
		$this->Hotel->delete( $id ) ;
		$this->redirect( array( 'controller' => 'hotels',  'action' => 'index' , $id, 'admin' => true   )  );

	}

 


}
