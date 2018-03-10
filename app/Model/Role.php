<?php


App::uses('AppModel', 'Model');

/**
 * Processes the app's roles table relationships
 *
 * PHP version 5.6.25
 */
class Role extends AppModel
{

	/**
	 * Represents a one-role-to-many-users
	 * relationship
	 *
	 * @var string the name of the connected model
	 */
	public $hasMany = array(
		'User' => array(
				'className' => 'User'
			)
		);
}