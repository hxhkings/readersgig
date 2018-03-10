<?php
	
	App::uses('AppController', 'Controller');

	/**
	 * Manipulates the articles table
	 * and the article views
	 *
	 * PHP version 5.6.25
	 */

	class ArticlesController extends AppController
	{

		/**
		 * Labels the controller
		 *
		 * @var string name of controller
		 */
		public $name = 'Articles';


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
						1 => array('index', 'delete','unpublish' ,'search', 'share', 'lists', 'view'),
						// publisher
						2 => array('index', 'review', 'lists', 'publish', 'unpublish', 'search'),
						// author
						3 => array('index', 'edit', 'create', 'review', 'search', 'lists', 'latest', 'view'),
						// reader
						4 => array('index', 'search', 'share', 'upvote', 'downvote', 'lists', 'view')
						);
		
			

		if ($controller == 'articles'){
			/* Omitted due to a complexity of O(R), R = no. of roles
			switch($this->Session->read('Auth.User.role_id')){
					case 1: //admin
						if (!in_array($action, $actions[1])) 
						exit($message);	
						break;
					case 2: //publisher
						if (!in_array($action, $actions[2])) 
						exit($message);	
						break;
					case 3: //author
						if (!in_array($action, $actions[3])) 
						exit($message);	
						break;
					case 4: //reader
						if (!in_array($action, $actions[4])) 
						exit($message);	
						break;
				} 
				*/
				// This replacement has a complexity of O(1)
				$role = $this->Session->read('Auth.User.role_id');
				if ($role != NULL && !in_array($action, $actions[$role])) exit($message);
			}
		}

		/**
		 * Displays all the shared articles
		 * to index view or to the home page
		 *
		 * @param void
		 * @return void
		 */
		public function index() {

			$conditions = array('Article.shared' => 1);
			$this->set('articles', $this->Article->find('all', array('conditions' => $conditions)));
		}

		/**
		 * Displays all the published articles
		 * to lists view
		 *
		 * @param void
		 * @return void
		 */
		public function lists()
		{
			$conditions = array('Article.published' => 1);
			$this->set('articles', $this->Article->find('all', array('conditions' => $conditions)));
		}

		/**
		 * Display an article with 
		 * a specified id
		 *
		 * @param mixed $id id of the article
		 * int if id exists, null if it doesn't exist
		 * @return void
		 * @throws NotFoundException if the id
		 * or the article was not found
		 */
		public function view($id = NULL)
		{
			
			if (!$id) {
				throw new NotFoundException(__('Invalid'));
			}
			$article = $this->Article->findById($id);
			
			$comments = $this->requestAction('/comments/lists', 
									array('pass' => array($id)));
			$userArray = array();
			foreach ($comments as $comment) {
				$userArray[] = $comment['User']['username'];
				
			}
			
			
			if (!$article) {
				throw new NotFoundException(__('Article not found'));
			} else {
				$this->set('published', $article['Article']['published']);
				$this->set('article', $article);
				$this->set('users', $userArray);
				$published = $article['Article']['published'];
				

			} 
		}

		/**
		 * Displays the latest created article
		 * to the latest view
		 *
		 * @param void
		 * @return void
		 */
		public function latest()
		{
			

			$conditions = array('order' => array('Article.created DESC'),
								'limit' => 1);
			$article = $this->Article->find('first', $conditions);
			$this->set('article', $article);
		}

		/**
		 * Displays all the articles
		 * for review purposes
		 *
		 * @param void
		 * @return void
		 */
		public function review()
		{
			$this->set('articles', $this->Article->find('all'));
		}

		/**
		 * Creates a new article
		 * with the designated user id
		 * of the author
		 *
		 * @param void
		 * @return void
		 */
		public function create()
		{
			if ($this->request->is('post')) {
				$this->Article->create();
				$this->request->data['Article']['user_id'] = $this->Auth->user('id');
				if ($this->Article->save($this->request->data)) {
					$this->Session->setFlash(__('Your article has been created.'));
					return $this->redirect(array('action' => 'latest'));
				}

				$this->Session->setFlash(__('Your article has not been created.'));
			}
		}

		/**
		 * Edits a single article
		 * with the given id
		 *
		 * @param mixed $id id of article
		 * int if id exists, null if it doesn't exist
		 * @return void
		 * @throws NotFoundException if the id
		 * or the article was not found
		 */
		public function edit($id = NULL)
		{	
			if (!$id) {
				throw new NotFoundException(__('Invalid'));
			}

			$article = $this->Article->findById($id);

			if (!$article) {
				throw new NotFoundException(__('Article not found'));
			}

			if ($this->request->is(array('post', 'put'))) {
				$this->Article->id = $id;
				if ($this->Article->save($this->request->data)) {
					$this->Session->setFlash(__('Successfully updated your article.'));
					 $this->redirect(array('action' => 'index'));
				}
				$this->Session->setFlash(__('Failed to update the article.'));
				 $this->redirect(array('action' => 'index'));
			
			}

			if (!$this->request->data) {
				$this->request->data = $article;
			}
		}

		/**
		 * Deletes an article
		 * with a given id
		 *
		 * @param mixed $id id of article
		 * int if id exists, null if it doesn't exist
		 * @return the home page view
		 * @throws MethodNotAllowedException
		 * if a get method is expected
		 */
		public function delete($id = NULL) 
		{
			if ($this->request->is('get')) {
				throw new MethodNotAllowedException();
			}

			if ($this->Article->delete($id)) {
				$this->Session->setFlash(__('The article was successfully deleted.'));
			} else {
				$this->Session->setFlash(__('Failed to delete the article.'));
			}

			return $this->redirect(array('action' => 'index'));
		}

		/**
		 * Searches for a queried article
		 *
		 * @param void
		 * @return void
		 */
		public function search()
		{
			if ($this->request->is('post')) {
				if ($this->request->data) {
					$q = $this->request->data['Article']['query'];
					$conditions = array(
						'Article.published' => 1,
						"OR" => array(
						"Article.title LIKE" => "%$q%",
						"Article.body LIKE" => "%$q%"
						));
					$result = $this->Article->find('all', array('conditions'=>$conditions));
					if (!empty($result)){
						$this->set('articles', $result);
					} else {
						$this->Session->setFlash(__('Unable to find the article.'));
						$this->redirect(array('controller' => 'articles', 'action' => 'index'));
					}
				} else {
					$this->Session->setFlash(__('Failed to search for the article.'));
					$this->redirect(array('controller' => 'articles', 'action' => 'index'));
				}
			} else {
					$this->Session->setFlash(__('Failed to search for the article.'));
					$this->redirect(array('controller' => 'articles', 'action' => 'index'));
			}
		}

		/**
		 * Publishes an article with the given id
		 *
		 * @param mixed $id id of the article
		 * int if id exists, null if it doesn't exist
		 * @return void
		 * @throws NotFoundException if the id
		 * or the article was not found
		 */
		public function publish($id = NULL)
		{
			$this->autoRender = false;

			if (!$id) {
				throw new NotFoundException(__('Invalid'));
			}

			$article = $this->Article->findById($id);

			if (!$article) {
				throw new NotFoundException(__('Article not found'));
			}
			$published = $article['Article']['published'];
			if ($published == 1){
				$this->Session->setFlash(__('Failed to publish the article.'));
				
				$this->redirect(array('action' => 'view', $id));
				
				exit();
			}
		
				$this->Article->id = $id;
			if ($this->Article->save(array('published' => 1))) {
				$this->Session->setFlash(__('Successfully published article.'));
				
				$this->redirect(array('action' => 'view', $id));
			} else {
				$this->Session->setFlash(__('Failed to publish the article.'));
			
				$this->redirect(array('action' => 'view', $id));
			} 
		}

		/**
		 * Unpublishes an article with the given id
		 *
		 * @param mixed $id id of the article
		 * int if id exists, null if it doesn't exist
		 * @return void
		 * @throws NotFoundException if the id
		 * or the article was not found
		 */
		public function unpublish($id = NULL)
		{
			if (!$id) {
				throw new NotFoundException(__('Invalid'));
			}

			$article = $this->Article->findById($id);

			if (!$article) {
				throw new NotFoundException(__('Article not found'));
			}
			$published = $article['Article']['published'];
			if ($published == 0) {
				$this->Session->setFlash(__('Failed to unpublish the article.'));
				
				$this->redirect(array('action' => 'view', $id));
				
				exit();
			}

			$this->Article->id = $id;
			if ($this->Article->save(array('published' => 0))) {
				$this->Session->setFlash(__('Successfully unpublished article.'));

				$this->redirect(array('action' => 'view', $id));
			} else {
				$this->Session->setFlash(__('Failed to unpublished the article.'));
				$this->redirect(array('action' => 'view', $id));

			}
		}

		/**
		 * Upvotes an article by 1 point
		 *
		 * @param mixed $id id of the article
		 * int if id exists, null if it doesn't exist
		 * @return void
		 * @throws NotFoundException if the id
		 * or the article was not found
		 */
		public function upvote($id = NULL)
		{
			$this->autoRender = false;

			if (!$id) {
				throw new NotFoundException(__('Invalid'));
			}
			
			$article = $this->Article->findById($id);

			if (!$article) {
				throw new NotFoundException(__('Article not found.'));
			}
			$rate = (int)$article['Article']['rating'];

			
			$this->Article->id = $id;

			if ($this->Article->save(array('rating' => $rate + 1))) {
				$this->Session->setFlash(__('Successfully upvoted the article.'));

				$this->redirect(array('action' => 'view', $id));
			} else {
				$this->Session->setFlash(__('Failed to upvote the article.'));
				$this->redirect(array('action' => 'view', $id));
			}
			

		}

		/**
		 * Downvotes an article by 1 point
		 *
		 * @param mixed $id id of the article
		 * int if id exists, null if it doesn't exist
		 * @return void
		 * @throws NotFoundException if the id
		 * or the article was not found
		 */
		public function downvote($id = NULL)
		{
			
			$this->autoRender = false;

			if (!$id) {
				throw new NotFoundException(__('Invalid'));
			}
			
			$article = $this->Article->findById($id);

			if (!$article) {
				throw new NotFoundException(__('Article not found.'));
			}
			$rate = (int)$article['Article']['rating'];

			if ($rate != 0) {
				$this->Article->id = $id;

				if ($this->Article->save(array('rating' => $rate - 1))) {
					$this->Session->setFlash(__('Successfully downvoted the article.'));

					$this->redirect(array('action' => 'view', $id));
				} else {
					$this->Session->setFlash(__('Failed to downvote the article.'));
					$this->redirect(array('action' => 'view', $id));
				}
			} else {
					$this->Session->setFlash(__('Can\'t downvote the article. Limit exceeded.'));
					$this->redirect(array('action' => 'view', $id));
			}
		

		}

		/**
		 * Shares an article with a given id
		 * and displays to to the home page or index view
		 *
		 * @param mixed $id id of the article
		 * int if id exists, null if it doesn't exist
		 * @return void
		 * @throws NotFoundException if the id
		 * or the article was not found
		 */
		public function share($id = NULL)
		{
			$this->autoRender = false;

			if (!$id) {
				throw new NotFoundException(__('Invalid'));
			}

			$article = $this->Article->findById($id);
			if (!$article) {
				throw new NotFoundException(__('Article not found.'));
			}

			$shared = $article['Article']['shared'];
			if ($shared == 0) {
				$this->Article->id = $id;
				if ($this->Article->save(array('shared' => 1))) {
					$this->Session->setFlash(__('Successfully shared the article.'));
					$this->redirect(array('action'=> 'view', $id));
				} else {
					$this->Session->setFlash(__('Failed to share the article.'));
					$this->redirect(array('action'=> 'view', $id));
				}

			} else {
				$this->Session->setFlash(__('The article is already shared'));
					$this->redirect(array('action'=> 'view', $id));
			}
		}
	}



?>