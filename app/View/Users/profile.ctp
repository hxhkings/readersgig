
<div>
	<h2><?php echo h($user['User']['username']); ?>'s Profile</h2>
	<h3>
	<?php $role = array( 1 => 'Administrator', 2 => 'Publisher', 3 => 'Author', 4 => 'Reader'); ?>
		<strong>Role:</strong> <?php  echo h($role[$this->Session->read('Auth.User.role_id')]); ?>
	</h3>
	<?php 
	if ($this->Session->read('Auth.User.role_id') == $user['User']['role_id']):
		echo $this->Html->link('Edit Profile', 
				array('controller' => 'users', 'action' => 'edit', $user['User']['id']),
				array('class' => 'btn btn-success'));
	endif;
	 ?>
	<section style="font-size: 20px; margin-top: 20px">
		<div>
			<strong>First Name:</strong> <?php echo h($user['User']['first_name']); ?>
		</div>
		<div>
			<strong>Last Name:</strong> <?php echo h($user['User']['last_name']); ?>
		</div>
		<div>
			<strong>Username:</strong> <?php echo h($user['User']['username']); ?>
		</div>
		<div>
			<strong>E-mail:</strong> <?php echo h($user['User']['email']); ?>
		</div>
		<div>
			<strong>Birthday:</strong> <?php echo h($user['User']['birthday']); ?>
		</div>
		<div>
			<strong>Phone Number:</strong> <?php echo h($user['User']['phone_number']); ?>
		</div>
	</section>
</div>