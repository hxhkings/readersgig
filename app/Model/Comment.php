<?php


App::uses('AppModel', 'Model');

/**
 * Processes the app's comments table relationships
 * and comment form validations
 *
 * PHP version 5.6.25
 */
class Comment extends AppModel 
{	
	/**
	 * Represents many-comments-to-one-article
	 * and many-comments-to-one-user relationship
	 *
	 * @var string the name of the connected model
	 */
	public $belongsTo = array('Article', 'User');

	/**
	 * Lists all the form field validation rules
	 *
	 * @var array multi-dimensional array
	 * of form field names and it's corresponding
	 * validation rules
	 */
	public $validate = array(
			'edit_comment' =>
			 		array(
			 			    
							'rule' => 'alphaNumeric',
							'message' => 'Wrong format')
		);
}