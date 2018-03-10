<?php

App::uses('AppModel', 'Model');

/**
 * Processes the app's articles table relationships
 * and article form validations
 *
 * PHP version 5.6.25
 */
class Article extends AppModel
{

	/**
	 * Represents a many-articles-to-one-user
	 * relationship
	 *
	 * @var string the name of the connected model
	 */
	public $belongsTo = 'User';

	/**
	 * Represents a one-article-to-many-comments
	 * relationship
	 *
	 * @var string the name of the connected model
	 */
	public $hasMany = 'Comment';

	/**
	 * Lists all the form field validation rules
	 *
	 * @var array multi-dimensional array
	 * of form field names and it's corresponding
	 * validation rules
	 */
		 public $validate = array(
	 							'title' => array(
	 											
	 										    
	 											'rule' => 'notBlank',
												'message' => 'Fill in the title'),
	 							'body' => array(
	 											
	 										    
												'rule' => 'notBlank',
	 											'message' => 'Fill in the body')
								
											     
	 							);

}



?>