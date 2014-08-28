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
class HotelsController extends AppController {

/**
 *
 * @var array
 */
	public $uses = array( 'Hotel');

	public function admin_index() {
	//	$this->layout = 'admin' ;

	   $this->paginate = array(
			'limit' => 20,
			'recursive' => 1
			);
	 	$data = $this->paginate('Hotel' );
	    $this->set('data', $data);
	 

	}
}
