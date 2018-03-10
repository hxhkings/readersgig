<?php
	
	App::uses('AppController', 'Controller');

	/**
	 * Manipulates the users table
	 * and the user views
	 *
	 * PHP version 5.6.25
	 */

	class UsersController extends AppController
	{	
		/**
		 * Labels the controller
		 *
		 * @var string name of controller
		 */
		public $name = 'Users';

		/**
		 * Runs the code
		 * before any action method
		 * is invoked
		 *
		 * @param void
		 * @return void
		 */
		public function beforeFilter()
		{
			$sections = parent::beforeFilter();
			$action = $sections[0];
			$controller = $sections[1];
			$message = $sections[2];

			$actions = array(
						// admin
						1 => array('logout', 'edit', 'profile', 'add', 'index', 'search', 'login'),
						// publisher
						2 => array('profile', 'edit', 'logout', 'login'),
						// author
						3 => array('profile', 'edit', 'logout', 'search', 'login'),
						// reader
						4 => array('edit', 'logout', 'profile', 'login')
						);
		
		if ($controller == 'users'){
			$role = $this->Session->read('Auth.User.role_id');
				if ($role != NULL && !in_array($action, $actions[$role])) exit($message);
			}
			
		}

		/**
		 * Displays all the users
		 * 
		 * @param void
		 * @return void
		 */
		public function index()
		{
			$this->set('users', $this->User->find('all'));
		}

		/**
		 * Adds a new user to the users table
		 *
		 * @param void
		 * @return void
		 */
		public function add()
		{
			if ($this->request->is('post')) {
				$this->User->create();

				$role = array('admin' => 1, 'publisher' => 2, 'author' => 3, 'reader' => 4);

				if ($this->request->data['User']['password'] ==
				 $this->request->data['User']['confirm_password']) {
					if ($this->User->save(array(
											'role_id'=> $role[$this->request->data['User']['role']],
											'username'=>$this->request->data['User']['username'],
											'email'=>$this->request->data['User']['email'],
											'password'=>$this->request->data['User']['password'],
											'first_name'=>$this->request->data['User']['first_name'],
											'last_name'=>$this->request->data['User']['last_name']))) {

					$this->Session->setFlash(__('Successfully added new user'));
					}
				} else {
					$this->Session->setFlash(__('Failed to save new user'));
				}
			}
		}

		/**
		 * Logs in a user and redirects
		 * to the home page
		 *
		 * @param void
		 * @return void
		 */
		public function login()
		{
			if ($this->request->is('post')) {
				if ($this->Auth->login()) {
					$this->redirect($this->Auth->redirectUrl());
				}
				$this->Session->setFlash(__('Invalid authentication'));
			}
		}

		/**
		 * Logs out a user and
		 * redirects to the login page
		 *
		 * @param void
		 * @return void
		 */
		public function logout()
		{
			$this->redirect($this->Auth->logout());
		}

		/**
		 * Displays the profile of a user
		 * with the designated id
		 *
		 * @param mixed $id id of the user
		 * int if id exists, null if it doesn't exist
		 * @return void
		 * @throws NotFoundException if the id
		 * or the user was not found
		 */
		public function profile($id = NULL)
		{
			if (!$id) {
				throw new NotFoundException(__('Invalid'));
			}
			if ($this->Session->read('Auth.User.id') == $id ||
			 $this->Session->read('Auth.User.role_id') == 1){

				if ($this->User->exists($id)) {
					$this->set('user', $this->User->findById($id));
				} else {
					throw new NotFoundException(__('User does not exist'));
				}
			} else {
				$this->Session->setFlash(__('You can\'t access other\'s profile page.'));
				$this->redirect(array('controller'=>'articles','action' => 'index'));
			}
		}

		/**
		 * Edits the profile of the user
		 * with the designated id
		 *
		 * @param mixed $id id of the user
		 * int if id exists, null if it doesn't exist
		 * @return void
		 * @throws NotFoundException if the id or
		 * the user was not found
		 */
		public function edit($id = NULL)
		{
			if (!$id) {
				throw new NotFoundException(__('Invalid'));
			}

			$user = $this->User->findById($id);

			if (!$user) {
				throw new NotFoundException(__('User not found'));
			}
			if ($user['User']['role_id'] == $this->Session->read('Auth.User.role_id')){
				if ($this->request->is(array('post', 'put'))) {
					$this->User->id = $id;
					if ($this->User->save($this->request->data)) {
						$this->Session->setFlash(__('Successfully updated your profile.'));
						return $this->redirect(array('action' => 'profile', $id));
					}
					$this->Session->setFlash(__('Failed to update profile.'));
				}
			} else {
				$this->Session->setFlash(__('You can\'t edit other\'s profile.'));
				$this->redirect(array('controller' => 'articles', 'action' => 'index'));
			}

			if (!$this->request->data) {
				$this->request->data = $user;
			}
		}

		/**
		 * Searches for the queried user
		 *
		 * @param void
		 * @return void
		 */
		public function search()
		{
			if ($this->request->is('post')) {
				if ($this->request->data) {
					$q = $this->request->data['User']['queryUser'];
					$conditions = array("OR" => array(
						"User.username LIKE" => "%$q%",
						"User.email LIKE" => "%$q%",
						"User.first_name LIKE" => "%$q%",
						"User.last_name LIKE" => "%$q%"
						));
					$result = $this->User->find('all', array('conditions'=>$conditions));
					if (!empty($result)){
						$this->set('users', $result);
					} else {
						$this->Session->setFlash(__('Failed to search for the user.'));
						$this->redirect(array('controller' => 'users', 'action' => 'index'));
					}
				} else {
					$this->Session->setFlash(__('Failed to search for the article.'));
					$this->redirect(array('controller' => 'users', 'action' => 'index'));
				}
			} else {
					$this->Session->setFlash(__('Failed to search for the article.'));
					$this->redirect(array('controller' => 'users', 'action' => 'index'));
			}
		}

		

	}



?>