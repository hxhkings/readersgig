<h2 class="text-center">Add New User</h2>

<div class="row">
	<div class="col-md-4 col-md-offset-4">
	<?php echo $this->Flash->render('auth'); ?>
	<?php echo $this->Form->create('User', array('url'=>array('controller' => 'users', 'action' => 'add'))); ?>
	<div class="form-group">
		<?php echo $this->Form->input('username', array('required' => false, 'class' => 'form-control')); ?>
	</div>
	<div class="form-group">
		<?php echo $this->Form->input('email', array('type' => 'email', 'required' => false, 'class' => 'form-control')); ?>
	</div>
	<div class="form-group">
		<?php echo $this->Form->input('password', array('type' => 'password', 'required' => false, 'class' => 'form-control')); ?>
	</div>
	<div class="form-group">
		<?php echo $this->Form->input('confirm_password', array('type' => 'password', 'required' => false, 'class' => 'form-control')); ?>
	</div>
	<div class="form-group">
		<?php echo $this->Form->input('first_name', array('required' => false, 'class' => 'form-control')); ?>
	</div>
	<div class="form-group">
		<?php echo $this->Form->input('last_name', array('required' => false, 'class' => 'form-control')); ?>
	</div>
	<div class="form-group">
		<?php echo $this->Form->input('role', 
			array('options' => 
				array('admin' => 'Admin', 'publisher' => 'Publisher', 'author' => 'Author', 'reader' => 'Reader')));	 ?>	
	</div>
	<div class="form-group">
		<?php echo $this->Form->submit('Submit', array('class' => 'btn btn-primary btn-lg')); ?>
	</div>
	<div class="form-group">
		<?php echo $this->Form->end(); ?>
	</div>
	</div>
	
</div>