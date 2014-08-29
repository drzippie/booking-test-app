<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {


    public $helpers = array(
        'Thumbnail',
    );

    public $components = array(
    	'DebugKit.Toolbar' => array('panels' => array('history' => false)), 
        'Session',
        'Cookie',
        'RequestHandler' ,
         'Auth' => array(
        	   'authenticate' => array(
            'Form' => array(
                'fields' => array('username' => 'email')
            )
        	),
            'loginRedirect' => array('controller' => 'users', 'action' => 'zonaInterna' , 'admin' => false ),
            'logoutRedirect' => '/'
        )
    );
    public function beforeFilter() {
      if ( $this->params['admin'] && $this->Auth->user( 'rol' ) != 'admin' && ( $this->request->params['action'] != 'login') ) {
     	 
     		$this->redirect( '/users/login') ;
    	}
 		  $this->Auth->fields = array(
            'username' => 'email',
            'password' => 'password'
        );
        $this->Auth->allow('index', 'view');
        $this->Auth->allow();
        $this->set( 'user',  $this->Auth->user());
        parent::beforeFilter();






     }
    public function isAuthorized($user = null) {
         // Any registered user can access public functions
         if (empty($this->request->params['admin'])) {
            return true;
        }

        // Only admins can access admin functions
        if (isset($this->request->params['admin'])) {
            return (bool)($user['role'] === 'admin');
        }

        // Default deny
        return false;
    }
    /**
     * Login  user , used in Register user 
     * @param  [type] $email    [description]
     * @param  [type] $password [description]
     * @return [type]           [description]
     */
 	  public function loginUser( $email, $password) {

    	$this->loadModel( 'User');

    	$usuario = $this->User->find('first', array(
    			'conditions' => array(
    				'User.email' => $email,
    				'User.password' => AuthComponent::password( $password )
    				)
		));
		return $this->Auth->login( $usuario['User'] ) ;
	}


}
