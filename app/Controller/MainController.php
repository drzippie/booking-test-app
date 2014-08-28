<?php
/**
 * Main Controller.
 *
 *
 * @package       app.Controller
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class MainController extends AppController {

/**
 *
 * @var array
 */
	public $uses = array( 'Hotel');
 	public function home( ) {


 		$items = $this->Hotel->find( 'all', array(
	    	'conditions' => array(
	    			 
	    		),

	     'recursive' => 1 ));
		$this->set( 'hotels', $items) ;



 	}
}
