<?php
/**
 * Users Controller
 *
 * @package       app.Controller
 */

App::uses('AppController', 'Controller');

/**
 * Users controller
 *
 *
 * @package       app.Controller
 */
class UsersController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	

 	 public function beforeFilter() {
    	parent::beforeFilter();
	    $this->Auth->allow('login'); 
	}
	public function newpassword( $id = null ) {
        /**
         * @todo Implement: user.newpassword
         */
    }
    /**
     * Check User Role and redirects 
     */
    public function zonaInterna() {
        if ( $this->Auth->user('rol') == 'admin') {
            $this->redirect( '/admin/hotels/') ;
        } else {
            $this->redirect( '/users/profile/' ) ;
        }

    }
    /**
     * Remember Password (send email)
     * @todo Implement Password Remember
     */
    public function remember ( $id = null ) {
        $result = array( 'message' => sprintf( __('Not Implemented') ));  
        $this->set( 'resultado' , $result ) ;
    }
 	/**
	* Login User
	* @return none 
	*/
	public function login() {
	    if ($this->request->is('post')) {
	        if ($this->Auth->login( )) {
	            $this->redirect($this->Auth->redirect());
	        } else {
	             $this->Session->setFlash(__('Invalid username or password, try again'));
	        }
	    }
	}
	/**
	 * Logout User
	 */
	public function logout() {
	    $this->redirect($this->Auth->logout());
	}
}
