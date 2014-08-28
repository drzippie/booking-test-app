<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
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
                            Configure::write('debug', 1); 

        if ( !isset( $this->params['named']['id']) || empty( $this->params['named']['id'] )) {
            $this->redirect( '/') ;   
            die(); 
        } else {
            $id = $this->params['named']['id'] ;
            $this->loadModel( 'User');
            $usuario = $this->User->findByPasswordreset( $id ) ;
            if ( empty( $usuario )) {
                  $this->redirect( '/') ;   
                 die(); 
            }
            $idioma =  $this->Session->read('Config.language' ) ;

           $this->loadModel( 'Sidebar') ;
            $sidebar = $this->Sidebar->find('first', array( 'conditions' => array( 
                'Sidebar.id' => 49
                )));
                $this->set( 'Sidebar', $sidebar) ;
                $password = substr( md5( R::isoDateTime()  . json_encode( $usuario )) , 10, 8 ); 
                   $this->User->id    = $usuario['User']['id'];
                $this->User->saveField('password', AuthComponent::password( $password  )   ) ;
                $this->User->saveField('passwordreset',  null   ) ;

                $template = 'newpassword-' . $idioma  ;
             $this->Mandrill->sendTemplate(  $template ,  $usuario['User']['email'] , null , array( 
                'mail' => $usuario['User']['email'] , 
                'password' => $password,
                'name' => $usuario['User']['name']

                )   )  ;

 

           // print_R( $usuario ) ;
        }
 
 


     }

    public function remember ( $id = null ) {

        $this->loadModel( 'User');
        $mail = ( isset( $_POST['mail']) ) ? $_POST['mail'] : '' ;
        $resultado = array( 'message' => sprintf( __('El correo %s no está registrado en Home at Homes')  , $mail )   )  ;
         if ( isset( $_POST['mail'])) {

            $mail = $_POST['mail'] ;

            $usuario = $this->User->findByEmail( $mail ) ;
            if ( !empty( $usuario )) {

                $changer = substr( md5( R::isoDateTime()  . json_encode( $usuario )) , 2,  8 ); 
            $idioma =  $this->Session->read('Config.language' ) ;

                $resultado['message'] = $changer ;
                $this->User->id    = $usuario['User']['id'];
                $this->User->saveField('passwordreset', $changer  ) ;
  
             $template = 'remember-' . $idioma  ;
             $this->Mandrill->sendTemplate(  $template ,  $usuario['User']['email'] , null , array( 
                'mail' => $usuario['User']['email'] , 
                'newid' => $changer,
                'name' => $usuario['User']['name']

                )   )  ;


                /*

                App::uses('CakeEmail', 'Network/Email');
                $Email = new CakeEmail('smtp');
                $Email->template('remember_' . $idioma  )
                    ->emailFormat('html') 
                    ->from(array('info@homeathomes.com' => 'Home at homes'))
                    ->to( $usuario['User']['email']  )
                    ->subject( __( 'Cambio de contraseña en Home at Homes') )
                    ->viewVars( array( 
                        'usuario' => $usuario['User'] ,
                        'changer' => $changer
                        )
                    );

                if ( !$Email->send()) {
                 }
                */



                $resultado = array( 'message' => sprintf( __('Se ha enviado un correo electrónico con las intrucciones para recuperar la contraseña') ));  


            }
             
        }

        $this->set( 'resultado' , $resultado ) ;



    }

 public function profile() {
    $this->loadModel( 'Reserva');
    $pendientes = $this->Reserva->find('all', array( 
        'conditions' => array( 
                'Reserva.user_id' => $this->Auth->user( 'id'),
                'Reserva.active' => 1 ,
            ),
        'recursive' => 1 

        ));
    $this->set('pendientes', $pendientes ) ;


  }
public function login() {
  /*  $this->loadModel( 'Sidebar') ;
    $sidebar = $this->Sidebar->find('first', array( 'conditions' => array( 
        'Sidebar.id' => 49
        )));
    $this->set( 'Sidebar', $sidebar) ;

    */
    if ($this->request->is('post')) {
        
        if ($this->Auth->login( )) {


            $this->redirect($this->Auth->redirect());
        } else {
             $this->Session->setFlash(__('Invalid username or password, try again'));
        }
    }
}

public function logout() {
    $this->redirect($this->Auth->logout());
}


}
