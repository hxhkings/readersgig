<?php

App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

/**
 * Processes the app's users table relationships
 * and user form validations
 *
 * PHP version 5.6.25
 */
class User extends AppModel
{
	/**
	 * Represents a many-articles-to-one-user
	 * relationship
	 *
	 * @var string the name of the connected model
	 */
	public $belongsTo = 'Role';	

	/**
	 * Represents one-user-to-many-comments
	 * one-user-to-many-articles relationship
	 *
	 * @var string the name of the connected model
	 */
	public $hasMany = array('Article', 'Comment');

	/**
	 * Lists all the form field validation rules
	 *
	 * @var array multi-dimensional array
	 * of form field names and it's corresponding
	 * validation rules
	 */
	public $validate = array(
		'username' => array(
			    
			    
				'rule' => 'alphaNumeric',
				'message' => 'Wrong format'
			),
		'email' => array(
			    
				
			   
				'rule' => 'email',
				'message' => 'Wrong format'
			),
		'password' => array(
			  
			    
				'rule' => 'alphaNumeric',
				'message' => 'Wrong format'
			),
		'confirm_password' => array(
			    
			    
				'rule' => 'alphaNumeric',
				'message' => 'Wrong format'
			),
		'first_name' => array(
			   
			   
				'rule' => 'alphaNumeric',
				'message' => 'Wrong format'
			),
		'last_name' => array(
			    
			   
				'rule' => 'alphaNumeric',
				'message' => 'Wrong format'
			),
		'phone_number' => array(
			    
				'rule' => 'notBlank',
				'message' => 'Wrong format'
			),
		'birthday' => array(
			    
			   
				'rule' => 'notBlank',
				'message' => 'Wrong format'
			)
		);
	
	/**
	 * Hashes the typed password before saving 
	 * it to the password field
	 *
	 * @param array $options array of available options
	 * @return boolean true
	 */
	public function beforeSave($options = array())
	{

		if (!empty($this->data[$this->alias]['password'])) {
			$passwordHasher = new SimplePasswordHasher(array('hashType' => 'sha1'));
			$this->data[$this->alias]['password'] = $passwordHasher->hash(
				$this->data[$this->alias]['password']
				);
		}
		return TRUE;
	}
}



?>