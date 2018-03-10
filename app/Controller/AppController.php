<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	/** 
	 * Includes the view helpers
	 *
	 * @var array list of helpers
	 */
	public $helpers = array('Html', 'Form');

	/**
	 * Includes app components
	 *
	 * @var array multi-dimensional array
	 * of components and/or attributes
	 */
	public $components = array(
			'Session',
			'DebugKit.Toolbar',
			'Auth' => array(
				'loginRedirect' => array(
						'controller' => 'articles',
						'action' => 'index'
					),
				'logoutRedirect' => array(
						'controller' => 'articles',
						'action' => 'index'
					),
				'authenticate' => array(
						'Form' => array(
							'passwordHasher' => 'Simple',
							'hashType' => 'sha1'
							)
					),
				//'authError' => 'You are not authorized to access this page',
				//'authorize' => 'Controller'
				)
		);

	/**
	 * Unauthorizes all users
	 *
	 * @param array $user associative array of user data
	 * @return boolean false
	 */
	public function isAuthorized($user)
	{
		return false;
	}

	/**
	 * Tracks the URI segments 
	 * and separates it to controller and action
	 *
	 * @param void
	 * @return array the action and controller
	 * segments along with a not allowed message
	 */
	public function beforeFilter()
	{
			/*
				$this->Auth->authorize = array(
				AuthComponent::ALL => array('actionPath' => 'controllers/'),
		  				'Controller',
						'Actions');
			*/
			
			$controller = 'articles';
			if (isset(explode('/', Router::url())[2]))
			$controller = explode('/', Router::url())[2];
			
			$action = 'index';
			if (isset(explode('/', Router::url())[3]))
			$action = explode('/', Router::url())[3];
			
			$controllers = array('articles', 'users', 'comments', '');

			if (!in_array($controller, $controllers)) exit('This route does not exist.');

			

			return array($action, $controller, 'You are not allowed to access this page.');
	}

}
