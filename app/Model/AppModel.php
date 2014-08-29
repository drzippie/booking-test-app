<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	/*
		Method for SoftDelete
	 */
	public function exists($id = null) {
	    if ($this->Behaviors->attached('SoftDelete')) {
	        return $this->existsAndNotDeleted($id);
	    } else {
	        return parent::exists($id);
	    }
	}
	public function delete($id = null, $cascade = true) {
	    $result = parent::delete($id, $cascade);
	    if ($result === false && $this->Behaviors->enabled('SoftDelete')) {
	       return (bool)$this->field('deleted', array('deleted' => 1));
	    }
	    return $result;
	}
		
}
