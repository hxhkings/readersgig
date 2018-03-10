<?php


App::uses('AppController', 'Controller');

	/**
	 * Manipulates the comments table
	 * and the comment views
	 *
	 * PHP version 5.6.25
	 */

class CommentsController extends AppController
{

	/**
	 * Labels the controller
	 *
	 * @var string name of controller
	 */
	public $name = 'Comments';

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
						1 => array('create', 'delete', 'edit', 'lists'),
						// publisher
						2 => array(),
						// author
						3 => array('lists'),
						// reader
						4 => array('create', 'lists')
						);
		
			

		if ($controller == 'comments'){
			$role = $this->Session->read('Auth.User.role_id');
				if ($role != NULL && !in_array($action, $actions[$role])) exit($message);
			}
	}

	/**
	 * Creates a new comment
	 * and displays it on the articles view page
	 * at the comment section
	 *
	 * @param mixed $id id of the article
	 * int if id exists, null if it doesn't exist
	 * @return void
	 * @throws NotFoundException if the id
	 * of the article was not found
	 */
	public function create($id = NULL)
	{
		$this->autoRender = false;

		if (!$id) {
			throw new NotFoundException(__('Invalid'));
		}

		if ($this->request->is('post')) {
			$this->Comment->create();
			
			if ($this->Comment->save(array('body' => $this->request->data['Comment']['comment'], 'article_id' => $id,
				'user_id' => $this->Auth->user('id')))) {
				$this->Session->setFlash(__('New comment created.'));
			$this->redirect(array('controller'=>'articles','action'=>'view',$id));
			}
			$this->Session->setFlash(__('Failed to create a new comment.'));
			$this->redirect(array('controller'=>'articles','action'=>'view',$id));
		}
	}

	/**
	 * Deletes a comment on a given article
	 *
	 * @param mixed $id id of the comment
	 * int if id exists, null if it doesn't exist
	 * @param mixed $article_id id of the article
	 * int if id exists, null if it doesn't exist
	 * @return void
	 * @throws NotFoundException if the id of
	 * the comment or the article id was not found
	 * @throws MethodNotAllowedException if a get method
	 * is expected
	 */
	public function delete($id = NULL, $article_id = NULL)
	{
		if (!$id || !$article_id) {
			throw new NotFoundException(__('Invalid'));
		}

		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		if ($this->Comment->delete($id)) {
			$this->Session->setFlash(__('Comment successfully deleted'));
			$this->redirect(array('controller'=>'articles','action'=>'view',$article_id));
		}
		$this->Session->setFlash(__('Failed to delete a comment.'));
		$this->redirect(array('controller'=>'articles','action'=>'view',$article_id));
	}

	/**
	 * Edits a comment with a given id
	 * and under a designated article
	 *
	 * @param mixed $id id of the comment
	 * int if id exists, null if it doesn't exist
	 * @param mixed $article_id id of the article
	 * int if id exists, null if it doesn't exist
	 * @return void
	 * @throws NotFoundException if the id of the comment,
	 * the id of the article, or the comment itself
	 * was not found
	 */
	public function edit($id = NULL, $article_id = NULL) 
	{
		if (!$id || !$article_id) {
			throw new NotFoundException(__('Invalid'));
		}

		$comment = $this->Comment->findById($id);

		if (!$comment) {
			throw new NotFoundException(__('Comment not found'));
		}

		if ($this->request->is(array('post', 'put'))) {
			$this->Comment->id = $id;

			if ($this->Comment->save(array('body' => $this->request->data['Comment']['edit_comment'],
											'article_id' => $article_id))) {
				$this->Session->setFlash(__('Successfully updated comment.'));
			    $this->redirect(array('controller' => 'articles', 'action' => 'view', $article_id));
			}
			$this->Session->setFlash(__('Failed to update comment.'));
			$this->redirect(array('controller' => 'articles', 'action' => 'view', $article_id));
		}

		if (!isset($this->request->data['Comment']['edit_comment'])) {
			$this->set('id', array($id, $article_id));
			$this->request->data['Comment']['edit_comment'] = $comment['Comment']['body'];
		}
	}

	/**
	 * Grabs an array of comments designated
	 * by the article id
	 *
	 * @param mixed $article_id 
	 * int if id exists, null if it doesn't exist
	 * @return array $comments multi-dimensional 
	 * array of comments
	 * @throws NotFoundException if the article_id
	 * or the comments array was not found
	 */
	public function lists($article_id = NULL)
	{
		$this->autoRender = false;
		if (!$article_id) {
			throw new NotFoundException(__('Invalid'));
		}
		$conditions = array('Comment.article_id' => $article_id);
		$comments = $this->Comment->find('all', array('conditions' => $conditions));
		
		if (!$comments) {
			throw new NotFoundException(__('Comments not found'));
		}
		
		return $comments;
	}
}