<?php
/**
 * MandrillComponent
 *
 * This class is used for interacting with the Mandrill API.
 * Mandrill API documentation is available at
 * https://mandrillapp.com/api/docs/
 *
 * To use:
 * place MandrillComponent.php in app/Controller/Component/
 *
 * public $components = array(
 *       'Mandrill.Mandrill' => array('key' => 'YOUR_API_KEY')
 *       );
 *
 * 
 *
 */
App::uses('Component', 'Controller');
App::uses('HttpSocket', 'Network/Http');

class MandrillComponent extends Component {

/**
 * Base API URI
 *
 * @var string
 */
	protected $base_uri = 'https://mandrillapp.com/api/1.0/';

/**
 * The Connection to the mandrill API server
 *
 * @var HttpSocket
 */
	private $__mandrillConnection;

/**
 * request
 *
 * @var array
 */
	protected $_request = array(
                    'header' => array(
                            'Accept' => 'application/json',
                            'Content-Type' => 'application/json',
                            'User-Agent' => 'CakePHP/MandrillComponent-1.0',
                    )
            );
/**
 * arguments
 *
 * @var array
 */
	private $__arguments = array();
	
/**
 * API Key
 *
 * @var mixed
 */
	public $key = null;

/**
 * Magic __Call
 * 
 * @param type $name
 * @param type $arguments
 * @return array
 */
        public function __call($name, $arguments = array( )) {
        	$this->__arguments = $arguments[0];
        	unset($arguments);
        	print_R( $this ) ;
            $name = str_replace('_', '-', $name);
            $uri = str_replace('_', '/', Inflector::underscore($name));
            $uri = $this->base_uri.$uri.'.json';
            
            $arguments = json_encode(array_merge(array('key' => $this->key), $this->__arguments));
            
            $__mandrillConnection = new HttpSocket();
            return json_decode($__mandrillConnection->post($uri, $this->__arguments, $this->_request), true);
        }

/**
 * Takes a CakeEmail Object and appempts to send it using the Mandrill API
 *
 * @return array
 */
        public function sendTemplate( $templateName, $to = '', $cc = null , $vars = array() ) { 
            $uri = $this->base_uri.'/messages/send-template.json';
            $toData = array();

            $destinoTo = new stdClass() ;
            $destinoTo->email = $to ;
            $destinoTo->type = "to" ;
            $toData[] = $destinoTo ;

            if ( !empty( $cc )) { 
            $destinoCC = new stdClass() ;
            $destinoCC->email = $cc ;
            $destinoCC->type = "bcc" ;
             $toData[] = $destinoCC ;
            }
            $varItems = array();

            foreach( $vars as $key => $value ) {

                $item = new stdClass();
                $item->name = $key ;
                $item->content = $value ;
                $varItems[] = $item ;
            }


            $data  = array( 
                'key' => $this->key ,
                'template_name' => $templateName ,
                'template_content' => array(   ),
                'message' => array( 
                    'to' => $toData,
                    "global_merge_vars" =>   $varItems   
                )
            );
              $__mandrillConnection = new HttpSocket();
            return json_decode($__mandrillConnection->post($uri,  json_encode( $data ), $this->_request), true);

        }

 	public function sendCake(CakeEmail $email) {
            $this->__extractCakeEmail($email);
            $this->messagesSend($this->__arguments);
        }
 
/**
 * Extract headers, subject, body, Reply-To, and BCC Address from a 
 * CakeEmail Object
 *
 * @return array
 */
 
	private function __extractCakeEmail(CakeEmail $email) {
		$this->__arguments['message'] = array();
				
		// From
		$this->__arguments['message']['from_email'] = $email->_headers['From'];

		// To
		$this->__arguments['message']["to"] = array(
			array("email" => $email->_headers['To'])
		);
                
                // Reply-To
                $this->__arguments['message']["headers"] = array(
			array("Reply-To" => $email->replyTo())
		);
                
                // bbc
                $this->__arguments['message']["bcc_address"] = array(
			array("Reply-To" => $email->replyTo())
		);
                
		// Subject
		$this->__arguments['message']['subject'] = mb_decode_mimeheader($email->_headers['Subject']);

		//Body
                switch ($email->emailFormat()) {
                    case 'both':
                        $this->__arguments['message']['html'] = $email->message('html');
                        $this->__arguments['message']['text'] = $email->message('text');
                        break;
                    case 'html':
                        $this->__arguments['message']['html'] = $email->message('html');
                        break;
                    case 'text':
                        $this->__arguments['message']['text'] = $email->message('text');
                        break;
                    default:
                        $this->__arguments['message']['html'] = $email->message('html');
                        $this->__arguments['message']['text'] = $email->message('text');
                        break;
                }
		return $this->__arguments;
		 
	}
	
}
