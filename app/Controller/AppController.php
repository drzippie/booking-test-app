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
            'logoutRedirect' => array('controller' => 'home', 'action' => 'index',  'admin' => false )
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



protected function showList( $model , $view  , $conditions = array() , $paginate = true , $defaultOrder = array() ) {
    $this->loadModel( $model );
    $this->set('modelView', $model ) ;

    if ( $paginate ) {  
        $this->paginate = array(
            'limit' => 20,
            'recursive' => 1,
            'conditions' => $conditions ,
        );
        $data = $this->paginate( $model  );
        
    } else {
        $data  = $this->$model->find( 'all' , array(
            'limit' => 0 ,
            'recursive' => 1,
            'order' => $defaultOrder ,
            'conditions' => $conditions ,
        )) ;
    }
        $this->set('data', $data);

        $this->render( $view ) ; 

}
    protected function deleteModel( $id , $model ,  $redirect ) {
        $this->loadModel( $model );
        $this->$model->delete( $id ) ;
        $this->redirect( $redirect );
    }
    protected function editModel( $id , $model, $view, $redirect,   $dirname = 'bloques' ) {
        $this->loadModel( $model );
        $this->set('modelView', $model ) ;
        $this->layout = 'admin' ;
        if (!$id) {
            throw new NotFoundException(__('Invalid ID'));
        }

     
        $Item = $this->$model->findById($id);

          if (!$Item) {
            throw new NotFoundException(__('Invalid ID'));
        }

        if (   ( $this->request->is('post') || $this->request->is('put')) ) {
 
            if ( isset( $this->request->data['utils']['deleteimage']) && !empty( $this->request->data['utils']['deleteimage'] )) {
                $this->request->data[ $model ]['image'] = '' ;

            }

            $this->$model->id = $id;

            if ( isset( $_POST['locale']) && !empty( $_POST['locale'])) {

                    $this->$model->locale = $_POST['locale'] ;

            }

            if ($this->$model->save($this->request->data)) {
                $this->Session->setFlash('Actualizada');
                $file = $this->request->data['file']['imgbase'];

                //the folder where the files will be stored
                $fileDestination = 'files/' . $dirname . '/';
               //the folder where the thumbnails will be saved (files/thumbnails/)
                $thumbnailDestination = $fileDestination.'/thumbnails/';
                $options = array('thumbnail'=>array("max_width"=>180,
                                      "max_height"=>100, 
                                          "path"=>$thumbnailDestination),
                       'max_width'=>700 );    
                try {
                  $output = $this->ImageUploader->upload($file,$fileDestination,$options);

                } catch (Exception $e) {
                  $output = array( ) ;
                  
                }
                if  (!empty( $output )) {
                   $filePath = str_replace( $fileDestination, '' , $output['file_path']  ) ;
                   $this->$model->set('image', $filePath  );
                   $this->$model->save();
                }


                
                // die()
             $this->redirect( $redirect );
            } else {
                $this->Session->setFlash('Unable to update your post.');
            }
        }

 
         /* 
     $this->set('tipos', $this->Propiedad->Tipo->find('list' , array(
                  ))); 
         
      $this->set('ciudades', $this->Propiedad->Ciudad->find('list' , array(
                  ))); 
         */
     if (!$this->request->data) {
              $this->request->data = $Item;

          }
        $this->render( $view ) ;

    }



    protected function addModel(   $model, $view, $redirect , $dirname = 'bloques' ) {
        $this->loadModel( $model );
        $this->set('modelView', $model ) ;
        $this->layout = 'admin' ;
       if (   ( $this->request->is('post') || $this->request->is('put')) ) {

     
            $this->$model->id = null ;
            if ($this->$model->save($this->request->data)) {
  
                     $file = $this->request->data['file']['imgbase'];

                //the folder where the files will be stored
                $fileDestination = 'files/' . $dirname .  '/';
               //the folder where the thumbnails will be saved (files/thumbnails/)
                $thumbnailDestination = $fileDestination.'/thumbnails/';
                $options = array('thumbnail'=>array("max_width"=>180,
                                      "max_height"=>100, 
                                          "path"=>$thumbnailDestination),
                       'max_width'=>700 );    
                try {
                  $output = $this->ImageUploader->upload($file,$fileDestination,$options);

                } catch (Exception $e) {
                    
                  $output = array( ) ;
                  
                }
                if  (!empty( $output )) {
                   $filePath = str_replace( $fileDestination, '' , $output['file_path']  ) ;
                   $this->$model->set('image', $filePath  );
                   $this->$model->save();
                }


                
            
             $this->redirect( $redirect );
            } else {
                $this->Session->setFlash('Unable to update your post.');
            }
        }

 
 
      
        $this->render( $view ) ;

    }


    private function _setLanguage() {
    //if the cookie was previously set, and Config.language has not been set
    //write the Config.language with the value from the Cookie
    //
    //
        $idioma = (isset( $this->params['language']) ? $this->params['language'] : null );
        if ( empty( $idioma )) {
            $idioma = (isset( $this->params['named']['language']) ? $this->params['named']['language'] : null );
        }
 

        if (  !empty( $idioma ) ) {
            if ( !in_array( $idioma, array( 'spa', 'eng'))) {
                $idioma = 'spa' ;
            }
            Configure::write('Config.language', $this->Cookie->read('lang'));
            $this->Session->write('Config.language',  $idioma );
            $this->Cookie->write('lang',  $idioma , false, '20 days');
        }
        if ($this->Cookie->read('lang') && !$this->Session->check('Config.language')) {
            $this->Session->write('Config.language', $this->Cookie->read('lang'));
        } 
        //if the user clicked the language URL 
        if (    !empty( $idioma )  &&  


        ( $idioma !=  $this->Cookie->read('lang') )
                ) {
            
            //then update the value in Session and the one in Cookie
            $this->Session->write('Config.language',  $idioma );
            $this->Cookie->write('lang',  $idioma , false, '20 days');
        }
 
       
 
         Configure::write('Config.language', $this->Cookie->read('lang'));

          $idioma = 'spa';
        if ( !in_array( $this->Cookie->read('lang')  , array( 'spa', 'eng'))  )  {
            $this->Cookie->write('lang',  $idioma  , false, '20 days');
            Configure::write('Config.language',  $idioma );

        } 

    }

    //override redirect
    public function redirect( $url, $status = NULL, $exit = true ) {


        if ( is_array( $url )) {
            if (!isset($url['language']) && $this->Session->check('Config.language')) {
                $url['language'] = $this->Session->read('Config.language');
            }
        }   
        parent::redirect($url,$status,$exit);
    }


}
