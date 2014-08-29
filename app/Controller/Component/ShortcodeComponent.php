<?php

/*
 * File: /app/Controller/Component/AttachmentComponent.php
 * A file uploader and image crop/thumbnailer component for CakePHP
 *
 * @link         https://github.com/tute/Thumbnail-component-for-CakePHP
 * @author       TuteC (Eugenio Costa), Palamethos (Ian Stewart)
 * @version      0.9.5
 * @license      MIT
 *
 */
App::uses('Component', 'Controller');

App::import('Core', 'Inflector');

class ShortcodeComponent extends Component {
	/**
	 * Configuration options
	 * @var $config array
	 */
	var $config = array(
		 
	 
	);

	/**
	 * Contructor method.
	 *
	 * @param $collection object
	 * @param $settings array
	 */
	function __construct(ComponentCollection $collection, $settings = array()) {
		parent::__construct($collection, $settings);
		/* General configuration and overridings */
		$this->config = array_merge($this->config, $settings);
	}

	/**
	 * Initialization method.
	 *
	 * @param $controller object
	 */
	function initialize(Controller $controller) {
  	}


  	public function  registerSC( $helper ) {

  		$helper->add_shortcode( 'negrita', array( $this, 'funct_prueba') ) ;
  		$helper->add_shortcode( 'form', array( $this, 'funct_form') ) ;
  
   	}
   	public function funct_prueba($atributes = array() ,  $content = '' ) {
   		$resultado = '<strong>' . $content . '</strong>'   ; 
   		return $resultado ; 
   	}

	public function funct_form($atributes = array() ,  $content = '' ) {

		$url  =trim( $content ) ;


		$View = new View();
		$resultado = $View->element( $url ,  array( 'atributes' => $atributes )  );


    		return $resultado ; 
   	}



	 
}
